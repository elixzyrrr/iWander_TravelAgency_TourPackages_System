<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSetting;
use App\Models\User;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

class AdminModuleController extends Controller implements HasMiddleware
{
    private const ALLOWED_USER_ROLES = ['admin', 'agent'];

    public static function middleware(): array
    {
        return [
            new Middleware(function (Request $request, Closure $next) {
                abort_unless($request->user()?->role === 'admin', 403);

                return $next($request);
            }),
        ];
    }

    public function dashboard(): View
    {
        $users = User::query();

        $stats = [
            'totalUsers' => $users->count(),
            'activeUsers' => User::query()->where('status', 'active')->count(),
            'lockedUsers' => User::query()->where('status', 'locked')->count(),
            'avgCommission' => round((float) (User::query()->avg('commission_rate') ?? 0), 2),
            'totalCreditLimit' => (float) User::query()->sum('credit_limit'),
            'resetTokens' => DB::table('password_reset_tokens')->count(),
        ];

        return view('admin.admin_dashboard', [
            'stats' => $stats,
            'recentUsers' => User::query()->latest()->take(5)->get(),
            'recentLockedUsers' => User::query()->where('status', 'locked')->latest('locked_at')->take(5)->get(),
            'settings' => $this->settingsSnapshot(),
        ]);
    }

    public function users(): View
    {
        $query = User::query()->orderBy('name');
        $users = $query->paginate(5)->withQueryString();

        $metrics = [
            'totalUsers' => User::query()->count(),
            'activeUsers' => User::query()->where('status', 'active')->count(),
            'inactiveUsers' => User::query()->where('status', 'inactive')->count(),
            'lockedUsers' => User::query()->where('status', 'locked')->count(),
        ];

        return view('admin.users', [
            'users' => $users,
            'metrics' => $metrics,
        ]);
    }

    public function storeUser(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'role' => ['required', Rule::in(self::ALLOWED_USER_ROLES)],
            'status' => ['required', Rule::in(['active', 'inactive', 'locked'])],
            'commission_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'credit_limit' => ['nullable', 'numeric', 'min:0'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'status' => $validated['status'],
            'commission_rate' => $validated['commission_rate'] ?? 0,
            'credit_limit' => $validated['credit_limit'] ?? 0,
            'locked_at' => $validated['status'] === 'locked' ? now() : null,
            'password' => $validated['password'],
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function editUser(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    public function updateUser(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required', Rule::in(self::ALLOWED_USER_ROLES)],
            'status' => ['required', Rule::in(['active', 'inactive', 'locked'])],
            'commission_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'credit_limit' => ['nullable', 'numeric', 'min:0'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $payload = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'status' => $validated['status'],
            'commission_rate' => $validated['commission_rate'] ?? 0,
            'credit_limit' => $validated['credit_limit'] ?? 0,
            'locked_at' => $validated['status'] === 'locked' ? ($user->locked_at ?? now()) : null,
        ];

        if (! empty($validated['password'])) {
            $payload['password'] = $validated['password'];
        }

        $user->update($payload);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroyUser(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function lockUser(User $user): RedirectResponse
    {
        $user->update([
            'status' => 'locked',
            'locked_at' => now(),
        ]);

        return back()->with('success', 'User locked.');
    }

    public function unlockUser(User $user): RedirectResponse
    {
        $user->update([
            'status' => 'active',
            'locked_at' => null,
        ]);

        return back()->with('success', 'User unlocked.');
    }

    public function authentication(): View
    {
        $lockedQuery = User::query()->where('status', 'locked')->latest('locked_at');
        $lockedUsers = $lockedQuery->paginate(10)->withQueryString();

        return view('admin.authentication', [
            'lockedUsers' => $lockedUsers,
            'resetTokenCount' => DB::table('password_reset_tokens')->count(),
        ]);
    }

    public function generateResetToken(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $validated['email']],
            [
                'token' => hash('sha256', Str::random(64)),
                'created_at' => now(),
            ]
        );

        return back()->with('success', 'Password reset token generated.');
    }

    public function system(): View
    {
        return view('admin.system', [
            'settings' => $this->settingsSnapshot(),
        ]);
    }

    public function updateSystem(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'agency_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'phone_number' => ['required', 'string', 'max:50'],
            'currency' => ['required', Rule::in(['PHP', 'USD', 'EUR'])],
            'address' => ['required', 'string', 'max:255'],
            'email_booking' => ['nullable', 'boolean'],
            'email_payment' => ['nullable', 'boolean'],
            'email_reminder' => ['nullable', 'boolean'],
            'email_newsletter' => ['nullable', 'boolean'],
        ]);

        $settings = [
            'agency_name' => $validated['agency_name'],
            'contact_email' => $validated['contact_email'],
            'phone_number' => $validated['phone_number'],
            'currency' => $validated['currency'],
            'address' => $validated['address'],
            'email_booking' => $request->boolean('email_booking') ? '1' : '0',
            'email_payment' => $request->boolean('email_payment') ? '1' : '0',
            'email_reminder' => $request->boolean('email_reminder') ? '1' : '0',
            'email_newsletter' => $request->boolean('email_newsletter') ? '1' : '0',
        ];

        foreach ($settings as $name => $value) {
            AdminSetting::query()->updateOrCreate(
                ['name' => $name],
                ['value' => $value]
            );
        }

        return back()->with('success', 'System settings saved.');
    }

    public function financial(): View
    {
        $users = User::query()->orderBy('name')->paginate(5)->withQueryString();
        $allUsers = User::query()->get();

        return view('admin.financial', [
            'users' => $users,
            'summary' => [
                'projectedCommission' => $allUsers->sum(fn (User $user) => ((float) $user->credit_limit) * (((float) $user->commission_rate) / 100)),
                'totalCreditLimit' => (float) $allUsers->sum('credit_limit'),
                'lockedExposure' => (float) $allUsers->where('status', 'locked')->sum('credit_limit'),
            ],
        ]);
    }

    public function analytics(): View
    {
        $users = User::query()->get();

        return view('admin.analytics', [
            'roleBreakdown' => User::query()
                ->select('role', DB::raw('count(*) as total'))
                ->groupBy('role')
                ->orderByDesc('total')
                ->get(),
            'statusBreakdown' => User::query()
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->orderByDesc('total')
                ->get(),
            'topUsers' => User::query()->orderByDesc('credit_limit')->paginate(5)->withQueryString(),
            'summary' => [
                'totalUsers' => $users->count(),
                'activeUsers' => $users->where('status', 'active')->count(),
                'lockedUsers' => $users->where('status', 'locked')->count(),
                'averageCommission' => round((float) $users->avg('commission_rate'), 2),
            ],
        ]);
    }

    private function settingsSnapshot(): array
    {
        $defaults = [
            'agency_name' => 'iWander Travel Agency',
            'contact_email' => 'support@iwander.com',
            'phone_number' => '+63 912 345 6789',
            'currency' => 'PHP',
            'address' => '123 Travel Street, Manila, Philippines',
            'email_booking' => '1',
            'email_payment' => '1',
            'email_reminder' => '1',
            'email_newsletter' => '0',
        ];

        return collect($defaults)
            ->merge(AdminSetting::query()->pluck('value', 'name')->all())
            ->all();
    }
}
