<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Booking - iWander</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Gwendolyn:wght@700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f9fafb; min-height: 100vh; }

        /* Top Navigation */
        .top-nav { background: white; padding: 20px 32px; display: flex; align-items: center; gap: 16px; }
        .back-btn { display: flex; align-items: center; gap: 8px; color: #4a5565; text-decoration: none; font-size: 14px; cursor: pointer; }
        .back-btn:hover { color: #237f87; }
        .back-btn svg { width: 20px; height: 20px; }
        .logo { display: flex; align-items: center; gap: 8px; }
        .logo svg { width: 24px; height: 24px; }
        .logo-text { font-family: 'Gwendolyn', cursive; font-size: 20px; font-weight: 700; color: #237f87; }

        /* Main Container */
        .main-container { max-width: 1280px; margin: 0 auto; padding: 32px; }

        /* Header */
        .header { margin-bottom: 32px; }
        .breadcrumb { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; }
        .breadcrumb svg { width: 20px; height: 20px; color: #4a5565; }
        .breadcrumb-text { font-size: 14px; color: #4a5565; }
        .route-title { font-size: 32px; font-weight: 700; color: #101828; margin-bottom: 8px; line-height: 48px; }
        .subtitle { font-size: 16px; color: #4a5565; line-height: 24px; }

        /* Filter Tabs */
        .filter-tabs { background: white; padding: 16px; border-radius: 14px; box-shadow: 0 4px 6px rgba(0,0,0,0.1), 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 32px; }
        .tabs-container { display: flex; gap: 12px; }
        .tab-btn { padding: 12px 24px; border-radius: 10px; border: none; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 8px; height: 45px; }
        .tab-btn svg { width: 16px; height: 16px; }
        .tab-btn.active { background: #237f87; color: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1), 0 2px 4px rgba(0,0,0,0.1); }
        .tab-btn.inactive { background: #f3f4f6; color: #364153; }
        .tab-btn:hover { transform: translateY(-2px); }

        /* Best Deal Badge */
        .best-deal-badge { display: inline-flex; align-items: center; gap: 8px; background: #dcfce7; color: #008236; padding: 4px 12px 4px 28px; border-radius: 999px; font-size: 12px; font-weight: 600; margin-bottom: 16px; position: relative; }
        .best-deal-badge svg { position: absolute; left: 12px; width: 12px; height: 12px; }

        /* Flight Cards */
        .flights-list { display: flex; flex-direction: column; gap: 16px; }
        .flight-card { background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: all 0.2s; }
        .flight-card:hover { box-shadow: 0 8px 16px rgba(0,0,0,0.15); transform: translateY(-2px); }

        /* Flight Card Grid */
        .flight-grid { display: grid; grid-template-columns: 200px 1fr auto 1fr 200px auto; align-items: center; gap: 24px; }

        /* Airline */
        .airline-section { display: flex; align-items: center; gap: 16px; }
        .flag { font-size: 48px; line-height: 48px; }
        .airline-info h3 { font-size: 16px; font-weight: 700; color: #101828; line-height: 24px; }
        .airline-info .aircraft { font-size: 12px; color: #6a7282; line-height: 18px; }
        .airline-info .class-badge { font-size: 12px; color: #237f87; font-weight: 600; margin-top: 2px; }

        /* Time Section */
        .time-section { }
        .time { font-size: 24px; font-weight: 700; color: #101828; line-height: 36px; }
        .location { font-size: 12px; color: #6a7282; line-height: 18px; margin-top: 4px; }

        /* Duration */
        .duration-section { text-align: center; min-width: 120px; }
        .duration-line { position: relative; height: 1px; background: #d1d5db; margin-bottom: 8px; }
        .plane-icon { position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); background: white; padding: 0 8px; }
        .plane-icon svg { width: 16px; height: 16px; color: #237f87; }
        .duration-text { font-size: 12px; color: #6a7282; line-height: 18px; }

        /* Details */
        .details-section { display: flex; flex-direction: column; gap: 8px; }
        .badges { display: flex; flex-wrap: wrap; gap: 6px; align-items: center; }
        .badge { padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; }
        .badge.nonstop { background: #dcfce7; color: #008236; }
        .badge.onestop { background: #fef3c7; color: #92400e; }
        .badge.economy { background: #f3f4f6; color: #6a7282; }
        .badge.business { background: #dbeafe; color: #1e40af; }
        .amenities { display: flex; flex-wrap: wrap; gap: 8px; font-size: 11px; color: #6a7282; }
        .amenity { display: flex; align-items: center; gap: 4px; }
        .amenity svg { width: 12px; height: 12px; }

        /* Price */
        .price-section { text-align: right; }
        .from-label { font-size: 12px; color: #6a7282; margin-bottom: 4px; }
        .price { font-size: 28px; font-weight: 700; color: #101828; margin-bottom: 8px; line-height: 1; }
        .select-btn { padding: 10px 24px; background: #237f87; color: white; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
        .select-btn:hover { background: #1a6269; transform: scale(1.05); }

        /* Suggestions */
        .suggestions { margin-top: 48px; }
        .suggestions h2 { font-size: 24px; font-weight: 700; color: #101828; margin-bottom: 8px; }
        .suggestions-subtitle { font-size: 14px; color: #6a7282; margin-bottom: 24px; }
        .suggestions-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
        .suggestion-card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1); cursor: pointer; transition: all 0.2s; }
        .suggestion-card:hover { transform: translateY(-4px); box-shadow: 0 8px 16px rgba(0,0,0,0.15); }
        .suggestion-image { height: 180px; overflow: hidden; position: relative; }
        .suggestion-image img { width: 100%; height: 100%; object-fit: cover; }
        .destination-name { position: absolute; bottom: 16px; left: 16px; color: white; font-size: 24px; font-weight: 700; text-shadow: 0 2px 8px rgba(0,0,0,0.3); }
        .suggestion-info { padding: 16px; display: flex; justify-content: space-between; align-items: center; }
        .route-label { font-size: 12px; color: #6a7282; margin-bottom: 4px; }
        .route-text { font-size: 14px; font-weight: 600; color: #101828; }
        .suggestion-price { font-size: 20px; font-weight: 700; color: #237f87; }

        @media (max-width: 1200px) {
            .flight-grid { grid-template-columns: 1fr; gap: 16px; }
            .suggestions-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .suggestions-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <!-- Top Navigation -->
    <div class="top-nav">
        <a href="dashboard-enhanced.html" class="back-btn">
            <svg fill="none" viewBox="0 0 20 20" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.67" d="M12.5 15L7.5 10l5-5"/>
            </svg>
            <span>Back</span>
        </a>
        <div class="logo">
            <svg viewBox="0 0 61 47" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="color: #237f87;">
                <path d="M6 24L55 6L33 41L28 27L6 24Z" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M28 27L55 6" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="logo-text">iWander</span>
        </div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Header -->
        <div class="header">
            <div class="breadcrumb">
                <svg fill="none" viewBox="0 0 20 20" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.67" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="breadcrumb-text">Flight Booking</span>
            </div>
            <h1 class="route-title" id="routeTitle">New York (JFK) → Paris (CDG)</h1>
            <p class="subtitle" id="subtitle">Select your preferred flight • <span id="flightCount">8</span> options available</p>
        </div>

        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <div class="tabs-container">
                <button class="tab-btn active" onclick="switchTab('best', this)">
                    <svg fill="none" viewBox="0 0 16 16" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.33" d="M8 1l2.5 5.5 5.5 0.8-4 3.9 1 5.6-5-2.6-5 2.6 1-5.6-4-3.9 5.5-0.8z"/>
                    </svg>
                    Best Deals
                </button>
                <button class="tab-btn inactive" onclick="switchTab('cheapest', this)">
                    <svg fill="none" viewBox="0 0 16 16" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.33" d="M8 1c3.866 0 7 3.134 7 7s-3.134 7-7 7-7-3.134-7-7 3.134-7 7-7z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.33" d="M8 4v4l2 2"/>
                    </svg>
                    Cheapest
                </button>
                <button class="tab-btn inactive" onclick="switchTab('quickest', this)">
                    <svg fill="none" viewBox="0 0 16 16" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.33" d="M8 1c3.866 0 7 3.134 7 7s-3.134 7-7 7-7-3.134-7-7 3.134-7 7-7z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.33" d="M8 4v4l3 3"/>
                    </svg>
                    Quickest
                </button>
            </div>
        </div>

        <!-- Best Deal Badge -->
        <div class="best-deal-badge" id="bestDealBadge">
            <svg fill="none" viewBox="0 0 12 12" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 1v10M1 6l5-5 5 5"/>
            </svg>
            Best Deal
        </div>

        <!-- Flights List -->
        <div class="flights-list" id="flightsList">
            <!-- Flights will be dynamically populated -->
        </div>

        <!-- Suggestions -->
        <div class="suggestions">
            <h2>You Might Also Like ✈️</h2>
            <p class="suggestions-subtitle">Other popular routes from New York</p>
            <div class="suggestions-grid">
                <div class="suggestion-card" onclick="selectSuggestion('London')">
                    <div class="suggestion-image">
                        <img src="https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?w=400" alt="London">
                        <div class="destination-name">London</div>
                    </div>
                    <div class="suggestion-info">
                        <div>
                            <div class="route-label">From</div>
                            <div class="route-text">New York → London</div>
                        </div>
                        <div class="suggestion-price">₱29,500</div>
                    </div>
                </div>

                <div class="suggestion-card" onclick="selectSuggestion('Rome')">
                    <div class="suggestion-image">
                        <img src="https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=400" alt="Rome">
                        <div class="destination-name">Rome</div>
                    </div>
                    <div class="suggestion-info">
                        <div>
                            <div class="route-label">From</div>
                            <div class="route-text">New York → Rome</div>
                        </div>
                        <div class="suggestion-price">₱41,000</div>
                    </div>
                </div>

                <div class="suggestion-card" onclick="selectSuggestion('Barcelona')">
                    <div class="suggestion-image">
                        <img src="https://images.unsplash.com/photo-1583422409516-2895a77efded?w=400" alt="Barcelona">
                        <div class="destination-name">Barcelona</div>
                    </div>
                    <div class="suggestion-info">
                        <div>
                            <div class="route-label">From</div>
                            <div class="route-text">New York → Barcelona</div>
                        </div>
                        <div class="suggestion-price">₱39,000</div>
                    </div>
                </div>

                <div class="suggestion-card" onclick="selectSuggestion('Tokyo')">
                    <div class="suggestion-image">
                        <img src="https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=400" alt="Tokyo">
                        <div class="destination-name">Tokyo</div>
                    </div>
                    <div class="suggestion-info">
                        <div>
                            <div class="route-label">From</div>
                            <div class="route-text">New York → Tokyo</div>
                        </div>
                        <div class="suggestion-price">₱54,000</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Flight Data (Dynamic)
        const flights = [
            {
                id: 1,
                flag: '🇫🇷',
                airline: 'Air France',
                aircraft: 'Boeing 777',
                class: null,
                departTime: '08:30 AM',
                departLocation: 'New York (JFK)',
                arriveTime: '10:00 PM',
                arriveLocation: 'Paris (CDG)',
                duration: '7h 30m',
                stops: 'Non-stop',
                cabin: 'Economy',
                baggage: '2 • 23kg',
                amenities: ['WiFi', 'Meals', 'Entertainment'],
                price: 38000,
                isBestDeal: true
            },
            {
                id: 2,
                flag: '🇺🇸',
                airline: 'United Airlines',
                aircraft: 'Boeing 787',
                class: null,
                departTime: '02:30 PM',
                departLocation: 'New York (JFK)',
                arriveTime: '04:00 AM+1',
                arriveLocation: 'Paris (CDG)',
                duration: '8h 30m',
                stops: 'Non-stop',
                cabin: 'Economy',
                baggage: '2 • 23kg',
                amenities: ['WiFi', 'Meals'],
                price: 39500,
                isBestDeal: false
            },
            {
                id: 3,
                flag: '🇫🇷',
                airline: 'Air France',
                aircraft: 'Boeing 777',
                class: null,
                departTime: '05:00 PM',
                departLocation: 'New York (JFK)',
                arriveTime: '06:30 AM+1',
                arriveLocation: 'Paris (CDG)',
                duration: '7h 30m',
                stops: 'Non-stop',
                cabin: 'Economy',
                baggage: '2 • 23kg',
                amenities: ['WiFi', 'Meals', 'Entertainment'],
                price: 40500,
                isBestDeal: false
            },
            {
                id: 4,
                flag: '🇺🇸',
                airline: 'Delta Airlines',
                aircraft: 'Airbus A350',
                class: null,
                departTime: '10:45 AM',
                departLocation: 'New York (JFK)',
                arriveTime: '12:15 AM+1',
                arriveLocation: 'Paris (CDG)',
                duration: '8h 30m',
                stops: 'Non-stop',
                cabin: 'Economy',
                baggage: '2 • 23kg',
                amenities: ['WiFi', 'Meals', 'Extra Legroom'],
                price: 42000,
                isBestDeal: false
            },
            {
                id: 5,
                flag: '🇫🇷',
                airline: 'Air France',
                aircraft: 'Boeing 777',
                class: 'Business',
                departTime: '08:30 AM',
                departLocation: 'New York (JFK)',
                arriveTime: '10:00 PM',
                arriveLocation: 'Paris (CDG)',
                duration: '7h 30m',
                stops: 'Non-stop',
                cabin: 'Business',
                baggage: '3 • 32kg',
                amenities: ['WiFi', 'Lounge Access', 'Lie-flat Seats'],
                price: 125000,
                isBestDeal: false
            },
            {
                id: 6,
                flag: '🇩🇪',
                airline: 'Lufthansa',
                aircraft: 'Airbus A380',
                class: null,
                departTime: '11:20 AM',
                departLocation: 'New York (JFK)',
                arriveTime: '02:30 AM+1',
                arriveLocation: 'Paris (CDG)',
                duration: '9h 10m',
                stops: '1 Stop (Frankfurt)',
                cabin: 'Economy',
                baggage: '2 • 23kg',
                amenities: ['WiFi', 'Meals'],
                price: 33000,
                isBestDeal: false
            },
            {
                id: 7,
                flag: '🇳🇱',
                airline: 'KLM Royal Dutch',
                aircraft: 'Boeing 787',
                class: null,
                departTime: '09:45 AM',
                departLocation: 'New York (JFK)',
                arriveTime: '01:15 AM+1',
                arriveLocation: 'Paris (CDG)',
                duration: '9h 30m',
                stops: '1 Stop (Amsterdam)',
                cabin: 'Economy',
                baggage: '2 • 23kg',
                amenities: ['WiFi', 'Meals'],
                price: 34000,
                isBestDeal: false
            },
            {
                id: 8,
                flag: '🇬🇧',
                airline: 'British Airways',
                aircraft: 'Airbus A350',
                class: null,
                departTime: '06:15 AM',
                departLocation: 'New York (JFK)',
                arriveTime: '08:45 PM',
                arriveLocation: 'Paris (CDG)',
                duration: '8h 30m',
                stops: '1 Stop (London)',
                cabin: 'Economy',
                baggage: '2 • 23kg',
                amenities: ['WiFi', 'Meals'],
                price: 35500,
                isBestDeal: false
            }
        ];

        let currentFilter = 'best';
        let sortedFlights = [...flights];

        // Render Flights
        function renderFlights() {
            const container = document.getElementById('flightsList');
            container.innerHTML = sortedFlights.map((flight, index) => `
                <div class="flight-card" data-flight-id="${flight.id}">
                    <div class="flight-grid">
                        <!-- Airline -->
                        <div class="airline-section">
                            <div class="flag">${flight.flag}</div>
                            <div class="airline-info">
                                <h3>${flight.airline}</h3>
                                ${flight.class ? `<div class="class-badge">${flight.class}</div>` : ''}
                                <div class="aircraft">${flight.aircraft}</div>
                            </div>
                        </div>

                        <!-- Departure -->
                        <div class="time-section">
                            <div class="time">${flight.departTime}</div>
                            <div class="location">${flight.departLocation}</div>
                        </div>

                        <!-- Duration -->
                        <div class="duration-section">
                            <div class="duration-line">
                                <div class="plane-icon">
                                    <svg fill="none" viewBox="0 0 16 16" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.33" d="M8 2L14 8 8 14 2 8 8 2Z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="duration-text">${flight.duration}</div>
                        </div>

                        <!-- Arrival -->
                        <div class="time-section">
                            <div class="time">${flight.arriveTime}</div>
                            <div class="location">${flight.arriveLocation}</div>
                        </div>

                        <!-- Details -->
                        <div class="details-section">
                            <div class="badges">
                                <span class="badge ${flight.stops === 'Non-stop' ? 'nonstop' : 'onestop'}">${flight.stops}</span>
                                <span class="badge ${flight.cabin.toLowerCase()}">${flight.cabin}</span>
                                <span style="font-size: 11px; color: #6a7282;">Baggage: ${flight.baggage}</span>
                            </div>
                            <div class="amenities">
                                ${flight.amenities.map(a => `
                                    <div class="amenity">
                                        <svg fill="none" viewBox="0 0 12 12" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 1v10M1 6h10"/>
                                        </svg>
                                        ${a}
                                    </div>
                                `).join('')}
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="price-section">
                            <div class="from-label">From</div>
                            <div class="price">₱${flight.price.toLocaleString()}</div>
                            <button class="select-btn" onclick="selectFlight(${flight.id})">SELECT</button>
                        </div>
                    </div>
                </div>
            `).join('');

            // Update count
            document.getElementById('flightCount').textContent = sortedFlights.length;

            // Show/hide best deal badge
            const badge = document.getElementById('bestDealBadge');
            if (currentFilter === 'best' && sortedFlights[0]?.isBestDeal) {
                badge.style.display = 'inline-flex';
            } else {
                badge.style.display = 'none';
            }
        }

        // Switch Tabs
        function switchTab(filter, btn) {
            currentFilter = filter;

            // Update button states
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('active');
                b.classList.add('inactive');
            });
            btn.classList.remove('inactive');
            btn.classList.add('active');

            // Sort flights
            if (filter === 'best') {
                sortedFlights = [...flights];
            } else if (filter === 'cheapest') {
                sortedFlights = [...flights].sort((a, b) => a.price - b.price);
            } else if (filter === 'quickest') {
                sortedFlights = [...flights].sort((a, b) => {
                    const getDuration = (d) => {
                        const match = d.match(/(\d+)h\s*(\d+)m/);
                        return match ? parseInt(match[1]) * 60 + parseInt(match[2]) : 0;
                    };
                    return getDuration(a.duration) - getDuration(b.duration);
                });
            }

            renderFlights();
        }

        // Select Flight
        function selectFlight(id) {
            const flight = flights.find(f => f.id === id);
            // Save to localStorage
            localStorage.setItem('selectedFlight', JSON.stringify(flight));
            // Navigate to checkout
            window.location.href = 'checkout-1.html';
        }

        // Select Suggestion
        function selectSuggestion(destination) {
            alert(`Searching flights to ${destination}...`);
        }

        // Initialize
        window.onload = function() {
            renderFlights();
        };
    </script>
</body>
</html>