/**
 * Tour Details Page Script
 * Handles tour detail page interactions, booking flow, itinerary, and UI management
 */

(() => {
    'use strict';

    // Guard: Check if agentRecordData is available
    if (typeof agentRecordData === 'undefined') {
        console.error('agentRecordData is not defined');
        return;
    }

    /**
     * Initialize tour details page
     */
    function initTourDetails() {
        console.log('Initializing tour details page for record:', agentRecordId);
        attachEventListeners();
        setupInteractiveElements();
        animateItinerary();
    }

    /**
     * Attach event listeners to interactive elements
     */
    function attachEventListeners() {
        const bookBtn = document.querySelector('.book-btn');
        if (bookBtn) {
            bookBtn.addEventListener('click', proceedToBooking);
        }
    }

    /**
     * Setup interactive elements on the page
     */
    function setupInteractiveElements() {
        // Add hover effects to itinerary days
        document.querySelectorAll('.itinerary-day').forEach((day, index) => {
            day.style.cursor = 'pointer';
            day.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f9fafb';
                this.style.borderRadius = '8px';
                this.style.padding = '10px';
                this.style.transition = 'all 0.3s ease';
            });
            day.addEventListener('mouseleave', function() {
                this.style.backgroundColor = 'transparent';
                this.style.padding = '20px 0';
            });
        });

        // Add hover effects to amenity items
        document.querySelectorAll('.amenity-item').forEach((item) => {
            item.style.cursor = 'pointer';
            item.addEventListener('mouseenter', function() {
                this.style.opacity = '0.8';
            });
            item.addEventListener('mouseleave', function() {
                this.style.opacity = '1';
            });
        });
    }

    /**
     * Animate itinerary items on page load
     */
    function animateItinerary() {
        const itineraryDays = document.querySelectorAll('.itinerary-day');
        itineraryDays.forEach((day, index) => {
            day.style.opacity = '0';
            day.style.transform = 'translateY(10px)';
            setTimeout(() => {
                day.style.transition = 'all 0.3s ease';
                day.style.opacity = '1';
                day.style.transform = 'translateY(0)';
            }, index * 100);
        });
    }

    /**
     * Proceed to booking with tour data
     */
    window.proceedToBooking = function() {
        // Store tour data to sessionStorage temporarily
        sessionStorage.setItem('tourBookingData', JSON.stringify({
            tourId: agentRecordId,
            tourTitle: agentRecordData.title || 'Tour Package',
            tourDestination: agentRecordData.destination || '',
            tourAmount: agentRecordData.amount || 0,
        }));

        // Redirect to tour dates selection page
        window.location.href = `/tours/dates/${agentRecordId}`;
    };

    /**
     * Log tour details for debugging
     */
    function logTourDetails() {
        console.log('Tour Details:', {
            id: agentRecordId,
            type: detailType,
            title: agentRecordData.title,
            destination: agentRecordData.destination,
            amount: agentRecordData.amount,
            creator: agentRecordData.creatorName,
        });
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            logTourDetails();
            initTourDetails();
        });
    } else {
        logTourDetails();
        initTourDetails();
    }
})();
