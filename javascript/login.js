function focar() {
    document.getElementById("email_login").focus();
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
 
function validarEmail(entrada) {
    if(!validarNaoVazio(entrada.value)) {
        return false;
    }
    else {
       return true;
    }             
}
 
function validarSenha(entrada) {
    if(!validarNaoVazio(entrada.value)) {
        return false;
    }
    else {
       return true;
    }
}
 
function logar(form) {
    if(!validarEmail(form["email_login"])) {
        form["email_login"].focus();
        alert("O e-mail precisa ser informado.");
        return false;
    }
    else if(!validarSenha(form["senha_login"])) {
        form["senha_login"].focus();
        alert("A senha precisa ser informada.");
        return false;
    }
    else {
        return true; 
    } 
}