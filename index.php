<?php
session_start();
require_once("banco_de_dados.php");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login e Cadastro</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="container">
        <div id="login-form" class="form-container">
            <h1>Login</h1>
            <?php
            // Exibe mensagens de erro do login, se houver
            if (isset($_SESSION['login_error'])) {
                echo '<p class="error-message">' . htmlspecialchars($_SESSION['login_error']) . '</p>';
                unset($_SESSION['login_error']);
            }
            ?>
            <form action="autentica.php" method="POST" id="formLogin">
                <div class="input-group">
                    <label for="login-email">Email:</label>
                    <input type="email" id="login-email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="login-password">Senha:</label>
                    <input type="password" id="login-password" name="senha" required>
                </div>
                <button type="submit">Entrar</button>
            </form>
            <p class="toggle-form">Não tem uma conta? <a href="#" id="show-register">Cadastre-se</a></p>
        </div>

        <div id="register-form" class="form-container" style="display: none;">
            <h1>Cadastro</h1>
            <?php
            // Exibe mensagens de sucesso/erro do cadastro
            if (isset($_SESSION['register_message'])) {
                $message_type = strpos(strtolower($_SESSION['register_message']), 'erro') !== false ? 'error-message' : 'success-message';
                echo '<p class="' . $message_type . '">' . htmlspecialchars($_SESSION['register_message']) . '</p>';
                unset($_SESSION['register_message']);
            }
            ?>
            <form action="cadastro_usuario.php" method="POST" id="formCadastro">
                <div class="input-group">
                    <label for="register-name">Nome:</label>
                    <input type="text" id="register-name" name="nome" required>
                </div>
                <div class="input-group">
                    <label for="register-email">Email:</label>
                    <input type="email" id="register-email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="register-password">Senha:</label>
                    <input type="password" id="register-password" name="senha" required>
                </div>
                <div class="input-group">
                    <label for="register-password-confirm">Confirme a Senha:</label>
                    <input type="password" id="register-password-confirm" name="senha_confirm" required>
                </div>
                <button type="submit">Cadastrar</button>
            </form>
            <p class="toggle-form">Já tem uma conta? <a href="#" id="show-login">Faça Login</a></p>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>