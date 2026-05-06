// Load data
    const bookingDraft = JSON.parse(localStorage.getItem('selectedBookingItem') || localStorage.getItem('selectedFlight') || '{}');
        const passengers = JSON.parse(localStorage.getItem('passengers') || '[]');
        const contactInfo = JSON.parse(localStorage.getItem('contactInfo') || '{}');
        const selectedSeats = JSON.parse(localStorage.getItem('selectedSeats') || '[]');
    const bookingType = document.body?.dataset.bookingType || bookingDraft.bookingType || 'flights';
    const completeUrl = document.body?.dataset.completeUrl || '/user/dashboard/bookings';
    const returnUrl = document.body?.dataset.returnUrl || '/';
    const backStepUrl = document.body?.dataset.backStepUrl || '/bookings/steps/seat-selection';

        // Initialize
        window.onload = function() {
            if ((!bookingDraft.id && !bookingDraft.itemId) || !passengers.length || !selectedSeats.length) {
                window.location.href = backStepUrl;
                return;
            }

            populateSummary();
            setupCardPreview();
        };

        // Populate summary
        function populateSummary() {
            // Flight
            const summaryTitle = bookingDraft.title || (bookingType === 'tours' ? 'Tour Package' : bookingType === 'stays' ? 'Hotel Stay' : 'Flight');
            const summaryOrigin = bookingDraft.origin || bookingDraft.departLocation?.split('(')[0].trim() || 'Selected departure';
            const summaryDestination = bookingDraft.destination || bookingDraft.arriveLocation?.split('(')[0].trim() || 'Selected destination';
            document.getElementById('summaryFlight').textContent = `${summaryTitle} - ${summaryOrigin} → ${summaryDestination}`;
            document.getElementById('summaryDate').textContent = `${bookingDraft.departTime || 'Selected date'} • ${bookingDraft.duration || 'Trip'} • ${bookingDraft.class || bookingType}`;

            // Passengers
            const passengersHTML = passengers.map((p, i) => 
                `<div class="summary-value" style="font-size: 13px; margin-top: 6px;">${i + 1}. ${p.title} ${p.firstName} ${p.lastName}</div>`
            ).join('');
            document.getElementById('passengersSummary').innerHTML = passengersHTML;

            // Seats
            const seatsHTML = selectedSeats.map(s => 
                `<span class="seat-tag">${s.seat}</span>`
            ).join('');
            document.getElementById('seatsSummary').innerHTML = seatsHTML;

            // Price
            const baseFare = bookingDraft.price || 38000;
            const paxCount = passengers.length;
            const subtotal = baseFare * paxCount;
            const upgradeTotal = selectedSeats.reduce((sum, s) => sum + s.priceAdd, 0);
            const taxes = Math.round((subtotal + upgradeTotal) * 0.1);
            const total = subtotal + upgradeTotal + taxes;

            document.getElementById('paxCount').textContent = paxCount;
            document.getElementById('baseFare').textContent = `₱${subtotal.toLocaleString()}`;
            document.getElementById('taxAmount').textContent = `₱${taxes.toLocaleString()}`;
            document.getElementById('totalAmount').textContent = `₱${total.toLocaleString()}`;

            if (upgradeTotal > 0) {
                document.getElementById('upgradeRow').style.display = 'flex';
                document.getElementById('upgradeAmount').textContent = `₱${upgradeTotal.toLocaleString()}`;
            }
        }

        // Card preview setup
        function setupCardPreview() {
            const cardNumberInput = document.getElementById('cardNumber');
            const cardholderInput = document.getElementById('cardholderName');
            const expiryInput = document.getElementById('expiryDate');

            cardNumberInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\s/g, '');
                let formatted = value.match(/.{1,4}/g)?.join(' ') || value;
                e.target.value = formatted;
                
                const preview = formatted || '•••• •••• •••• ••••';
                document.getElementById('previewCardNumber').textContent = preview;
            });

            cardholderInput.addEventListener('input', function(e) {
                const value = e.target.value.toUpperCase();
                e.target.value = value;
                document.getElementById('previewCardHolder').textContent = value || 'YOUR NAME';
            });

            expiryInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length >= 2) {
                    value = value.slice(0, 2) + '/' + value.slice(2, 4);
                }
                e.target.value = value;
                document.getElementById('previewExpiry').textContent = value || 'MM/YY';
            });

            document.getElementById('cvv').addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');
            });
        }

        // Validation
        function validateCardNumber(number) {
            const cleaned = number.replace(/\s/g, '');
            return /^\d{16}$/.test(cleaned);
        }

        function validateExpiry(expiry) {
            if (!/^\d{2}\/\d{2}$/.test(expiry)) return false;
            
            const [month, year] = expiry.split('/').map(Number);
            if (month < 1 || month > 12) return false;
            
            const currentYear = new Date().getFullYear() % 100;
            const currentMonth = new Date().getMonth() + 1;
            
            if (year < currentYear) return false;
            if (year === currentYear && month < currentMonth) return false;
            
            return true;
        }

        function validateCVV(cvv) {
            return /^\d{3,4}$/.test(cvv);
        }

        // Form submit
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Clear errors
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            document.querySelectorAll('.form-input').forEach(el => el.classList.remove('error'));

            // Get values
            const cardNumber = document.getElementById('cardNumber').value;
            const cardholderName = document.getElementById('cardholderName').value;
            const expiryDate = document.getElementById('expiryDate').value;
            const cvv = document.getElementById('cvv').value;
            const termsAccepted = document.getElementById('termsCheckbox').checked;

            let isValid = true;

            // Validate card number
            if (!validateCardNumber(cardNumber)) {
                document.getElementById('cardNumberError').textContent = 'Please enter a valid 16-digit card number';
                document.getElementById('cardNumber').classList.add('error');
                isValid = false;
            }

            // Validate expiry
            if (!validateExpiry(expiryDate)) {
                document.getElementById('expiryError').textContent = 'Please enter a valid expiry date (MM/YY)';
                document.getElementById('expiryDate').classList.add('error');
                isValid = false;
            }

            // Validate CVV
            if (!validateCVV(cvv)) {
                document.getElementById('cvvError').textContent = 'Please enter a valid CVV (3-4 digits)';
                document.getElementById('cvv').classList.add('error');
                isValid = false;
            }

            // Validate cardholder
            if (!cardholderName || cardholderName.length < 3) {
                alert('Please enter cardholder name');
                isValid = false;
            }

            // Validate terms
            if (!termsAccepted) {
                alert('Please accept the terms and conditions');
                isValid = false;
            }

            if (!isValid) return;

            // Process payment (simulate)
            processPayment();
        });

        // Process payment
        function processPayment() {
            const btn = document.getElementById('payBtn');
            btn.textContent = 'Processing...';
            btn.disabled = true;

            const bookingRef = generateBookingReference();

            const paymentInfo = {
                cardNumber: document.getElementById('cardNumber').value.replace(/\d(?=\d{4})/g, '*'),
                cardholderName: document.getElementById('cardholderName').value,
                billingAddress: {
                    street: document.getElementById('address').value,
                    city: document.getElementById('city').value,
                    postalCode: document.getElementById('postalCode').value,
                    country: document.getElementById('country').value
                }
            };

            const csrfToken = document.querySelector('input[name="_token"]')?.value || '';
            const payload = {
                booking_type: bookingType,
                section_key: bookingType,
                item_id: bookingDraft.sourceType === 'dashboard' ? (bookingDraft.sourceId || bookingDraft.itemId || bookingDraft.id || null) : null,
                agent_record_id: bookingDraft.sourceType === 'agent' ? (bookingDraft.sourceId || bookingDraft.itemId || bookingDraft.id || null) : null,
                origin: bookingDraft.origin || null,
                destination: bookingDraft.destination || null,
                start_date: bookingDraft.startDate || null,
                end_date: bookingDraft.endDate || null,
                travelers: passengers.length,
                rooms: bookingType === 'stays' ? 1 : null,
                budget: String(bookingDraft.price || 0),
                notes: JSON.stringify({
                    draft: bookingDraft,
                    passengers,
                    contactInfo,
                    selectedSeats,
                    paymentInfo,
                }),
            };

            fetch(completeUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(payload)
            }).then(async (response) => {
                if (!response.ok) {
                    throw new Error('Booking save failed');
                }

                const result = await response.json();
                localStorage.setItem('paymentInfo', JSON.stringify(paymentInfo));
                localStorage.setItem('bookingReference', result.referenceCode || bookingRef);
                localStorage.setItem('bookingDate', new Date().toISOString());

                document.getElementById('bookingReference').textContent = result.referenceCode || bookingRef;
                document.getElementById('confirmationModal').classList.add('active');

                btn.textContent = 'Complete Booking';
                btn.disabled = false;
            }).catch(() => {
                alert('Unable to save booking. Please try again.');
                btn.textContent = 'Complete Booking';
                btn.disabled = false;
            });
        }

        // Generate booking reference
        function generateBookingReference() {
            const date = new Date();
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const random = Math.random().toString(36).substring(2, 8).toUpperCase();
            return `IW-${year}${month}${day}-${random}`;
        }

        // Download ticket
        function downloadTicket() {
            alert('E-ticket download started!\n\nYour booking details will be downloaded as a PDF file.');
            // In real app, this would generate and download a PDF
        }

        // Go to dashboard
        function goToDashboard() {
        // Clear checkout data
        localStorage.removeItem('selectedFlight');
        localStorage.removeItem('selectedBookingItem');
        localStorage.removeItem('passengers');
        localStorage.removeItem('contactInfo');
        localStorage.removeItem('selectedSeats');

        // Return to the booking flow instead of the dashboard
        window.location.href = returnUrl;
        }

        // Remove error on focus
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.classList.remove('error');
                const errorId = this.id + 'Error';
                const errorEl = document.getElementById(errorId);
                if (errorEl) errorEl.textContent = '';
            });
        });