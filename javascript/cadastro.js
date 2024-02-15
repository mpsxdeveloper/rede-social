function focar() {
    document.getElementById("nome_cad").focus();
}
 
function trim(str) {
    return str.replace(/^\s+|\s+$/g,"");
}
 
function validarNaoVazio(valor) {
    valor = trim(valor);
    if(valor == "")
        return false;
    return true; 
}
 
function validarNome(entrada) {
    if(!validarNaoVazio(entrada.value)) {
        return false;
    }
    else {
       return true;
    }             
}
 
function validarSobrenome(entrada) {
    if(!validarNaoVazio(entrada.value)) {
        return false;
    }
    else {
       return true;
    }
}
 
function validarData(d, m, a) {
    var dia = d.value;
    var mes = m.value;
    var ano = a.value;          
    if(isNaN(dia)) {
        alert("Selecione o dia do aniversário.");
        return false;
    }
    if(isNaN(mes)) {
        alert("Selecione o mês do aniversário.");
        return false;
    }
    if(isNaN(ano)) {
        alert("Selecione o ano do aniversário.");
        return false;
    }
    if(mes == '02' && dia > 29) {
        alert("Dia incorreto. Fevereiro possui no máximo 29 dias.");
        return false;
    }
    if(ano % 4 != 0 && mes == '02' && dia == 29) {
        alert(ano + " não é ano bissexto, portanto fevereiro não poderia ter 29 dias.");
        return false;
    }
    if((mes == '04' || mes == '06' || mes == '09' || mes == 11) && dia == 31) {
        alert("Dia incorreto. Abril, junho, setembro e novembro possuem apenas 30 dias.");
        return false;
    }
    else {
        return true;
    } 
}
 
function validarEmail(entrada) {
    var regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var email = entrada.value;    
    if(!validarNaoVazio(email)) {
        alert("O e-mail precisa ser informado.");
        return false;
    }
    else if(!regex.test(email.toLowerCase())) {
        alert("Formato de e-mail incorreto!");
        return false;
    }
    else {
        return true;
    }
}

function validarConfirmaEmail(entrada) {
    var regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var email = entrada.value;    
    if(!validarNaoVazio(email)) {
        alert("O e-mail precisa ser confirmado.");
        return false;
    }
    else if(!regex.test(email.toLowerCase())) {
        alert("Formato de e-mail incorreto!");
        return false;
    }
    else {
        return true;
    }
}
 
function compararEmails(e1, e2) { 
    var email1 = e1.value.toLowerCase();
    var email2 = e2.value.toLowerCase();
    if(email1 != email2) {
        alert("Os e-mail's informados não conferem!");
        return false;   
    }
    else {
        return true;
    }
}
 
function validarSenha(entrada) {
    var regex = /^\w{5,30}$/;
    var min = 5, max = 30;          
    if(!validarNaoVazio(entrada.value)) {
        alert("A senha precisa ser informada!");
        return false;
    }
    else if(!regex.test(entrada.value)) {
        alert("A senha deve conter no mínimo " + min + " e no máximo " + max + " caracteres.");
        return false;
    }
    else {
        return true;
    }
}
 
function cadastrar_usuario(form) {
    if(!validarNome(document.getElementById("nome_cad"))) {
        form["nome_cad"].focus();
        alert("O nome precisa ser informado.");
        return false;
    }
    else if(!validarSobrenome(document.getElementById("sobrenome_cad"))) {
        form["sobrenome_cad"].focus();
        alert("O sobrenome precisa ser informado.");
        return false;
    }
    else if(!validarData(document.getElementById("dia"), document.getElementById("mes"), document.getElementById("ano"))) {
        form["dia"].focus();
        return false;
    }
    else if(!validarEmail(document.getElementById("email_cad"))) {
        form["email_cad"].focus();
        return false;
    }
    else if(!validarConfirmaEmail(document.getElementById("email_confirma_cad"))) {
        form["email_confirma_cad"].focus();
        return false;
    }
    else if(!compararEmails(document.getElementById("email_cad"), document.getElementById("email_confirma_cad"))) {
        form["email_confirma_cad"].focus();
        return false;
    }
    else if(!validarSenha(document.getElementById("senha_cad"))) {
        form["senha_cad"].focus();
        return false;
    }
    else {
        return true;
    }
}
