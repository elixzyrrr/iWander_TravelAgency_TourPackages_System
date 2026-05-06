<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iWander - Luxury Travel Agency</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/landing_page.css')
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="nav-container">
            <a href="index.html" class="logo">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="logo-text">iWander</span>
            </a>

            <div class="nav-links">
                <a href="#destination">Destination</a>
                <a href="#tours">Tours</a>
                <a href="#about">About</a>
                
                <a href="#contacts">Contacts</a>
            </div>

            <div class="auth-buttons">
                <a href="{{ route('login') }}" class="btn btn-login">Login</a>
                <a href="{{ route('register') }}" class="btn btn-signup">Sign Up</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="destination">
        <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=1200" alt="Luxury travel destination" class="hero-bg">
        <div class="hero-overlay"></div>
        
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">EXPLORE LUXURY TRAVEL<br>LIKE NEVER BEFORE</h1>
                <p class="hero-subtitle">Exclusive destinations, personalized experiences, unforgettable memories</p>
                <div class="button-container">
                    <button class="btn btn-explore">Explore offerings</button>
                </div>
            </div>

            <div class="search-container">
                <div class="search-grid">
                    <div class="search-field">
                        <label>Destination</label>
                        <select>
                            <option>Tokyo, Japan</option>
                            <option>Paris, France</option>
                            <option>Maldives</option>
                        </select>
                    </div>
                    <div class="search-field">
                        <label>Travel style</label>
                        <select>
                            <option>Luxury Explorer</option>
                            <option>Adventure Seeker</option>
                        </select>
                    </div>
                    <div class="search-field">
                        <label>Date</label>
                        <input type="date" value="2026-09-10">
                    </div>
                    <div class="search-field" style="display: flex; align-items: flex-end;">
                        <button class="btn btn-search">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Destinations -->
    <section id="tours" class="section-bg-gray">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Featured Destinations</h2>
                <p class="section-subtitle">Handpicked luxury experiences for discerning travelers</p>
            </div>

            <div class="cards-grid">
                <!-- Card 1 -->
                <div class="card">
                    <div class="card-image">
                        <img src="https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=600" alt="Tropical Paradise">
                        <div class="card-price">₱12,499</div>
                    </div>
                    <div class="card-content">
                        <div class="card-location">
                            <svg width="16" height="16" fill="none">
                                <path d="M14 6.66667C14 11.3333 8 15.3333 8 15.3333C8 15.3333 2 11.3333 2 6.66667C2 5.07536 2.63214 3.54927 3.75736 2.42405C4.88258 1.29883 6.40867 0.666672 8 0.666672C9.59131 0.666672 11.1174 1.29883 12.2426 2.42405C13.3679 3.54927 14 5.07536 14 6.66667Z" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8 8.66667C9.10457 8.66667 10 7.77124 10 6.66667C10 5.5621 9.10457 4.66667 8 4.66667C6.89543 4.66667 6 5.5621 6 6.66667C6 7.77124 6.89543 8.66667 8 8.66667Z" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Maldives</span>
                        </div>
                        <h3 class="card-title">Tropical Paradise</h3>
                        <p class="card-description">Pristine beaches and crystal-clear waters await you</p>
                        <div class="card-info">
                            <div class="card-info-item">
                                <svg width="16" height="16" fill="none">
                                    <path d="M5.33333 1.33333V4" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M10.6667 1.33333V4" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    <rect x="2" y="2.66667" width="12" height="12" rx="2" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M2 6.66667H14" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>7 Days</span>
                            </div>
                            <div class="card-info-item">
                                <svg width="16" height="16" fill="none">
                                    <path d="M11.3333 14V12.6667C11.3333 11.9594 11.0524 11.2811 10.5523 10.781C10.0522 10.281 9.37391 10 8.66667 10H4C3.29276 10 2.61448 10.281 2.11438 10.781C1.61429 11.2811 1.33333 11.9594 1.33333 12.6667V14" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M6.33333 7.33333C7.80609 7.33333 9 6.13943 9 4.66667C9 3.19391 7.80609 2 6.33333 2C4.86057 2 3.66667 3.19391 3.66667 4.66667C3.66667 6.13943 4.86057 7.33333 6.33333 7.33333Z" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>2-8 People</span>
                            </div>
                        </div>
                        <button class="btn btn-book">Book Now</button>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="card">
                    <div class="card-image">
                        <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600" alt="Mountain Adventure">
                        <div class="card-price">₱10,000</div>
                    </div>
                    <div class="card-content">
                        <div class="card-location">
                            <svg width="16" height="16" fill="none">
                                <path d="M14 6.66667C14 11.3333 8 15.3333 8 15.3333C8 15.3333 2 11.3333 2 6.66667C2 5.07536 2.63214 3.54927 3.75736 2.42405C4.88258 1.29883 6.40867 0.666672 8 0.666672C9.59131 0.666672 11.1174 1.29883 12.2426 2.42405C13.3679 3.54927 14 5.07536 14 6.66667Z" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8 8.66667C9.10457 8.66667 10 7.77124 10 6.66667C10 5.5621 9.10457 4.66667 8 4.66667C6.89543 4.66667 6 5.5621 6 6.66667C6 7.77124 6.89543 8.66667 8 8.66667Z" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Swiss Alps</span>
                        </div>
                        <h3 class="card-title">Mountain Adventure</h3>
                        <p class="card-description">Breathtaking views and exhilarating outdoor experiences</p>
                        <div class="card-info">
                            <div class="card-info-item">
                                <svg width="16" height="16" fill="none">
                                    <path d="M5.33333 1.33333V4" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M10.6667 1.33333V4" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    <rect x="2" y="2.66667" width="12" height="12" rx="2" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M2 6.66667H14" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>5 Days</span>
                            </div>
                            <div class="card-info-item">
                                <svg width="16" height="16" fill="none">
                                    <path d="M11.3333 14V12.6667C11.3333 11.9594 11.0524 11.2811 10.5523 10.781C10.0522 10.281 9.37391 10 8.66667 10H4C3.29276 10 2.61448 10.281 2.11438 10.781C1.61429 11.2811 1.33333 11.9594 1.33333 12.6667V14" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M6.33333 7.33333C7.80609 7.33333 9 6.13943 9 4.66667C9 3.19391 7.80609 2 6.33333 2C4.86057 2 3.66667 3.19391 3.66667 4.66667C3.66667 6.13943 4.86057 7.33333 6.33333 7.33333Z" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>2-6 People</span>
                            </div>
                        </div>
                        <button class="btn btn-book">Book Now</button>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="card">
                    <div class="card-image">
                        <img src="https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=600" alt="Urban Luxury">
                        <div class="card-price">₱25,000</div>
                    </div>
                    <div class="card-content">
                        <div class="card-location">
                            <svg width="16" height="16" fill="none">
                                <path d="M14 6.66667C14 11.3333 8 15.3333 8 15.3333C8 15.3333 2 11.3333 2 6.66667C2 5.07536 2.63214 3.54927 3.75736 2.42405C4.88258 1.29883 6.40867 0.666672 8 0.666672C9.59131 0.666672 11.1174 1.29883 12.2426 2.42405C13.3679 3.54927 14 5.07536 14 6.66667Z" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8 8.66667C9.10457 8.66667 10 7.77124 10 6.66667C10 5.5621 9.10457 4.66667 8 4.66667C6.89543 4.66667 6 5.5621 6 6.66667C6 7.77124 6.89543 8.66667 8 8.66667Z" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Dubai, UAE</span>
                        </div>
                        <h3 class="card-title">Urban Luxury</h3>
                        <p class="card-description">Experience luxury living in the world's most vibrant city</p>
                        <div class="card-info">
                            <div class="card-info-item">
                                <svg width="16" height="16" fill="none">
                                    <path d="M5.33333 1.33333V4" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M10.6667 1.33333V4" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    <rect x="2" y="2.66667" width="12" height="12" rx="2" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M2 6.66667H14" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>6 Days</span>
                            </div>
                            <div class="card-info-item">
                                <svg width="16" height="16" fill="none">
                                    <path d="M11.3333 14V12.6667C11.3333 11.9594 11.0524 11.2811 10.5523 10.781C10.0522 10.281 9.37391 10 8.66667 10H4C3.29276 10 2.61448 10.281 2.11438 10.781C1.61429 11.2811 1.33333 11.9594 1.33333 12.6667V14" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M6.33333 7.33333C7.80609 7.33333 9 6.13943 9 4.66667C9 3.19391 7.80609 2 6.33333 2C4.86057 2 3.66667 3.19391 3.66667 4.66667C3.66667 6.13943 4.86057 7.33333 6.33333 7.33333Z" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>2-10 People</span>
                            </div>
                        </div>
                        <button class="btn btn-book">Book Now</button>
                    </div>
                </div>
            </div>

            <div class="button-container">
                <button class="btn-see-more">See more</button>
            </div>
        </div>
    </section>

    <!-- Why Choose iWander -->
    <section id="about">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Why Choose iWander?</h2>
                <p class="section-subtitle">Exceptional service, unforgettable experiences</p>
            </div>

            <div class="features-grid">
                <div class="feature">
                    <div class="feature-icon">
                        <svg width="32" height="32" fill="none">
                            <path d="M10.6667 21.3333L21.3333 10.6667" stroke="white" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10.6667 10.6667H21.3333V21.3333" stroke="white" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Premium Flights</h3>
                    <p class="feature-description">First-class and business-class flights to destinations worldwide</p>
                </div>

                <div class="feature">
                    <div class="feature-icon">
                        <svg width="32" height="32" fill="none">
                            <circle cx="16" cy="16" r="13.3333" stroke="white" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2.66667 16H29.3333" stroke="white" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Global Coverage</h3>
                    <p class="feature-description">Access to over 150 luxury destinations across 6 continents</p>
                </div>

                <div class="feature">
                    <div class="feature-icon">
                        <svg width="32" height="32" fill="none">
                            <path d="M16 2.66667L19.7813 10.3853L28 11.6L22 17.44L23.5627 25.6L16 21.5853L8.43733 25.6L10 17.44L4 11.6L12.2187 10.3853L16 2.66667Z" stroke="white" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Award-Winning Service</h3>
                    <p class="feature-description">Recognized for excellence in luxury travel planning</p>
                </div>

                <div class="feature">
                    <div class="feature-icon">
                        <svg width="32" height="32" fill="none">
                            <circle cx="16" cy="16" r="13.3333" stroke="white" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 8V16L21.3333 18.6667" stroke="white" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">24/7 Support</h3>
                    <p class="feature-description">Dedicated concierge service available around the clock</p>
                </div>
            </div>
        </div>
    </section>

    <!-- What Our Travelers Say -->
    <section class="section-bg-gray">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">What Our Travelers Say</h2>
                <p class="section-subtitle">Real experiences from our valued clients</p>
            </div>

            <div class="cards-grid">
                <div class="review-card">
                    <div class="stars">
                        <svg class="star" viewBox="0 0 20 20"><path d="M10 1L12.9389 6.98278L19.5106 7.90983L14.7553 12.5172L15.8779 19.0902L10 15.98L4.12215 19.0902L5.24472 12.5172L0.489435 7.90983L7.06107 6.98278L10 1Z"/></svg>
                        <svg class="star" viewBox="0 0 20 20"><path d="M10 1L12.9389 6.98278L19.5106 7.90983L14.7553 12.5172L15.8779 19.0902L10 15.98L4.12215 19.0902L5.24472 12.5172L0.489435 7.90983L7.06107 6.98278L10 1Z"/></svg>
                        <svg class="star" viewBox="0 0 20 20"><path d="M10 1L12.9389 6.98278L19.5106 7.90983L14.7553 12.5172L15.8779 19.0902L10 15.98L4.12215 19.0902L5.24472 12.5172L0.489435 7.90983L7.06107 6.98278L10 1Z"/></svg>
                        <svg class="star" viewBox="0 0 20 20"><path d="M10 1L12.9389 6.98278L19.5106 7.90983L14.7553 12.5172L15.8779 19.0902L10 15.98L4.12215 19.0902L5.24472 12.5172L0.489435 7.90983L7.06107 6.98278L10 1Z"/></svg>
                        <svg class="star" viewBox="0 0 20 20"><path d="M10 1L12.9389 6.98278L19.5106 7.90983L14.7553 12.5172L15.8779 19.0902L10 15.98L4.12215 19.0902L5.24472 12.5172L0.489435 7.90983L7.06107 6.98278L10 1Z"/></svg>
                    </div>
                    <p class="review-text">"Absolutely incredible experience! The attention to detail and personalized service made our Maldives trip unforgettable."</p>
                    <div class="review-author">
                        <img src="https://i.pravatar.cc/150?img=1" alt="Sarah Johnson" class="review-avatar">
                        <div>
                            <p class="review-author-name">Sarah Johnson</p>
                            <p class="review-author-location">New York, USA</p>
                        </div>
                    </div>
                </div>

                <div class="review-card">
                    <div class="stars">
                        <svg class="star" viewBox="0 0 20 20"><path d="M10 1L12.9389 6.98278L19.5106 7.90983L14.7553 12.5172L15.8779 19.0902L10 15.98L4.12215 19.0902L5.24472 12.5172L0.489435 7.90983L7.06107 6.98278L10 1Z"/></svg>
                        <svg class="star" viewBox="0 0 20 20"><path d="M10 1L12.9389 6.98278L19.5106 7.90983L14.7553 12.5172L15.8779 19.0902L10 15.98L4.12215 19.0902L5.24472 12.5172L0.489435 7.90983L7.06107 6.98278L10 1Z"/></svg>
                        <svg class="star" viewBox="0 0 20 20"><path d="M10 1L12.9389 6.98278L19.5106 7.90983L14.7553 12.5172L15.8779 19.0902L10 15.98L4.12215 19.0902L5.24472 12.5172L0.489435 7.90983L7.06107 6.98278L10 1Z"/></svg>
                        <svg class="star" viewBox="0 0 20 20"><path d="M10 1L12.9389 6.98278L19.5106 7.90983L14.7553 12.5172L15.8779 19.0902L10 15.98L4.12215 19.0902L5.24472 12.5172L0.489435 7.90983L7.06107 6.98278L10 1Z"/></svg>
                        <svg class="star" viewBox="0 0 20 20"><path d="M10 1L12.9389 6.98278L19.5106 7.90983L14.7553 12.5172L15.8779 19.0902L10 15.98L4.12215 19.0902L5.24472 12.5172L0.489435 7.90983L7.06107 6.98278L10 1Z"/></svg>
                    </div>
                    <p class="review-text">"The Swiss Alps adventure exceeded all expectations. Professional, luxurious, and perfectly organized!"</p>
                    <div class="review-author">
                        <img src="https://i.pravatar.cc/150?img=12" alt="Michael Chen" class="review-avatar">
                        <div>
                            <p class="review-author-name">Michael Chen</p>
                            <p class="review-author-location">Singapore</p>
                        </div>
                    </div>
                </div>

                <div class="review-card">
                    <div class="stars">
                        <svg class="star" viewBox="0 0 20 20"><path d="M10 1L12.9389 6.98278L19.5106 7.90983L14.7553 12.5172L15.8779 19.0902L10 15.98L4.12215 19.0902L5.24472 12.5172L0.489435 7.90983L7.06107 6.98278L10 1Z"/></svg>
                        <svg class="star" viewBox="0 0 20 20"><path d="M10 1L12.9389 6.98278L19.5106 7.90983L14.7553 12.5172L15.8779 19.0902L10 15.98L4.12215 19.0902L5.24472 12.5172L0.489435 7.90983L7.06107 6.98278L10 1Z"/></svg>
                        <svg class="star" viewBox="0 0 20 20"><path d="M10 1L12.9389 6.98278L19.5106 7.90983L14.7553 12.5172L15.8779 19.0902L10 15.98L4.12215 19.0902L5.24472 12.5172L0.489435 7.90983L7.06107 6.98278L10 1Z"/></svg>
                        <svg class="star" viewBox="0 0 20 20"><path d="M10 1L12.9389 6.98278L19.5106 7.90983L14.7553 12.5172L15.8779 19.0902L10 15.98L4.12215 19.0902L5.24472 12.5172L0.489435 7.90983L7.06107 6.98278L10 1Z"/></svg>
                        <svg class="star" viewBox="0 0 20 20"><path d="M10 1L12.9389 6.98278L19.5106 7.90983L14.7553 12.5172L15.8779 19.0902L10 15.98L4.12215 19.0902L5.24472 12.5172L0.489435 7.90983L7.06107 6.98278L10 1Z"/></svg>
                    </div>
                    <p class="review-text">"Dubai has never looked better! From the luxury hotels to the personalized tours, everything was perfect."</p>
                    <div class="review-author">
                        <img src="https://i.pravatar.cc/150?img=5" alt="Emma Williams" class="review-avatar">
                        <div>
                            <p class="review-author-name">Emma Williams</p>
                            <p class="review-author-location">London, UK</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Get In Touch -->
    <section id="contacts">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Get In Touch</h2>
                <p class="section-subtitle">Ready to plan your dream vacation? Our travel experts are here to help.</p>
            </div>

            <div class="contact-grid">
                <div class="contact-item">
                    <div class="contact-icon">
                        <svg width="24" height="24" fill="none">
                            <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M22 6L12 13L2 6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="contact-title">Email</h3>
                        <p class="contact-info">contact@iwander.com</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <svg width="24" height="24" fill="none">
                            <path d="M22 16.92V19.92C22.0011 20.1985 21.9441 20.4741 21.8325 20.7293C21.7209 20.9845 21.5573 21.2136 21.3521 21.4019C21.1469 21.5901 20.9046 21.7335 20.6407 21.8227C20.3769 21.9119 20.0974 21.9451 19.82 21.92C16.7428 21.5856 13.7869 20.5341 11.19 18.85C8.77382 17.3147 6.72533 15.2662 5.19 12.85C3.49998 10.2412 2.44824 7.271 2.12 4.17999C2.095 3.90346 2.12787 3.62476 2.21649 3.36162C2.30512 3.09849 2.44756 2.85669 2.63476 2.65162C2.82196 2.44655 3.0498 2.28271 3.30379 2.17052C3.55777 2.05833 3.83233 2.00026 4.11 1.99999H7.11C7.59531 1.9952 8.06579 2.16705 8.43376 2.48351C8.80173 2.79996 9.04207 3.23942 9.11 3.71999C9.23662 4.68006 9.47145 5.6227 9.81 6.52999C9.94455 6.88793 9.97366 7.27691 9.89391 7.65086C9.81415 8.02481 9.62886 8.36809 9.36 8.63999L8.09 9.90999C9.51355 12.4135 11.5865 14.4864 14.09 15.91L15.36 14.64C15.6319 14.3711 15.9752 14.1858 16.3491 14.1061C16.7231 14.0263 17.1121 14.0554 17.47 14.19C18.3773 14.5285 19.3199 14.7634 20.28 14.89C20.7658 14.9585 21.2094 15.2032 21.5265 15.5775C21.8437 15.9518 22.0122 16.4296 22 16.92Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="contact-title">Phone</h3>
                        <p class="contact-info">+1 (555) 123-4567</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <svg width="24" height="24" fill="none">
                            <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61305 3.94821 5.32387 5.63604 3.63604C7.32387 1.94821 9.61305 1 12 1C14.3869 1 16.6761 1.94821 18.364 3.63604C20.0518 5.32387 21 7.61305 21 10Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="contact-title">Address</h3>
                        <p class="contact-info">123 Luxury Avenue, Suite 500<br>New York, NY 10001</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2026 iWander. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>