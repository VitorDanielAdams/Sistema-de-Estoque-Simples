const form = document.getElementById('form');
const oldPassword = document.getElementById('oldPassword');
const newPassword = document.getElementById('password');
const confirmPassword = document.getElementById('confirmPassword');

function checkInputs() {
    const oldPasswordValue = oldPassword.value.trim();
    const passwordValue = newPassword.value.trim();
    const confirmPasswordValue = confirmPassword.value.trim();


    if (oldPasswordValue === '') {
        setErrorFor(oldPassword, "É necessário preencher o campo com a senha antiga");
    } else {
        setSuccessFor(oldPassword);
    }

    if (passwordValue === '') {
        setErrorFor(newPassword, "É necessário preencher o campo com a nova senha");
    } else if (passwordValue.length < 8) {
        setErrorFor(newPassword, "A nova senha deve ter no mínimo 8 digitos");
    } else {
        setSuccessFor(newPassword);
    }


    if (confirmPasswordValue === '') {
        setErrorFor(confirmPassword, "É necessário preencher o campo de confirmação");
    } else if (passwordValue != confirmPasswordValue) {
        setErrorFor(confirmPassword, "As senhas não correspondem");
        setErrorFor(newPassword, " ");
    } else {
        setSuccessFor(confirmPassword);
    }

    if (oldPasswordValue !== '' && passwordValue !== '' && confirmPasswordValue !== '' &&
        passwordValue === confirmPasswordValue && passwordValue.length >= 8) {
        return true;
    } else {
        return false;
    }
}

function setErrorFor(input, menssage) {
    const inputControl = input.parentElement;
    const span = inputControl.querySelector('small');


    span.innerText = menssage;
    inputControl.className = 'input error';
}

function setSuccessFor(input) {
    const inputControl = input.parentElement;

    inputControl.className = 'input';
}

//--------------------------------------------------------------------------------------------//

// Mostrar senha

var state = false;
var state1 = false;
var state2 = false;

function toggleOld() {
    if (state) {
        document.getElementById("oldPassword").setAttribute("type", "password");
        document.getElementById('show').style.display = "inline-block";
        document.getElementById('hide').style.display = "none";
        state = false;
    } else {
        document.getElementById("oldPassword").setAttribute("type", "text");
        document.getElementById('hide').style.display = "inline-block";
        document.getElementById('show').style.display = "none";
        state = true;
    }
}

function togglePass() {
    if (state1) {
        document.getElementById("password").setAttribute("type", "password");
        document.getElementById('show1').style.display = "inline-block";
        document.getElementById('hide1').style.display = "none";
        state1 = false;
    } else {
        document.getElementById("password").setAttribute("type", "text");
        document.getElementById('hide1').style.display = "inline-block";
        document.getElementById('show1').style.display = "none";
        state1 = true;
    }
}

function toggleConf() {
    if (state2) {
        document.getElementById("confirmPassword").setAttribute("type", "password");
        document.getElementById('show2').style.display = "inline-block";
        document.getElementById('hide2').style.display = "none";
        state2 = false;
    } else {
        document.getElementById("confirmPassword").setAttribute("type", "text");
        document.getElementById('hide2').style.display = "inline-block";
        document.getElementById('show2').style.display = "none";
        state2 = true;
    }
}