const form = document.getElementById('form');
const userName = document.getElementById('user');
const inputPassword = document.getElementById('password');

function checkInputs() {

    const userNameValue = userName.value.trim();
    const passwordValue = inputPassword.value.trim();

    if (userNameValue === '') {
        setErrorFor(userName, "Informe um usuário válido");
    } else {
        setSuccessFor(userName);
    }

    if (passwordValue === '') {
        setErrorFor(inputPassword, "Informe uma senha válida");
    } else {
        setSuccessFor(inputPassword);
    }

    if (userNameValue !== '' && passwordValue !== '') {
        return true;
    } else {
        return false;
    }

}

function setErrorFor(input, message) {
    const inputControl = input.parentElement;
    const span = inputControl.querySelector('small');

    span.innerText = message;

    inputControl.className = 'input error';
}

function setSuccessFor(input) {
    const inputControl = input.parentElement;

    inputControl.className = 'input';

}

//--------------------------------------------------------------------------------------------//

// Mostrar senha

var state = false;

function toggle() {
    if (state) {
        document.getElementById("password").setAttribute("type", "password");
        document.getElementById('show').style.display = "inline-block";
        document.getElementById('hide').style.display = "none";
        state = false;
    } else {
        document.getElementById("password").setAttribute("type", "text");
        document.getElementById('hide').style.display = "inline-block";
        document.getElementById('show').style.display = "none";
        state = true;
    }
}