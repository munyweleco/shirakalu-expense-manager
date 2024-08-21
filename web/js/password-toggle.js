document.addEventListener('DOMContentLoaded', function () {
    // Process all password fields with prepend buttons
    document.querySelectorAll('.input-group').forEach(function (inputGroup) {
        const passwordField = inputGroup.querySelector('input[type="password"]');
        const toggleButton = inputGroup.querySelector('.input-group-append .btn'); // Target existing button

        if (passwordField && toggleButton) {
            // Toggle password visibility on button click
            toggleButton.addEventListener('click', function () {
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    toggleButton.innerHTML = '<i class="fa fa-eye-slash"></i>'; // Eye slash icon
                } else {
                    passwordField.type = 'password';
                    toggleButton.innerHTML = '<i class="fa fa-eye"></i>'; // Eye icon
                }
            });
        }
    });
});