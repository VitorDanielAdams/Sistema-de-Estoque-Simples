const form = document.getElementById('form');
const nome = document.getElementById('nome');
const codigo = document.getElementById('codigo');
const price = document.getElementById('price');
const descricao = document.getElementById('description');
const fornecedor = document.getElementById('fornecedor');
const quantidade = document.getElementById('qtd');
const categorias = document.getElementById('categorias');
const list = document.getElementById('categoria');

function checkInputs() {

    const nomeValue = nome.value.trim();
    const codigoValue = codigo.value.trim();
    const priceValue = price.value.trim();
    const descriptionValue = descricao.value.trim();
    const qtdValue = quantidade.value.trim();
    const fornecedorValue = fornecedor.value.trim();
    const categoriasValue = categorias.value.trim();

    if (nomeValue === '') {
        setErrorFor(nome, "Informe um nome válido");
    } else {
        setSuccessFor(nome);
    }

    if (codigoValue === '') {
        setErrorFor(codigo, "Informe um código para o produto");
    } else if (codigoValue.length < 6) {
        setErrorFor(codigo, "O código tem que conter 6 digitos");
    } else {
        setSuccessFor(codigo);
    }

    if (priceValue === '') {
        setErrorFor(price, "Informe um valor válido");
    } else if (!isPrice(priceValue)) {
        setErrorFor(price, "Informe um valor neste formato R$0,00")
    } else {
        setSuccessFor(price);
    }

    if (descriptionValue === '') {
        setErrorFor(descricao, "Este campo não pode estar vázio");
    } else {
        setSuccessFor(descricao);
    }

    if (qtdValue === '') {
        setErrorFor(quantidade, "Informe a quantidade em estoque");
    } else {
        setSuccessFor(quantidade);
    }

    if (fornecedorValue === 'hide') {
        setErrorFor(fornecedor, "Informe o fornecedor do produto");
    } else {
        setSuccessFor(fornecedor);
    }

    if (categoriasValue === '') {
        setErrorFor(categorias, "Preencha este campo");
    } else if (!isCat('categoria', categoriasValue)) {
        setErrorFor(categorias, "Informe uma categoria válida");
    } else {
        setSuccessFor(categorias);
    }

    if (nomeValue !== '' && codigoValue !== '' && priceValue !== '' && isPrice(priceValue) &&
        descriptionValue !== '' && qtdValue !== '' && categoriasValue !== '' &&
        fornecedorValue !== 'hide' && isCat('categoria', categoriasValue) && codigoValue.length >= 6) {
        return true;
    } else {
        return false;
    }
}

function setErrorFor(input, message) {
    const inputControl = input.parentElement;
    const span = inputControl.querySelector('small');

    span.innerText = message;

    if (input === categorias) {
        inputControl.className = 'campo cat error';
    } else {
        inputControl.className = 'campo error';
    }

}

function setSuccessFor(input) {
    const inputControl = input.parentElement;
    const span = inputControl.querySelector('small');

    span.innerText = "";

    if (input === categorias) {
        inputControl.className = 'campo cat';
    } else {
        inputControl.className = 'campo';
    }

}

function isPrice(price) {
    return /^([1-9]\d{0,2}(\,\d{3})*|([0-9]\d*))(\.\d{2})?$/.test(price);
}

function isCat(idDataList, inputValue) {

    var option = document.querySelector("#" + idDataList + " option[value='" + inputValue + "']");

    if (option != null) {
        return true;
    }
    return false;
}