const form = document.getElementById('form');
const userName = document.getElementById('user');
const inputNome = document.getElementById('nome');
const inputCargo = document.getElementById('cargo');
const inputTurno = document.getElementById('turno');
const inputTelefone = document.getElementById('telefone');

function checkInputs() {
    const userNameValue = userName.value.trim();
    const nomeValue = inputNome.value.trim();
    const cargoValue = inputCargo.value.trim();
    const turnoValue = inputTurno.value.trim();
    const telefoneValue = inputTelefone.value.trim();

    if (userNameValue === '') {
        setErrorFor(userName, "O campo Usuário não pode estar vazio");
    } else {
        setSuccessFor(userName);
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


    if (userNameValue !== '' && nomeValue !== '' && turnoValue !== '' && telefoneValue !== '') {
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