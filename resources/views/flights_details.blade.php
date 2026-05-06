You've been out of storage for 658 days … Not enough storage. You can't save to Drive, back up to Photos, and use Gmail. Get 30 GB for ₱10 for 3 months ₱49.
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Details - iWander</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Gwendolyn:wght@700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f9fafb; color: #101828; }
        
        /* Navigation */
        .navbar { background: #237f87; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .nav-container { max-width: 1280px; margin: 0 auto; padding: 0 24px; display: flex; justify-content: space-between; align-items: center; height: 64px; }
        .logo-section { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .logo-section svg { width: 36px; height: 28px; }
        .logo-text { font-family: 'Gwendolyn', cursive; font-size: 24px; font-weight: 700; color: white; letter-spacing: 0.5px; }
        .back-btn { display: flex; align-items: center; gap: 8px; padding: 8px 16px; background: rgba(255,255,255,0.2); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: white; font-weight: 500; cursor: pointer; text-decoration: none; transition: all 0.2s; }
        .back-btn:hover { background: rgba(255,255,255,0.3); }

        /* Main */
        .main-content { max-width: 1280px; margin: 0 auto; padding: 32px 24px; }
        
        /* Hero Section */
        .flight-hero { position: relative; height: 320px; border-radius: 16px; overflow: hidden; margin-bottom: 32px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
        .hero-image { width: 100%; height: 100%; object-fit: cover; }
        .hero-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0, 0, 0, 0.6), transparent); }
        .hero-content { position: absolute; left: 24px; bottom: 24px; right: 24px; color: white; }
        .airline-info { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; }
        .airline-icon { width: 24px; height: 24px; }
        .airline-name { font-size: 14px; opacity: 0.9; }
        .route-title { font-size: 36px; font-weight: 700; margin-bottom: 8px; }
        .rating-section { display: flex; align-items: center; gap: 8px; }
        .star-icon { width: 20px; height: 20px; fill: #FDC700; }
        .rating-value { font-size: 18px; font-weight: 600; }
        .rating-count { font-size: 14px; opacity: 0.9; }

        /* Details Card */
        .details-card { background: white; border-radius: 16px; padding: 32px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-bottom: 24px; }
        
        /* Quick Info Grid */
        .quick-info { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 24px; margin-bottom: 32px; }
        .info-item { display: flex; gap: 12px; }
        .info-icon { width: 48px; height: 48px; background: rgba(35, 127, 135, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .info-icon svg { width: 24px; height: 24px; color: #237f87; }
        .info-content { flex: 1; }
        .info-label { font-size: 12px; color: #6a7282; margin-bottom: 4px; }
        .info-value { font-size: 16px; font-weight: 600; }

        /* Section Divider */
        .section-divider { border-top: 1px solid #e5e7eb; padding-top: 32px; margin-top: 32px; }
        .section-title { font-size: 20px; font-weight: 700; margin-bottom: 16px; }
        .section-text { font-size: 15px; line-height: 1.6; color: #364153; margin-bottom: 24px; }

        /* Two Column Layout */
        .two-columns { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; }
        .column-title { font-size: 16px; font-weight: 600; margin-bottom: 12px; }
        .amenity-list { list-style: none; }
        .amenity-item { display: flex; align-items: center; gap: 8px; padding: 8px 0; }
        .check-icon { width: 20px; height: 20px; color: #237f87; flex-shrink: 0; }
        .amenity-text { font-size: 14px; color: #364153; }

        /* Map Section */
        .map-section { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-bottom: 24px; }
        .map-header { padding: 24px; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; gap: 8px; }
        .map-icon { width: 20px; height: 20px; color: #237f87; }
        .map-title { font-size: 20px; font-weight: 700; }
        .map-container { height: 384px; background: #eee; position: relative; overflow: hidden; }
        .map-placeholder { width: 100%; height: 100%; object-fit: cover; }

        /* Reviews Section */
        .reviews-section { background: white; border-radius: 16px; padding: 32px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-bottom: 24px; }
        .reviews-header { font-size: 20px; font-weight: 700; margin-bottom: 24px; }
        .review-card { padding: 20px 0; border-bottom: 1px solid #e5e7eb; }
        .review-card:last-child { border-bottom: none; }
        .reviewer-info { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
        .reviewer-avatar { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; }
        .reviewer-details { flex: 1; }
        .reviewer-name { font-size: 16px; font-weight: 600; margin-bottom: 4px; }
        .review-date { font-size: 12px; color: #6a7282; }
        .review-stars { display: flex; gap: 4px; }
        .review-star { width: 16px; height: 16px; fill: #FDC700; }
        .review-text { font-size: 14px; color: #364153; line-height: 1.6; margin-bottom: 12px; }
        .review-images { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 12px; }
        .review-image { width: 100%; aspect-ratio: 16/9; object-fit: cover; border-radius: 8px; }

        /* Booking Footer */
        .booking-footer { position: sticky; bottom: 0; background: white; border-top: 1px solid #e5e7eb; padding: 16px 24px; box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.05); }
        .booking-container { max-width: 1280px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .price-section { }
        .price-label { font-size: 12px; color: #6a7282; margin-bottom: 4px; }
        .price-value { font-size: 28px; font-weight: 700; color: #237f87; }
        .book-btn { padding: 16px 48px; background: #237f87; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
        .book-btn:hover { background: #1a6269; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(35, 127, 135, 0.3); }

        @media (max-width: 768px) {
            .route-title { font-size: 24px; }
            .quick-info { grid-template-columns: 1fr; }
            .two-columns { grid-template-columns: 1fr; }
            .booking-container { flex-direction: column; gap: 16px; }
            .book-btn { width: 100%; }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="dashboard-enhanced.html" class="logo-section">
                <svg viewBox="0 0 61 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M30.5 0L61 47H0L30.5 0Z" fill="white" opacity="0.9"/>
                    <path d="M30.5 10L50 40H11L30.5 10Z" fill="rgba(255,255,255,0.3)"/>
                </svg>
                <span class="logo-text">iWander</span>
            </a>
            <a href="search-results.html" class="back-btn">
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
            <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=1400" alt="Flight" class="hero-image">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <div class="airline-info">
                    <svg class="airline-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    <span class="airline-name">Air France</span>
                </div>
                <h1 class="route-title">New York → Paris</h1>
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
                        <div class="info-value">7h 30m</div>
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
                <p class="section-text">
                    Experience world-class service on our direct flight from New York (JFK) to Paris (CDG). Operated by Air France, one of the world's leading airlines, this flight offers exceptional comfort and amenities throughout your journey across the Atlantic.
                </p>

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

            <!-- Review 1 -->
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
                <p class="review-text">
                    Amazing flight experience! The crew was incredibly attentive and the seats were very comfortable. The view of the city as we took off was breathtaking.
                </p>
                <div class="review-images">
                    <img src="https://images.unsplash.com/photo-1464037866556-6812c9d1c72e?w=300&h=200&fit=crop" alt="Review" class="review-image">
                </div>
            </div>

            <!-- Review 2 -->
            <div class="review-card">
                <div class="reviewer-info">
                    <img src="https://i.pravatar.cc/150?img=7" alt="Michael" class="reviewer-avatar">
                    <div class="reviewer-details">
                        <div class="reviewer-name">Michael Chen</div>
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
                <p class="review-text">
                    Had a great time. My wife was happy. Smooth was boring, and they pampered us right to admired ways to explore!
                </p>
                <div class="review-images">
                    <img src="https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=300&h=200&fit=crop" alt="Review" class="review-image">
                </div>
            </div>

            <!-- Review 3 -->
            <div class="review-card">
                <div class="reviewer-info">
                    <img src="https://i.pravatar.cc/150?img=32" alt="Emma" class="reviewer-avatar">
                    <div class="reviewer-details">
                        <div class="reviewer-name">Emma Williams</div>
                        <div class="review-date">2 months ago</div>
                    </div>
                    <div class="review-stars">
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                    </div>
                </div>
                <p class="review-text">
                    Flight was smooth from New to was scheduled and very didn't service was delicious, but definitely for the French again!
                </p>
                <div class="review-images">
                    <img src="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=300&h=200&fit=crop" alt="Review" class="review-image">
                </div>
            </div>

            <!-- Review 4 -->
            <div class="review-card">
                <div class="reviewer-info">
                    <img src="https://i.pravatar.cc/150?img=13" alt="David" class="reviewer-avatar">
                    <div class="reviewer-details">
                        <div class="reviewer-name">David Martinez</div>
                        <div class="review-date">3 months ago</div>
                    </div>
                    <div class="review-stars">
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                        <svg class="review-star" viewBox="0 0 16 16"><path d="M8 0.8L10.3512 5.58622L15.6085 6.32786L11.8042 10.0138L12.7023 15.2482L8 12.784L3.29772 15.2482L4.19577 10.0138L0.391548 6.32786L5.64886 5.58622L8 0.8Z"/></svg>
                    </div>
                </div>
                <p class="review-text">
                    Excellent service! The flight was punctual, the crew was attentive to healthy. I highly recommend this airline for transatlantic flights!
                </p>
                <div class="review-images">
                    <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=300&h=200&fit=crop" alt="Review" class="review-image">
                </div>
            </div>
        </div>
    </main>

    <!-- Booking Footer -->
    <div class="booking-footer">
        <div class="booking-container">
            <div class="price-section">
                <div class="price-label">From start of</div>
                <div class="price-value">₱38,000</div>
            </div>
            <button class="book-btn" onclick="bookFlight()">Book Now</button>
        </div>
    </div>

    <script>
        function bookFlight() {
            alert('Booking feature coming soon! You selected the New York → Paris flight for ₱38,000');
        }
    </script>
</body>
</html>