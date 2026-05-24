// resources/js/agent.js
document.addEventListener('DOMContentLoaded', () => {
    console.log('Agent JS loaded');

    // ------------------------------
    // Sidebar
    // ------------------------------
    window.toggleSidebar = function() {
        const sidebar = document.getElementById('sidebar');
        if (sidebar) sidebar.classList.toggle('mobile-open');
    }

    // Bind any elements using data-sidebar-toggle to the toggle function
    document.querySelectorAll('[data-sidebar-toggle]').forEach(btn => btn.addEventListener('click', () => window.toggleSidebar()));

    // ------------------------------
    // Switch View
    // ------------------------------
    window.switchView = function(view, event) {
        event = event || window.event;

        // Update active nav item
        document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
        if (event?.target) event.target.closest('.nav-item')?.classList.add('active');

        // Hide all views
        document.querySelectorAll('.view-content').forEach(content => content.classList.remove('active'));

        // Show selected view
        const viewEl = document.getElementById(`view-${view}`);
        if (viewEl) viewEl.classList.add('active');

        // Update header title
        const titles = {
            'dashboard': 'Dashboard Overview',
            'bookings': 'All Bookings',
            'customers': 'Customer Management',
            'flights': 'Flight Inventory',
            'hotels': 'Hotel Listings',
            'packages': 'Tour Packages',
            'calendar': 'Booking Calendar',
            'messages': 'Messages',
            'reports': 'Analytics & Reports',
            'settings': 'Settings'
        };
        const header = document.getElementById('headerTitle');
        if (header && titles[view]) header.textContent = titles[view];

        // Close sidebar on mobile
        const sidebar = document.getElementById('sidebar');
        if (window.innerWidth < 1024 && sidebar) sidebar.classList.remove('mobile-open');
    }

    // Bind nav items that have data-section attribute to switchView
    document.querySelectorAll('.nav-item[data-section]').forEach(item => {
        item.addEventListener('click', function(e){
            const section = this.getAttribute('data-section');
            if(section) {
                // If section is settings or about, open modal if present
                if(section === 'settings' || section === 'about') {
                    const modalId = section + '-modal';
                    const modal = document.getElementById(modalId);
                    if(modal) return modal.classList.add('active');
                }
                window.switchView(section, e);
            }
        });
    });

    // Fallback: open modal for elements with data-open-modal
    document.querySelectorAll('[data-open-modal]').forEach(btn => {
        btn.addEventListener('click', function(e){
            const id = this.getAttribute('data-open-modal');
            const modal = document.getElementById(id);
            if(modal) modal.classList.add('active');
        });
    });

    // Delegate logout handling to the shared app-level handler when available.
    document.querySelectorAll('.logout-btn, .admin-logout').forEach(btn => {
        btn.addEventListener('click', function(e){
            const form = this.closest('form');
            if (typeof window.openLogoutModal === 'function' && form) {
                e.preventDefault();
                window.openLogoutModal(form);
            }
        });
    });

    // ------------------------------
    // Filter Bookings
    // ------------------------------
    window.filterBookings = function(filter, event) {
        event = event || window.event;
        const parent = event.target.parentElement;
        parent.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');

        console.log('Filtering by:', filter);
    }

    // ------------------------------
    // Booking Modals
    // ------------------------------
    window.viewBooking = function(id) { openModal('viewBookingModal'); }
    window.editBooking = function(id) { closeModal('viewBookingModal'); openModal('editBookingModal'); }
    window.saveBooking = function() { alert('Booking updated successfully!'); closeModal('editBookingModal'); }

    window.viewRequest = function(id) { openModal('viewRequestModal'); }
    window.sendResponse = function() { alert('Response sent successfully!'); closeModal('viewRequestModal'); }

    window.createPackage = function() { alert('Package created successfully!'); closeModal('createPackageModal'); }
    window.generateReport = function() { alert('Report generated successfully!'); closeModal('generateReportModal'); }

    // ------------------------------
    // Image Upload Preview
    // ------------------------------
    let uploadedImages = [];
    window.handleImageUpload = function(event) {
        const files = event.target.files;
        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                uploadedImages.push(e.target.result);
                renderImagePreview();
            };
            reader.readAsDataURL(file);
        });
    }

    function renderImagePreview() {
        const previewGrid = document.getElementById('imagePreviewGrid');
        if (!previewGrid) return;
        previewGrid.innerHTML = uploadedImages.map((img, index) => `
            <div class="image-preview-item">
                <img src="${img}" alt="Preview">
                <button class="image-remove-btn" onclick="removeImage(${index})">×</button>
            </div>
        `).join('');
    }

    window.removeImage = function(index) {
        uploadedImages.splice(index, 1);
        renderImagePreview();
    }

    // ------------------------------
    // Modals
    // ------------------------------
    window.openModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.add('active');
    }

    window.closeModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.remove('active');

        // Reset images if closing create package modal
        if (modalId === 'createPackageModal') {
            uploadedImages = [];
            renderImagePreview();
        }
    }

    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', e => {
            if (e.target === overlay) window.closeModal(overlay.id);
        });
    });

    // ------------------------------
    // Logout
    // ------------------------------
    window.logout = function() {
        const logoutForm = document.querySelector('form[action$="/logout"]');

        if (!logoutForm) {
            return;
        }

        if (typeof window.openLogoutModal === 'function') {
            window.openLogoutModal(logoutForm);
            return;
        }

        logoutForm.submit();
    }

    // ------------------------------
    // Close sidebar on outside click (mobile)
    // ------------------------------
    const hamburger = document.querySelector('.hamburger');
    const sidebar = document.getElementById('sidebar');
    document.addEventListener('click', e => {
        if (window.innerWidth < 1024 && sidebar?.classList.contains('mobile-open') && !sidebar.contains(e.target) && !(hamburger && hamburger.contains(e.target))) {
            sidebar.classList.remove('mobile-open');
        }
    });
});