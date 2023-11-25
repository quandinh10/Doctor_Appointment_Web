const form = document.getElementById('form');
const firstname = document.getElementById('firstnameRes');
const lastname = document.getElementById('lastnameRes');
const email = document.getElementById('emailRes');
const password = document.getElementById('passRes');
const passwordRes = document.getElementById('rePassRes');

form.addEventListener('submit', function (e) {
    if (!validateInputs()) {
        e.preventDefault(); 
    }
});

const setError = (element, message) => {
    const inputControl = element.parentElement;
    const errorDisplay = inputControl.querySelector('.error');

    errorDisplay.innerText = message;
    inputControl.classList.add('error');
    inputControl.classList.remove('success')
}

const setSuccess = element => {
    const inputControl = element.parentElement;
    const errorDisplay = inputControl.querySelector('.error');

    errorDisplay.innerText = '';
    inputControl.classList.add('success');
    inputControl.classList.remove('error');
};

const isValidEmail = email => {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}
const isValidFirstname = (firstname) => {
    const regex = /^[a-zA-Z]+$/;
    return regex.test(firstname);
};
const isValidLastname = (lastname) => {
    const regex = /^[a-zA-Z]+$/;
    return regex.test(lastname);
};
const validateInputs = () => {
    const fisrtnameValue = firstname.value.trim();
    const lastnameValue = lastname.value.trim();
    const emailValue = email.value.trim();
    const passwordValue = password.value.trim();
    const passwordResValue = passwordRes.value.trim();
    let validFirstname = false;
    let validLastname = false;
    let validEmail = false;
    let validPass = false;
    let validPassRes = false;

    //check fistname
    if (fisrtnameValue === ''){
        setError(firstname, 'Firstname is required');
    }
    else if (!isValidFirstname(fisrtnameValue)){
        setError(firstname, 'Firstname must include only alphabet');
    }
    else {
        setSuccess(firstname);
        validFirstname = true;
    }

    //check lastname
    if (lastnameValue === ''){
        setError(lastname, 'Lastname is required');
    }
    else if (!isValidFirstname(lastnameValue)){
        setError(lastname, 'Lastname must include only alphabet');
    }
    else {
        setSuccess(lastname);
        validLastname = true;
    }

    if(emailValue === '') {
        setError(email, 'Email is required');
    } else if (!isValidEmail(emailValue)) {
        setError(email, 'Provide a valid email address');
    } else {
        setSuccess(email);
        validEmail = true;
    }

    if(passwordValue === '') {
        setError(password, 'Password is required');
    } else if (passwordValue.length < 8 ) {
        setError(password, 'Password must be at least 8 character.')
    } else {
        setSuccess(password);
        validPass = true;
    }

    if(passwordResValue === '') {
        setError(passwordRes, 'Confirm password is required');
    } else if (passwordResValue !== passwordValue) {
        setError(passwordRes, 'Password does not match');
    } else {
        setSuccess(passwordRes);
        validPassRes = true;
    }

    if (validFirstname == true && validLastname == true && validEmail == true && validPass == true && validPassRes == true) return true;
    return false;

};
