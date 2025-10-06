<?php
// logout.php

// Inicia a sessão (necessário para acessá-la)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Limpa todas as variáveis de sessão
$_SESSION = array();

// 2. Remove o cookie de sessão do navegador
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. Destrói a sessão
session_destroy();

// 4. Remove o COOKIE de admin_status (se existir)
if (isset($_COOKIE['admin_status'])) {
    // Define a data de expiração para o passado para remover o cookie
    setcookie('admin_status', '', time() - 3600, "/"); // "/" para garantir que seja removido de todo o site
}

// 5. Redireciona para a página inicial
header("Location: index.php?logout=sucesso");
exit();
?>