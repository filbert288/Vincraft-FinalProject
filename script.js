// LOGIN FORM
const loginForm = document.getElementById("login-form");

if (loginForm) {
    loginForm.addEventListener("submit", function(event){
        event.preventDefault();

        const username = document.getElementById("username").value.trim();
        const pass = document.getElementById("pass").value.trim();

        if (!username) {
            alert("Username must be filled.");
            return;
        }

        if (username.length < 3 || username.length > 30) {
            alert("Username must be between 3 - 30 characters long.");
            return;
        }

        if (!pass) {
            alert("Password must be filled.");
            return;
        }

        if (pass.length < 8) {
            alert("Password must be at least 8 characters long.");
            return;
        }

        this.submit();
    });
}


// REGISTER FORM
const registerForm = document.getElementById("register-form");

if (registerForm) {
    registerForm.addEventListener("submit", function(event){
        event.preventDefault();

        const username = document.getElementById("reg-username").value.trim();
        const email = document.getElementById("reg-email").value.trim();
        const pass = document.getElementById("reg-pass").value.trim();
        const conf_pass = document.getElementById("reg-conf-pass").value.trim();

        if (!username) {
            alert("Username must be filled.");
            return;
        }

        if (username.length < 3 || username.length > 30) {
            alert("Username must be between 3 - 30 characters long.");
            return;
        }

        if (!email) {
            alert("Email must be filled.");
            return;
        }

        if (!email.includes("@") || !email.includes(".")) {
            alert("Please enter a valid email address.");
            return;
        }

        if (
            email.startsWith("@") || email.startsWith(".") ||
            email.endsWith("@") || email.endsWith(".")
        ) {
            alert("Please enter a valid email format.");
            return;
        }

        if (
            email.includes("@@") ||
            email.includes("..") ||
            email.includes("@.") ||
            email.includes(".@")
        ) {
            alert("Please enter a valid email format.");
            return;
        }

        if (!pass) {
            alert("Password must be filled.");
            return;
        }

        if (pass.length < 8) {
            alert("Password must be at least 8 characters long.");
            return;
        }

        if (pass !== conf_pass) {
            alert("Passwords do not match.");
            return;
        }

        this.submit();
    });
}
