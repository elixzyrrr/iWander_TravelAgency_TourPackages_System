/**
 * Flight Details Page Script
 * Handles flight detail page interactions, booking flow, and UI management
 */

(() => {
    'use strict';

    // Guard: Check if agentRecordData is available
    if (typeof agentRecordData === 'undefined') {
        console.error('agentRecordData is not defined');
        return;
    }

    /**
     * Initialize flight details page
     */
    function initFlightDetails() {
        console.log('Initializing flight details page for record:', agentRecordId);
        attachEventListeners();
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
     * Proceed to airlines selection page
     */
    window.proceedToBooking = function() {
        // Store flight data to sessionStorage for airlines selection
        const flightData = {
            id: agentRecordId,
            title: agentRecordData.title || 'Flight',
            description: agentRecordData.description || agentRecordData.destination || '',
            price: agentRecordData.amount || 0,
            destination: agentRecordData.destination || 'Destination',
            startDate: agentRecordData.travelStart || null,
            endDate: agentRecordData.travelEnd || null,
            bookingType: 'flights',
        };

        // Store to sessionStorage for airlines page
        sessionStorage.setItem('selectedFlight', JSON.stringify(flightData));

        // Redirect to airlines selection page
        window.location.href = `/flights/airlines/${agentRecordId}`;
    };

    /**
     * Log flight details for debugging
     */
    function logFlightDetails() {
        console.log('Flight Details:', {
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
            logFlightDetails();
            initFlightDetails();
        });
    } else {
        logFlightDetails();
        initFlightDetails();
    }
})();
