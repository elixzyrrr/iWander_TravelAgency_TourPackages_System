<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $agentRecord->title ?? 'Tour Package' }} - iWander</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Gwendolyn:wght@700&display=swap" rel="stylesheet">
    @vite(['resources/css/tour-details.css', 'resources/js/tour-details.js'])
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('user.dashboard') }}" class="logo-section">
                <svg viewBox="0 0 61 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M30.5 0L61 47H0L30.5 0Z" fill="white" opacity="0.9"/>
                    <path d="M30.5 10L50 40H11L30.5 10Z" fill="rgba(255,255,255,0.3)"/>
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
        <div class="tour-hero">
            <img src="{{ $agentRecord->cover_image ?? 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=1400' }}" alt="{{ $agentRecord->title }}" class="hero-image">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <div class="tour-info">
                    <svg class="tour-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3.724a1 1 0 001.447-.894V5.618a1 1 0 00-1.447-.894L15 7m0 13V7m6 6.618V5.618a1 1 0 00-1.447-.894L21 7"/>
                    </svg>
                    <span class="tour-name">{{ $agentRecord->destination ?? 'Tour Package' }}</span>
                </div>
                <h1 class="route-title">{{ $agentRecord->title }}</h1>
                <div class="rating-section">
                    <svg class="star-icon" viewBox="0 0 20 20">
                        <path d="M10 1L12.9389 6.98278L19.5106 7.90983L14.7553 12.5172L15.8779 19.0902L10 15.98L4.12215 19.0902L5.24472 12.5172L0.489435 7.90983L7.06107 6.98278L10 1Z"/>
                    </svg>
                    <span class="rating-value">4.9</span>
                    <span class="rating-count">(512 reviews)</span>
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
                        <div class="info-value">7 Days / 6 Nights</div>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H7m10 0v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Group Size</div>
                        <div class="info-value">Up to 20 Travelers</div>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Difficulty</div>
                        <div class="info-value">Moderate</div>
                    </div>
                </div>
            </div>

            <!-- Tour Details Section -->
            <div class="section-divider">
                <h3 class="section-title">Tour Highlights</h3>
                <p class="section-text">{{ $agentRecord->description ?? 'Join us for an unforgettable journey through some of the world\'s most beautiful destinations.' }}</p>

                <div class="two-columns">
                    <div>
                        <h4 class="column-title">Included in Package</h4>
                        <ul class="amenity-list">
                            <li class="amenity-item">
                                <svg class="check-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M16.667 5L7.5 14.167 3.333 10"/>
                                </svg>
                                <span class="amenity-text">Round-trip transportation</span>
                            </li>
                            <li class="amenity-item">
                                <svg class="check-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M16.667 5L7.5 14.167 3.333 10"/>
                                </svg>
                                <span class="amenity-text">6 nights accommodation</span>
                            </li>
                            <li class="amenity-item">
                                <svg class="check-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M16.667 5L7.5 14.167 3.333 10"/>
                                </svg>
                                <span class="amenity-text">All meals & beverages</span>
                            </li>
                            <li class="amenity-item">
                                <svg class="check-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M16.667 5L7.5 14.167 3.333 10"/>
                                </svg>
                                <span class="amenity-text">Professional guide</span>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="column-title">What to Bring</h4>
                        <ul class="amenity-list">
                            <li class="amenity-item">
                                <svg class="check-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M16.667 5L7.5 14.167 3.333 10"/>
                                </svg>
                                <span class="amenity-text">Comfortable hiking boots</span>
                            </li>
                            <li class="amenity-item">
                                <svg class="check-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M16.667 5L7.5 14.167 3.333 10"/>
                                </svg>
                                <span class="amenity-text">Weather-appropriate clothing</span>
                            </li>
                            <li class="amenity-item">
                                <svg class="check-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M16.667 5L7.5 14.167 3.333 10"/>
                                </svg>
                                <span class="amenity-text">Sunscreen & hat</span>
                            </li>
                            <li class="amenity-item">
                                <svg class="check-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M16.667 5L7.5 14.167 3.333 10"/>
                                </svg>
                                <span class="amenity-text">Camera & binoculars</span>
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
                        <span class="provider-label">Organized by:</span>
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

        <!-- Itinerary Section -->
        <div class="itinerary-section">
            <h3 class="section-title">Detailed Itinerary</h3>

            <div class="itinerary-day">
                <div class="day-header">
                    <span class="day-number">Day 1</span>
                    <h4 class="day-title">Arrival & City Orientation</h4>
                </div>
                <p class="day-description">Arrive at the airport and transfer to your hotel. After check-in, enjoy a welcome dinner and explore the city center on a guided walking tour.</p>
            </div>

            <div class="itinerary-day">
                <div class="day-header">
                    <span class="day-number">Day 2</span>
                    <h4 class="day-title">Cultural Heritage Tour</h4>
                </div>
                <p class="day-description">Visit historic monuments and museums. Learn about local history and culture from our expert guides. Lunch at a traditional restaurant.</p>
            </div>

            <div class="itinerary-day">
                <div class="day-header">
                    <span class="day-number">Day 3 - 5</span>
                    <h4 class="day-title">Adventure Activities</h4>
                </div>
                <p class="day-description">Enjoy hiking, water sports, or other adventure activities depending on your preference. Each day offers new experiences and stunning views.</p>
            </div>

            <div class="itinerary-day">
                <div class="day-header">
                    <span class="day-number">Day 6</span>
                    <h4 class="day-title">Leisure & Shopping</h4>
                </div>
                <p class="day-description">Free time to explore local markets, do some souvenir shopping, or relax at the hotel spa and facilities.</p>
            </div>

            <div class="itinerary-day">
                <div class="day-header">
                    <span class="day-number">Day 7</span>
                    <h4 class="day-title">Departure</h4>
                </div>
                <p class="day-description">Enjoy a final breakfast with the group and transfer to the airport for your departure. Safe travels!</p>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="reviews-section">
            <h3 class="reviews-header">Traveler Reviews & Photos</h3>

            <div class="review-card">
                <div class="reviewer-info">
                    <img src="https://i.pravatar.cc/150?img=5" alt="Traveler" class="reviewer-avatar">
                    <div class="reviewer-details">
                        <div class="reviewer-name">John Martinez</div>
                        <div class="review-date">1 month ago</div>
                    </div>
                    <div class="review-stars">
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                    </div>
                </div>
                <p class="review-text">Fantastic tour! Everything was well-organized and the guide was very knowledgeable. I especially loved the hiking experience and meeting people from around the world.</p>
                <div class="review-images">
                    <img src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=300&h=200&fit=crop" alt="Review" class="review-image">
                </div>
            </div>
        </div>
    </main>

    <!-- Booking Footer -->
    <div class="booking-footer">
        <div class="booking-container">
            <div class="price-section">
                <div class="price-label">Price per person</div>
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
            module: '{{ $agentRecord->module }}'
        };
    </script>
</body>
</html>
