const form = document.getElementById('form');
const userName = document.getElementById('user');
const inputPassword = document.getElementById('password');
const inputNome = document.getElementById('nome');
const inputCargo = document.getElementById('cargo');
const inputTurno = document.getElementById('turno');
const inputTelefone = document.getElementById('telefone');
const inputConfirmPassword = document.getElementById('confirmPassword');

function checkInputs() {
    const userNameValue = userName.value.trim();
    const passwordValue = inputPassword.value.trim();
    const nomeValue = inputNome.value.trim();
    const cargoValue = inputCargo.value.trim();
    const turnoValue = inputTurno.value.trim();
    const telefoneValue = inputTelefone.value.trim();
    const confirmPasswordValue = inputConfirmPassword.value.trim();

    if (userNameValue === '') {
        setErrorFor(userName, "O campo Usuário não pode estar vazio");
    } else {
        setSuccessFor(userName);
    }

    if (passwordValue === '') {
        setErrorFor(inputPassword, "O campo Senha não pode estar vazio");
    } else if (passwordValue.length < 8) {
        setErrorFor(inputPassword, "A senha deve ter no mínimo 8 digitos");
    } else {
        setSuccessFor(inputPassword);
    }

    if (nomeValue === '') {
        setErrorFor(inputNome, "O campo Nome não pode estar vazio");
    } else {
        setSuccessFor(inputNome);
    }

    if (cargoValue === 'hide') {
        setErrorFor(inputCargo, "É necessario selecionar uma opção");
    } else {
        setSuccessFor(inputCargo);
    }

    if (turnoValue === '') {
        setErrorFor(inputTurno, "O campo Turno não pode estar vazio");
    } else {
        setSuccessFor(inputTurno);
    }

    if (telefoneValue === '') {
        setErrorFor(inputTelefone, "O campo Telefone não pode estar vazio");
    } else if (telefoneValue.toString().length < 9) {
        setErrorFor(inputTelefone, "Informe um número de telefone valido");
    } else {
        setSuccessFor(inputTelefone);
    }

    if (confirmPasswordValue === '') {
        setErrorFor(inputConfirmPassword, "Insira um valor nesse campo");
    } else if (passwordValue != confirmPasswordValue) {
        setErrorFor(inputConfirmPassword, "As senhas não correspondem");
        setErrorFor(inputPassword, " ");
    } else {
        setSuccessFor(inputConfirmPassword);
    }

    if (userNameValue !== '' && passwordValue !== '' && nomeValue !== '' &&
        cargoValue !== 'hide' && turnoValue !== '' && telefoneValue !== '' &&
        confirmPasswordValue !== '' && passwordValue === confirmPasswordValue &&
        passwordValue.length >= 8 && telefoneValue.toString().length === 9) {
        return true;
    } else {
        return false;
    }
}

function setErrorFor(input, menssage) {
    const inputControl = input.parentElement;
    const span = inputControl.querySelector('small');


    span.innerText = menssage;
    if (input === cargo) {
        inputControl.className = 'select error';
    } else {
        inputControl.className = 'input error';
    }

}

function setSuccessFor(input) {
    const inputControl = input.parentElement;

    if (input === cargo) {
        inputControl.className = 'select';
    } else {
        inputControl.className = 'input';
    }
}