<?php
$senha_plana = '123456';
$novo_hash = password_hash($senha_plana, PASSWORD_DEFAULT);

echo "A senha plana que você deve usar no login é: <b>" . $senha_plana . "</b><br>";
echo "O HASH que você deve COPIAR para o banco de dados é: <b>" . $novo_hash . "</b><br>";

// Teste de verificação local (apenas para confirmar)
if (password_verify($senha_plana, $novo_hash)) {
    echo "<p style='color: green;'>✅ Teste de verificação local concluído com sucesso.</p>";
} else {
    echo "<p style='color: red;'>❌ ALERTA: Seu ambiente PHP está com um problema sério na função password_verify.</p>";
}
?>