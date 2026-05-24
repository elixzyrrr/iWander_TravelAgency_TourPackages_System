<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Room - {{ $hotel->title }} - iWander</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Gwendolyn:wght@700&display=swap" rel="stylesheet">
    @vite(['resources/css/rooms-selection.css', 'resources/js/hotels-selection.js'])
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('user.dashboard') }}" class="logo-section">
                <svg viewBox="0 0 61 47" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="color: #237f87;">
                    <path d="M6 24L55 6L33 41L28 27L6 24Z" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M28 27L55 6" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="logo-text">iWander</span>
            </a>
            <a href="{{ route('detail.show', ['type' => 'hotels', 'id' => $hotel->id]) }}" class="back-btn">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Back</span>
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <span class="breadcrumb-item">Hotel Details</span>
            <span class="breadcrumb-sep">/</span>
            <span class="breadcrumb-item active">Select Room</span>
        </div>

        <!-- Hotel Summary Section -->
        <div class="hotel-summary">
            <div class="summary-header">
                <h2>{{ $hotel->title }}</h2>
                <span class="summary-destination">{{ $hotel->destination }}</span>
            </div>
            <div class="summary-details">
                <div class="summary-item">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Check-in dates flexible</span>
                </div>
                <div class="summary-item">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>₱{{ number_format($hotel->amount, 0) }} base price</span>
                </div>
            </div>
        </div>

        <!-- Rooms Selection -->
        <div class="rooms-container">
            <h3 class="section-title">Available Rooms</h3>
            <div class="rooms-list">
                @foreach($rooms as $room)
                <div class="room-card">
                    <div class="room-selection">
                        <input type="radio" id="room-{{ $room['id'] }}" name="selected-room" value="{{ $room['id'] }}" class="room-radio">
                        <label for="room-{{ $room['id'] }}" class="room-label">
                            <div class="room-header">
                                <h4 class="room-type">{{ $room['roomType'] }}</h4>
                                <span class="room-availability">{{ $room['availableRooms'] }} available</span>
                            </div>
                            <div class="room-details">
                                <div class="detail-item">
                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10h.01M13 10h.01M11 10h.01M9 10h.01M7 10h.01"/>
                                    </svg>
                                    <span>Up to {{ $room['capacity'] }} guests</span>
                                </div>
                                @if($room['description'])
                                <p class="room-description">{{ $room['description'] }}</p>
                                @endif
                                @if(!empty($room['amenities']))
                                <div class="amenities">
                                    @foreach($room['amenities'] as $amenity)
                                    <span class="amenity-tag">{{ $amenity }}</span>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            <div class="room-price">
                                <span class="price-label">Per night</span>
                                <span class="price-value">₱{{ number_format($room['pricePerNight'], 0) }}</span>
                            </div>
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Sticky Footer with Action -->
        <div class="sticky-footer">
            <button class="btn-confirm" id="confirmRoomBtn" disabled>Confirm & Continue to Booking</button>
        </div>
    </main>

    <!-- Data Script -->
    <script>
        const agentRecordId = {{ $hotel->id }};
        const roomSelectionData = {
            hotelId: {{ $hotel->id }},
            hotelTitle: "{{ $hotel->title }}",
            hotelDestination: "{{ $hotel->destination }}",
            hotelAmount: {{ $hotel->amount }},
            creatorName: "{{ $hotel->creator?->name ?? 'Agent' }}"
        };
    </script>
</body>
</html>
