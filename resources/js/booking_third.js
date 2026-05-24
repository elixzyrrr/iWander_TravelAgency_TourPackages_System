// Load data
    const bookingDraft = JSON.parse(localStorage.getItem('selectedBookingItem') || localStorage.getItem('selectedFlight') || '{}');
        const passengers = JSON.parse(localStorage.getItem('passengers') || '[]');
        const contactInfo = JSON.parse(localStorage.getItem('contactInfo') || '{}');
        const selectedSeats = JSON.parse(localStorage.getItem('selectedSeats') || '[]');
    const bookingType = document.body?.dataset.bookingType || bookingDraft.bookingType || 'flights';
    const completeUrl = document.body?.dataset.completeUrl || '/user/dashboard/bookings';
    const returnUrl = document.body?.dataset.returnUrl || '/';
    const backStepUrl = document.body?.dataset.backStepUrl || '/bookings/steps/seat-selection';

        const paymentMethodLabels = {
            card: 'Credit / Debit Card',
            online_banking: 'Online Banking',
            gcash: 'GCash',
            maya: 'Maya',
            paypal: 'PayPal',
        };

        // Initialize
        window.onload = function() {
            if ((!bookingDraft.id && !bookingDraft.itemId) || !passengers.length || !selectedSeats.length) {
                window.location.href = backStepUrl;
                return;
            }

            populateSummary();
            setupPaymentMethodSelector();
            setupCardPreview();
        };

        function getSelectedPaymentMethod() {
            return document.querySelector('input[name="paymentMethod"]:checked')?.value || 'card';
        }

        function setupPaymentMethodSelector() {
            const methodOptions = document.querySelectorAll('.payment-method-option');
            const methodRadios = document.querySelectorAll('input[name="paymentMethod"]');
            const sections = {
                card: document.getElementById('cardPaymentFields'),
                online_banking: document.getElementById('onlineBankingFields'),
                gcash: document.getElementById('gcashFields'),
                maya: document.getElementById('mayaFields'),
                paypal: document.getElementById('paypalFields'),
            };

            function applyMethod(method) {
                methodOptions.forEach((option) => {
                    option.classList.toggle('active', option.dataset.methodOption === method);
                });

                Object.entries(sections).forEach(([sectionMethod, section]) => {
                    if (!section) return;
                    if (sectionMethod === method) {
                        section.classList.remove('hidden');
                    } else {
                        section.classList.add('hidden');
                    }
                });
            }

            methodRadios.forEach((radio) => {
                radio.addEventListener('change', function () {
                    applyMethod(this.value);
                });
            });

            applyMethod(getSelectedPaymentMethod());
        }

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

        function isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        function isValidPhilippineMobile(number) {
            return /^09\d{9}$/.test(number);
        }

        function setFieldError(fieldId, errorId, message) {
            const field = document.getElementById(fieldId);
            const error = document.getElementById(errorId);
            if (field) field.classList.add('error');
            if (error) error.textContent = message;
        }

        // Form submit
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Clear errors
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            document.querySelectorAll('.form-input').forEach(el => el.classList.remove('error'));
            document.querySelectorAll('.form-select').forEach(el => el.classList.remove('error'));

            // Get values
            const paymentMethod = getSelectedPaymentMethod();
            const cardNumber = document.getElementById('cardNumber').value;
            const cardholderName = document.getElementById('cardholderName').value;
            const expiryDate = document.getElementById('expiryDate').value;
            const cvv = document.getElementById('cvv').value;
            const bankName = document.getElementById('bankName').value;
            const bankAccountName = document.getElementById('bankAccountName').value;
            const bankReference = document.getElementById('bankReference').value;
            const gcashMobile = document.getElementById('gcashMobile').value.trim();
            const gcashName = document.getElementById('gcashName').value.trim();
            const mayaMobile = document.getElementById('mayaMobile').value.trim();
            const mayaName = document.getElementById('mayaName').value.trim();
            const paypalEmail = document.getElementById('paypalEmail').value.trim();
            const termsAccepted = document.getElementById('termsCheckbox').checked;

            let isValid = true;

            if (paymentMethod === 'card') {
                if (!validateCardNumber(cardNumber)) {
                    setFieldError('cardNumber', 'cardNumberError', 'Please enter a valid 16-digit card number');
                    isValid = false;
                }

                if (!validateExpiry(expiryDate)) {
                    setFieldError('expiryDate', 'expiryError', 'Please enter a valid expiry date (MM/YY)');
                    isValid = false;
                }

                if (!validateCVV(cvv)) {
                    setFieldError('cvv', 'cvvError', 'Please enter a valid CVV (3-4 digits)');
                    isValid = false;
                }

                if (!cardholderName || cardholderName.length < 3) {
                    alert('Please enter cardholder name');
                    isValid = false;
                }
            } else if (paymentMethod === 'online_banking') {
                if (!bankName) {
                    setFieldError('bankName', 'bankNameError', 'Please select your bank');
                    isValid = false;
                }
                if (!bankAccountName || bankAccountName.length < 3) {
                    setFieldError('bankAccountName', 'bankAccountNameError', 'Please enter the account name');
                    isValid = false;
                }
                if (!bankReference || bankReference.length < 6) {
                    setFieldError('bankReference', 'bankReferenceError', 'Enter a valid transaction reference');
                    isValid = false;
                }
            } else if (paymentMethod === 'gcash') {
                if (!isValidPhilippineMobile(gcashMobile)) {
                    setFieldError('gcashMobile', 'gcashMobileError', 'Use 11-digit PH mobile format (09XXXXXXXXX)');
                    isValid = false;
                }
                if (!gcashName || gcashName.length < 3) {
                    setFieldError('gcashName', 'gcashNameError', 'Please enter account name');
                    isValid = false;
                }
            } else if (paymentMethod === 'maya') {
                if (!isValidPhilippineMobile(mayaMobile)) {
                    setFieldError('mayaMobile', 'mayaMobileError', 'Use 11-digit PH mobile format (09XXXXXXXXX)');
                    isValid = false;
                }
                if (!mayaName || mayaName.length < 3) {
                    setFieldError('mayaName', 'mayaNameError', 'Please enter account name');
                    isValid = false;
                }
            } else if (paymentMethod === 'paypal') {
                if (!isValidEmail(paypalEmail)) {
                    setFieldError('paypalEmail', 'paypalEmailError', 'Please enter a valid PayPal email');
                    isValid = false;
                }
            }

            // Validate terms
            if (!termsAccepted) {
                alert('Please accept the terms and conditions');
                isValid = false;
            }

            if (!isValid) return;

            // Process payment
            processPayment(paymentMethod);
        });

        function showProcessingModal() {
            document.getElementById('processingModal')?.classList.add('active');
        }

        function hideProcessingModal() {
            document.getElementById('processingModal')?.classList.remove('active');
        }

        // Process payment
        function processPayment(selectedPaymentMethod) {
            const btn = document.getElementById('payBtn');
            btn.textContent = 'Processing...';
            btn.disabled = true;
            showProcessingModal();

            const bookingRef = generateBookingReference();

            const paymentInfo = {
                method: selectedPaymentMethod,
                methodLabel: paymentMethodLabels[selectedPaymentMethod] || selectedPaymentMethod,
                cardNumber: selectedPaymentMethod === 'card' ? document.getElementById('cardNumber').value.replace(/\d(?=\d{4})/g, '*') : null,
                cardholderName: selectedPaymentMethod === 'card' ? document.getElementById('cardholderName').value : null,
                onlineBanking: selectedPaymentMethod === 'online_banking' ? {
                    bankName: document.getElementById('bankName').value,
                    accountName: document.getElementById('bankAccountName').value,
                    reference: document.getElementById('bankReference').value,
                } : null,
                eWallet: selectedPaymentMethod === 'gcash' || selectedPaymentMethod === 'maya' ? {
                    provider: selectedPaymentMethod,
                    mobile: selectedPaymentMethod === 'gcash' ? document.getElementById('gcashMobile').value : document.getElementById('mayaMobile').value,
                    accountName: selectedPaymentMethod === 'gcash' ? document.getElementById('gcashName').value : document.getElementById('mayaName').value,
                } : null,
                paypal: selectedPaymentMethod === 'paypal' ? {
                    email: document.getElementById('paypalEmail').value,
                } : null,
                billingAddress: {
                    street: document.getElementById('address').value,
                    city: document.getElementById('city').value,
                    postalCode: document.getElementById('postalCode').value,
                    country: document.getElementById('country').value
                }
            };

            const csrfToken = document.querySelector('input[name="_token"]')?.value || '';
            const bookingSourceId = bookingDraft.sourceId || bookingDraft.itemId || bookingDraft.id || bookingDraft.agentRecordId || bookingDraft.agent_record_id || null;
            const bookingSourceType = bookingDraft.sourceType || (bookingDraft.agentRecordId || bookingDraft.agent_record_id ? 'agent' : 'dashboard');

            const payload = {
                booking_type: bookingType,
                section_key: bookingType,
                item_id: bookingSourceType === 'agent' ? null : bookingSourceId,
                agent_record_id: bookingSourceType === 'agent' ? bookingSourceId : null,
                origin: bookingDraft.origin || null,
                destination: bookingDraft.destination || null,
                start_date: bookingDraft.startDate || null,
                end_date: bookingDraft.endDate || null,
                travelers: passengers.length,
                rooms: bookingType === 'stays' ? 1 : null,
                budget: String(bookingDraft.price || 0),
                notes: JSON.stringify({
                    bookingSnapshot: {
                        title: bookingDraft.title || null,
                        origin: bookingDraft.origin || null,
                        destination: bookingDraft.destination || null,
                    },
                    passengers: passengers.map((p) => ({
                        title: p.title,
                        firstName: p.firstName,
                        lastName: p.lastName,
                    })),
                    contactInfo: {
                        email: contactInfo.email || null,
                        phone: contactInfo.phone || null,
                    },
                    selectedSeats: selectedSeats.map((seat) => seat.seat),
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
                    let message = 'Booking save failed';
                    try {
                        const errorBody = await response.json();
                        message = errorBody.message || errorBody.error || message;
                        if (errorBody.errors) {
                            const firstField = Object.values(errorBody.errors)[0];
                            if (Array.isArray(firstField) && firstField.length) {
                                message = firstField[0];
                            }
                        }
                    } catch {
                        try {
                            const errorText = await response.text();
                            if (errorText) message = errorText;
                        } catch {
                            // keep fallback message
                        }
                    }
                    throw new Error(message);
                }

                const result = await response.json();
                localStorage.setItem('paymentInfo', JSON.stringify(paymentInfo));
                localStorage.setItem('bookingReference', result.referenceCode || bookingRef);
                localStorage.setItem('bookingDate', new Date().toISOString());

                document.getElementById('bookingReference').textContent = result.referenceCode || bookingRef;
                document.getElementById('invoiceReference').textContent = result.referenceCode || bookingRef;
                document.getElementById('receiptTrip').textContent = document.getElementById('summaryFlight')?.textContent || 'Booking';
                document.getElementById('receiptPassengers').textContent = String(passengers.length);
                document.getElementById('receiptSeats').textContent = selectedSeats.length ? selectedSeats.map((seat) => seat.seat).join(', ') : 'No seats selected';
                document.getElementById('receiptPaymentMethod').textContent = paymentInfo.methodLabel;
                document.getElementById('receiptTotal').textContent = document.getElementById('totalAmount')?.textContent || '₱0';
                hideProcessingModal();
                document.getElementById('confirmationModal').classList.add('active');

                btn.textContent = 'Complete Booking';
                btn.disabled = false;
            }).catch((error) => {
                hideProcessingModal();
                alert(error?.message ? `Unable to save booking. ${error.message}` : 'Unable to save booking. Please try again.');
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

        function closeConfirmationModal() {
            document.getElementById('confirmationModal')?.classList.remove('active');
        }

        // Download ticket
        window.downloadTicket = function downloadTicket() {
            const bookingReference = document.getElementById('bookingReference')?.textContent || generateBookingReference();
            const totalAmount = document.getElementById('totalAmount')?.textContent || '';
            const summaryFlight = document.getElementById('summaryFlight')?.textContent || 'Booking';
            const passengerSummary = Array.from(document.querySelectorAll('#passengersSummary .summary-value'))
                .map((el) => el.textContent.trim())
                .join('\n');

            const ticketContent = [
                'iWander E-Ticket',
                `Reference: ${bookingReference}`,
                `Trip: ${summaryFlight}`,
                `Total: ${totalAmount}`,
                '',
                'Passengers:',
                passengerSummary || 'No passenger details found.',
            ].join('\n');

            const blob = new Blob([ticketContent], { type: 'text/plain;charset=utf-8' });
            const downloadUrl = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = downloadUrl;
            link.download = `${bookingReference}.txt`;
            document.body.appendChild(link);
            link.click();
            link.remove();

            window.setTimeout(() => URL.revokeObjectURL(downloadUrl), 1000);
        };

        // Go to dashboard
        window.goToDashboard = function goToDashboard() {
            closeConfirmationModal();
            // Clear checkout data
            localStorage.removeItem('selectedFlight');
            localStorage.removeItem('selectedBookingItem');
            localStorage.removeItem('passengers');
            localStorage.removeItem('contactInfo');
            localStorage.removeItem('selectedSeats');
            localStorage.removeItem('paymentInfo');
            localStorage.removeItem('bookingReference');
            localStorage.removeItem('bookingDate');

            window.location.href = '/user/dashboard';
        };

        // Remove error on focus
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.classList.remove('error');
                const errorId = this.id + 'Error';
                const errorEl = document.getElementById(errorId);
                if (errorEl) errorEl.textContent = '';
            });
        });