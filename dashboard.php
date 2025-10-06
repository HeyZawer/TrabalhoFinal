<?php
// dashboard.php
// 1. INCLUSÃO BÁSICA E VERIFICAÇÃO DE SESSÃO
require_once 'verifica_sessao.php';

// Assumindo que verifica_sessao.php contém verificaLogin() e session_start()
// Se não contiver, adicione:
// session_start();
// verificaLogin(); // Função que garante que o usuário está logado

// Variável para exibir o nome do usuário
$nome_usuario = $_SESSION['usuario_nome'] ?? 'Usuário';

// 2. LÓGICA DE ADMINISTRAÇÃO E COOKIE
// O administrador é validado se o cookie 'admin_status' for 'true'
$is_admin = (isset($_COOKIE['admin_status']) && $_COOKIE['admin_status'] === 'true');

// Variáveis para a listagem de usuários
$usuarios = [];
$show_user_list = false;

// 3. VERIFICAÇÃO DE AÇÃO (Se o usuário clicou no botão para ver a lista)
if (isset($_GET['action']) && $_GET['action'] === 'show_users') {
    
    // Se a ação for solicitada, verifica se o usuário TEM permissão de admin
    if ($is_admin) {
        
        // Inclui a conexão com o banco de dados e executa a busca
        require_once 'banco_de_dados.php';
        
        $sql = "SELECT id, nome, email FROM usuarios"; 
        
        try {
            // Executa a consulta usando o objeto PDO ($pdo)
            $stmt = $pdo->query($sql);
            $usuarios = $stmt->fetchAll();
            $show_user_list = true;
        } catch (PDOException $e) {
            // Em caso de erro na consulta
            echo "<p style='color: red;'>Erro ao buscar usuários: " . $e->getMessage() . "</p>";
        }
        
    } else {
        // Se a ação foi solicitada, mas o usuário NÃO É admin, redireciona
        header('Location: sem_permissao.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="page-container">
    
        <h1>Bem-vindo, <?php echo htmlspecialchars($nome_usuario); ?>!</h1>
        <p>Esta é a sua área restrita.</p>
        <a href="logout.php" class="btn-logout">Sair (Logout)</a>
        
        <hr> 

        <?php if ($is_admin): ?>
            <h2>Painel Administrativo</h2>
            
            <?php if (!$show_user_list): ?>
                <p><a href="dashboard.php?action=show_users">
                    <button>Mostrar Cadastros dos Usuários</button>
                </a></p>
            <?php endif; ?>

            <p><a href="cadastro_usuario.php">PlaceHolder para gerenciar cadastros</a></p>

        <?php endif; ?>

        </div> 

    <script src="js/script.js"></script>
</body>
</html>


<?php if ($show_user_list): ?> 
    
    <h2>Usuários Cadastrados</h2>

    <?php if (!empty($usuarios)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum usuário cadastrado até o momento.</p>
    <?php endif; ?>

<?php endif; ?>
