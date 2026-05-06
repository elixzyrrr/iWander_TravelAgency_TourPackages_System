/**
 * Hotel Rooms Selection Page Script
 * Handles room selection and booking flow
 */

(() => {
    'use strict';

    // Guard: Check if roomSelectionData is available
    if (typeof roomSelectionData === 'undefined') {
        console.error('roomSelectionData is not defined');
        return;
    }

    /**
     * Initialize rooms selection page
     */
    function initRoomSelection() {
        console.log('Initializing room selection page for hotel:', agentRecordId);
        attachEventListeners();
    }

    /**
     * Attach event listeners to room radio buttons
     */
    function attachEventListeners() {
        const roomRadios = document.querySelectorAll('input[name="selected-room"]');
        const confirmBtn = document.getElementById('confirmRoomBtn');

        roomRadios.forEach((radio) => {
            radio.addEventListener('change', function() {
                updateRoomSelection(this);
                enableConfirmButton(confirmBtn);
            });
        });

        if (confirmBtn) {
            confirmBtn.addEventListener('click', proceedToBooking);
        }
    }

    /**
     * Update display when room is selected
     */
    function updateRoomSelection(selectedRadio) {
        const roomCards = document.querySelectorAll('.room-card');
        
        roomCards.forEach((card) => {
            const radio = card.querySelector('input[name="selected-room"]');
            if (radio === selectedRadio) {
                card.style.backgroundColor = '#f0f9fa';
            } else {
                card.style.backgroundColor = '';
            }
        });

        console.log('Room selected:', selectedRadio.value);
    }

    /**
     * Enable confirm button when a room is selected
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
        const selectedRoom = document.querySelector('input[name="selected-room"]:checked');
        
        if (!selectedRoom) {
            alert('Please select a room first');
            return;
        }

        const selectedRoomValue = selectedRoom.value;
        
        const bookingItem = {
            id: `agent-${agentRecordId}`,
            itemId: selectedRoomValue,
            agentRecordId: agentRecordId,
            sourceType: 'agent',
            sourceId: agentRecordId,
            title: roomSelectionData.hotelTitle || 'Hotel',
            description: roomSelectionData.hotelDestination || '',
            price: roomSelectionData.hotelAmount || 0,
            origin: 'Hotel Location',
            destination: roomSelectionData.hotelDestination || 'Destination',
            flag: '🏨',
            bookingType: 'stays',
            selectedRoomId: selectedRoomValue,
        };

        // Store to localStorage for multi-step booking
        localStorage.setItem('selectedBookingItem', JSON.stringify(bookingItem));

        // Redirect to booking page
        window.location.href = `/bookings/steps/booking?type=stays`;
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initRoomSelection);
    } else {
        initRoomSelection();
    }
})();
