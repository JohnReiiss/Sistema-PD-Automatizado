function alterarSaudacao() {
    const agora = new Date();
    const hora = agora.getHours();
    const nomeUsuario = document.getElementById("nome-usuario").textContent;
    let saudacao = "";

    if (hora >= 0 && hora < 12) {
        saudacao = "Bom dia, ";
    } else if (hora >= 12 && hora < 18) {
        saudacao = "Boa tarde, ";
    } else {
        saudacao = "Boa noite, ";
    }

    document.getElementById("saudacao").textContent = saudacao + nomeUsuario + "!";
}

window.onload = alterarSaudacao;