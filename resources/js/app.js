import './agent_dashboard';

// Future: import other dashboard scripts as needed

function setupLogoutConfirmation() {
	const modal = document.getElementById('logout-modal');
	const confirmBtn = document.getElementById('confirm-logout-btn');
	const logoutForms = document.querySelectorAll('form[action$="/logout"]');

	if (!modal || !confirmBtn || logoutForms.length === 0) {
		return;
	}

	let logoutFormToSubmit = null;

	function openLogoutModal(form) {
		logoutFormToSubmit = form;
		modal.style.display = 'flex';
		modal.classList.add('active');
	}

	function closeLogoutModal() {
		modal.style.display = 'none';
		modal.classList.remove('active');
		logoutFormToSubmit = null;
	}

	window.openLogoutModal = openLogoutModal;
	window.closeLogoutModal = closeLogoutModal;

	logoutForms.forEach((form) => {
		if (form.dataset.logoutBound === '1') {
			return;
		}

		form.dataset.logoutBound = '1';
		form.addEventListener('submit', function (event) {
			event.preventDefault();
			openLogoutModal(form);
		});
	});

	confirmBtn.addEventListener('click', function () {
		if (logoutFormToSubmit) {
			logoutFormToSubmit.submit();
		}
	});

	modal.addEventListener('click', function (event) {
		if (event.target === modal) {
			closeLogoutModal();
		}
	});

	document.addEventListener('keydown', function (event) {
		if (event.key === 'Escape' && modal.style.display === 'flex') {
			closeLogoutModal();
		}
	});
}

// Generic booking handlers and confirmation modal
window.proceedToBooking = function(target){
	// If called from inline onclick without element, try to detect caller
	let href = null;
	if(target && typeof target === 'string') href = target;
	else if(target && target instanceof Event) {
		const el = target.currentTarget || target.target;
		href = el?.getAttribute?.('data-href') || null;
	} else if(window.event && window.event.currentTarget) {
		const el = window.event.currentTarget;
		href = el?.getAttribute?.('data-href') || null;
	}

	// If booking form present, submit it
	const bookingForm = document.getElementById('booking-form');
	if(bookingForm){
		if(confirm('Proceed to booking?')) bookingForm.submit();
		return;
	}

	if(href){
		if(confirm('Proceed to booking?')) window.location.href = href;
		return;
	}

	if(confirm('Proceed to booking?')) {
		// Fallback: go to signup or landing page
		window.location.href = '/signup';
	}
};

window.bookFlight = function(){ window.proceedToBooking(); };

// Ensure a reusable confirmation modal exists for non-blocking UI if needed
document.addEventListener('DOMContentLoaded', function(){
	setupLogoutConfirmation();

	if(!document.getElementById('generic-confirm-modal')){
		const div = document.createElement('div');
		div.id = 'generic-confirm-modal';
		div.className = 'modal-overlay';
		div.style.display = 'none';
		div.innerHTML = `
			<div class="modal" style="max-width:480px; padding:16px;">
				<div class="modal-header"><h3 class="modal-title">Confirm</h3></div>
				<div class="modal-body">Are you sure?</div>
				<div class="modal-footer" style="display:flex; gap:8px; justify-content:flex-end;">
					<button type="button" class="btn-secondary" onclick="document.getElementById('generic-confirm-modal').style.display='none'">Cancel</button>
					<button type="button" class="btn-primary" id="generic-confirm-ok">OK</button>
				</div>
			</div>`;
		document.body.appendChild(div);
	}
});

// Extra bindings to ensure card and booking buttons are clickable
document.addEventListener('DOMContentLoaded', function(){
	// Cards with data-href should navigate when clicked
	document.querySelectorAll('.card[data-href]').forEach(card => {
		card.style.cursor = 'pointer';
		card.addEventListener('click', function(e){
			const href = card.getAttribute('data-href');
			if(href) window.location.href = href;
		});
	});

	// Anchor-like cards: ensure clicks on inner elements bubble to anchor
	document.querySelectorAll('.card a').forEach(a => {
		a.style.cursor = 'pointer';
	});

	// Book buttons: if anchor, follow href; if button, call proceedToBooking
	document.querySelectorAll('.btn-book, .book-btn').forEach(el => {
		if(el.tagName.toLowerCase() === 'a') return; // anchor will follow href
		el.addEventListener('click', function(e){
			const href = el.getAttribute('data-href') || el.getAttribute('href');
			if(href){
				window.location.href = href;
				return;
			}
			// Call generic booking handler
			if(typeof window.proceedToBooking === 'function') window.proceedToBooking(e);
		});
	});
});
