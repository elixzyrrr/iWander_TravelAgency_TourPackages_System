/**
 * Tour Dates Selection Page Script
 * Handles tour date selection and booking flow
 */

(() => {
    'use strict';

    // Guard: Check if tourSelectionData is available
    if (typeof tourSelectionData === 'undefined') {
        console.error('tourSelectionData is not defined');
        return;
    }

    /**
     * Initialize tour dates selection page
     */
    function initTourDateSelection() {
        console.log('Initializing tour date selection page for tour:', agentRecordId);
        attachEventListeners();
    }

    /**
     * Attach event listeners to date radio buttons
     */
    function attachEventListeners() {
        const dateRadios = document.querySelectorAll('input[name="selected-date"]');
        const confirmBtn = document.getElementById('confirmDateBtn');

        dateRadios.forEach((radio) => {
            radio.addEventListener('change', function() {
                updateDateSelection(this);
                enableConfirmButton(confirmBtn);
            });
        });

        if (confirmBtn) {
            confirmBtn.addEventListener('click', proceedToBooking);
        }
    }

    /**
     * Update display when date is selected
     */
    function updateDateSelection(selectedRadio) {
        const dateCards = document.querySelectorAll('.date-card');
        
        dateCards.forEach((card) => {
            const radio = card.querySelector('input[name="selected-date"]');
            if (radio === selectedRadio) {
                card.style.backgroundColor = '#f0f9fa';
            } else {
                card.style.backgroundColor = '';
            }
        });

        console.log('Date selected:', selectedRadio.value);
    }

    /**
     * Enable confirm button when a date is selected
     */
    function enableConfirmButton(btn) {
        if (btn) {
            btn.disabled = false;
        }
    }

    /**
     * Proceed to booking page
     */
    window.proceedToBooking = function() {
        const selectedDate = document.querySelector('input[name="selected-date"]:checked');
        
        if (!selectedDate) {
            alert('Please select departure dates first');
            return;
        }

        const selectedDateValue = selectedDate.value;
        
        const bookingItem = {
            id: `agent-${agentRecordId}`,
            itemId: selectedDateValue,
            agentRecordId: agentRecordId,
            sourceType: 'agent',
            sourceId: agentRecordId,
            title: tourSelectionData.tourTitle || 'Tour Package',
            description: tourSelectionData.tourDestination || '',
            price: tourSelectionData.tourAmount || 0,
            origin: 'Tour Start Point',
            destination: tourSelectionData.tourDestination || 'Destination',
            flag: '🗺️',
            bookingType: 'tours',
            selectedDateId: selectedDateValue,
        };

        // Store to localStorage for multi-step booking
        localStorage.setItem('selectedBookingItem', JSON.stringify(bookingItem));

        // Redirect to airlines selection page
        window.location.href = '/bookings/steps/airlines';
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTourDateSelection);
    } else {
        initTourDateSelection();
    }
})();
