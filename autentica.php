<?php
session_start();
require_once 'banco_de_dados.php';

// Verifica se o método da requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- LÓGICA DE BLOQUEIO TEMPORÁRIO (COOLDOWN) ---
    $tempo_bloqueio = 30; // 30 segundos para testes!
    
    // 1. Verifica se o usuário está em período de bloqueio
    if (isset($_SESSION['block_until']) && $_SESSION['block_until'] > time()) {
        $tempo_restante = $_SESSION['block_until'] - time();
        $minutos = floor($tempo_restante / 60);
        $segundos = $tempo_restante % 60;
        
        $_SESSION['login_error'] = "Conta temporariamente bloqueada. Tente novamente em {$minutos}m e {$segundos}s.";
        header("Location: index.php");
        exit();
    } 

    // 2. Se o tempo de bloqueio expirou, limpa a sessão de bloqueio e reinicia as tentativas
    if (isset($_SESSION['block_until']) && $_SESSION['block_until'] <= time()) {
        unset($_SESSION['block_until']);
        $_SESSION['login_attempts'] = 0; 
    }

    // 3. Inicializa o contador de tentativas se não existir
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }
    
    // 4. BLOQUEIO: Se o limite de 5 tentativas foi atingido, inicia o cooldown
    if ($_SESSION['login_attempts'] >= 5) {
        $_SESSION['block_until'] = time() + $tempo_bloqueio; // Define o bloqueio para 30 segundos
        $_SESSION['login_error'] = "Você excedeu o número de tentativas. Conta bloqueada por 30 segundos.";
        header("Location: index.php");
        exit();
    }
    // --- FIM DA LÓGICA DE BLOQUEIO ---


    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']); // Usa trim() na senha também para segurança

    if (empty($email) || empty($senha)) {
        $_SESSION['login_error'] = "E-mail e senha são obrigatórios.";
        header("Location: index.php");
        exit();
    }

    try {
        // Busca o usuário, incluindo a coluna 'nivel_acesso'
        $sql = "SELECT id, nome, senha, nivel_acesso FROM usuarios WHERE email = ?"; 
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();

        // Verifica se o usuário existe E se a senha está correta
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            
            // --- LOGIN BEM-SUCEDIDO ---
            
            // Limpa as tentativas de login e o estado de bloqueio
            unset($_SESSION['login_attempts']);
            if (isset($_SESSION['block_until'])) {
                unset($_SESSION['block_until']);
            }
            
            session_regenerate_id(true);

            // Armazena dados do usuário na sessão
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            
            // LÓGICA DO COOKIE DE ADMINISTRAÇÃO 
            if ($usuario['nivel_acesso'] === 'admin') {
                // Define o cookie 'admin_status' como 'true' por 1 hora
                setcookie('admin_status', 'true', time() + 3600, "/");
            } else {
                // Caso não seja admin, define como 'false'
                setcookie('admin_status', 'false', time() + 3600, "/");
            }
            
            // Redireciona para a página restrita
            header("Location: dashboard.php");
            exit();

        } else {
            // --- LOGIN FALHOU ---
            
            // Incrementa a tentativa de login (Só chega aqui se não estiver bloqueado)
            $_SESSION['login_attempts']++; 
            $_SESSION['login_error'] = "E-mail ou senha inválidos.";
            header("Location: index.php");
            exit();
        }

    } catch (PDOException $e) {
        $_SESSION['login_error'] = "Ocorreu um erro no servidor. Tente mais tarde.";
        // Em um ambiente de produção, registre o erro detalhado: error_log("Erro na autenticação: " . $e->getMessage());
        header("Location: index.php");
        exit();
    }

} else {
    // Redireciona para a página inicial se o acesso não for via POST
    header("Location: index.php");
    exit();
}