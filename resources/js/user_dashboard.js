(() => {
    const dashboardData = window.__USER_DASHBOARD__ ?? {};
    const userData = dashboardData.user ?? {};
    const profileData = dashboardData.profile ?? {};
    const sections = Array.isArray(dashboardData.sections) ? dashboardData.sections : [];
    const bookings = Array.isArray(dashboardData.bookings) ? dashboardData.bookings : [];
    const csrfToken = dashboardData.csrfToken ?? '';

    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const hamburger = document.querySelector('[data-sidebar-toggle]');
    const sidebarCloseTrigger = document.querySelector('[data-sidebar-close]');
    const searchTabs = Array.from(document.querySelectorAll('.search-tab'));
    const navItems = Array.from(document.querySelectorAll('.nav-item[data-section]'));
    const welcomeTitle = document.querySelector('.welcome-title');
    const profileName = document.querySelector('.profile-info h3');
    const profileEmail = document.querySelector('.profile-info p');
    const tripCount = document.querySelector('.profile-stats .stat-value:nth-of-type(1)');
    const pointCount = document.querySelector('.profile-stats .stat-value:nth-of-type(2)');
    const inputIds = ['input1', 'input2', 'input3', 'input4', 'input5'];
    const labelIds = ['label1', 'label2', 'label3', 'label4', 'label5'];
    const sectionGridMap = {
        flights: 'flightsGrid',
        stays: 'hotelsGrid',
        tours: 'toursGrid',
    };
    const searchTypeMap = {
        flights: 'flights',
        stays: 'stays',
        tours: 'tours',
    };
    const currentSearchType = dashboardData.activeSearchKey || 'flights';

    const searchConfigs = {
        flights: {
            labels: ['From', 'To', 'Departure Date', 'Return Date', 'Travelers'],
            types: ['text', 'text', 'date', 'date', 'number'],
            placeholders: [profileData.preferredDestination || 'Manila', 'Tokyo', '', '', '2'],
            values: ['', '', todayString(), addDaysString(7), '2'],
        },
        stays: {
            labels: ['City', 'Check-in', 'Check-out', 'Guests', 'Rooms'],
            types: ['text', 'date', 'date', 'number', 'number'],
            placeholders: [profileData.preferredDestination || 'Boracay', '', '', '2', '1'],
            values: ['', todayString(), addDaysString(3), '2', '1'],
        },
        tours: {
            labels: ['Destination', 'Budget', 'Start Date', 'End Date', 'Travelers'],
            types: ['text', 'number', 'date', 'date', 'number'],
            placeholders: [profileData.preferredDestination || 'Paris', '50000', '', '', '2'],
            values: ['', '', addDaysString(30), addDaysString(36), '2'],
        },
    };

    function todayString() {
        return new Date().toISOString().slice(0, 10);
    }

    function addDaysString(daysAhead) {
        const date = new Date();
        date.setDate(date.getDate() + daysAhead);
        return date.toISOString().slice(0, 10);
    }

    function escapeHtml(value) {
        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#39;');
    }

    function normalizeText(value) {
        return String(value ?? '').toLowerCase().replace(/\s+/g, ' ').trim();
    }

    function formatCurrency(value, currency = 'PHP') {
        const numericValue = Number(value ?? 0);

        if (! Number.isFinite(numericValue)) {
            return '';
        }

        try {
            return new Intl.NumberFormat('en-PH', {
                style: 'currency',
                currency,
                maximumFractionDigits: 0,
            }).format(numericValue);
        } catch {
            return `${currency} ${numericValue.toLocaleString('en-PH')}`;
        }
    }

    function setActiveSearchTab(type) {
        searchTabs.forEach((tab, index) => {
            const tabType = Object.keys(searchTypeMap)[index];
            tab.classList.toggle('active', tabType === type);
        });
    }

    function setActiveNavigation(sectionKey) {
        navItems.forEach((item) => {
            item.classList.toggle('active', item.dataset.section === sectionKey);
        });
    }

    function renderSearchForm(type) {
        const config = searchConfigs[type] ?? searchConfigs.flights;

        inputIds.forEach((inputId, index) => {
            const input = document.getElementById(inputId);
            const label = document.getElementById(labelIds[index]);

            if (! input || ! label) {
                return;
            }

            input.type = config.types[index] ?? 'text';
            input.placeholder = config.placeholders[index] ?? '';
            input.value = config.values[index] ?? '';
            input.min = input.type === 'number' ? '1' : '';
            if (input.type !== 'number') {
                input.removeAttribute('min');
            }

            label.textContent = config.labels[index] ?? '';
        });

        setActiveSearchTab(type);
    }

    function getSearchQuery() {
        const firstValue = document.getElementById('input1')?.value ?? '';
        const secondValue = document.getElementById('input2')?.value ?? '';

        if (currentSearchType === 'flights') {
            return `${secondValue} ${firstValue}`.trim();
        }

        return firstValue.trim();
    }

    function clearSearchHighlights() {
        document.querySelectorAll('.search-hit').forEach((element) => {
            element.classList.remove('search-hit');
        });
    }

    function scrollToSearchMatch(query) {
        const normalizedQuery = normalizeText(query);

        if (! normalizedQuery) {
            scrollToGrid(currentSearchType);
            return false;
        }

        const candidates = Array.from(document.querySelectorAll('[data-search-text]'));
        const match = candidates.find((element) => normalizeText(element.dataset.searchText).includes(normalizedQuery));

        if (! match) {
            scrollToGrid(currentSearchType);
            return false;
        }

        clearSearchHighlights();
        match.classList.add('search-hit');
        match.scrollIntoView({ behavior: 'smooth', block: 'center' });

        window.setTimeout(() => {
            match.classList.remove('search-hit');
        }, 2200);

        const gridId = match.closest('.card-grid, .destinations-grid')?.id;

        if (gridId === 'flightsGrid') {
            setActiveNavigation('flights');
        } else if (gridId === 'hotelsGrid') {
            setActiveNavigation('stays');
        } else if (gridId === 'toursGrid') {
            setActiveNavigation('tours');
        }

        return true;
    }

    function renderCardGrid(gridId, items, sectionKey) {
        const grid = document.getElementById(gridId);

        if (! grid) {
            return;
        }

        if (! items.length) {
            grid.innerHTML = '<div class="card" style="padding:24px;grid-column:1/-1;cursor:default;">No records found.</div>';
            return;
        }

        grid.innerHTML = items.map((item) => {
            const title = escapeHtml(item.title ?? 'Untitled');
            const description = escapeHtml(item.description ?? '');
            const price = item.price !== null && item.price !== undefined ? formatCurrency(item.price, item.currency || 'PHP') : '';
            const imageUrl = item.imageUrl || fallbackImageUrl(sectionKey);
            const creatorLabel = item.creatorName
                ? `Created by ${escapeHtml(item.creatorRole ? `${item.creatorRole} ` : '')}${escapeHtml(item.creatorName)}`
                : 'Created by iWander staff';
            const metaText = sectionKey === 'flights'
                ? escapeHtml(item.meta?.section_key ? 'Flight' : 'Flight Option')
                : sectionKey === 'stays'
                    ? 'Stay option'
                    : 'Tour package';
            const searchText = [title, description, price, metaText, creatorLabel].join(' ');
            const itemId = escapeHtml(item.sourceId ?? item.id ?? '');
            const itemSource = escapeHtml(item.sourceType || 'dashboard');

            return `
                <article class="card" data-item-id="${itemId}" data-item-source="${itemSource}" data-search-text="${escapeHtml(searchText)}">
                    <div class="card-image">
                        <img src="${escapeHtml(imageUrl)}" alt="${title}">
                        ${item.isFeatured ? '<div class="card-badge"><svg viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg><span>Featured</span></div>' : ''}
                    </div>
                    <div class="card-content">
                        <div class="card-header">
                            <h4 class="card-title">${title}</h4>
                        </div>
                        <div class="card-location">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>${metaText}</span>
                        </div>
                        <p class="card-subtitle">${description || 'Database-backed dashboard entry.'}</p>
                        <p class="card-subtitle" style="margin-top:8px;font-size:12px;opacity:.8;">${creatorLabel}</p>
                        <div class="card-footer">
                            <div class="card-info">${escapeHtml(item.currency || 'PHP')}</div>
                            <div class="card-price">${price}</div>
                        </div>
                    </div>
                </article>
            `;
        }).join('');
    }

    function fallbackImageUrl(sectionKey) {
        const fallbacks = {
            flights: 'https://images.unsplash.com/photo-1528360983277-13d401cdc186?auto=format&fit=crop&w=900&q=80',
            stays: 'https://images.unsplash.com/photo-1501117716987-c8e2a0a7e8b7?auto=format&fit=crop&w=900&q=80',
            tours: 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=900&q=80',
        };

        return fallbacks[sectionKey] || fallbacks.flights;
    }

    function renderDestinationGrid() {
        const grid = document.getElementById('destinationsGrid');

        if (! grid) {
            return;
        }

        const destinationItems = [];

        bookings.forEach((booking) => {
            const destinationName = booking.destination || booking.origin;

            if (destinationName) {
                destinationItems.push({
                    title: destinationName,
                    description: booking.referenceCode || booking.bookingType || 'Recent booking',
                    imageUrl: fallbackImageUrl(booking.bookingType),
                });
            }
        });

        sections.forEach((section) => {
            (section.items || []).forEach((item) => {
                destinationItems.push({
                    title: item.title,
                    description: item.description || section.subtitle || section.title,
                    imageUrl: item.imageUrl || fallbackImageUrl(section.key),
                });
            });
        });

        const uniqueDestinations = [];
        const seenTitles = new Set();

        destinationItems.forEach((item) => {
            if (! item.title || seenTitles.has(item.title)) {
                return;
            }

            seenTitles.add(item.title);
            uniqueDestinations.push(item);
        });

        grid.innerHTML = uniqueDestinations.slice(0, 6).map((item) => `
            <article class="destination-card" data-search-text="${escapeHtml([item.title, item.description].join(' '))}">
                <img src="${escapeHtml(item.imageUrl)}" alt="${escapeHtml(item.title)}">
                <div class="destination-overlay">
                    <h4>${escapeHtml(item.title)}</h4>
                    <p>${escapeHtml(item.description)}</p>
                </div>
            </article>
        `).join('');
    }

    function renderHeaderData() {
        const firstName = (userData.name || 'Traveler').split(' ')[0];

        if (welcomeTitle) {
            welcomeTitle.textContent = `Welcome back, ${firstName}! 👋`;
        }

        if (profileName) {
            profileName.textContent = userData.name || 'Traveler';
        }

        if (profileEmail) {
            profileEmail.textContent = userData.email || '';
        }

        if (tripCount) {
            tripCount.textContent = String(profileData.tripsCount ?? 0);
        }

        if (pointCount) {
            pointCount.textContent = String(profileData.points ?? 0);
        }
    }

    function scrollToGrid(sectionKey) {
        const gridId = sectionGridMap[sectionKey];
        const grid = gridId ? document.getElementById(gridId) : null;

        if (grid) {
            grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    function performSearch(event) {
        if (event) {
            event.preventDefault();
        }

        return scrollToSearchMatch(getSearchQuery());
    }

    function switchSearchType(type) {
        const normalizedType = searchConfigs[type] ? type : 'flights';
        renderSearchForm(normalizedType);
        scrollToGrid(normalizedType);
        return false;
    }

    function logout() {
        if (! csrfToken) {
            return;
        }

        const logoutForm = document.createElement('form');
        logoutForm.method = 'POST';
        logoutForm.action = '/logout';
        logoutForm.style.display = 'none';

        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = csrfToken;

        logoutForm.appendChild(tokenInput);
        document.body.appendChild(logoutForm);
        logoutForm.submit();
    }

    const toggleSidebar = () => {
        sidebar?.classList.toggle('open');
        overlay?.classList.toggle('active');
    };

    const closeSidebar = () => {
        sidebar?.classList.remove('open');
        overlay?.classList.remove('active');
    };

    window.toggleSidebar = toggleSidebar;
    window.closeSidebar = closeSidebar;
    window.switchSearchType = switchSearchType;
    window.performSearch = performSearch;
    window.logout = logout;

    hamburger?.addEventListener('click', toggleSidebar);
    overlay?.addEventListener('click', closeSidebar);
    sidebarCloseTrigger?.addEventListener('click', closeSidebar);

    searchTabs.forEach((tab, index) => {
        const tabType = Object.keys(searchConfigs)[index] || 'flights';
        tab.addEventListener('click', () => switchSearchType(tabType));
    });

    navItems.forEach((item) => {
        item.addEventListener('click', () => {
            setActiveNavigation(item.dataset.section || 'flights');
            scrollToGrid(item.dataset.section || 'flights');

            if (window.innerWidth <= 768) {
                window.closeSidebar();
            }
        });
    });

    // Generic handlers for buttons present in the Blade template
    document.querySelectorAll('.explore-btn').forEach((btn) => {
        btn.addEventListener('click', (e) => {
            const section = btn.closest('.section-header')?.nextElementSibling?.id;
            if (section) {
                document.getElementById(section)?.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    document.querySelectorAll('.favorite-btn').forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            btn.classList.toggle('favorited');
            // Persist favorite via fetch to server (best-effort, non-blocking)
            const card = btn.closest('.card');
            const title = card?.querySelector('.card-title')?.textContent?.trim();
            if (! title) return;

            fetch('/api/user/favorites', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ title, favorited: btn.classList.contains('favorited') })
            }).catch(() => {});
        });
    });

    // Make special offer button navigate to 'flights' section
    document.querySelectorAll('.special-offer-btn').forEach((btn) => {
        btn.addEventListener('click', () => {
            setActiveNavigation('flights');
            scrollToGrid('flights');
        });
    });

    renderHeaderData();
    renderSearchForm(currentSearchType);

    sections.forEach((section) => {
        if (section.key === 'flights') {
            renderCardGrid('flightsGrid', section.items || [], section.key);
        }

        if (section.key === 'stays') {
            renderCardGrid('hotelsGrid', section.items || [], section.key);
        }

        if (section.key === 'tours') {
            renderCardGrid('toursGrid', section.items || [], section.key);
        }
    });

    renderDestinationGrid();

    // Wire card clicks to detail pages or booking process (after cards are rendered)
    document.querySelectorAll('.card').forEach((card) => {
        card.addEventListener('click', () => {
            const title = card.querySelector('.card-title')?.textContent?.trim();
            const description = card.querySelector('.card-subtitle')?.textContent?.trim();
            const priceEl = card.querySelector('.card-price');
            const price = priceEl ? parseFloat(priceEl.textContent.replace(/[^\d.]/g, '')) || 0 : 0;
            const grid = card.parentElement;
            const sectionKey = grid?.id === 'flightsGrid' ? 'flights' : (grid?.id === 'hotelsGrid' ? 'stays' : 'tours');
            const sourceType = card.dataset.itemSource || 'dashboard';
            const sourceId = card.dataset.itemId || '';
            
            // Debug logging
            console.log('Card clicked:', { title, sourceType, sourceId, sectionKey });
            
            // If this is an agent-created record, navigate to detail page first
            if (sourceType === 'agent') {
                const typeMap = {
                    flights: 'flights',
                    stays: 'hotels',
                    tours: 'tours',
                };
                const detailType = typeMap[sectionKey] || sectionKey;
                
                // Navigate to detail page
                console.log('Routing to detail page:', `/flights/details/${sourceId}`.replace('flights', detailType));
                window.location.href = `/flights/details/${sourceId}`.replace('flights', detailType);
                return;
            }
            
            // For dashboard items, proceed directly to booking
            const bookingItem = {
                id: sourceId,
                itemId: sourceType === 'dashboard' ? sourceId : '',
                agentRecordId: sourceType === 'agent' ? sourceId : '',
                sourceType,
                sourceId,
                title: title || 'Selected Item',
                description: description || '',
                price: price,
                origin: sectionKey === 'flights' ? 'Departure' : 'Location',
                destination: description || 'Destination',
                flag: sectionKey === 'flights' ? '✈️' : (sectionKey === 'stays' ? '🏨' : '🗺️'),
                bookingType: sectionKey,
            };
            
            // Store to localStorage
            localStorage.setItem('selectedBookingItem', JSON.stringify(bookingItem));
            
            // Redirect to booking form
            const bookingUrl = new URL('/bookings/steps/booking', window.location.origin);
            bookingUrl.searchParams.set('type', sectionKey);
            window.location.href = bookingUrl.toString();
        });
    });

    setActiveNavigation(dashboardData.activeSectionKey || 'flights');
    setActiveSearchTab(currentSearchType);
})();