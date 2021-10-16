const form = document.getElementById('form');
const userName = document.getElementById('nome');
const inputEmail = document.getElementById('email');
const inputCep = document.getElementById('cep');
const inputTelefone = document.getElementById('telefone');
const inputCnpj = document.getElementById('cnpj');


function checkInputs() {
    const userNameValue = userName.value.trim();
    const emailValue = inputEmail.value.trim();
    const cepValue = inputCep.value.trim();
    const telefoneValue = inputTelefone.value.trim();
    const cnpjValue = inputCnpj.value.trim();


    if (userNameValue === '') {
        setErrorFor(userName, "O campo Nome não pode estar vazio");
    } else {
        setSuccessFor(userName);
    }

    if (emailValue === '') {
        setErrorFor(inputEmail, "O campo Email não pode estar vazio");
    } else if (!isEmail(emailValue)) {
        setErrorFor(inputEmail, "Insira um email válido");
    } else {
        setSuccessFor(inputEmail);
    }

    if (cepValue === '') {
        setErrorFor(inputCep, "O campo Cep não pode estar vazio");
    } else if (!isCep(cepValue)) {
        setErrorFor(inputCep, "Insira um CEP válido");
    } else {
        setSuccessFor(inputCep);
    }

    if (telefoneValue === '') {
        setErrorFor(inputTelefone, "O campo Telefone não pode estar vazio");
    } else if (telefoneValue.toString().length < 9) {
        setErrorFor(inputTelefone, "Informe um número de telefone válido");
    } else {
        setSuccessFor(inputTelefone);
    }

    if (cnpjValue === '') {
        setErrorFor(inputCnpj, "O campo Cnpj não pode estar vazio");
    } else if (!isCnpj(cnpjValue)) {
        setErrorFor(inputCnpj, "Insira um CNPJ válido");
    } else {
        setSuccessFor(inputCnpj);
    }


    if (userNameValue !== '' && emailValue !== '' && telefoneValue !== '' && cepValue !== '' &&
        isCep(cepValue) && isEmail(emailValue) && isCnpj(cnpjValue) && cnpjValue !== '') {
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

function isEmail(inputEmail) {
    return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(inputEmail);
}

function isCep(inputCep) {
    return /^[0-9]{5}-[0-9]{3}$/.test(inputCep);
}

function isCnpj(inputCnpj) {
    return /^\d{2}.\d{3}.\d{3}\/\d{4}-\d{2}$/.test(inputCnpj);
}