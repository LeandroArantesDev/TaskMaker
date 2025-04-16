document.getElementById('form-redefinir').addEventListener('submit', function (e) {
    const senha = document.getElementById('senha').value;
    const confirma = document.getElementById('confirmarsenha').value;

    if (senha !== confirma) {
        e.preventDefault();
        alert('As senhas não coincidem!');
    }
});