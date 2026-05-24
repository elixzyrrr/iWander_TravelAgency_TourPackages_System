<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Dates - {{ $tour->title }} - iWander</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Gwendolyn:wght@700&display=swap" rel="stylesheet">
    @vite(['resources/css/tour-dates-selection.css', 'resources/js/tour-selection.js'])
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
            <a href="{{ route('detail.show', ['type' => 'tours', 'id' => $tour->id]) }}" class="back-btn">
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
            <span class="breadcrumb-item">Tour Details</span>
            <span class="breadcrumb-sep">/</span>
            <span class="breadcrumb-item active">Select Dates</span>
        </div>

        <!-- Tour Summary Section -->
        <div class="tour-summary">
            <div class="summary-header">
                <h2>{{ $tour->title }}</h2>
                <span class="summary-destination">{{ $tour->destination }}</span>
            </div>
            <div class="summary-details">
                <div class="summary-item">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Multiple departure dates available</span>
                </div>
                <div class="summary-item">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>₱{{ number_format($tour->amount, 0) }} base price</span>
                </div>
            </div>
        </div>

        <!-- Dates Selection -->
        <div class="dates-container">
            <h3 class="section-title">Available Departure Dates</h3>
            <div class="dates-list">
                @foreach($dates as $date)
                <div class="date-card">
                    <div class="date-selection">
                        <input type="radio" id="date-{{ $date['id'] }}" name="selected-date" value="{{ $date['id'] }}" class="date-radio">
                        <label for="date-{{ $date['id'] }}" class="date-label">
                            <div class="date-header">
                                <div class="date-info">
                                    <h4 class="date-range">
                                        {{ \Carbon\Carbon::parse($date['departureDate'])->format('M d') }} - {{ \Carbon\Carbon::parse($date['returnDate'])->format('M d, Y') }}
                                    </h4>
                                    <span class="trip-duration">{{ \Carbon\Carbon::parse($date['departureDate'])->diffInDays($date['returnDate']) }} days</span>
                                </div>
                                <span class="slots-availability">{{ $date['availableSlots'] }} slots left</span>
                            </div>
                            <div class="date-details">
                                <div class="detail-item">
                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10h.01M13 10h.01M11 10h.01M9 10h.01M7 10h.01"/>
                                    </svg>
                                    <span>Group size: {{ $date['groupSize'] }} people</span>
                                </div>
                                @if($date['description'])
                                <p class="date-description">{{ $date['description'] }}</p>
                                @endif
                                @if(!empty($date['includedItems']))
                                <div class="included-items">
                                    <h5>Included:</h5>
                                    <ul>
                                        @foreach($date['includedItems'] as $item)
                                        <li>{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                            <div class="date-price">
                                <span class="price-label">Per person</span>
                                <span class="price-value">₱{{ number_format($date['pricePerPerson'], 0) }}</span>
                            </div>
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Sticky Footer with Action -->
        <div class="sticky-footer">
            <button class="btn-confirm" id="confirmDateBtn" disabled>Confirm & Continue to Booking</button>
        </div>
    </main>

    <!-- Data Script -->
    <script>
        const agentRecordId = {{ $tour->id }};
        const tourSelectionData = {
            tourId: {{ $tour->id }},
            tourTitle: "{{ $tour->title }}",
            tourDestination: "{{ $tour->destination }}",
            tourAmount: {{ $tour->amount }},
            creatorName: "{{ $tour->creator?->name ?? 'Agent' }}"
        };
    </script>
</body>
</html>
