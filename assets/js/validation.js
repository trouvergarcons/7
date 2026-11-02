/**
 * ApexCorp Client-side Form Validation & UI Helpers
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Password Visibility Toggle
    const toggleBtns = document.querySelectorAll('.toggle-password-btn');
    toggleBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = btn.getAttribute('data-target');
            const targetInput = document.getElementById(targetId);
            if (!targetInput) return;

            if (targetInput.type === 'password') {
                targetInput.type = 'text';
                btn.innerHTML = '🙈';
                btn.setAttribute('title', 'Hide password');
            } else {
                targetInput.type = 'password';
                btn.innerHTML = '👁️';
                btn.setAttribute('title', 'Show password');
            }
        });
    });

    // 2. Role Selector styling sync
    const roleRadios = document.querySelectorAll('input[name="role"]');
    roleRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            document.querySelectorAll('.role-radio-label').forEach(label => {
                label.classList.remove('selected');
            });
            const parentLabel = radio.closest('.role-radio-label');
            if (parentLabel) {
                parentLabel.classList.add('selected');
            }
        });
    });

    // 3. Registration Form Validation
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', (e) => {
            let isValid = true;

            const fullname = document.getElementById('fullname');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            const phone = document.getElementById('phone');
            const role = document.querySelector('input[name="role"]:checked');

            // Reset errors
            document.querySelectorAll('.field-error').forEach(el => {
                el.style.display = 'none';
                el.textContent = '';
            });

            // Validate Full Name
            if (!fullname.value.trim() || fullname.value.trim().length < 3) {
                showError('fullname_error', 'Full name must be at least 3 characters long.');
                isValid = false;
            }

            // Validate Email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email.value.trim() || !emailRegex.test(email.value.trim())) {
                showError('email_error', 'Please provide a valid corporate email address.');
                isValid = false;
            }

            // Validate Role
            if (!role) {
                showError('role_error', 'Please select either Employee or Admin role.');
                isValid = false;
            }

            // Validate Password
            if (!password.value || password.value.length < 6) {
                showError('password_error', 'Password must contain at least 6 characters.');
                isValid = false;
            }

            // Validate Confirm Password
            if (password.value !== confirmPassword.value) {
                showError('confirm_password_error', 'Passwords do not match. Please verify.');
                isValid = false;
            }

            // Validate Phone
            if (!phone.value.trim()) {
                showError('phone_error', 'Please enter a contact phone number.');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    }

    // 4. Login Form Validation
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            let isValid = true;
            const email = document.getElementById('login_email');
            const password = document.getElementById('login_password');

            // Reset errors
            document.querySelectorAll('.field-error').forEach(el => {
                el.style.display = 'none';
                el.textContent = '';
            });

            if (!email.value.trim()) {
                showError('login_email_error', 'Email address is required.');
                isValid = false;
            }

            if (!password.value) {
                showError('login_password_error', 'Password is required.');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    }

    // Helper to show field error
    function showError(elementId, message) {
        const el = document.getElementById(elementId);
        if (el) {
            el.textContent = message;
            el.style.display = 'block';
        }
    }
});
