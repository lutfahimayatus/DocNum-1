const togglePasswordIcons = document.querySelectorAll('.toggle-password-icon');

togglePasswordIcons.forEach(icon => {
    icon.addEventListener('click', function () {
        const targetId = icon.getAttribute('data-target');
        const passwordInput = document.getElementById(targetId);

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    var closeButtons = document.querySelectorAll('.alert .close');
    
    closeButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var alert = this.parentElement;
            alert.classList.add('fade-out');
            setTimeout(function () {
                alert.style.display = 'none';
            }, 500); // Adjust the time in milliseconds (e.g., 500 = 0.5 seconds)
        });
    });
});