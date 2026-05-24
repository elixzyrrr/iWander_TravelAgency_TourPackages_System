<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $agentRecord->title ?? 'Hotel Details' }} - iWander</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Gwendolyn:wght@700&display=swap" rel="stylesheet">
    @vite(['resources/css/hotel-details.css', 'resources/js/hotel-details.js'])
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
        <div class="hotel-hero">
            <img src="{{ $agentRecord->cover_image ?? 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=1400' }}" alt="{{ $agentRecord->title }}" class="hero-image">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <div class="hotel-info">
                    <svg class="hotel-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="hotel-name">{{ $agentRecord->destination ?? 'Hotel' }}</span>
                </div>
                <h1 class="route-title">{{ $agentRecord->title }}</h1>
                <div class="rating-section">
                    <svg class="star-icon" viewBox="0 0 20 20">
                        <path d="M10 1L12.9389 6.98278L19.5106 7.90983L14.7553 12.5172L15.8779 19.0902L10 15.98L4.12215 19.0902L5.24472 12.5172L0.489435 7.90983L7.06107 6.98278L10 1Z"/>
                    </svg>
                    <span class="rating-value">4.7</span>
                    <span class="rating-count">(389 reviews)</span>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h2a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h2a1 1 0 001-1V9m-9 9l-2-2m0 0L3 9"/>
                        </svg>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Room Type</div>
                        <div class="info-value">Luxury Suite</div>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Check-in</div>
                        <div class="info-value">3:00 PM</div>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Occupancy</div>
                        <div class="info-value">Up to 4 Guests</div>
                    </div>
                </div>
            </div>

            <!-- Hotel Details Section -->
            <div class="section-divider">
                <h3 class="section-title">Hotel Details</h3>
                <p class="section-text">{{ $agentRecord->description ?? 'Experience luxury and comfort at this exquisite hotel.' }}</p>

                <div class="two-columns">
                    <div>
                        <h4 class="column-title">Amenities</h4>
                        <ul class="amenity-list">
                            <li class="amenity-item">
                                <svg class="check-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M16.667 5L7.5 14.167 3.333 10"/>
                                </svg>
                                <span class="amenity-text">Free WiFi in all rooms</span>
                            </li>
                            <li class="amenity-item">
                                <svg class="check-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M16.667 5L7.5 14.167 3.333 10"/>
                                </svg>
                                <span class="amenity-text">Fitness Center & Spa</span>
                            </li>
                            <li class="amenity-item">
                                <svg class="check-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M16.667 5L7.5 14.167 3.333 10"/>
                                </svg>
                                <span class="amenity-text">Swimming Pool</span>
                            </li>
                            <li class="amenity-item">
                                <svg class="check-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M16.667 5L7.5 14.167 3.333 10"/>
                                </svg>
                                <span class="amenity-text">24/7 Room Service</span>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="column-title">Room Features</h4>
                        <ul class="amenity-list">
                            <li class="amenity-item">
                                <svg class="check-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M16.667 5L7.5 14.167 3.333 10"/>
                                </svg>
                                <span class="amenity-text">Luxury Bedding</span>
                            </li>
                            <li class="amenity-item">
                                <svg class="check-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M16.667 5L7.5 14.167 3.333 10"/>
                                </svg>
                                <span class="amenity-text">Premium Bathroom</span>
                            </li>
                            <li class="amenity-item">
                                <svg class="check-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M16.667 5L7.5 14.167 3.333 10"/>
                                </svg>
                                <span class="amenity-text">Smart TV & Entertainment</span>
                            </li>
                            <li class="amenity-item">
                                <svg class="check-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M16.667 5L7.5 14.167 3.333 10"/>
                                </svg>
                                <span class="amenity-text">Work Desk & Chair</span>
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
                        <span class="provider-label">Listed by:</span>
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

        <!-- Location Section -->
        <div class="map-section">
            <div class="map-header">
                <svg class="map-icon" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <h3 class="map-title">Location</h3>
            </div>
            <div class="map-container">
                <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?w=1400&h=600&fit=crop" alt="Location Map" class="map-placeholder">
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="reviews-section">
            <h3 class="reviews-header">Guest Reviews & Photos</h3>

            <div class="review-card">
                <div class="reviewer-info">
                    <img src="https://i.pravatar.cc/150?img=2" alt="Guest" class="reviewer-avatar">
                    <div class="reviewer-details">
                        <div class="reviewer-name">Maria Garcia</div>
                        <div class="review-date">3 weeks ago</div>
                    </div>
                    <div class="review-stars">
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                    </div>
                </div>
                <p class="review-text">Wonderful stay! The staff was very attentive and the room was impeccably clean. Highly recommend this hotel for your next vacation.</p>
                <div class="review-images">
                    <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=300&h=200&fit=crop" alt="Review" class="review-image">
                </div>
            </div>
        </div>
    </main>

    <!-- Booking Footer -->
    <div class="booking-footer">
        <div class="booking-container">
            <div class="price-section">
                <div class="price-label">Starting from per night</div>
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
