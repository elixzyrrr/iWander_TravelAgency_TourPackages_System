<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Details - iWander</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Gwendolyn:wght@700&display=swap" rel="stylesheet">
    @vite('resources/css/booking.css')
</head>
<body data-booking-type="{{ $bookingType }}" data-next-step-url="{{ route('booking.steps.second', ['type' => $bookingType]) }}">
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="logo-section">
            <svg viewBox="0 0 61 47" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="color: #237f87;">
                <path d="M6 24L55 6L33 41L28 27L6 24Z" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M28 27L55 6" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="logo-text">iWander</span>
        </div>
        <a href="{{ route('user.dashboard', ['section' => $bookingType === 'tours' ? 'tours' : ($bookingType === 'stays' ? 'stays' : 'flights')]) }}" class="back-btn">← Back</a>
    </div>

    <!-- Progress Bar -->
    <div class="progress-bar">
        <div class="progress-container">
            <div class="steps">
                <div class="step active">
                    <div class="step-circle">1</div>
                    <div class="step-label">Passenger Details</div>
                </div>
                <div class="step">
                    <div class="step-circle">2</div>
                    <div class="step-label">Seat Selection</div>
                </div>
                <div class="step">
                    <div class="step-circle">3</div>
                    <div class="step-label">Payment</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Left: Form -->
        <div>
            <div class="form-card">
                <h1 class="form-title" id="formTitle">Booking Details</h1>
                <p class="form-subtitle" id="formSubtitle">Please provide information for your booking</p>

                <div class="alert" id="alertBox"></div>

                <!-- Form -->
                <form id="passengerForm" method="POST" action="{{ route('user.bookings.store') }}" data-next-step-url="{{ route('booking.steps.second', ['type' => $bookingType]) }}" data-booking-type="{{ $bookingType }}">
                    @csrf
                    <input type="hidden" name="booking_type" value="{{ $bookingType }}">
                    <input type="hidden" name="section_key" id="sectionKey" value="{{ $bookingType === 'tours' ? 'tours' : ($bookingType === 'stays' ? 'stays' : 'flights') }}">
                    <input type="hidden" name="item_id" id="bookingItemId" value="">
                    <input type="hidden" name="agent_record_id" id="bookingAgentRecordId" value="">
                    <input type="hidden" name="origin" id="bookingOrigin" value="">
                    <input type="hidden" name="destination" id="bookingDestination" value="">
                    <input type="hidden" name="start_date" id="bookingStartDate" value="">
                    <input type="hidden" name="end_date" id="bookingEndDate" value="">
                    <input type="hidden" name="travelers" id="bookingTravelers" value="1">
                    <input type="hidden" name="budget" id="bookingBudget" value="">
                    <textarea name="notes" id="bookingNotes" hidden></textarea>
                    <!-- Passengers Container -->
                    <div id="passengersContainer"></div>

                    <!-- Add Passenger Button -->
                    <button type="button" class="add-passenger-btn" onclick="addPassenger()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Another Passenger
                    </button>

                    <!-- Contact Information -->
                    <div style="margin-bottom: 32px;">
                        <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 16px; color: #101828;">Contact Information</h3>
                        
                        <div class="form-row two-col">
                            <div class="form-group">
                                <label class="form-label">Email Address <span class="required">*</span></label>
                                <input type="email" class="form-input" id="contactEmail" required>
                                <span class="error-message" id="emailError"></span>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Phone Number <span class="required">*</span></label>
                                <input type="tel" class="form-input" id="contactPhone" placeholder="+63 912 345 6789" required>
                                <span class="error-message" id="phoneError"></span>
                            </div>
                        </div>

                        <div class="form-row full">
                            <div class="form-group">
                                <label class="form-label">Emergency Contact Number <span class="required">*</span></label>
                                <input type="tel" class="form-input" id="emergencyContact" placeholder="+63 912 999 8888" required>
                            </div>
                        </div>

                        <div class="form-row full">
                            <div class="form-group">
                                <label class="form-label">Special Requests (Optional)</label>
                                <textarea class="form-textarea" id="specialRequests" placeholder="Dietary requirements, wheelchair assistance, etc."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('booking.steps.second', ['type' => $bookingType]) }}'">Back</button>
                        <button type="submit" class="btn btn-primary">Continue to Seat Selection →</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Summary -->
        <div>
            <div class="summary-card">
                <h2 class="summary-title" id="summaryTitle">Booking Summary</h2>
                
                <div class="flight-info">
                    <div class="airline-row">
                        <span class="airline-flag" id="summaryFlag">🇫🇷</span>
                        <div>
                            <div class="airline-name" id="summaryAirline">Air France</div>
                            <div style="font-size: 12px; color: #6b7280;" id="summaryAircraft">Boeing 777</div>
                        </div>
                    </div>

                    <div class="route" id="summaryRoute">
                        <strong>JFK</strong> → <strong>CDG</strong>
                    </div>

                    <div class="time-row">
                        <span style="color: #6b7280;">Departure:</span>
                        <strong id="summaryDepartTime">08:30 AM</strong>
                    </div>
                    <div class="time-row">
                        <span style="color: #6b7280;">Arrival:</span>
                        <strong id="summaryArriveTime">10:00 PM</strong>
                    </div>
                    <div class="time-row">
                        <span style="color: #6b7280;">Duration:</span>
                        <strong id="summaryDuration">7h 30m</strong>
                    </div>
                    <div class="time-row">
                        <span style="color: #6b7280;">Class:</span>
                        <strong id="summaryCabin">Economy</strong>
                    </div>
                </div>

                <div class="price-row">
                    <div>
                        <div class="price-label">Price per person</div>
                        <div style="font-size: 12px; color: #6b7280; margin-top: 4px;">
                            <span id="passengerCount">1</span> passenger(s)
                        </div>
                    </div>
                    <div class="price-value" id="summaryPrice">₱38,000</div>
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/booking.js')
</body>
</html>