<?php
// Configurações do banco de dados
define('DB_HOST', 'localhost'); // Geralmente 'localhost'
define('DB_NAME', 'banco_de_dados'); 
define('DB_USER', 'root'); // Seu usuário do MySQL
define('DB_PASS', ''); // Sua senha do MySQL

// Opções do PDO para otimizar a conexão e reportar erros
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lança exceções em caso de erros
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Retorna os resultados como arrays associativos
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Desativa a emulação de prepared statements para segurança
];

try {
    // Cria uma nova instância do PDO para conectar ao banco
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    // Em caso de erro na conexão, exibe uma mensagem genérica e encerra o script
    // Em um ambiente de produção, é ideal logar o erro em vez de exibi-lo na tela.
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}