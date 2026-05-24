<?php

use App\Http\Controllers\Agent\AgentModuleController;
use App\Http\Controllers\Admin\AdminModuleController;
use App\Http\Controllers\Content\ContentModuleController;
use App\Http\Controllers\User\UserDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing_page');
})->name('landing');

Route::view('/loading', 'loading')->name('loading');

require __DIR__.'/auth.php';

Route::middleware('auth')->get('/dashboard', function () {
    $role = auth()->user()?->role;

    return match ($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'agent' => redirect()->route('agent.dashboard'),
        default => redirect()->route('user.dashboard'),
    };
})->name('dashboard');

Route::middleware('auth')->get('/user/dashboard', [UserDashboardController::class, 'dashboard'])->name('user.dashboard');
Route::middleware('auth')->post('/user/dashboard/bookings', [UserDashboardController::class, 'storeBooking'])->name('user.bookings.store');
Route::middleware('auth')->get('/bookings/steps/booking', function (\Illuminate\Http\Request $request) {
    $bookingType = $request->query('type', 'flights');
    return view('bookings.steps.booking', ['bookingType' => $bookingType]);
})->name('booking.steps');
Route::middleware('auth')->get('/bookings/steps/seat-selection', function (\Illuminate\Http\Request $request) {
    $bookingType = $request->query('type', 'flights');

    return view('bookings.steps.booking_second', ['bookingType' => $bookingType]);
})->name('booking.steps.second');
Route::middleware('auth')->get('/bookings/steps/payment', function (\Illuminate\Http\Request $request) {
    $bookingType = $request->query('type', 'flights');

    return view('bookings.steps.booking_third', ['bookingType' => $bookingType]);
})->name('booking.steps.third');

// Detail pages for flights, hotels, and tours
Route::middleware('auth')->get('/{type}/details/{id}', [UserDashboardController::class, 'showDetail'])
    ->whereIn('type', ['flights', 'hotels', 'tours'])
    ->where('id', '\d+')
    ->name('detail.show');

// Airlines selection for flights
Route::middleware('auth')->get('/flights/airlines/{flightId}', [UserDashboardController::class, 'showAirlines'])
    ->where('flightId', '\d+')
    ->name('airlines.select');

// Rooms selection for hotels
Route::middleware('auth')->get('/hotels/rooms/{hotelId}', [UserDashboardController::class, 'showRooms'])
    ->where('hotelId', '\d+')
    ->name('rooms.select');

// Tour dates selection for tours
Route::middleware('auth')->get('/tours/dates/{tourId}', [UserDashboardController::class, 'showTourDates'])
    ->where('tourId', '\d+')
    ->name('tour-dates.select');


Route::middleware('auth')->post('/api/user/favorites', function (\Illuminate\Http\Request $request) {
    $user = $request->user();

    if (! $user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $validated = $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'favorited' => ['required', 'boolean'],
    ]);

    $key = "user:{$user->id}:favorites";
    $favorites = cache()->get($key, []);

    if ($validated['favorited']) {
        $favorites[$validated['title']] = now()->toDateTimeString();
    } else {
        unset($favorites[$validated['title']]);
    }

    cache()->put($key, $favorites, now()->addDays(365));

    return response()->json(['ok' => true]);
})->name('api.user.favorites');

Route::prefix('agent')->middleware('auth')->name('agent.')->group(function () {
    Route::get('/dashboard', [AgentModuleController::class, 'dashboard'])->name('dashboard');
    Route::get('/{module}', [AgentModuleController::class, 'module'])
        ->whereIn('module', ['bookings', 'customers', 'flights', 'hotels', 'packages', 'reports', 'settings'])
        ->name('module');
    Route::patch('/bookings/{booking}', [AgentModuleController::class, 'updateBookingStatus'])
        ->name('bookings.update');
    Route::post('/{module}', [AgentModuleController::class, 'store'])
        ->whereIn('module', ['bookings', 'flights', 'hotels', 'packages'])
        ->name('module.store');
    Route::put('/records/{agentRecord}', [AgentModuleController::class, 'update'])->name('records.update');
    Route::delete('/records/{agentRecord}', [AgentModuleController::class, 'destroy'])->name('records.destroy');
    Route::post('/settings', [AgentModuleController::class, 'updateSettings'])->name('settings.update');
});

Route::prefix('content')->middleware('auth')->name('content.')->group(function () {
    Route::get('/dashboard', [ContentModuleController::class, 'dashboard'])->name('dashboard');
    Route::get('/{module}', [ContentModuleController::class, 'module'])
        ->whereIn('module', ['bookings', 'customers', 'flights', 'hotels', 'packages', 'reports', 'settings'])
        ->name('module');
    Route::post('/{module}', [ContentModuleController::class, 'store'])
        ->whereIn('module', ['bookings', 'flights', 'hotels', 'packages'])
        ->name('module.store');
    Route::put('/records/{agentRecord}', [ContentModuleController::class, 'update'])->name('records.update');
    Route::delete('/records/{agentRecord}', [ContentModuleController::class, 'destroy'])->name('records.destroy');
    Route::post('/settings', [ContentModuleController::class, 'updateSettings'])->name('settings.update');
});

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/', [AdminModuleController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminModuleController::class, 'users'])->name('users.index');
    Route::post('/users', [AdminModuleController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminModuleController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminModuleController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminModuleController::class, 'destroyUser'])->name('users.destroy');
    Route::patch('/users/{user}/lock', [AdminModuleController::class, 'lockUser'])->name('users.lock');
    Route::patch('/users/{user}/unlock', [AdminModuleController::class, 'unlockUser'])->name('users.unlock');
    Route::get('/authentication', [AdminModuleController::class, 'authentication'])->name('authentication');
    Route::post('/authentication/reset-token', [AdminModuleController::class, 'generateResetToken'])->name('authentication.reset');
    Route::get('/system', [AdminModuleController::class, 'system'])->name('system');
    Route::post('/system', [AdminModuleController::class, 'updateSystem'])->name('system.update');
    Route::get('/financial', [AdminModuleController::class, 'financial'])->name('financial');
    Route::get('/analytics', [AdminModuleController::class, 'analytics'])->name('analytics');
});
