document.addEventListener('DOMContentLoaded', () => {

    // Toggle password visibility
    function togglePassword(inputId, closedIconId, openIconId) {
        const passwordInput = document.getElementById(inputId);
        const eyeIconClosed = document.getElementById(closedIconId);
        const eyeIconOpen = document.getElementById(openIconId);

        if (!passwordInput || !eyeIconClosed || !eyeIconOpen) return;

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIconClosed.style.display = 'none';
            eyeIconOpen.style.display = 'block';
        } else {
            passwordInput.type = 'password';
            eyeIconClosed.style.display = 'block';
            eyeIconOpen.style.display = 'none';
        }
    }

    // Expose globally if used with inline onclick
    window.togglePassword = togglePassword;

});