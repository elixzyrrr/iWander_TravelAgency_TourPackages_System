<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserDashboardBooking;
use App\Models\UserDashboardItem;
use App\Models\UserDashboardProfile;
use App\Models\UserDashboardSection;
use App\Models\AirlineOption;
use App\Models\HotelRoomOption;
use App\Models\TourDateOption;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Str;
use App\Models\AgentRecord;

class UserDashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(function (Request $request, Closure $next) {
                abort_unless(in_array($request->user()?->role, ['user', 'staff', 'manager'], true), 403);

                return $next($request);
            }),
        ];
    }

    public function dashboard(Request $request): Response
    {
        $user = $request->user();

        $profile = UserDashboardProfile::query()->firstOrCreate(['user_id' => $user->id]);

        $sections = UserDashboardSection::query()
            ->with(['items' => fn ($query) => $query->orderBy('sort_order')])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $bookings = UserDashboardBooking::query()
            ->with(['section', 'item'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(6)
            ->get();

        $navigationSections = $sections->filter(fn ($section) => filled($section->nav_label))->values();
        $searchSections = $sections->filter(fn ($section) => $section->is_searchable)->values();

        $activeSectionKey = $request->query('section', $profile->home_section_key ?: ($sections->first()?->key ?? 'flights'));

        if (! $sections->contains('key', $activeSectionKey)) {
            $activeSectionKey = $sections->first()?->key ?? 'flights';
        }

        $activeSearchKey = $searchSections->contains('key', $activeSectionKey)
            ? $activeSectionKey
            : null;

        $viewData = [
            'user' => $user,
            'profile' => $profile,
            'sections' => $sections,
            'navigationSections' => $navigationSections,
            'searchSections' => $searchSections,
            'bookings' => $bookings,
            'activeSectionKey' => $activeSectionKey,
            'activeSearchKey' => $activeSearchKey,
            'activeSection' => $sections->firstWhere('key', $activeSectionKey) ?? $sections->first(),
        ];

        // include agent-created records for flights, hotels and packages
        $agentRecords = AgentRecord::query()
            ->with(['creator:id,name,role'])
            ->whereIn('module', ['flights', 'hotels', 'packages'])
            ->latest()
            ->get()
            ->groupBy('module');

        $html = view('user.user_dashboard', $viewData)->render();
        $payload = json_encode($this->buildDashboardPayload(
            $user,
            $profile,
            $sections,
            $navigationSections,
            $searchSections,
            $bookings,
            $activeSectionKey,
            $activeSearchKey,
            $agentRecords
        ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $dashboardAssets = '<script>window.__USER_DASHBOARD__ = '.($payload ?: '{}').';</script>'
            .'<script type="module" src="'.e(Vite::asset('resources/js/user_dashboard.js')).'"></script>';

        $html = str_replace('</body>', $dashboardAssets.'</body>', $html);

        return response($html);
    }

    public function storeBooking(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'booking_type' => ['required', 'in:flights,stays,tours'],
            'section_key' => ['required', 'exists:user_dashboard_sections,key'],
            'item_id' => ['nullable', 'exists:user_dashboard_items,id'],
            'agent_record_id' => ['nullable', 'exists:agent_records,id'],
            'origin' => ['nullable', 'string', 'max:255'],
            'destination' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'travelers' => ['nullable', 'integer', 'min:1'],
            'rooms' => ['nullable', 'integer', 'min:1'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        abort_unless($validated['item_id'] || $validated['agent_record_id'], 422, 'Select a booking item first.');

        $item = $validated['item_id']
            ? UserDashboardItem::query()->find($validated['item_id'])
            : null;

        $agentRecord = $validated['agent_record_id']
            ? AgentRecord::query()->find($validated['agent_record_id'])
            : null;

        $section = UserDashboardSection::query()
            ->where('key', $validated['section_key'])
            ->firstOrFail();

        $referenceCode = 'BK-'.Str::upper(Str::random(8));

        $amount = $item?->price
            ?? $agentRecord?->amount
            ?? ($validated['budget'] ?? null);

        UserDashboardBooking::query()->create([
            'user_id' => $request->user()->id,
            'user_dashboard_section_id' => $section->id,
            'user_dashboard_item_id' => $item?->id,
            'agent_record_id' => $agentRecord?->id,
            'booking_type' => $validated['booking_type'],
            'reference_code' => $referenceCode,
            'origin' => $validated['origin'] ?? null,
            'destination' => $validated['destination'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'travelers' => $validated['travelers'] ?? 1,
            'rooms' => $validated['rooms'] ?? null,
            'budget' => $validated['budget'] ?? null,
            'amount' => $amount,
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        $profile = UserDashboardProfile::query()->firstOrCreate(['user_id' => $request->user()->id]);
        $profile->update([
            'home_section_key' => $validated['booking_type'],
            'trips_count' => ($profile->trips_count ?? 0) + 1,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'referenceCode' => $referenceCode,
            ]);
        }

        return back()->with('success', 'Booking saved successfully.');
    }

    private function buildDashboardPayload(
        $user,
        UserDashboardProfile $profile,
        $sections,
        $navigationSections,
        $searchSections,
        $bookings,
        string $activeSectionKey,
        ?string $activeSearchKey,
        $agentRecords
    ): array {
        return [
            'csrfToken' => csrf_token(),
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'profile' => [
                'homeSectionKey' => $profile->home_section_key,
                'tripsCount' => $profile->trips_count,
                'points' => $profile->points,
                'preferredDestination' => $profile->preferred_destination,
                'preferredTravelStyle' => $profile->preferred_travel_style,
                'notes' => $profile->notes,
            ],
            'sections' => $sections->map(fn (UserDashboardSection $section) => $this->formatSectionPayload($section, $agentRecords))->values()->all(),
            'navigationSections' => $navigationSections->map(fn (UserDashboardSection $section) => $this->formatSectionPayload($section))->values()->all(),
            'searchSections' => $searchSections->map(fn (UserDashboardSection $section) => $this->formatSectionPayload($section))->values()->all(),
            'bookings' => $bookings->map(fn (UserDashboardBooking $booking) => $this->formatBookingPayload($booking))->values()->all(),
            'activeSectionKey' => $activeSectionKey,
            'activeSearchKey' => $activeSearchKey,
        ];
    }

    private function formatSectionPayload(UserDashboardSection $section, $agentRecords = null): array
    {
        $items = $section->items->map(fn (UserDashboardItem $item) => $this->formatItemPayload($item))->values()->all();

        // map agent records into items when appropriate
        if ($agentRecords instanceof \Illuminate\Support\Collection || is_array($agentRecords)) {
            $moduleKey = match ($section->key) {
                'flights' => 'flights',
                'stays' => 'hotels',
                'tours' => 'packages',
                default => null,
            };

            if ($moduleKey && ($agentRecords[$moduleKey] ?? null)) {
                foreach ($agentRecords[$moduleKey] as $agentRecord) {
                    $items[] = [
                        'id' => 'agent-'.$agentRecord->id,
                        'sourceType' => 'agent',
                        'sourceId' => $agentRecord->id,
                        'title' => $agentRecord->title,
                        'description' => $agentRecord->description ?? $agentRecord->destination ?? null,
                        'imageUrl' => $agentRecord->cover_image ?? null,
                        'price' => $agentRecord->amount ?? null,
                        'currency' => 'PHP',
                        'meta' => [
                            'agent_id' => $agentRecord->created_by,
                            'agent_module' => $agentRecord->module,
                            'creator_name' => $agentRecord->creator?->name,
                            'creator_role' => $agentRecord->creator?->role,
                        ],
                        'creatorName' => $agentRecord->creator?->name,
                        'creatorRole' => $agentRecord->creator?->role,
                        'sortOrder' => 9999,
                        'isFeatured' => false,
                    ];
                }
            }
        }

        return [
            'id' => $section->id,
            'key' => $section->key,
            'navLabel' => $section->nav_label,
            'navIcon' => $section->nav_icon,
            'title' => $section->title,
            'subtitle' => $section->subtitle,
            'sectionType' => $section->section_type,
            'body' => $section->body,
            'sortOrder' => $section->sort_order,
            'isSearchable' => $section->is_searchable,
            'items' => $items,
        ];
    }

    private function formatItemPayload(UserDashboardItem $item): array
    {
        return [
            'id' => $item->id,
            'sourceType' => 'dashboard',
            'sourceId' => $item->id,
            'title' => $item->title,
            'description' => $item->description,
            'imageUrl' => $item->image_url,
            'price' => $item->price,
            'currency' => $item->currency,
            'meta' => $item->meta,
            'sortOrder' => $item->sort_order,
            'isFeatured' => $item->is_featured,
        ];
    }

    private function formatBookingPayload(UserDashboardBooking $booking): array
    {
        return [
            'id' => $booking->id,
            'referenceCode' => $booking->reference_code,
            'bookingType' => $booking->booking_type,
            'origin' => $booking->origin,
            'destination' => $booking->destination,
            'startDate' => $booking->start_date?->toDateString(),
            'endDate' => $booking->end_date?->toDateString(),
            'travelers' => $booking->travelers,
            'rooms' => $booking->rooms,
            'budget' => $booking->budget,
            'amount' => $booking->amount,
            'status' => $booking->status,
            'notes' => $booking->notes,
        ];
    }

    public function showDetail(Request $request, string $type, int $id): Response
    {
        $user = $request->user();
        
        abort_unless(in_array($type, ['flights', 'hotels', 'tours'], true), 404);
        
        $moduleMap = [
            'flights' => 'flights',
            'hotels' => 'hotels',
            'tours' => 'packages',
        ];
        
        $agentRecord = AgentRecord::query()
            ->with(['creator:id,name,role,email'])
            ->where('module', $moduleMap[$type])
            ->where('id', $id)
            ->firstOrFail();
        
        $viewMap = [
            'flights' => 'user.details.flight-details',
            'hotels' => 'user.details.hotel-details',
            'tours' => 'user.details.tour-details',
        ];
        
        $data = [
            'user' => $user,
            'agentRecord' => $agentRecord,
            'type' => $type,
        ];
        
        return response(view($viewMap[$type], $data)->render());
    }

    public function showAirlines(Request $request, int $flightId): Response
    {
        $user = $request->user();
        
        // Fetch the flight record with seeded airline details
        $flight = AgentRecord::query()
            ->with(['creator:id,name,role,email'])
            ->where('module', 'flights')
            ->where('id', $flightId)
            ->firstOrFail();

        $airlines = AirlineOption::query()
            ->where('agent_record_id', $flight->id)
            ->orderBy('sort_order')
            ->get()
            ->map(fn (AirlineOption $airline) => [
                'id' => $airline->id,
                'name' => $airline->airline_name,
                'code' => $airline->airline_code,
                'icon' => $airline->icon,
                'flights' => $airline->flights,
            ])
            ->all();

        if (! filled($airlines)) {
            $airlines = [
                [
                    'id' => 1,
                    'name' => 'Philippine Airlines',
                    'code' => 'PR',
                    'icon' => '🇵🇭',
                    'flights' => [
                        ['departure' => '08:00', 'arrival' => '15:30', 'duration' => '7h 30m', 'stops' => 0, 'price' => 45000],
                        ['departure' => '14:00', 'arrival' => '21:30', 'duration' => '7h 30m', 'stops' => 0, 'price' => 42000],
                    ]
                ],
            ];
        }
        
        $data = [
            'user' => $user,
            'flight' => $flight,
            'airlines' => $airlines,
        ];
        
        return response(view('user.airlines.airlines-selection', $data)->render());
    }

    public function showRooms(Request $request, int $hotelId): Response
    {
        $user = $request->user();
        
        // Fetch the hotel record with seeded room details
        $hotel = AgentRecord::query()
            ->with(['creator:id,name,role,email'])
            ->where('module', 'hotels')
            ->where('id', $hotelId)
            ->firstOrFail();

        $rooms = HotelRoomOption::query()
            ->where('agent_record_id', $hotel->id)
            ->orderBy('sort_order')
            ->get()
            ->map(fn (HotelRoomOption $room) => [
                'id' => $room->id,
                'roomType' => $room->room_type,
                'capacity' => $room->capacity,
                'availableRooms' => $room->available_rooms,
                'pricePerNight' => $room->price_per_night,
                'description' => $room->room_description,
                'amenities' => $room->amenities ?? [],
            ])
            ->all();

        $data = [
            'user' => $user,
            'hotel' => $hotel,
            'rooms' => $rooms,
        ];
        
        return response(view('user.hotels.rooms-selection', $data)->render());
    }

    public function showTourDates(Request $request, int $tourId): Response
    {
        $user = $request->user();
        
        // Fetch the tour record with seeded date details
        $tour = AgentRecord::query()
            ->with(['creator:id,name,role,email'])
            ->where('module', 'packages')
            ->where('id', $tourId)
            ->firstOrFail();

        $dates = TourDateOption::query()
            ->where('agent_record_id', $tour->id)
            ->orderBy('departure_date')
            ->get()
            ->map(fn (TourDateOption $date) => [
                'id' => $date->id,
                'departureDate' => $date->departure_date->format('Y-m-d'),
                'returnDate' => $date->return_date->format('Y-m-d'),
                'groupSize' => $date->group_size,
                'availableSlots' => $date->available_slots,
                'pricePerPerson' => $date->price_per_person,
                'description' => $date->tour_description,
                'includedItems' => $date->included_items ?? [],
                'excludedItems' => $date->excluded_items ?? [],
            ])
            ->all();

        $data = [
            'user' => $user,
            'tour' => $tour,
            'dates' => $dates,
        ];
        
        return response(view('user.tours.tour-dates-selection', $data)->render());
    }
}