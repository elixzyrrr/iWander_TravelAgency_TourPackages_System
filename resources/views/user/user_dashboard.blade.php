<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - iWander</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/user_dashboard.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo-section">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="color: #237f87;">
                    <path d="M3 12L21 3L13 21L10 13L3 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M10 13L21 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="logo-text">iWander</span>
            </div>
            <button class="hamburger" type="button" data-sidebar-toggle>
                <svg id="menuIcon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="profile-section">
                <div class="profile-avatar">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="profile-info">
                    <h3>John Doe</h3>
                    <p>john.doe@email.com</p>
                </div>
            </div>
            <div class="profile-stats">
                <div>
                    <div class="stat-label">Trips</div>
                    <div class="stat-value">12</div>
                </div>
                <div>
                    <div class="stat-label">Points</div>
                    <div class="stat-value">2,450</div>
                </div>
            </div>
        </div>

        <div class="sidebar-nav">
            <button class="nav-item active" data-section="flights">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                <span>Flights</span>
            </button>
            <button class="nav-item" data-section="stays">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span>Stays</span>
            </button>
            <button class="nav-item" data-section="tours">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>Tours</span>
            </button>

            <div class="nav-divider"></div>

            <button class="nav-item" data-section="settings">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>Settings</span>
            </button>
            <button class="nav-item" data-section="about">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>About</span>
            </button>
        </div>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="logout-btn" type="submit">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 20px; height: 20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay" data-sidebar-close></div>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h2 class="welcome-title">Welcome back</h2>
        </div>

        <!-- Search Container -->
        <div class="search-container">
            <div class="search-tabs">
                <button class="search-tab active" onclick="switchSearchType('flights')">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    <span>Flights</span>
                </button>
                <button class="search-tab" onclick="switchSearchType('stays')">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>Stays</span>
                </button>
                <button class="search-tab" onclick="switchSearchType('tours')">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Tours</span>
                </button>
            </div>

            <form class="search-form" id="searchForm" onsubmit="performSearch(event)">
                <div class="form-field">
                    <label class="form-label" id="label1">From</label>
                    <div class="input-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <input type="text" class="form-input" id="input1" placeholder="New York" required>
                </div>

                <div class="form-field" id="field2">
                    <label class="form-label">To</label>
                    <div class="input-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <input type="text" class="form-input" id="input2" placeholder="London" required>
                </div>

                <div class="form-field">
                    <label class="form-label" id="label3">Departure Date</label>
                    <div class="input-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <input type="date" class="form-input" id="input3" value="2026-05-15" required>
                </div>

                <div class="form-field" id="field4">
                    <label class="form-label" id="label4">Return Date</label>
                    <div class="input-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <input type="date" class="form-input" id="input4" value="2026-05-22">
                </div>

                <div class="form-field">
                    <label class="form-label" id="label5">Travelers</label>
                    <div class="input-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <input type="number" class="form-input" id="input5" value="2" min="1" required>
                </div>
            </form>

            <button class="search-btn" onclick="performSearch(event)">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Search
            </button>
        </div>

        <!-- Popular Flights -->
        <section>
            <div class="section-header">
                <div>
                    <h3 class="section-title">Popular Flights ✈️</h3>
                    <p class="section-subtitle">Top routes chosen by travelers</p>
                </div>
                <button class="explore-btn" onclick="window.location.href='search-results.html'">
                    <span>Explore More</span>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>

            <div class="card-grid" id="flightsGrid">
                <!-- Cards will be generated by JavaScript -->
            </div>
        </section>

        <!-- Best Tour Packages -->
        <section>
            <div class="section-header">
                <div>
                    <h3 class="section-title">Best Tour Packages 🗺️</h3>
                    <p class="section-subtitle">Curated experiences for unforgettable journeys</p>
                </div>
                <button class="explore-btn">
                    <span>Explore More</span>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>

            <div class="card-grid" id="toursGrid">
                <!-- Cards will be generated by JavaScript -->
            </div>
        </section>

        <!-- Favorite Hotels -->
        <section>
            <div class="section-header">
                <div>
                    <h3 class="section-title">Favorite Hotels 🏨</h3>
                    <p class="section-subtitle">Handpicked luxury stays for you</p>
                </div>
                <button class="explore-btn">
                    <span>Explore More</span>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>

            <div class="card-grid" id="hotelsGrid">
                <!-- Cards will be generated by JavaScript -->
            </div>
        </section>

        <!-- Special Offer Banner -->
        <div class="special-offer">
            <div class="special-offer-content">
                <h3>✨ Summer Special Offer ✨</h3>
                <p>Save up to 30% on selected destinations. Limited time offer!</p>
                <button class="special-offer-btn">
                    <span>Claim Offer</span>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 20px; height: 20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Countries We Fly To -->
        <section>
            <div class="section-header">
                <div>
                    <h3 class="section-title">Countries We Fly To 🌍</h3>
                    <p class="section-subtitle">Discover amazing destinations worldwide</p>
                </div>
            </div>

            <div class="destinations-grid" id="destinationsGrid">
            </div>
        </section>
    </main>

    <!-- Logout confirmation modal -->
    <div id="logout-modal" class="modal-overlay" style="display:none; align-items:center; justify-content:center;">
        <div class="modal logout-modal">
            <div class="modal-header">
                <div>
                    <h3 class="modal-title">Confirm Logout</h3>
                </div>
            </div>
            <div class="modal-body">
                Are you sure you want to logout?
            </div>
            <div class="modal-footer logout-actions">
                <button type="button" class="logout-cancel-btn" onclick="closeLogoutModal()">Cancel</button>
                <button type="button" class="logout-confirm-btn" id="confirm-logout-btn">Logout</button>
            </div>
        </div>
    </div>

    <!-- Settings modal -->
    <div id="settings-modal" class="modal-overlay" style="display:none; align-items:center; justify-content:center;">
        <div class="modal" style="max-width:520px; padding:18px;">
            <div class="modal-header">
                <div>
                    <h3 class="modal-title">Settings</h3>
                </div>
                <button type="button" class="modal-close" onclick="document.getElementById('settings-modal').classList.remove('active')">Close</button>
            </div>
            <div class="modal-body">User settings placeholder.</div>
            <div class="modal-footer" style="display:flex; gap:8px; justify-content:flex-end;">
                <button type="button" class="btn-secondary" onclick="document.getElementById('settings-modal').classList.remove('active')">Close</button>
            </div>
        </div>
    </div>

    <!-- About modal -->
    <div id="about-modal" class="modal-overlay" style="display:none; align-items:center; justify-content:center;">
        <div class="modal" style="max-width:520px; padding:18px;">
            <div class="modal-header">
                <div>
                    <h3 class="modal-title">About</h3>
                </div>
                <button type="button" class="modal-close" onclick="document.getElementById('about-modal').classList.remove('active')">Close</button>
            </div>
            <div class="modal-body">About the iWander app.</div>
            <div class="modal-footer" style="display:flex; gap:8px; justify-content:flex-end;">
                <button type="button" class="btn-secondary" onclick="document.getElementById('about-modal').classList.remove('active')">Close</button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            function bindLayoutLogout() {
                const modal = document.getElementById('logout-modal');
                const confirmBtn = document.getElementById('confirm-logout-btn');
                const form = document.querySelector('form[action="{{ route('logout') }}"]');

                if (!modal || !confirmBtn || !form || form.dataset.layoutLogoutBound === '1') {
                    return;
                }

                form.dataset.layoutLogoutBound = '1';

                function openLogoutModal() {
                    modal.style.display = 'flex';
                    modal.classList.add('active');
                }

                function closeLogoutModal() {
                    modal.style.display = 'none';
                    modal.classList.remove('active');
                }

                window.openLogoutModal = function (submitForm) {
                    if (submitForm === form || !submitForm) {
                        openLogoutModal();
                    }
                };
                window.closeLogoutModal = closeLogoutModal;

                form.addEventListener('submit', function (event) {
                    if (form.dataset.logoutConfirmed === '1') {
                        return;
                    }

                    event.preventDefault();
                    openLogoutModal();
                });

                confirmBtn.addEventListener('click', function () {
                    form.dataset.logoutConfirmed = '1';
                    closeLogoutModal();
                    form.submit();
                });

                modal.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        closeLogoutModal();
                    }
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', bindLayoutLogout);
            } else {
                bindLayoutLogout();
            }
        })();
    </script>
</body>
</html>