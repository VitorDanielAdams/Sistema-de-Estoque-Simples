const form = document.getElementById('form');
const inputCod = document.getElementById('codigo');
const inputQTD = document.getElementById('quantidade');

function checkInputs() {
    const codValue = inputCod.value.trim();
    const qtdValue = inputQTD.value.trim();

    if (codValue === '') {
        setErrorFor(inputCod, "O campo Codigo não pode estar vazio");
    } else {
        setSuccessFor(inputCod);
    }

    if (qtdValue === '') {
        setErrorFor(inputQTD, "O campo Quantidade não pode estar vazio");
    } else {
        setSuccessFor(inputQTD);
    }

    if (codValue !== '' && qtdValue !== '') {
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