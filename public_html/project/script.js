const passwordBox = document.getElementById('passwordBox');

passwordBox.addEventListener('click', function() {
    if (passwordBox.type === 'password') {
        passwordBox.type = 'text';
        passwordBox.style.backgroundColor = 'lightgreen';
    } else {
        passwordBox.type = 'password';
        passwordBox.style.backgroundColor = 'lightgray';
    }
});