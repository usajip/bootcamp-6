function validateForm(event) {
    event.preventDefault(); // Prevent form submission
    const username = document.getElementById('username').value;
    if (username.length < 5) {
        alert('Username must be at least 5 characters long.');
        return false;
    }

    const password = document.getElementById('password').value;
    if (password.length < 8) {
        alert('Password must be at least 8 characters long.');
        return false;
    }

    alert('Form submitted successfully!');
    return true;
}