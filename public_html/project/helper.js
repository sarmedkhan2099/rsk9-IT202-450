function validateRegister() {
    const username = document.forms["registerForm"]["username"].value;
    const email = document.forms["registerForm"]["email"].value;
    const password = document.forms["registerForm"]["password"].value;
    const confirm = document.forms["registerForm"]["confirm_password"].value;

    if (!username || !email || !password || !confirm) {
        alert("All fields are required.");
        return false;
    }
    if (password !== confirm) {
        alert("Passwords do not match.");
        return false;
    }
    return true;
}
