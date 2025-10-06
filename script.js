document.addEventListener('DOMContentLoaded', function() {
    const loginFormContainer = document.getElementById('login-form');
    const registerFormContainer = document.getElementById('register-form');
    
    const showRegisterLink = document.getElementById('show-register');
    const showLoginLink = document.getElementById('show-login');

    const formLogin = document.getElementById('formLogin');
    const formCadastro = document.getElementById('formCadastro');

    // Alterna para o formulário de cadastro
    showRegisterLink.addEventListener('click', function(event) {
        event.preventDefault();
        loginFormContainer.style.display = 'none';
        registerFormContainer.style.display = 'block';
    });

    // Alterna para o formulário de login
    showLoginLink.addEventListener('click', function(event) {
        event.preventDefault();
        registerFormContainer.style.display = 'none';
        loginFormContainer.style.display = 'block';
    });

    // Validação Mínima - Campos Obrigatórios para Login
    formLogin.addEventListener('submit', function(event) {
        const email = document.getElementById('login-email').value;
        const senha = document.getElementById('login-password').value;

        if (email.trim() === '' || senha.trim() === '') {
            event.preventDefault();
            alert('Por favor, preencha todos os campos obrigatórios.');
        }
    });

    // Validação para Cadastro (campos obrigatórios e confirmação de senha)
    formCadastro.addEventListener('submit', function(event) {
        const nome = document.getElementById('register-name').value;
        const email = document.getElementById('register-email').value;
        const senha = document.getElementById('register-password').value;
        const senhaConfirm = document.getElementById('register-password-confirm').value;

        // 1. Verifica se todos os campos estão preenchidos
        if (nome.trim() === '' || email.trim() === '' || senha.trim() === '' || senhaConfirm.trim() === '') {
            event.preventDefault();
            alert('Por favor, preencha todos os campos obrigatórios.');
            return; // Para a execução para não mostrar o segundo alerta
        }

        // 2. Verifica se as senhas são iguais
        if (senha !== senhaConfirm) {
            event.preventDefault(); // Impede o envio do formulário
            alert('As senhas não conferem. Por favor, tente novamente.');
        }
    });
});