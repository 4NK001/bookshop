document.addEventListener("DOMContentLoaded", function() {
    
    // Get the form
    var form = document.querySelector(".contact-form");

    // Get the name field and error span
    var readerName = document.getElementById("name");
    var nameError = document.getElementById("nameError");

    function validateName() {
        var namePattern = /^[a-zA-Z-' ]*$/;
        if (!namePattern.test(readerName.value)) {
            nameError.textContent = "Only letters and white space allowed";
            return false;
        } else {
            nameError.textContent = "";
            return true;
        }
    }

    readerName.addEventListener("blur", validateName);

    // Get the email field and error span
    var email = document.getElementById("email");
    var emailError = document.getElementById("emailError");

    function validateEmail() {
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!emailPattern.test(email.value)) {
            emailError.textContent = "Invalid email format.";
            return false;
        } else {
            emailError.textContent = "";
            return true;
        }
    }

    email.addEventListener("blur", validateEmail);

    // Get the password and confirm password fields and error span
    var password = document.getElementById("password");
    var confPassword = document.getElementById("password1");
    var passwordError = document.getElementById("passwordError");

    function checkPasswordsMatch() {
        if (password.value !== confPassword.value) {
            passwordError.textContent = "Passwords do not match";
            return false;
        } else {
            passwordError.textContent = "";
            return true;
        }
    }

    confPassword.addEventListener("blur", checkPasswordsMatch);

    // Add event listener to the form submit event
    form.addEventListener("submit", function(event) {
        // Validate all fields
        var isNameValid = validateName();
        var isEmailValid = validateEmail();
        var arePasswordsMatching = checkPasswordsMatch();

        // Prevent form submission if any validation fails
        if (!isNameValid || !isEmailValid || !arePasswordsMatching) {
            event.preventDefault();
        }
    });

});
