const validUCIDs = ["abc123", "xyz456", "test789", "hello1", "world99"];

function validateUCID() {
    event.preventDefault(); // Prevent form submission

    let ucidInput = document.getElementById("ucid").value.trim();
    let resultElement = document.getElementById("result");
    
    // Regular expression pattern: starts with letters, followed by up to three digits
    let pattern = /^[a-zA-Z]+\d{0,3}$/;
    
    if (!pattern.test(ucidInput)) {
        resultElement.textContent = "UCID DOES NOT CONFORM TO VALID FORMAT";
        resultElement.style.color = "red";
    } else if (validUCIDs.includes(ucidInput)) {
        resultElement.textContent = "VALID UCID FORMAT AND UCID FOUND";
        resultElement.style.color = "green";
    } else {
        resultElement.textContent = "VALID UCID FORMAT BUT INVALID UCID";
        resultElement.style.color = "orange";
    }
}
