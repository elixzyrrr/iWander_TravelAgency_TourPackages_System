<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $agentRecord->title ?? 'Flight Details' }} - iWander</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Gwendolyn:wght@700&display=swap" rel="stylesheet">
    @vite(['resources/css/flight-details.css', 'resources/js/flight-details.js'])
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
            <a href="{{ route('user.dashboard') }}" class="back-btn">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Back</span>
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Hero Section -->
        <div class="flight-hero">
            <img src="{{ $agentRecord->cover_image ?? 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=1400' }}" alt="{{ $agentRecord->title }}" class="hero-image">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <div class="airline-info">
                    <svg class="airline-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <path d="M2 12l19-9-4 9 4 9-19-9z" />
                        <path d="M2 12l7 2m7-2l-7-2" />
                    </svg>
                    <span class="airline-name">{{ $agentRecord->destination ?? 'Flight' }}</span>
                </div>
                <h1 class="route-title">{{ $agentRecord->title }}</h1>
                <div class="rating-section">
                    <svg class="star-icon" viewBox="0 0 20 20">
                        <path d="M10 1L12.9389 6.98278L19.5106 7.90983L14.7553 12.5172L15.8779 19.0902L10 15.98L4.12215 19.0902L5.24472 12.5172L0.489435 7.90983L7.06107 6.98278L10 1Z"/>
                    </svg>
                    <span class="rating-value">4.8</span>
                    <span class="rating-count">(245 reviews)</span>
                </div>
            </div>
        </div>

        <!-- Details Card -->
        <div class="details-card">
            <!-- Quick Info Grid -->
            <div class="quick-info">
                <div class="info-item">
                    <div class="info-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Duration</div>
                        <div class="info-value" id="duration">7h 30m</div>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Departure</div>
                        <div class="info-value">Daily Flights</div>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Capacity</div>
                        <div class="info-value">280 Passengers</div>
                    </div>
                </div>
            </div>

            <!-- Flight Details Section -->
            <div class="section-divider">
                <h3 class="section-title">Flight Details</h3>
                <p class="section-text">{{ $agentRecord->description ?? 'Experience world-class service on this flight.' }}</p>

                <div class="two-columns">
                    <div>
                        <h4 class="column-title">Included Amenities</h4>
                        <ul class="amenity-list">
                            <li class="amenity-item">
                                <svg class="check-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M16.667 5L7.5 14.167 3.333 10"/>
                                </svg>
                                <span class="amenity-text">In-flight Entertainment System</span>
                            </li>
                            <li class="amenity-item">
                                <svg class="check-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M16.667 5L7.5 14.167 3.333 10"/>
                                </svg>
                                <span class="amenity-text">Complimentary Meals & Beverages</span>
                            </li>
                            <li class="amenity-item">
                                <svg class="check-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M16.667 5L7.5 14.167 3.333 10"/>
                                </svg>
                                <span class="amenity-text">WiFi Available (Premium)</span>
                            </li>
                            <li class="amenity-item">
                                <svg class="check-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M16.667 5L7.5 14.167 3.333 10"/>
                                </svg>
                                <span class="amenity-text">USB & Power Outlets</span>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="column-title">Baggage Allowance</h4>
                        <ul class="amenity-list">
                            <li class="amenity-item">
                                <svg class="check-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M16.667 5L7.5 14.167 3.333 10"/>
                                </svg>
                                <span class="amenity-text">Carry-on: 1 bag (12kg)</span>
                            </li>
                            <li class="amenity-item">
                                <svg class="check-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M16.667 5L7.5 14.167 3.333 10"/>
                                </svg>
                                <span class="amenity-text">Checked: 2 bags (23kg each)</span>
                            </li>
                            <li class="amenity-item">
                                <svg class="check-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M16.667 5L7.5 14.167 3.333 10"/>
                                </svg>
                                <span class="amenity-text">Personal item included</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Provider Info -->
            <div class="section-divider">
                <h3 class="section-title">Provider Information</h3>
                <div class="provider-info">
                    <div class="provider-detail">
                        <span class="provider-label">Created by:</span>
                        <span class="provider-value">
                            {{ $agentRecord->creator?->name ?? 'iWander Staff' }}
                            @if($agentRecord->creator?->role)
                                <small class="provider-role">({{ ucfirst($agentRecord->creator->role) }})</small>
                            @endif
                        </span>
                    </div>
                    @if($agentRecord->creator?->email)
                        <div class="provider-detail">
                            <span class="provider-label">Contact:</span>
                            <span class="provider-value">{{ $agentRecord->creator->email }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="map-section">
            <div class="map-header">
                <svg class="map-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <h3 class="map-title">Route Map</h3>
            </div>
            <div class="map-container">
                <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?w=1400&h=600&fit=crop" alt="Route Map" class="map-placeholder">
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="reviews-section">
            <h3 class="reviews-header">Traveler Reviews & Photos</h3>

            <div class="review-card">
                <div class="reviewer-info">
                    <img src="https://i.pravatar.cc/150?img=1" alt="Sarah" class="reviewer-avatar">
                    <div class="reviewer-details">
                        <div class="reviewer-name">Sarah Johnson</div>
                        <div class="review-date">2 weeks ago</div>
                    </div>
                    <div class="review-stars">
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                    </div>
                </div>
                <p class="review-text">Amazing flight experience! The crew was incredibly attentive and the seats were very comfortable. The view of the city as we took off was breathtaking.</p>
                <div class="review-images">
                    <img src="https://images.unsplash.com/photo-1464037866556-6812c9d1c72e?w=300&h=200&fit=crop" alt="Review" class="review-image">
                </div>
            </div>
        </div>
    </main>

    <!-- Booking Footer -->
    <div class="booking-footer">
        <div class="booking-container">
            <div class="price-section">
                <div class="price-label">Starting from</div>
                <div class="price-value">{{ number_format($agentRecord->amount ?? 0, 0, ',', '.') }} ₱</div>
            </div>
            <button class="book-btn" onclick="proceedToBooking()">Book Now</button>
        </div>
    </div>

    <script>
        const agentRecordId = {{ $agentRecord->id }};
        const detailType = '{{ $type }}';
        const agentRecordData = {
            id: agentRecordId,
            title: '{{ addslashes($agentRecord->title ?? '') }}',
            description: '{{ addslashes($agentRecord->description ?? '') }}',
            destination: '{{ addslashes($agentRecord->destination ?? '') }}',
            amount: {{ $agentRecord->amount ?? 0 }},
            coverImage: '{{ $agentRecord->cover_image ?? '' }}',
            createdBy: {{ $agentRecord->created_by ?? 'null' }},
            creatorName: '{{ addslashes($agentRecord->creator?->name ?? '') }}',
            creatorRole: '{{ addslashes($agentRecord->creator?->role ?? '') }}',
            module: '{{ $agentRecord->module }}',
            travelStart: '{{ optional($agentRecord->travel_start)->format('Y-m-d') ?? '' }}',
            travelEnd: '{{ optional($agentRecord->travel_end)->format('Y-m-d') ?? '' }}'
        };
    </script>
</body>
</html>
