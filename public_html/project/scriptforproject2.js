const plumbers = [
    { firstName: "Paige", lastName: "Doe", password: "PPP@1", id: "2468", phone: "555-555-5555", email: "Paige@Plumbing.com"},
    { firstName: "John", lastname: "Dru", password: "Plumb!3", id: "1234", phone: "123-456-7890", email: "John@Plumbing.com" },
    { firstName: "Maura", lastName: "Deek", password: "Plumb123", id: "4568", phone: "459-781-4504", email: "Maura@Plumbing.com" },
    { firstName: "Rana", lastName: "Khan", password: "Acura123", id: "5949", phone: "855-565-5566", email: "rsk9@njit.edu" },
    { firstName: "David", lastName: "Matthews", password: "Calcu303", id: "5566", phone: "556-669-2166", email: "David@Plumbing.com"},
    { firstName: "Donny", lastName: "Kat", password: "Math123", id: "3356", phone: "656-959-5629", email: "Donny@Plumbing.com"},
    { firstName: "Matt", lastname: "James", password: "Apple333", id: "4343", phone: "566-562-5965", email: "Matt@Plumbing.com"},
    { firstName: "Aggy", lastName: "John", password: "Aggy3393", id: "5566", phone: "966-595-2666", email: "Aggy@Plumbing.com"},
    { firstName: "Michael", lastName: "Thomas", password: "Mike8889", id: "5599", phone: "858-599-7006", email: "Michael@Plumbing.com"},
    { firstName: "King", lastName: "Vamp", password: "King3333", id: "5656", phone: "111-222-3330", email: "King@Plumbing.com"}
];
function validate() {
    const name = document.getElementById("name").value;
    const password = document.getElementById("password").value;
    const phone = document.getElementById("phone").value;
    const id = document.getElementById("id").value;
    const email = document.getElementById("email").value;
    const emailConfirm = document.getElementById("emailConfirm").checked;

    if (!/^[A-Za-z]+\s[A-Za-z]+$/.test(name)) {
        alert("Please enter a valid first and last name.");
        document.getElementById("name").focus();
        return false;
    }
    if (!/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{1,5}$/.test(password)) {
        alert("Password must contain up to 5 characters, including 1 uppercase letter, 1 numeric, and 1 special character.");
        document.getElementById("password").focus();
        return false;
    }
    if (!/^\d{3}[-\s]?\d{3}[-\s]?\d{4}$/.test(phone)) {
        alert("Please enter a valid 10-digit phone number (with optional dashes/spaces).");
        document.getElementById("phone").focus();
        return false;
    }
    if (!/^\d{4}$/.test(id)) {
        alert("Please enter a 4-digit plumber ID.");
        document.getElementById("id").focus();
        return false;
    }
    if (emailConfirm) {
        document.getElementById("email").disabled = false;
        if (!/^[\w-]+@([\w-]+\.)+[\w-]{2,4}$/.test(email)) {
            alert("Please enter a valid email address.");
            document.getElementById("email").focus();
            return false;
        }
    }
    verify(name, password, id, phone, email);
}
function verify(name, password, id, phone, email) {
    const plumber = plumbers.find(p => 
        p.name === name && 
        p.password === password && 
        p.id === id && 
        p.phone === phone && 
        (!email || p.email === email)
    );

    if (plumber) {
        alert(`Welcome, ${plumber.name}! You have chosen to ${document.getElementById("transaction").value}.`);
    } else {
        alert(`Plumber ${name} not found.`);
    }
}
document.getElementById("submit").addEventListener("click", validate);

document.getElementById("emailConfirm").addEventListener("change", function() {
    const emailField = document.getElementById("email");
    emailField.disabled = !this.checked; 
});
document.getElementById("togglePassword").addEventListener("click", function() {
    const passwordField = document.getElementById("password");
    if (passwordField.type === "password") {
        passwordField.type = "text";
        this.innerText = "Hide";
    } else {
        passwordField.type = "password";
        this.innerText = "Show";
    }
});
