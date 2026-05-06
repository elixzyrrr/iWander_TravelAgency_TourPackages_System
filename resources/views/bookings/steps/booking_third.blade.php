<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - iWander</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Gwendolyn:wght@700&display=swap" rel="stylesheet">
    @vite('resources/css/booking_third.css')
</head>
<body data-booking-type="{{ $bookingType ?? 'flights' }}" data-back-step-url="{{ route('booking.steps.second', ['type' => $bookingType ?? 'flights']) }}" data-complete-url="{{ route('user.bookings.store') }}" data-return-url="{{ route('booking.steps', ['type' => $bookingType ?? 'flights']) }}">
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="logo-section">
            <svg viewBox="0 0 61 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M30.5 0L61 47H0L30.5 0Z" fill="#237f87"/>
                <path d="M30.5 10L50 40H11L30.5 10Z" fill="#1a6269"/>
            </svg>
            <span class="logo-text">iWander</span>
        </div>
        <a href="{{ route('booking.steps.second', ['type' => $bookingType ?? 'flights']) }}" class="back-btn">← Back</a>
    </div>

    <!-- Progress Bar -->
    <div class="progress-bar">
        <div class="progress-container">
            <div class="steps">
                <div class="step completed">
                    <div class="step-circle">✓</div>
                    <div class="step-label">Passenger Details</div>
                </div>
                <div class="step completed">
                    <div class="step-circle">✓</div>
                    <div class="step-label">Seat Selection</div>
                </div>
                <div class="step active">
                    <div class="step-circle">3</div>
                    <div class="step-label">Payment</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Left: Payment Form -->
        <div>
            <div class="payment-card">
                <h1 class="card-title">Payment Details</h1>
                <p class="card-subtitle">Complete your booking with secure payment</p>

                <form id="paymentForm">
                    @csrf
                    <!-- Card Preview -->
                    <div class="card-preview">
                        <div>
                            <div class="card-chip"></div>
                            <div class="card-number" id="previewCardNumber">•••• •••• •••• ••••</div>
                        </div>
                        <div class="card-details">
                            <div class="card-holder">
                                <div class="card-holder-label">CARD HOLDER</div>
                                <div class="card-holder-name" id="previewCardHolder">YOUR NAME</div>
                            </div>
                            <div class="card-expiry">
                                <div class="card-expiry-label">EXPIRES</div>
                                <div class="card-expiry-date" id="previewExpiry">MM/YY</div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Card Information
                        </h3>

                        <div class="form-row full">
                            <div class="form-group">
                                <label class="form-label">Card Number <span class="required">*</span></label>
                                <input type="text" class="form-input" id="cardNumber" maxlength="19" placeholder="1234 5678 9012 3456" required>
                                <span class="error-message" id="cardNumberError"></span>
                            </div>
                        </div>

                        <div class="form-row full">
                            <div class="form-group">
                                <label class="form-label">Cardholder Name <span class="required">*</span></label>
                                <input type="text" class="form-input" id="cardholderName" placeholder="JOHN DOE" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Expiry Date <span class="required">*</span></label>
                                <input type="text" class="form-input" id="expiryDate" maxlength="5" placeholder="MM/YY" required>
                                <span class="error-message" id="expiryError"></span>
                            </div>
                            <div class="form-group">
                                <label class="form-label">CVV <span class="required">*</span></label>
                                <input type="text" class="form-input" id="cvv" maxlength="4" placeholder="123" required>
                                <span class="error-message" id="cvvError"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Billing Address -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Billing Address
                        </h3>

                        <div class="form-row full">
                            <div class="form-group">
                                <label class="form-label">Street Address <span class="required">*</span></label>
                                <input type="text" class="form-input" id="address" placeholder="123 Main Street" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">City <span class="required">*</span></label>
                                <input type="text" class="form-input" id="city" placeholder="Manila" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Postal Code <span class="required">*</span></label>
                                <input type="text" class="form-input" id="postalCode" placeholder="1000" required>
                            </div>
                        </div>

                        <div class="form-row full">
                            <div class="form-group">
                                <label class="form-label">Country <span class="required">*</span></label>
                                <select class="form-select" id="country" required>
                                    <option value="">Select country</option>
                                    <option value="Philippines" selected>Philippines</option>
                                    <option value="United States">United States</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="Japan">Japan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Terms -->
                    <div class="terms">
                        <input type="checkbox" id="termsCheckbox" required>
                        <label for="termsCheckbox">
                            I agree to the <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a>
                        </label>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('booking.steps.second', ['type' => $bookingType ?? 'flights']) }}'">Back</button>
                        <button type="submit" class="btn btn-primary" id="payBtn">Complete Booking</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Summary -->
        <div>
            <div class="summary-card">
                <h2 class="summary-title">Booking Summary</h2>

                <!-- Flight Details -->
                <div class="summary-section">
                    <div class="summary-label">Flight Details</div>
                    <div class="summary-value highlight" id="summaryFlight">Air France - JFK → CDG</div>
                    <div class="summary-value" id="summaryDate" style="font-size: 13px; color: #6b7280; margin-top: 4px;">Date info</div>
                </div>

                <!-- Passengers -->
                <div class="summary-section">
                    <div class="summary-label">Passengers</div>
                    <div id="passengersSummary"></div>
                </div>

                <!-- Seats -->
                <div class="summary-section">
                    <div class="summary-label">Selected Seats</div>
                    <div class="seat-list" id="seatsSummary"></div>
                </div>

                <!-- Price -->
                <div class="summary-section">
                    <div class="price-breakdown">
                        <div class="price-row">
                            <span>Base Fare (<span id="paxCount">1</span> pax)</span>
                            <strong id="baseFare">₱38,000</strong>
                        </div>
                        <div class="price-row" id="upgradeRow" style="display: none;">
                            <span>Seat Upgrades</span>
                            <strong id="upgradeAmount">₱0</strong>
                        </div>
                        <div class="price-row">
                            <span>Taxes & Fees</span>
                            <strong id="taxAmount">₱3,800</strong>
                        </div>
                        <div class="price-row total-row">
                            <span>Total Amount</span>
                            <strong id="totalAmount">₱41,800</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal" id="confirmationModal">
        <div class="modal-content">
            <div class="success-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h2 class="modal-title">Booking Confirmed! 🎉</h2>
            <p class="modal-subtitle">Your flight has been successfully booked</p>
            
            <div class="booking-ref">
                <div class="booking-ref-label">Booking Reference</div>
                <div class="booking-ref-code" id="bookingReference">IW-ABC123</div>
            </div>

            <p class="modal-message">
                A confirmation email has been sent to your registered email address with your e-ticket and booking details.
                Please save your booking reference for future reference.
            </p>

            <button class="modal-btn" onclick="downloadTicket()">Download E-Ticket</button>
            <button class="modal-btn modal-btn-secondary" onclick="goToDashboard()">Book Another Trip</button>
        </div>
    </div>
    @vite('resources/js/booking_third.js')
</body>
</html>