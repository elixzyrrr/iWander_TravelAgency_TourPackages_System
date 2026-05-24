/**
 * Hotel Details Page Script
 * Handles hotel detail page interactions, booking flow, and UI management
 */

(() => {
    'use strict';

    // Guard: Check if agentRecordData is available
    if (typeof agentRecordData === 'undefined') {
        console.error('agentRecordData is not defined');
        return;
    }

    /**
     * Initialize hotel details page
     */
    function initHotelDetails() {
        console.log('Initializing hotel details page for record:', agentRecordId);
        attachEventListeners();
        setupInteractiveElements();
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
     * Proceed to booking with hotel data
     */
    window.proceedToBooking = function() {
        // Store hotel data to sessionStorage temporarily
        sessionStorage.setItem('hotelBookingData', JSON.stringify({
            hotelId: agentRecordId,
            hotelTitle: agentRecordData.title || 'Hotel',
            hotelDestination: agentRecordData.destination || '',
            hotelAmount: agentRecordData.amount || 0,
        }));

        // Redirect to rooms selection page
        window.location.href = `/hotels/rooms/${agentRecordId}`;
    };

    /**
     * Log hotel details for debugging
     */
    function logHotelDetails() {
        console.log('Hotel Details:', {
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
            logHotelDetails();
            initHotelDetails();
        });
    } else {
        logHotelDetails();
        initHotelDetails();
    }
})();
