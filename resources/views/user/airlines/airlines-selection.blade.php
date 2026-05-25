<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Airline - iWander</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Gwendolyn:wght@700&display=swap" rel="stylesheet">
    @vite(['resources/css/airlines-selection.css', 'resources/js/airlines-selection.js'])
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
            <a href="{{ $flight->id ? route('detail.show', ['type' => 'flights', 'id' => $flight->id]) : route('user.dashboard') }}" class="back-btn">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Back</span>
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header Section -->
        <div class="header-section">
            <div class="breadcrumb">
                <span class="breadcrumb-item">Flight Details</span>
                <svg class="breadcrumb-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="breadcrumb-item active">Select Airline</span>
            </div>
            <div class="page-title-row">
                <span class="page-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <path d="M2 12l19-9-4 9 4 9-19-9z" />
                        <path d="M2 12l7 2m7-2l-7-2" />
                    </svg>
                </span>
                <h1 class="page-title">Select Your Preferred Airline</h1>
            </div>
            <p class="page-subtitle">Choose from available airlines for {{ $flight->destination ?? 'your destination' }}</p>
        </div>

        <!-- Flight Summary -->
        <div class="flight-summary">
            <div class="summary-content">
                <div class="summary-item">
                    <span class="label">Flight Route</span>
                    <span class="value">{{ $flight->title ?? 'Flight' }}</span>
                </div>
                <div class="summary-divider">→</div>
                <div class="summary-item">
                    <span class="label">Price Range</span>
                    <span class="value">₱{{ number_format($flight->amount ?? 0) }}</span>
                </div>
                <div class="summary-divider">•</div>
                <div class="summary-item">
                    <span class="label">Available Airlines</span>
                    <span class="value">{{ count($airlines) }} options</span>
                </div>
            </div>
        </div>

        <!-- Airlines List -->
        <div class="airlines-container">
            @foreach($airlines as $airline)
            <div class="airline-card" data-airline-id="{{ $airline['id'] }}" data-airline-name="{{ $airline['name'] }}">
                <!-- Airline Header -->
                <div class="airline-header">
                    <div class="airline-info">
                        <div class="airline-badge">{{ $airline['icon'] }}</div>
                        <div class="airline-details">
                            <h3 class="airline-name">{{ $airline['name'] }}</h3>
                            <span class="airline-code">Code: {{ $airline['code'] }}</span>
                        </div>
                    </div>
                    <div class="airline-rating">
                        <svg class="star" viewBox="0 0 20 20">
                            <path d="M10 1L12.9389 6.98278L19.5106 7.90983L14.7553 12.5172L15.8779 19.0902L10 15.98L4.12215 19.0902L5.24472 12.5172L0.489435 7.90983L7.06107 6.98278L10 1Z" fill="currentColor"/>
                        </svg>
                        <span class="rating-value">4.5</span>
                    </div>
                </div>

                <!-- Flight Options -->
                <div class="flights-options">
                    @foreach($airline['flights'] as $index => $flightOption)
                    <div class="flight-option">
                        <div class="option-select">
                            <input type="radio" id="flight-{{ $airline['id'] }}-{{ $index }}" 
                                   name="airline-flight" value="{{ $airline['id'] }}-{{ $index }}"
                                   data-airline-id="{{ $airline['id'] }}"
                                   data-airline-name="{{ $airline['name'] }}"
                                   data-flight-data="{{ base64_encode(json_encode(array_merge($flightOption, ['airlineId' => $airline['id'], 'airlineName' => $airline['name']]))) }}"
                                   class="flight-radio">
                            <label for="flight-{{ $airline['id'] }}-{{ $index }}" class="option-label">
                                <div class="option-content">
                                    <div class="time-section">
                                        <div class="departure-time">{{ $flightOption['departure'] }}</div>
                                        <div class="arrival-time">{{ $flightOption['arrival'] }}</div>
                                    </div>
                                    <div class="duration-section">
                                        <div class="duration">{{ $flightOption['duration'] }}</div>
                                        <div class="stops">
                                            @if($flightOption['stops'] == 0)
                                            <span class="stop-badge nonstop">Non-stop</span>
                                            @else
                                            <span class="stop-badge stops">{{ $flightOption['stops'] }} Stop{{ $flightOption['stops'] > 1 ? 's' : '' }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="price-section">
                                    <span class="price-label">from</span>
                                    <span class="price-value">₱{{ number_format($flightOption['price']) }}</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- Booking Footer -->
        <div class="booking-footer">
            <div class="footer-content">
                <div class="selected-info">
                    <span class="info-label">Selected:</span>
                    <span class="info-value" id="selectedAirlineDisplay">Select an airline to continue</span>
                </div>
                <button class="book-btn" id="confirmBookingBtn" disabled>
                    <span>Confirm & Continue to Booking</span>
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
            </div>
        </div>
    </main>

    <!-- Data for JavaScript -->
    <script>
        const airlineSelectionData = {
            flightId: {{ $flight->id }},
            flightTitle: @json($flight->title),
            flightDescription: @json($flight->description),
            flightDestination: @json($flight->destination),
            flightAmount: {{ $flight->amount }},
               flightStartDate: @json($flightStartDate ?? null),
               flightEndDate: @json($flightEndDate ?? null),
            flightCoverImage: @json($flight->cover_image),
        };
    </script>
</body>
</html>
