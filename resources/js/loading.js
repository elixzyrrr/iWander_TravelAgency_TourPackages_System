document.addEventListener('DOMContentLoaded', () => {
    if (!window.location.pathname.includes('loading')) {
        return;
    }

    const urlParams = new URLSearchParams(window.location.search);
    const redirectUrl = urlParams.get('redirect') || '/dashboard';
    const userType = urlParams.get('type') || '';

    if (userType) {
        const loadingText = document.querySelector('.loading-text');

        if (loadingText) {
            loadingText.textContent = `Logging in as ${userType}`;

            const dots = document.createElement('span');
            dots.classList.add('dots');
            dots.id = 'dots';
            loadingText.appendChild(dots);
        }
    }

    let dotCount = 0;
    const intervalId = setInterval(() => {
        const dotsEl = document.getElementById('dots');

        if (!dotsEl) {
            clearInterval(intervalId);
            return;
        }

        dotCount = (dotCount + 1) % 4;
        dotsEl.textContent = '.'.repeat(dotCount);
    }, 500);

    setTimeout(() => {
        window.location.href = redirectUrl;
    }, 3000);
});