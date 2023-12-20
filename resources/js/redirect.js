document.addEventListener('DOMContentLoaded', function () {
    var loginButton = document.getElementById('loginButton');

    if (loginButton) {
        loginButton.addEventListener('click', function () {
            window.location.href = "{{ url('/login') }}";
        });
    }
});