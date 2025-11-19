<?php
session_start();

// ========================================
// BUSCA RESPOSTAS DO SUPORTE PARA O USUÁRIO LOGADO
// ========================================
$respostas = [];
if (isset($_SESSION['usuario_id'])) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=ZYPHER_SNEAKERS;charset=utf8mb4", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("
            SELECT fc.assunto, fc.mensagem, fc.resposta, fc.data_resposta, f.nome AS nome_funcionario
            FROM fale_conosco fc
            LEFT JOIN funcionario f ON fc.id_funcionario = f.id_funcionario
            WHERE fc.id_usuario = ? 
            AND fc.status = 'respondida' 
            AND fc.resposta IS NOT NULL
            ORDER BY fc.data_resposta DESC
        ");
        $stmt->execute([$_SESSION['usuario_id']]);
        $respostas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // Silencioso – não quebra a página se der erro
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fale Conosco - Zypher Sneakers</title>
    <link rel="stylesheet" href="/zypher/CSS/FaleConosco.css">
    <link rel="stylesheet" href="/zypher/CSS/FaleConoscoNotificacao.css"> <!-- NOVO CSS -->
</head>
<body>

    <!-- HEADER -->
    <header>
        <div class="topo">
            <div class="logo">
                <a href="<?php echo (isset($_SESSION['membro']) && $_SESSION['membro']) ? '/zypher/VIEWS/HomeMembro.php' : '/zypher/VIEWS/HomeCliente.php'; ?>">
                    <img src="/zypher/MIDIA/LogoDeitado.png" alt="Zypher Sneakers" class="logo-img">
                </a>
            </div>
            <div class="busca">
                <button type="button"><img src="/zypher/MIDIA/Lupa.png" alt="Buscar"></button>
                <input type="text" placeholder="Buscar tênis...">
            </div>
            <div class="icones">
                <a href="/zypher/views/SejaMembro.php"><img src="/zypher/MIDIA/coroa.png" alt="coroa"></a>
                <a href="/zypher/views/Carrinho.php"><img src="/zypher/MIDIA/carrinho.png" alt="carrinho"></a>

                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <a href="/zypher/views/PerfilUsuario.php" title="Meu Perfil">
                        <img src="/zypher/MIDIA/perfil.png" alt="perfil">
                    </a>
                <?php else: ?>
                    <a href="/zypher/views/login.php" title="Entrar">
                        <img src="/zypher/MIDIA/perfil.png" alt="Entrar">
                    </a>
                <?php endif; ?>
                    <?php if (!empty($respostas)): ?>
                        <div class="notificacao-suporte" id="sininho-suporte" onclick="abrirModal()">
                        <img src="/zypher/MIDIA/notificacao.png" alt="Notificações">
                         <span class="badge"><?= count($respostas) ?></span>
                        </div>
                    <?php endif; ?>
            </div>
        </div>

        <nav class="menu">
            <a href="/zypher/views/Feminino.php">Feminino</a>
            <a href="/zypher/views/Masculino.php">Masculino</a>
            <a href="/zypher/views/Explorar.php">Explorar</a>
            <a href="/zypher/views/QuemSomos.php">Sobre nós</a>
        </nav>
    </header>

    <!-- SEÇÃO FALE CONOSCO (igualzinha ao que você já tem) -->
    <section class="fale-conosco-section">
        <div class="icon-mensagem">
            <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                <circle cx="30" cy="30" r="30" fill="#1E3A5F"/>
                <rect x="18" y="22" width="24" height="16" rx="2" stroke="white" stroke-width="2" fill="none"/>
                <path d="M18 24L30 32L42 24" stroke="white" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>
        
        <h1>Fale Conosco</h1>
        <p class="subtitle">Tem alguma dúvida ou sugestão? Estamos aqui para ajudar!</p>

        <div class="content-wrapper">
            <!-- Formulário (igual ao seu) -->
            <div class="form-container">
                <h2>Envie sua Mensagem</h2>
                
                <form class="contact-form" action="/zypher/controllers/FaleConosco.php" method="POST">
                    <input type="hidden" name="action" value="saveMensagem">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nome">Nome Completo *</label>
                            <input type="text" id="nome" name="nome" placeholder="Insira seu nome completo" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" placeholder="email@gmail.com" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="assunto">Assunto *</label>
                        <input type="text" id="assunto" name="assunto" placeholder="Sobre o que você quer falar?" required>
                    </div>
                    <div class="form-group">
                        <label for="mensagem">Mensagem *</label>
                        <textarea id="mensagem" name="mensagem" placeholder="Escreva sua mensagem aqui..." required></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Enviar Mensagem</button>
                </form>
            </div>

             <!-- Informações de Contato -->
            <div class="info-container">
                <div class="contact-info-box">
                    <h3>Outras Formas de Contato</h3>
                   
                    <div class="contact-item">
                        <div class="contact-icon">✉</div>
                        <div>
                            <strong>Email</strong>
                            <p>contato@zyphersneakers.com</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">💬</div>
                        <div>
                            <strong>WhatsApp</strong>
                            <p>(11) 96664-9999</p>
                        </div>
                    </div>
                </div>

                <div class="horario-box">
                    <h3>Horário de Atendimento</h3>
                    <div class="horario-item"><span>Segunda à Sexta</span><strong>9h - 18h</strong></div>
                    <div class="horario-item"><span>Sábado</span><strong>9h - 14h</strong></div>
                    <div class="horario-item"><span>Domingo</span><strong>Fechado</strong></div>
                </div>

                <div class="resposta-rapida">
                    <strong>Resposta Rápida:</strong> Nossa equipe geralmente responde em até 24 horas úteis.
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER (igual ao seu) -->
    <footer>
        <a href="/zypher/VIEWS/Politicas.php">Política de Privacidade</a> | 
        <a href="/zypher/VIEWS/Termos.php">Termos de Uso</a> | 
        <a href="/zypher/VIEWS/FaleConosco.php">Fale conosco</a>
        <p>&copy; 2025 Zypher Sneakers. Todos os direitos reservados.</p>
    </footer>

    <!-- MODAL DE RESPOSTAS + SCRIPT -->
    <?php if (!empty($respostas)): ?>
    <div id="modalRespostas" class="modal-suporte">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Respostas do Suporte</h3>
                <span class="close" onclick="document.getElementById('modalRespostas').style.display='none'">&times;</span>
            </div>
            <div class="modal-body">
                <?php foreach ($respostas as $r): ?>
                    <div class="resposta-card">
                        <strong><?= htmlspecialchars($r['assunto']) ?></strong>
                        <p class="sua-mensagem"><strong>Você:</strong> <?= nl2br(htmlspecialchars(substr($r['mensagem'], 0, 150))) ?><?= strlen($r['mensagem']) > 150 ? '...' : '' ?></p>
                        <div class="resposta-suporte">
                            <p><strong>Resposta do suporte (<?= htmlspecialchars($r['nome_funcionario'] ?? 'Equipe Zypher') ?>):</strong></p>
                            <?= nl2br(htmlspecialchars($r['resposta'])) ?>
                            <small>Em <?= date('d/m/Y às H:i', strtotime($r['data_resposta'])) ?></small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="modal-footer">
                <button onclick="document.getElementById('modalRespostas').style.display='none'">Fechar</button>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script>
const ULTIMA_RESPOSTA_TIMESTAMP = <?= !empty($respostas) ? strtotime($respostas[0]['data_resposta']) : 0 ?>; // timestamp da resposta mais recente
const CHAVE_STORAGE = 'ultima_resposta_vista_<?= $_SESSION['usuario_id'] ?>';

function abrirModal() {
    document.getElementById('modalRespostas').style.display = 'block';

    // Atualiza a última resposta que o cliente viu
    localStorage.setItem(CHAVE_STORAGE, ULTIMA_RESPOSTA_TIMESTAMP);

    // Remove o sininho da tela
    const sininho = document.getElementById('sininho-suporte');
    if (sininho) sininho.remove();
}

// Quando carrega a página: verifica se a resposta mais recente é mais nova que a última vista
window.addEventListener('load', function() {
    const ultimaVista = localStorage.getItem(CHAVE_STORAGE);
    
    // Se tem resposta nova (mais recente que a última vista), mantém o sininho
    // Se não tem resposta nova → remove o sininho
    if (ultimaVista && ULTIMA_RESPOSTA_TIMESTAMP <= ultimaVista) {
        const sininho = document.getElementById('sininho-suporte');
        if (sininho) sininho.remove();
    }
});
    </script>
</body>
</html>