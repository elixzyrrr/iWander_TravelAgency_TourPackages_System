/**
 * Airlines Selection Page Script
 * Handles airline selection, booking flow, and UI management
 */

(() => {
    'use strict';

    // Guard: Check if selection data is available
    if (typeof airlineSelectionData === 'undefined') {
        console.error('airlineSelectionData is not defined');
        return;
    }

    /**
     * Initialize airlines selection page
     */
    function initAirlinesSelection() {
        console.log('Initializing airlines selection page for flight:', airlineSelectionData.flightId);
        attachEventListeners();
    }

    /**
     * Attach event listeners to interactive elements
     */
    function attachEventListeners() {
        // Flight radio buttons
        const flightRadios = document.querySelectorAll('.flight-radio');
        flightRadios.forEach(radio => {
            radio.addEventListener('change', handleFlightSelection);
        });

        // Confirm booking button
        const confirmBtn = document.getElementById('confirmBookingBtn');
        if (confirmBtn) {
            confirmBtn.addEventListener('click', proceedToBooking);
        }
    }

    /**
     * Handle flight selection
     */
    function handleFlightSelection(event) {
        const selectedRadio = event.target;
        
        // Remove selected class from all airline cards
        document.querySelectorAll('.airline-card').forEach(card => {
            card.classList.remove('selected');
        });

        // Add selected class to the parent airline card
        const airlineCard = selectedRadio.closest('.airline-card');
        if (airlineCard) {
            airlineCard.classList.add('selected');
        }

        // Update the selected airline display
        const airlineName = selectedRadio.dataset.airlineName;
        const departure = selectedRadio.value; // airline-id-index format
        const displayElement = document.getElementById('selectedAirlineDisplay');
        
        if (displayElement) {
            displayElement.textContent = `${airlineName} - Flight ${departure}`;
        }

        // Enable confirm button
        const confirmBtn = document.getElementById('confirmBookingBtn');
        if (confirmBtn) {
            confirmBtn.disabled = false;
        }

        console.log('Flight selected:', {
            airline: airlineName,
            flight: departure
        });
    }

    /**
     * Proceed to booking with selected airline
     */
    window.proceedToBooking = function() {
        const selectedRadio = document.querySelector('.flight-radio:checked');
        
        if (!selectedRadio) {
            alert('Please select a flight and airline');
            return;
        }

        // Get the selected flight data
        const flightDataBase64 = selectedRadio.dataset.flightData;
        const flightData = JSON.parse(atob(flightDataBase64));
        const airlineId = selectedRadio.dataset.airlineId;
        const airlineName = selectedRadio.dataset.airlineName;

        // Create booking item with airline information
        const bookingItem = {
            id: `agent-flight-${airlineSelectionData.flightId}-airline-${airlineId}`,
            itemId: '',
            agentRecordId: airlineSelectionData.flightId,
            sourceType: 'agent',
            sourceId: airlineSelectionData.flightId,
            title: airlineSelectionData.flightTitle || 'Flight',
            description: `${airlineName} - ${airlineSelectionData.flightDescription}` || airlineSelectionData.flightDestination || '',
            price: airlineSelectionData.flightAmount || 0,
            origin: 'Departure',
            destination: airlineSelectionData.flightDestination || 'Destination',
            startDate: airlineSelectionData.flightStartDate || null,
            endDate: airlineSelectionData.flightEndDate || null,
            airline: airlineName,
            airlineId: airlineId,
            departure: flightData.departure,
            arrival: flightData.arrival,
            duration: flightData.duration,
            stops: flightData.stops,
            flightPrice: flightData.price,
            flag: '✈️',
            bookingType: 'flights',
        };

        // Store to localStorage for multi-step booking
        localStorage.setItem('selectedBookingItem', JSON.stringify(bookingItem));

        // Clear session storage
        sessionStorage.removeItem('selectedFlight');

        // Log for debugging
        console.log('Proceeding to booking with:', bookingItem);

        // Redirect to booking form
        const bookingUrl = new URL('/bookings/steps/booking', window.location.origin);
        bookingUrl.searchParams.set('type', 'flights');
        window.location.href = bookingUrl.toString();
    };

    /**
     * Handle back navigation
     */
    window.handleBackNavigation = function() {
        history.back();
    };

    /**
     * Log airlines selection data (for debugging)
     */
    function logAirlinesData() {
        console.log('Airlines Selection Data:', {
            flight: airlineSelectionData,
            selectedFlight: sessionStorage.getItem('selectedFlight'),
        });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAirlinesSelection);
    } else {
        initAirlinesSelection();
    }

    // Expose logging function for debugging
    window.logAirlinesData = logAirlinesData;
})();
