document.addEventListener('DOMContentLoaded', function () {

    // Toggle password visibility
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIconClosed = document.getElementById('eyeIconClosed');
        const eyeIconOpen = document.getElementById('eyeIconOpen');

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

    // Make togglePassword available globally
    window.togglePassword = togglePassword;

    // Login uses native form submit to preserve Laravel redirects and validation session state.

});