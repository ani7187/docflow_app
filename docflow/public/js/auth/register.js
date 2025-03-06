//pass validation
document.getElementById('password').addEventListener('input', function (e) {
    var passwordInput = e.target.value.trim();
    var passwordError = document.getElementById('password-error');

    var isValid = passwordInput.length >= 8; // Example: Minimum length of 8 characters

    if (!isValid) {
        debugger
        passwordError.textContent = 'Գաղտնաբառը պետք է լինի առնվազն 8 նիշ';
        $(this).css('border-color', 'red');
    } else {
        passwordError.textContent = '';
        $(this).css('border-color', '');
    }
    checkPasswordType(passwordInput);
});

//password strong
var passType = "Weak";
function checkPasswordType(passwordInput) {
    // var passwordInput = e.target.value.trim();
    var passwordStrength = document.getElementById('password-strength');

    var strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{11,}$/;
    var mediumRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/;

    if (passwordInput && strongRegex.test(passwordInput)) {
        passType = 'Strong';
        passwordStrength.textContent = '(Ամուր գաղտնաբառ)';
        passwordStrength.style.color = 'green';
    } else if (passwordInput && mediumRegex.test(passwordInput)) {
        passType = 'Medium';
        passwordStrength.textContent = '(Միջին գաղտնաբառ)';
        passwordStrength.style.color = 'orange';
    } else if(passwordInput) {
        passwordStrength.textContent = '(Թույլ գաղտնաբառ)';
        passwordStrength.style.color = 'red';
    } else {
        passwordStrength.textContent = '';
    }
};

/*//gen strong pass
document.getElementById('generate-password').addEventListener('click', function () {
    document.getElementById('generated-password').innerHTML = generateStrongPassword();
    debugger
});

function generateStrongPassword() {
    var length = 11;
    var strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{11,}$/;
    var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@$!%*?&";
    var password = "";
    for (var i = 0; i < length; i++) {
        var charIndex = Math.floor(Math.random() * charset.length);
        password += charset.charAt(charIndex);
    }
    if (!strongRegex.test(password)) {
        generateStrongPassword()
    }

    return password;
}*/


//email validation
function validateEmail(email) {
    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return pattern.test(email);
}

// alert(document.getElementById('email'));
document.getElementById('email').addEventListener('input', function() {
    const emailError = document.getElementById('emailError');
    const email = this.value;
    if (!validateEmail(email)) {
        emailError.textContent = 'Անվավեր էլ.հասցե';
        $(this).css('border-color', 'red');
    } else {
        emailError.textContent = '';
        $(this).css('border-color', '');
    }
});

document.getElementById('register_form').addEventListener('submit', function (e) {
    if (!checkPassword()) {
        e.preventDefault();
    }
    if (passType !== 'Strong') {
        e.preventDefault();
        var passwordError = document.getElementById('password-error');
        passwordError.textContent = 'Ընտրեք ամուր գաղտնաբառ';
        $(this).css('border-color', 'red');
    }
});

function checkPassword() {
    var password = document.getElementById('password');
    var password_confirmation = document.getElementById('password_confirmation');
    var message = document.getElementById('message');

    if (password.value == password_confirmation.value) {
        $('#password_confirmation').css('border-color', 'green');
        return true;
    } else {
        $('#password_confirmation').css('border-color', 'red');
        message.innerHTML = 'Գաղտնաբառերը չեն համընկնում';
        message.style.color = 'red';
    }
    return false;
}
