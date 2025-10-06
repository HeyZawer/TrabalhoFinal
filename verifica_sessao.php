<?php
// verifica_sessao.php

// Inicia a sessão se ainda não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Função para verificar se o usuário está logado
 * Redireciona para o index.php se não houver um usuário na sessão
 */
function verificaLogin() {
    // Verifica se a variável de sessão do usuário existe
    if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['usuario_nome'])) {
        // Se não estiver logado, destrói qualquer sessão e redireciona
        session_unset();
        session_destroy();
        header("Location: index.php?erro=sessao_expirada");
        exit();
    }
}

/**
 * Função para verificar se o usuário é administrador
 * Usa um COOKIE para verificar o status de admin para segurança adicional
 * Redireciona para sem_permissao.php se não for admin
 */
function verificaAdmin() {
    // Certifique-se de chamar verificaLogin() antes se necessário
    verificaLogin();

    // Verifica se o cookie de admin está presente e é 'true'
    // O cookie deve ser definido em autentica.php APÓS um login de admin bem-sucedido
    if (!isset($_COOKIE['admin_status']) || $_COOKIE['admin_status'] !== 'true') {
        header("Location: sem_permissao.php");
        exit();
    }
}

// Em páginas que SÓ precisam de login (ex: dashboard) você só chama verificaLogin().
// Em páginas que SÓ admins podem ver (ex: cadastro_usuario), você chama verificaAdmin().
?>