<?php
session_start();

if (!isset($_SESSION['funcionario_id'])) {
    header('Location: /zypher/views/loginFuncionario.php');
    exit();
}

require_once __DIR__ . '/../controllers/FuncionarioController.php';

$controller = new FuncionarioController();
$conversas = $controller->listarConversas();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suporte ao Usuário - Zypher</title>
    <link rel="stylesheet" href="/zypher/CSS/SuporteUsuario.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar com conversas -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Suporte ao Usuário</h2>
                <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['funcionario_nome']); ?></p>
            </div>
            
            <div class="conversas-lista" id="conversasLista">
                <?php if (empty($conversas)): ?>
                    <div style="padding: 20px; text-align: center; color: #999;">
                        Nenhuma conversa ainda
                    </div>
                <?php else: ?>
                    <?php foreach ($conversas as $conversa): ?>
                        <div class="conversa-item" data-usuario-id="<?php echo $conversa['id_usuario']; ?>">
                            <div class="conversa-header">
                                <span class="conversa-nome">
                                    <?php echo htmlspecialchars($conversa['usuario_nome']); ?>
                                    <?php if ($conversa['nao_lidas'] > 0): ?>
                                        <span class="badge-nao-lida"><?php echo $conversa['nao_lidas']; ?></span>
                                    <?php endif; ?>
                                </span>
                                <span class="conversa-hora">
                                    <?php echo date('H:i', strtotime($conversa['ultima_mensagem'])); ?>
                                </span>
                            </div>
                            <div class="conversa-preview">
                                <?php echo htmlspecialchars(substr($conversa['ultima_msg'], 0, 50)) . '...'; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Área do chat -->
        <div class="chat-area">
            <div id="chatVazio" class="sem-conversa">
                Selecione uma conversa para começar
            </div>

            <div id="chatAtivo" style="display: none; flex-direction: column; flex: 1;">
                <div class="chat-header">
                    <div class="chat-usuario-nome" id="chatUsuarioNome"></div>
                    <div class="chat-usuario-email" id="chatUsuarioEmail"></div>
                </div>

                <div class="mensagens-container" id="mensagensContainer">
                    <div class="loading">Carregando mensagens...</div>
                </div>

                <div class="chat-input-area">
                    <div class="chat-input-container">
                        <input 
                            type="text" 
                            class="chat-input" 
                            id="mensagemInput" 
                            placeholder="Digite sua mensagem..."
                            autocomplete="off"
                        >
                        <button class="btn-enviar" id="btnEnviar">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/suporte.js"></script>
</body>
</html>