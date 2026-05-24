<?php

declare(strict_types=1);

use App\Http\Controllers\User\UserDashboardController;
use App\Models\AgentRecord;
use App\Models\AirlineOption;
use App\Models\HotelRoomOption;
use App\Models\TourDateOption;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

function fail(string $message): never
{
    fwrite(STDERR, "[FAIL] {$message}".PHP_EOL);
    exit(1);
}

function pass(string $message): void
{
    fwrite(STDOUT, "[PASS] {$message}".PHP_EOL);
}

$agentUser = User::query()->whereIn('role', ['agent', 'admin', 'staff'])->orderBy('id')->first();
$customerUser = User::query()->where('role', 'user')->orderBy('id')->first();

if (! $agentUser) {
    fail('No agent/admin/staff user found to own test records.');
}

if (! $customerUser) {
    fail('No customer user found (role=user) for dashboard verification.');
}

$stamp = now()->format('YmdHis');
$flightTitle = "E2E Flight {$stamp}";
$hotelTitle = "E2E Hotel {$stamp}";
$tourTitle = "E2E Tour {$stamp}";
$airlineName = "E2E Airline {$stamp}";

$flight = null;
$hotel = null;
$tour = null;

try {
    $flight = AgentRecord::query()->create([
        'created_by' => $agentUser->id,
        'module' => 'flights',
        'reference_code' => "E2E-FLT-{$stamp}",
        'title' => $flightTitle,
        'destination' => 'Tokyo',
        'travel_type' => 'Flight',
        'travel_start' => now()->addDays(10)->toDateString(),
        'travel_end' => now()->addDays(11)->toDateString(),
        'amount' => 25000,
        'status' => 'available',
        'description' => 'End-to-end verification flight record',
    ]);

    $hotel = AgentRecord::query()->create([
        'created_by' => $agentUser->id,
        'module' => 'hotels',
        'reference_code' => "E2E-HTL-{$stamp}",
        'title' => $hotelTitle,
        'destination' => 'Tokyo',
        'travel_type' => 'Hotel',
        'travel_start' => now()->addDays(10)->toDateString(),
        'travel_end' => now()->addDays(12)->toDateString(),
        'amount' => 8000,
        'status' => 'available',
        'description' => 'End-to-end verification hotel record',
    ]);

    $tour = AgentRecord::query()->create([
        'created_by' => $agentUser->id,
        'module' => 'packages',
        'reference_code' => "E2E-TUR-{$stamp}",
        'title' => $tourTitle,
        'destination' => 'Kyoto',
        'travel_type' => 'Tour',
        'travel_start' => now()->addDays(15)->toDateString(),
        'travel_end' => now()->addDays(18)->toDateString(),
        'amount' => 18000,
        'status' => 'published',
        'description' => 'End-to-end verification tour record',
        'flight_record_id' => $flight->id,
        'hotel_record_id' => $hotel->id,
    ]);

    AirlineOption::query()->create([
        'agent_record_id' => $flight->id,
        'airline_name' => $airlineName,
        'airline_code' => 'E2E',
        'icon' => 'E2E',
        'sort_order' => 1,
        'flights' => [
            ['departure' => '08:00', 'arrival' => '12:00', 'duration' => '4h 0m', 'stops' => 0, 'price' => 25000],
        ],
    ]);

    HotelRoomOption::query()->create([
        'agent_record_id' => $hotel->id,
        'room_type' => 'E2E Suite',
        'capacity' => 2,
        'available_rooms' => 5,
        'price_per_night' => 8000,
        'room_description' => 'E2E room verification',
        'amenities' => ['WiFi', 'Breakfast'],
        'sort_order' => 1,
    ]);

    TourDateOption::query()->create([
        'agent_record_id' => $tour->id,
        'departure_date' => now()->addDays(15)->toDateString(),
        'return_date' => now()->addDays(18)->toDateString(),
        'group_size' => 12,
        'available_slots' => 10,
        'price_per_person' => 18000,
        'tour_description' => 'E2E date verification',
        'included_items' => ['Guide', 'Transfers'],
        'excluded_items' => ['Flights'],
        'sort_order' => 1,
    ]);

    pass('Agent records and dependent options were created.');

    $controller = app(UserDashboardController::class);

    $dashboardRequest = Request::create('/user/dashboard', 'GET');
    $dashboardRequest->setUserResolver(static fn () => $customerUser);
    $dashboardResponse = $controller->dashboard($dashboardRequest);
    $dashboardHtml = $dashboardResponse->getContent();

    if (! str_contains($dashboardHtml, $flightTitle) || ! str_contains($dashboardHtml, $hotelTitle) || ! str_contains($dashboardHtml, $tourTitle)) {
        fail('Customer dashboard payload did not include one or more created agent records.');
    }
    pass('Customer dashboard contains created flight/hotel/tour records.');

    $flightDetailRequest = Request::create("/flights/details/{$flight->id}", 'GET');
    $flightDetailRequest->setUserResolver(static fn () => $customerUser);
    $flightDetailResponse = $controller->showDetail($flightDetailRequest, 'flights', $flight->id);
    if ($flightDetailResponse->getStatusCode() !== 200 || ! str_contains($flightDetailResponse->getContent(), $flightTitle)) {
        fail('Flight detail page does not resolve created flight record.');
    }
    pass('Flight detail page resolves created flight record.');

    $hotelDetailRequest = Request::create("/hotels/details/{$hotel->id}", 'GET');
    $hotelDetailRequest->setUserResolver(static fn () => $customerUser);
    $hotelDetailResponse = $controller->showDetail($hotelDetailRequest, 'hotels', $hotel->id);
    if ($hotelDetailResponse->getStatusCode() !== 200 || ! str_contains($hotelDetailResponse->getContent(), $hotelTitle)) {
        fail('Hotel detail page does not resolve created hotel record.');
    }
    pass('Hotel detail page resolves created hotel record.');

    $tourDetailRequest = Request::create("/tours/details/{$tour->id}", 'GET');
    $tourDetailRequest->setUserResolver(static fn () => $customerUser);
    $tourDetailResponse = $controller->showDetail($tourDetailRequest, 'tours', $tour->id);
    if ($tourDetailResponse->getStatusCode() !== 200 || ! str_contains($tourDetailResponse->getContent(), $tourTitle)) {
        fail('Tour detail page does not resolve created package record.');
    }
    pass('Tour detail page resolves created package record.');

    $airlineRequest = Request::create("/flights/airlines/{$flight->id}", 'GET');
    $airlineRequest->setUserResolver(static fn () => $customerUser);
    $airlineResponse = $controller->showAirlines($airlineRequest, $flight->id);
    if ($airlineResponse->getStatusCode() !== 200 || ! str_contains($airlineResponse->getContent(), $airlineName)) {
        fail('Airline selection did not include created airline option.');
    }
    pass('Airline selection includes created airline option.');

    $roomsRequest = Request::create("/hotels/rooms/{$hotel->id}", 'GET');
    $roomsRequest->setUserResolver(static fn () => $customerUser);
    $roomsResponse = $controller->showRooms($roomsRequest, $hotel->id);
    if ($roomsResponse->getStatusCode() !== 200 || ! str_contains($roomsResponse->getContent(), 'E2E Suite')) {
        fail('Room selection did not include created hotel room option.');
    }
    pass('Room selection includes created hotel room option.');

    $datesRequest = Request::create("/tours/dates/{$tour->id}", 'GET');
    $datesRequest->setUserResolver(static fn () => $customerUser);
    $datesResponse = $controller->showTourDates($datesRequest, $tour->id);
    if ($datesResponse->getStatusCode() !== 200 || ! str_contains($datesResponse->getContent(), 'E2E date verification')) {
        fail('Tour date selection did not include created tour date option.');
    }
    pass('Tour date selection includes created tour date option.');

    pass('End-to-end verification completed successfully.');
} finally {
    if ($tour) {
        TourDateOption::query()->where('agent_record_id', $tour->id)->delete();
    }
    if ($hotel) {
        HotelRoomOption::query()->where('agent_record_id', $hotel->id)->delete();
    }
    if ($flight) {
        AirlineOption::query()->where('agent_record_id', $flight->id)->delete();
    }

    if ($tour) {
        $tour->delete();
    }
    if ($hotel) {
        $hotel->delete();
    }
    if ($flight) {
        $flight->delete();
    }
}
