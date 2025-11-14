<?php
session_start();
session_unset(); // Remove todas as variáveis da sessão
session_destroy(); // Encerra a sessão completamente

// Redireciona o usuário para a tela de login
header("Location: /zypher/views/LoginFuncionario.php");
exit();
?>