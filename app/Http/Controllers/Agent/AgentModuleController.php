<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\AgentRecord;
use App\Models\AgentSetting;
use App\Models\AirlineOption;
use App\Models\UserDashboardBooking;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AgentModuleController extends Controller
{
    private const MODULES = [
        'dashboard' => [
            'title' => 'Dashboard Overview',
            'subtitle' => 'Operational overview for the agent workspace',
            'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
            'module' => null,
            'canCrud' => false,
            'statusOptions' => ['pending', 'confirmed', 'cancelled'],
        ],
        'bookings' => [
            'title' => 'Bookings',
            'subtitle' => 'Manage travel bookings and trip requests',
            'icon' => 'M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4',
            'module' => 'bookings',
            'canCrud' => true,
            'statusOptions' => ['pending', 'confirmed', 'cancelled'],
        ],
        'customers' => [
            'title' => 'Customers',
            'subtitle' => 'Track and maintain customer records',
            'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
            'module' => 'customers',
            'canCrud' => false,
            'statusOptions' => ['active', 'vip', 'inactive'],
        ],
        'flights' => [
            'title' => 'Flights',
            'subtitle' => 'Maintain flight inventory entries',
            'icon' => 'M12 19l9 2-9-18-9 18 9-2zm0 0v-8',
            'module' => 'flights',
            'canCrud' => true,
            'statusOptions' => ['available', 'pending', 'archived'],
        ],
        'hotels' => [
            'title' => 'Hotels',
            'subtitle' => 'Manage hotel listings and room availability',
            'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
            'module' => 'hotels',
            'canCrud' => true,
            'statusOptions' => ['available', 'limited', 'archived'],
        ],
        'packages' => [
            'title' => 'Tour Packages',
            'subtitle' => 'Create and update package offers',
            'icon' => 'M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4',
            'module' => 'packages',
            'canCrud' => true,
            'statusOptions' => ['draft', 'published', 'archived'],
        ],
        'reports' => [
            'title' => 'Reports',
            'subtitle' => 'Review metrics generated from the record tables',
            'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
            'module' => null,
            'canCrud' => false,
            'statusOptions' => [],
        ],
        'settings' => [
            'title' => 'Settings',
            'subtitle' => 'Control key agent configuration values',
            'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z',
            'module' => null,
            'canCrud' => false,
            'statusOptions' => [],
        ],
    ];

    public function dashboard(): View
    {
        $this->assertAgent(request());

        if (! $this->storageReady()) {
            return view('agent.modules.dashboard', [
                'page' => self::MODULES['dashboard'],
                'moduleKey' => 'dashboard',
                'records' => collect(),
                'recentFlights' => collect(),
                'recentHotels' => collect(),
                'recentPackages' => collect(),
                'recentBookings' => collect(),
                'pendingRequests' => collect(),
                'summary' => [
                    'totalBookings' => 0,
                    'totalCustomers' => 0,
                    'totalFlights' => 0,
                    'totalHotels' => 0,
                    'totalPackages' => 0,
                    'pendingRequests' => 0,
                    'settingsCount' => 0,
                    'revenue' => 0,
                ],
                'storageReady' => false,
            ]);
        }

        $allRecords = AgentRecord::query()->latest()->get();
        $recentFlights = $allRecords->where('module', 'flights')->take(5)->values();
        $recentHotels = $allRecords->where('module', 'hotels')->take(5)->values();
        $recentPackages = $allRecords->where('module', 'packages')->take(5)->values();
        $recentBookings = UserDashboardBooking::query()
            ->with(['user:id,name,email', 'section:id,key,title', 'item:id,title'])
            ->latest()
            ->take(3)
            ->get();

        return view('agent.modules.dashboard', [
            'page' => self::MODULES['dashboard'],
            'moduleKey' => 'dashboard',
            'records' => $allRecords->take(5),
            'recentFlights' => $recentFlights,
            'recentHotels' => $recentHotels,
            'recentPackages' => $recentPackages,
            'recentBookings' => $recentBookings,
            'pendingRequests' => collect(),
            'summary' => $this->summary($allRecords),
            'storageReady' => true,
        ]);
    }

    public function module(Request $request, string $module): View
    {
        $this->assertAgent($request);

        $page = $this->pageFor($module);
        $editingRecord = null;
        $supportingFlights = collect();
        $supportingHotels = collect();
        $flightLookup = collect();
        $hotelLookup = collect();

        if ($module === 'bookings') {
            $editingRecord = null;

            if ($request->filled('edit')) {
                $editingRecord = UserDashboardBooking::query()
                    ->with(['user:id,name,email', 'section:id,key,title', 'item:id,title'])
                    ->find($request->integer('edit'));
            }

            $records = UserDashboardBooking::query()
                ->with(['user:id,name,email', 'section:id,key,title', 'item:id,title'])
                ->latest()
                ->paginate(5)
                ->withQueryString();

            return view($this->viewNameFor($module), [
                'page' => $page,
                'moduleKey' => $module,
                'records' => $records,
                'editingRecord' => $editingRecord,
                'summary' => $this->summary(),
                'settings' => $this->storageReady() ? $this->settingsSnapshot() : [],
                'supportingFlights' => collect(),
                'supportingHotels' => collect(),
                'flightLookup' => collect(),
                'hotelLookup' => collect(),
                'storageReady' => $this->storageReady(),
            ]);
        }

        // Customers page should show real customer accounts from users table.
        if ($module === 'customers') {
            $records = User::query()
                ->where('role', 'user')
                ->latest()
                ->paginate(5)
                ->through(function (User $user) {
                    return (object) [
                        'id' => $user->id,
                        'reference_code' => 'USR-'.str_pad((string) $user->id, 4, '0', STR_PAD_LEFT),
                        'title' => $user->name,
                        'contact_name' => $user->name,
                        'contact_email' => $user->email,
                        'contact_phone' => null,
                        'destination' => 'Customer Account',
                        'status' => $user->status ?? 'active',
                        'amount' => 0,
                        'travel_start' => null,
                        'travel_end' => null,
                        'created_at' => $user->created_at,
                    ];
                })
                ->withQueryString();

            return view($this->viewNameFor($module), [
                'page' => $page,
                'moduleKey' => $module,
                'records' => $records,
                'editingRecord' => null,
                'summary' => $this->summary(),
                'settings' => $this->storageReady() ? $this->settingsSnapshot() : [],
                'supportingFlights' => collect(),
                'supportingHotels' => collect(),
                'flightLookup' => collect(),
                'hotelLookup' => collect(),
                'storageReady' => $this->storageReady(),
            ]);
        }

        if (! $this->storageReady()) {
            return view($this->viewNameFor($module), [
                'page' => $page,
                'moduleKey' => $module,
                'records' => collect(),
                'editingRecord' => null,
                'summary' => $this->summaryFallback(),
                'settings' => $this->settingsSnapshot(),
                'storageReady' => false,
            ]);
        }

        $supportingFlights = AgentRecord::query()
            ->where('module', 'flights')
            ->latest()
            ->get();

        $supportingHotels = AgentRecord::query()
            ->where('module', 'hotels')
            ->latest()
            ->get();

        $flightLookup = $supportingFlights->keyBy('id');
        $hotelLookup = $supportingHotels->keyBy('id');

        if ($request->filled('edit')) {
            $editingRecordQuery = AgentRecord::query()->where('module', $module);

            if ($module === 'flights') {
                $editingRecordQuery->with('airlineOptions');
            }

            $editingRecord = $editingRecordQuery->find($request->integer('edit'));
        }

        $query = AgentRecord::query()->where('module', $module)->latest();

        $records = $page['canCrud'] || $module === 'customers'
            ? $query->paginate(5)->withQueryString()
            : $query->paginate(5)->withQueryString();

        return view($this->viewNameFor($module), [
            'page' => $page,
            'moduleKey' => $module,
            'records' => $records,
            'editingRecord' => $editingRecord,
            'summary' => $this->summary(),
            'settings' => $this->settingsSnapshot(),
            'supportingFlights' => $supportingFlights,
            'supportingHotels' => $supportingHotels,
            'flightLookup' => $flightLookup,
            'hotelLookup' => $hotelLookup,
            'storageReady' => true,
        ]);
    }

    public function store(Request $request, string $module): RedirectResponse
    {
        $this->assertAgent($request);

        abort_unless($this->storageReady(), 503, 'Run php artisan migrate to create the agent tables first.');

        if ($module === 'bookings') {
            abort(403, 'Bookings are created by customers and can only be updated by agents.');
        }

        $page = $this->pageFor($module);

        $validated = $request->validate($this->rulesFor($module));

        DB::transaction(function () use ($request, $module, $validated): void {
            $record = AgentRecord::create($this->recordData($request, $module, $validated));

            if ($module === 'flights') {
                $this->syncFlightAirlineOptions($record, $validated['airline_options_json'] ?? null);
            }
        });

        return redirect()->route('agent.module', ['module' => $module])->with('success', $page['title'].' saved.');
    }

    public function update(Request $request, AgentRecord $agentRecord): RedirectResponse
    {
        $this->assertAgent($request);

        abort_unless($this->storageReady(), 503, 'Run php artisan migrate to create the agent tables first.');

        $validated = $request->validate($this->rulesFor($agentRecord->module));

        DB::transaction(function () use ($request, $agentRecord, $validated): void {
            $agentRecord->update($this->recordData($request, $agentRecord->module, $validated, $agentRecord));

            if ($agentRecord->module === 'flights') {
                $this->syncFlightAirlineOptions($agentRecord, $validated['airline_options_json'] ?? null);
            }
        });

        return redirect()->route('agent.module', ['module' => $agentRecord->module])->with('success', 'Record updated.');
    }

    public function updateBookingStatus(Request $request, UserDashboardBooking $booking): RedirectResponse
    {
        $this->assertAgent($request);

        abort_unless(Schema::hasTable('user_dashboard_bookings'), 503, 'Run php artisan migrate to create the booking tables first.');

        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'confirmed', 'cancelled'])],
        ]);

        $booking->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('agent.module', ['module' => 'bookings'])
            ->with('success', 'Booking status updated.');
    }

    public function destroy(AgentRecord $agentRecord): RedirectResponse
    {
        $this->assertAgent(request());

        abort_unless($this->storageReady(), 503, 'Run php artisan migrate to create the agent tables first.');

        $module = $agentRecord->module;

        if ($agentRecord->cover_image) {
            Storage::disk('public')->delete($agentRecord->cover_image);
        }

        $agentRecord->delete();

        return redirect()->route('agent.module', ['module' => $module])->with('success', 'Record deleted.');
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $this->assertAgent($request);

        abort_unless($this->storageReady(), 503, 'Run php artisan migrate to create the agent tables first.');

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
            AgentSetting::query()->updateOrCreate(
                ['name' => $name],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Settings saved.');
    }

    private function pageFor(string $module): array
    {
        abort_unless(array_key_exists($module, self::MODULES), 404);

        return self::MODULES[$module];
    }

    private function viewNameFor(string $module): string
    {
        return "agent.modules.{$module}";
    }

    private function rulesFor(string $module): array
    {
        $page = $this->pageFor($module);

        abort_unless($page['canCrud'] ?? false, 403);

        $flightRule = Rule::exists('agent_records', 'id')->where(fn ($query) => $query->where('module', 'flights'));
        $hotelRule = Rule::exists('agent_records', 'id')->where(fn ($query) => $query->where('module', 'hotels'));

        return [
            'reference_code' => ['nullable', 'string', 'max:50'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'title' => ['required', 'string', 'max:255'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'destination' => ['nullable', 'string', 'max:255'],
            'travel_type' => ['nullable', 'string', 'max:255'],
            'travel_start' => ['nullable', 'date'],
            'travel_end' => ['nullable', 'date', 'after_or_equal:travel_start'],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(array_merge($page['statusOptions'], ['active', 'draft', 'available', 'limited', 'archived', 'new', 'in_progress', 'closed']))],
            'description' => ['nullable', 'string'],
            'details' => ['nullable', 'string'],
            'flight_record_id' => $module === 'packages' ? ['required', $flightRule] : ['nullable'],
            'hotel_record_id' => $module === 'packages' ? ['required', $hotelRule] : ['nullable'],
            'airline_options_json' => $module === 'flights' ? ['nullable', 'string', 'max:50000'] : ['nullable'],
        ];
    }

    private function syncFlightAirlineOptions(AgentRecord $record, ?string $airlineOptionsJson): void
    {
        if ($record->module !== 'flights') {
            return;
        }

        $payload = trim((string) $airlineOptionsJson);

        if ($payload === '') {
            $record->airlineOptions()->delete();

            return;
        }

        $decoded = json_decode($payload, true);

        if (json_last_error() !== JSON_ERROR_NONE || ! is_array($decoded)) {
            throw ValidationException::withMessages([
                'airline_options_json' => 'Airline options must be valid JSON array.',
            ]);
        }

        $rows = [];

        foreach ($decoded as $index => $option) {
            if (! is_array($option)) {
                throw ValidationException::withMessages([
                    'airline_options_json' => 'Each airline option must be an object.',
                ]);
            }

            $airlineName = trim((string) ($option['airline_name'] ?? ''));
            $airlineCode = trim((string) ($option['airline_code'] ?? ''));
            $icon = trim((string) ($option['icon'] ?? ''));
            $sortOrder = isset($option['sort_order']) ? (int) $option['sort_order'] : ($index + 1);
            $flights = $option['flights'] ?? [];

            if ($airlineName === '') {
                throw ValidationException::withMessages([
                    'airline_options_json' => 'Each airline option requires airline_name.',
                ]);
            }

            if (! is_array($flights) || $flights === []) {
                throw ValidationException::withMessages([
                    'airline_options_json' => 'Each airline option requires at least one flight entry.',
                ]);
            }

            $normalizedFlights = [];

            foreach ($flights as $flightIndex => $flight) {
                if (! is_array($flight)) {
                    throw ValidationException::withMessages([
                        'airline_options_json' => 'Each flight entry must be an object.',
                    ]);
                }

                $departure = trim((string) ($flight['departure'] ?? ''));
                $arrival = trim((string) ($flight['arrival'] ?? ''));
                $duration = trim((string) ($flight['duration'] ?? ''));
                $stops = isset($flight['stops']) ? max(0, (int) $flight['stops']) : 0;
                $priceRaw = $flight['price'] ?? null;
                $price = is_numeric($priceRaw) ? (float) $priceRaw : null;

                if ($departure === '' || $arrival === '' || $duration === '' || $price === null || $price < 0) {
                    throw ValidationException::withMessages([
                        'airline_options_json' => 'Flight entries require departure, arrival, duration, and non-negative price.',
                    ]);
                }

                $normalizedFlights[] = [
                    'departure' => $departure,
                    'arrival' => $arrival,
                    'duration' => $duration,
                    'stops' => $stops,
                    'price' => $price,
                ];
            }

            $rows[] = [
                'agent_record_id' => $record->id,
                'airline_name' => $airlineName,
                'airline_code' => $airlineCode !== '' ? $airlineCode : null,
                'icon' => $icon !== '' ? $icon : null,
                'sort_order' => max(1, $sortOrder),
                'flights' => $normalizedFlights,
            ];
        }

        $record->airlineOptions()->delete();

        foreach ($rows as $row) {
            AirlineOption::query()->create($row);
        }
    }

    private function summary($records = null): array
    {
        $customerCount = User::query()->where('role', 'user')->count();

        if (! $this->storageReady()) {
            $fallback = $this->summaryFallback();
            $fallback['totalCustomers'] = $customerCount;
            return $fallback;
        }

        $records = $records ?? AgentRecord::query()->get();
        $settingsCount = AgentSetting::query()->count();
        $bookingCount = UserDashboardBooking::query()->count();
        $pendingBookingCount = UserDashboardBooking::query()->where('status', 'pending')->count();
        $bookingRevenue = (float) UserDashboardBooking::query()->sum('amount');

        return [
            'totalBookings' => $bookingCount,
            'totalCustomers' => $customerCount,
            'totalFlights' => $records->where('module', 'flights')->count(),
            'totalHotels' => $records->where('module', 'hotels')->count(),
            'totalPackages' => $records->where('module', 'packages')->count(),
            'pendingRequests' => $pendingBookingCount,
            'settingsCount' => $settingsCount,
            'revenue' => $bookingRevenue > 0 ? $bookingRevenue : (float) $records->sum('amount'),
        ];
    }

    private function summaryFallback(): array
    {
        return [
            'totalBookings' => 0,
            'totalCustomers' => 0,
            'totalFlights' => 0,
            'totalHotels' => 0,
            'totalPackages' => 0,
            'pendingRequests' => 0,
            'settingsCount' => 0,
            'revenue' => 0,
        ];
    }

    private function storageReady(): bool
    {
        return Schema::hasTable('agent_records') && Schema::hasTable('agent_settings');
    }

    private function assertAgent(Request $request): void
    {
        abort_unless(in_array($request->user()?->role, ['admin', 'agent', 'staff'], true), 403);
    }

    private function normalizeDetails(null|string|array $details): array
    {
        if (is_array($details)) {
            return $details;
        }

        if (is_string($details) && $details !== '') {
            $decoded = json_decode($details, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }

            return ['notes' => $details];
        }

        return [];
    }

    private function recordData(Request $request, string $module, array $validated, ?AgentRecord $record = null): array
    {
        $payload = [
            'created_by' => $record?->created_by ?? $request->user()?->id,
            'module' => $module,
            'reference_code' => $validated['reference_code'] ?? $record?->reference_code ?? strtoupper(Str::random(8)),
            'cover_image' => $record?->cover_image,
            'title' => $validated['title'],
            'contact_name' => $validated['contact_name'] ?? null,
            'contact_email' => $validated['contact_email'] ?? null,
            'contact_phone' => $validated['contact_phone'] ?? null,
            'destination' => $validated['destination'] ?? null,
            'travel_type' => $validated['travel_type'] ?? null,
            'travel_start' => $validated['travel_start'] ?? null,
            'travel_end' => $validated['travel_end'] ?? null,
            'amount' => $validated['amount'] ?? null,
            'status' => $validated['status'] ?? 'pending',
            'description' => $validated['description'] ?? null,
            'details' => $this->normalizeDetails($validated['details'] ?? null),
            'flight_record_id' => $module === 'packages' ? ($validated['flight_record_id'] ?? null) : null,
            'hotel_record_id' => $module === 'packages' ? ($validated['hotel_record_id'] ?? null) : null,
        ];

        if ($request->hasFile('cover_image')) {
            if ($record?->cover_image) {
                Storage::disk('public')->delete($record->cover_image);
            }

            $payload['cover_image'] = $request->file('cover_image')->store("agent-records/{$module}", 'public');
        }

        return $payload;
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
            ->merge(AgentSetting::query()->pluck('value', 'name')->all())
            ->all();
    }
}
