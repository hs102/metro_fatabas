let validEmail = false;
let validPassword = false;
let confirmed = false;

function validateForm(mode) {
    if (mode !== "profile") {
        validateEmail(true);
    } else
        validEmail = true;

    validatePassword();
    //console.log(validEmail, validPassword, confirmed);
    document.getElementById("submit").disabled = !(validEmail && validPassword && confirmed);
}

function validateEmail(register) {
    let email = document.getElementById("email").value;

    if (!email) {
        document.getElementById("submit").disabled = true;
            invalid("Email cannot be empty")
        return;
    }

    let emailRegex = /^\S+@\S+\.\S+$/;
    if (!emailRegex.test(email)) {
        document.getElementById("submit").disabled = true;
        return invalid("Not a valid email");
    }
    

    if(register) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "controllers/validate.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("email=" + email);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText.trim() == "true") {;
                    document.getElementById("submit").disabled = true;
                    return invalid("Email already exists");
                } else {
                    document.getElementById("submit").disabled = false;
                    return valid();
                }
            }
        };
    }

    function invalid(msg) {
        document.querySelector("label" + "[for='email']").innerHTML = "Email: <small>"+msg+"</small>";
        document.getElementById("email").classList.remove("valid");
        document.getElementById("email").classList.add("invalid");
        validEmail = false;
    }

    function valid() {
        document.querySelector("label" + "[for='email']").innerHTML = "Email:";
        document.getElementById("email").classList.remove("invalid");
        document.getElementById("email").classList.add("valid");
        validEmail = true;
    }


}

function validatePassword() {
    let ul = document.getElementById("passwordRules");
    let password = document.getElementById("password").value;
    let length = document.getElementById("length");
    let upper = document.getElementById("upper");
    let lower = document.getElementById("lower");
    let number = document.getElementById("number");
    let special = document.getElementById("special");

    let rules = [[length, /^.{8,}$/], [upper, /[A-Z]/], [lower, /[a-z]/], [number, /[0-9]/], [special, /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/]];

    let applied = 0;
    for (let rule of rules) {
        if (rule[1].test(password)) {
            rule[0].style.display = "none";
            applied++;
        } else {
            rule[0].style.display = "list-item";
        }
    }
    validPassword = applied === rules.length;
    if (validPassword) {
        ul.style.display = "none";
        document.getElementById("submit").disabled = true;

    } else {
        ul.style.display = "block";
        document.getElementById("submit").disabled = false;
    }
}


function show() {
    let password = document.getElementById("password");
    let confirm = document.getElementById("confirmPassword");
    if (password.type === "password") {
        password.type = "text";
        confirm.type = "text";
    } else {
        password.type = "password";
        confirm.type = "password";
    }
}