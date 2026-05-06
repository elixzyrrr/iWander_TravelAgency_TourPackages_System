// resources/js/booking.js
document.addEventListener('DOMContentLoaded', () => {
    console.log('Booking JS loaded');
 
    const form = document.getElementById('passengerForm');
    const bookingType = form?.dataset.bookingType || document.body?.dataset.bookingType || 'flights';
    const nextStepUrl = form?.dataset.nextStepUrl || document.body?.dataset.nextStepUrl || '/bookings/steps/seat-selection';
    
    // Countries list
    window.countries = ['Philippines', 'United States', 'United Kingdom', 'France', 'Germany', 'Italy', 'Spain', 'Japan', 'China', 'South Korea', 'Australia', 'Canada', 'Singapore', 'Thailand', 'Malaysia', 'Indonesia', 'Vietnam', 'India', 'United Arab Emirates', 'Saudi Arabia'];

    // Passengers / Guests
    window.passengers = [
        { id: 1, title: '', firstName: '', lastName: '', dob: '', nationality: '', passportNumber: '', passportExpiry: '' }
    ];
     
    // Load booking data from localStorage or URL
    const selectedItem = JSON.parse(localStorage.getItem('selectedBookingItem') || '{}');

    window.initBooking = function() {
        // Update form titles based on booking type
        const titles = {
            flights: 'Passenger Details',
            stays: 'Guest Details',
            tours: 'Traveler Details'
        };
        const subtitles = {
            flights: 'Please provide information for all passengers',
            stays: 'Please provide information for all guests',
            tours: 'Please provide information for all travelers'
        };
        
        if (!selectedItem.id && !selectedItem.itemId) {
            console.warn('No booking item found, using defaults');
        }

        // Update UI
        const formTitle = document.getElementById('formTitle');
        const formSubtitle = document.getElementById('formSubtitle');
        const summaryTitle = document.getElementById('summaryTitle');
        
        if (formTitle) formTitle.textContent = titles[bookingType] || 'Booking Details';
        if (formSubtitle) formSubtitle.textContent = subtitles[bookingType] || 'Please provide booking information';
        if (summaryTitle) summaryTitle.textContent = `${(bookingType === 'tours' ? 'Tour' : bookingType === 'stays' ? 'Stay' : 'Flight')} Summary`;

        // Populate summary
        const summaryFlag = document.getElementById('summaryFlag');
        if (summaryFlag) summaryFlag.textContent = selectedItem.flag || '✈️';
        const summaryAirline = document.getElementById('summaryAirline');
        if (summaryAirline) summaryAirline.textContent = selectedItem.title || 'Selected Item';
        const summaryAircraft = document.getElementById('summaryAircraft');
        if (summaryAircraft) summaryAircraft.textContent = selectedItem.description || '';
        const summaryRoute = document.getElementById('summaryRoute');
        if (summaryRoute) summaryRoute.innerHTML = selectedItem.destination 
            ? `<strong>${selectedItem.origin || 'Departure'}</strong> → <strong>${selectedItem.destination}</strong>`
            : `<strong>${selectedItem.title || 'Item'}</strong>`;
        const summaryDepartTime = document.getElementById('summaryDepartTime');
        if (summaryDepartTime) summaryDepartTime.textContent = selectedItem.departTime || 'N/A';
        const summaryArriveTime = document.getElementById('summaryArriveTime');
        if (summaryArriveTime) summaryArriveTime.textContent = selectedItem.arriveTime || 'N/A';
        const summaryDuration = document.getElementById('summaryDuration');
        if (summaryDuration) summaryDuration.textContent = selectedItem.duration || 'Variable';
        const summaryCabin = document.getElementById('summaryCabin');
        if (summaryCabin) summaryCabin.textContent = selectedItem.class || bookingType;
        const summaryPrice = document.getElementById('summaryPrice');
        if (summaryPrice) summaryPrice.textContent = `₱${(selectedItem.price || 0).toLocaleString()}`;

        renderPassengers();
    };

    // Render passengers/guests/travelers
    window.renderPassengers = function() {
        const container = document.getElementById('passengersContainer');
        container.innerHTML = passengers.map((p, index) => `
            <div class="passenger-section" data-passenger-id="${p.id}">
                <div class="passenger-header">
                    <h3 class="passenger-title">Person ${index + 1}</h3>
                    ${passengers.length > 1 ? `<button type="button" class="remove-btn" onclick="removePassenger(${p.id})">Remove</button>` : ''}
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Title *</label>
                        <select id="title_${p.id}" class="form-select" required>
                            <option value="">Select</option>
                            <option value="Mr" ${p.title === 'Mr' ? 'selected' : ''}>Mr</option>
                            <option value="Ms" ${p.title === 'Ms' ? 'selected' : ''}>Ms</option>
                            <option value="Mrs" ${p.title === 'Mrs' ? 'selected' : ''}>Mrs</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>First Name *</label>
                        <input type="text" id="firstName_${p.id}" class="form-input" value="${p.firstName}" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name *</label>
                        <input type="text" id="lastName_${p.id}" class="form-input" value="${p.lastName}" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Date of Birth *</label>
                        <input type="date" id="dob_${p.id}" class="form-input" value="${p.dob}" max="${new Date().toISOString().split('T')[0]}" required>
                    </div>
                    <div class="form-group">
                        <label>Nationality *</label>
                        <select id="nationality_${p.id}" class="form-select" required>
                            <option value="">Select country</option>
                            ${countries.map(c => `<option value="${c}" ${p.nationality === c ? 'selected' : ''}>${c}</option>`).join('')}
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Document Number *</label>
                        <input type="text" id="passportNumber_${p.id}" class="form-input" value="${p.passportNumber}" placeholder="Passport or ID number" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Document Expiry Date *</label>
                        <input type="date" id="passportExpiry_${p.id}" class="form-input" value="${p.passportExpiry}" min="${new Date().toISOString().split('T')[0]}" required>
                    </div>
                </div>
            </div>
        `).join('');

        updatePassengerCount();
    };

    window.addPassenger = function() {
        const newId = Math.max(...passengers.map(p => p.id), 0) + 1;
        passengers.push({ id: newId, title:'', firstName:'', lastName:'', dob:'', nationality:'', passportNumber:'', passportExpiry:'' });
        renderPassengers();
    };

    window.removePassenger = function(id) {
        if(passengers.length > 1){
            passengers = passengers.filter(p => p.id !== id);
            renderPassengers();
        }
    };

    window.updatePassengerCount = function() {
        const countEl = document.getElementById('passengerCount');
        if(countEl) countEl.textContent = passengers.length;
    };
     
    // Validation
    window.validateEmail = email => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    window.validatePhone = phone => /^[+]?[\d\s()-]{10,}$/.test(phone);

    window.showAlert = function(message, type='warning') {
        const alert = document.getElementById('alertBox');
        if(!alert) return;
        alert.textContent = message;
        alert.className = 'alert show';
        alert.style.background = type==='error' ? '#fee2e2' : '#fef3c7';
        alert.style.borderColor = type==='error' ? '#fca5a5' : '#fcd34d';
        alert.style.color = type==='error' ? '#991b1b' : '#92400e';

        setTimeout(()=>alert.classList.remove('show'), 5000);
    };

    window.syncBookingFields = function() {
        const summaryPayload = {
            title: selectedItem.title || 'Booking',
            description: selectedItem.description,
            origin: selectedItem.origin,
            destination: selectedItem.destination,
            price: Number(selectedItem.price || 0),
        };

        const passengersPayload = passengers.map((p) => ({
            id: p.id,
            title: document.getElementById(`title_${p.id}`)?.value,
            firstName: document.getElementById(`firstName_${p.id}`)?.value,
            lastName: document.getElementById(`lastName_${p.id}`)?.value,
            dob: document.getElementById(`dob_${p.id}`)?.value,
            nationality: document.getElementById(`nationality_${p.id}`)?.value,
            passportNumber: document.getElementById(`passportNumber_${p.id}`)?.value,
            passportExpiry: document.getElementById(`passportExpiry_${p.id}`)?.value,
        }));

        const contactInfo = {
            email: document.getElementById('contactEmail')?.value || '',
            phone: document.getElementById('contactPhone')?.value || '',
            emergency: document.getElementById('emergencyContact')?.value || '',
            specialRequests: document.getElementById('specialRequests')?.value || '',
        };

        const itemId = selectedItem.sourceType === 'agent' ? '' : (selectedItem.itemId || selectedItem.id || '');
        const agentRecordId = selectedItem.sourceType === 'agent' ? (selectedItem.sourceId || selectedItem.itemId || selectedItem.id || '') : '';
        const hiddenFields = {
            bookingItemId: itemId,
            bookingAgentRecordId: agentRecordId,
            bookingOrigin: summaryPayload.origin || selectedItem.title || '',
            bookingDestination: summaryPayload.destination || '',
            bookingTravelers: String(passengersPayload.length),
            bookingBudget: String(summaryPayload.price),
            bookingNotes: JSON.stringify({ item: summaryPayload, passengers: passengersPayload, contactInfo }),
        };

        Object.entries(hiddenFields).forEach(([fieldId, value]) => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.value = value;
            }
        });

        localStorage.setItem('passengers', JSON.stringify(passengersPayload));
        localStorage.setItem('contactInfo', JSON.stringify(contactInfo));
    };

    // Form Submit
    if(form){
        form.addEventListener('submit', e=>{
            e.preventDefault();

            // Collect passenger data
            passengers = passengers.map(p=>({
                id: p.id,
                title: document.getElementById(`title_${p.id}`)?.value,
                firstName: document.getElementById(`firstName_${p.id}`)?.value,
                lastName: document.getElementById(`lastName_${p.id}`)?.value,
                dob: document.getElementById(`dob_${p.id}`)?.value,
                nationality: document.getElementById(`nationality_${p.id}`)?.value,
                passportNumber: document.getElementById(`passportNumber_${p.id}`)?.value,
                passportExpiry: document.getElementById(`passportExpiry_${p.id}`)?.value
            }));

            // Validate
            for(const p of passengers){
                if(!p.title || !p.firstName || !p.lastName || !p.dob || !p.nationality || !p.passportNumber || !p.passportExpiry){
                    showAlert('Please fill in all required fields','error'); return;
                }
                if(new Date(p.dob) >= new Date()){ showAlert('Please enter a valid date of birth','error'); return; }
                if(new Date(p.passportExpiry) <= new Date()){ showAlert('Document must be valid','error'); return; }
            }

            // Validate contact info
            const email = document.getElementById('contactEmail')?.value || '';
            const phone = document.getElementById('contactPhone')?.value || '';
            const emergency = document.getElementById('emergencyContact')?.value || '';
            if(!validateEmail(email)){ showAlert('Please enter a valid email','error'); return; }
            if(!validatePhone(phone)){ showAlert('Please enter a valid phone number','error'); return; }
            if(!validatePhone(emergency)){ showAlert('Please enter a valid emergency contact','error'); return; }

            // Save to localStorage
            window.syncBookingFields();

            // Continue to the seat selection step
            window.location.href = nextStepUrl;
        });
    }
     
    // Remove error on focus
    document.querySelectorAll('.form-input, .form-select').forEach(input=>{
        input.addEventListener('focus', ()=>input.classList.remove('error'));
    });

    // Initialize page
    initBooking();
});