<?php
session_start();
require_once 'banco_de_dados.php'; // Inclui o script de conexão

// Verifica se o método da requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Sanitiza e obtém os dados do formulário
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $senha_confirm = $_POST['senha_confirm'];

    // 2. Validações do servidor
    if (empty($nome) || empty($email) || empty($senha)) {
        $_SESSION['register_message'] = "Erro: Todos os campos são obrigatórios.";
        header("Location: index.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['register_message'] = "Erro: Formato de e-mail inválido.";
        header("Location: index.php");
        exit();
    }

    if ($senha !== $senha_confirm) {
        $_SESSION['register_message'] = "Erro: As senhas não conferem.";
        header("Location: index.php");
        exit();
    }

    // 3. Verifica se o e-mail já existe no banco
    try {
        $sql = "SELECT id FROM usuarios WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $_SESSION['register_message'] = "Erro: Este e-mail já está cadastrado.";
            header("Location: index.php");
            exit();
        }

        // 4. Criptografa a senha (REQUISITO DE SEGURANÇA)
        // O PASSWORD_ARGON2ID é ótimo, mantenha-o!
        $senha_hash = password_hash($senha, PASSWORD_ARGON2ID);

        // 5. Insere o novo usuário no banco usando prepared statements (INCLUSÃO DO nivel_acesso)
        
        // Adiciona 'nivel_acesso' à lista de colunas
        $sql_insert = "INSERT INTO usuarios (nome, email, senha, nivel_acesso) VALUES (?, ?, ?, ?)"; 
        
        $stmt_insert = $pdo->prepare($sql_insert);
        
        // Adiciona o valor 'user' (usuário comum) para o 'nivel_acesso'
        if ($stmt_insert->execute([$nome, $email, $senha_hash, 'user'])) { 
            $_SESSION['register_message'] = "Cadastro realizado com sucesso! Faça o login.";
        } else {
            $_SESSION['register_message'] = "Erro ao realizar o cadastro. Tente novamente.";
        }

    } catch (PDOException $e) {
        // Em produção, logar o erro. Para o usuário, uma mensagem genérica.
        $_SESSION['register_message'] = "Ocorreu um erro no servidor. Tente mais tarde.";
        // error_log("Erro no cadastro: " . $e->getMessage()); // Linha para log de erros
    }

    header("Location: index.php");
    exit();

} else {
    // Redireciona para a página inicial se o acesso não for via POST
    header("Location: index.php");
    exit();
}