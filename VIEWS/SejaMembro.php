<?php
session_start();
require_once __DIR__ . '/../controllers/CarrinhoController.php';

// Redireciona se não estiver logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /zypher/login?msg=precisa-logar");
    exit;
}

// 🔹 Conexão com o banco
$pdo = new PDO("mysql:host=localhost;dbname=ZYPHER_SNEAKERS;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// 🔹 Se o pagamento foi confirmado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar_pagamento'])) {
    try {
        $id_usuario = $_SESSION['usuario_id'];
        $total = (float)($_POST['total'] ?? 0);

        // Atualiza o status do membro na tabela usuario
        $stmt = $pdo->prepare("UPDATE usuario SET membro = 1 WHERE id_usuario = :id_usuario");
        $stmt->execute([':id_usuario' => $id_usuario]);

        // Verifica se a atualização foi bem-sucedida
        if ($stmt->rowCount() > 0) {
            header('Content-Type: application/json');
            echo json_encode(['sucesso' => true, 'mensagem' => 'Bem-vindo à Zypher Premium!']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['sucesso' => false, 'mensagem' => 'Usuário não encontrado']);
        }
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro no servidor: ' . $e->getMessage()]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membro Zypher</title>
    <link rel="stylesheet" href="/zypher/CSS/SejaMembro.css">
</head>
<body>
<header>
    <div class="topo">
        <div class="logo">
            <a href="/zypher/VIEWS/HomeMembro.php">
                <img src="/zypher/MIDIA/LogoDeitado.png" alt="Zypher Sneakers" class="logo-img">
            </a>
        </div>
        <div class="busca">
            <input type="text" placeholder="Buscar...">
            <button>🔍</button>
        </div>
        <div class="icones">
            <a href="/zypher/views/SejaMembro.php"><img src="/zypher/MIDIA/coroa.png" alt="coroa"></a>
            <a href="/zypher/views/CarrinhoCliente.php"><img src="/zypher/MIDIA/carrinho.png" alt="carrinho"></a>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <a href="/zypher/views/PerfilUsuario.php" title="Meu Perfil">
                    <img src="/zypher/MIDIA/perfil.png" alt="perfil">
                </a>
            <?php else: ?>
                <a href="/zypher/views/login.php" title="Entrar">
                    <img src="/zypher/MIDIA/perfil.png" alt="Entrar">
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- SEÇÃO DE CADASTRO -->
<section class="membro-section">
    <div class="container">
        <div class="membro-texto">
            <h2>Seja um Membro Zypher</h2>
            <p>
                Aproveite todos os benefícios de ser parte da nossa comunidade exclusiva!<br>
                Receba descontos, tenha acesso antecipado a lançamentos e muito mais.
            </p>
            <p class="preco">
                Valor de <strong>R$ 339,90</strong> ao ano.<br>
                Acesso à plataforma exclusiva para membros.<br>
                Descontos imperdíveis!
            </p>
        </div>

        <div class="membro-form">
            <h3>💳 Escolha seu Método de Pagamento</h3>

            <div class="metodo">
                <button id="btn-cartao" class="ativo" onclick="selecionarMetodo('cartao')">Cartão</button>
                <button id="btn-pix" onclick="selecionarMetodo('pix')">PIX</button>
            </div>

            <div id="form-cartao" class="form-pagamento">
                <label>Número do cartão</label>
                <input type="text" id="numero-cartao" maxlength="19" placeholder="0000 0000 0000 0000" oninput="formatarCartao(this)">

                <label>Nome no cartão</label>
                <input type="text" id="nome-cartao" placeholder="Como no cartão">

                <div class="duas-colunas">
                    <div>
                        <label>Validade</label>
                        <input type="text" id="validade" maxlength="5" placeholder="MM/AA" oninput="formatarValidade(this)">
                    </div>
                    <div>
                        <label>CVV</label>
                        <input type="text" id="cvv" maxlength="3" placeholder="123">
                    </div>
                </div>

                <div class="resumo">
                    <p><strong>Total: <span id="total">R$ 339,90</span></strong></p>
                </div>

                <button class="botao-pagar" onclick="confirmarPagamento('cartao')">Pagar com Cartão</button>
            </div>

            <div id="form-pix" class="form-pagamento" style="display: none;">
                <p>Escaneie o QR Code ou copie a chave PIX abaixo:</p>
                <img src="/zypher/MIDIA/qrcode-fake.png" alt="QR Code PIX" style="width:180px; margin:10px auto; display:block;">
                <p><strong>Chave:</strong> pix@zypher.com.br</p>
                <button class="botao-pagar" onclick="confirmarPagamento('pix')">Confirmar Pagamento PIX</button>
            </div>
        </div>
    </div>
</section>

<!-- MODAL DE CONFIRMAÇÃO -->
<div id="modal-confirmado" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:9999;">
    <div style="background:#fff; padding:40px; border-radius:10px; text-align:center; animation: slideIn 0.3s ease-out;">
        <h2 style="color:#28a745; font-size:28px; margin:0 0 10px 0;">✅ Pagamento Confirmado!</h2>
        <p style="font-size:16px; color:#333; margin:10px 0;">Parabéns! Você é agora membro da Zypher Sneakers!</p>
        <p style="font-size:14px; color:#666; margin:10px 0;">Você será redirecionado em 2 segundos...</p>
        <button onclick="fecharModal()" style="margin-top:15px; background:#001f3f; color:white; border:none; padding:10px 20px; border-radius:6px; cursor:pointer; font-size:14px;">Voltar à Loja Agora</button>
    </div>
</div>

<style>
@keyframes slideIn {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>


    <!-- FAQ -->
    <section class="faq-section">
        <h2>Perguntas Frequentes</h2>
        <div class="faq">
            <details>
                <summary>O que é ser um Membro Zypher?</summary>
                <p>Ser um Membro Zypher é ter acesso a benefícios exclusivos, lançamentos antecipados e descontos especiais.</p>
            </details>
            <details>
                <summary>Quais são os benefícios exclusivos?</summary>
                <p>Os membros têm direito a promoções, pré-vendas e coleções limitadas antes do público geral.</p>
            </details>
            <details>
                <summary>Como faço para cancelar a assinatura?</summary>
                <p>Você pode cancelar a assinatura a qualquer momento entrando em contato com o suporte Zypher.</p>
            </details>
        </div>
    </section>

    <script>
// Alterna método de pagamento
function selecionarMetodo(metodo) {
    document.getElementById('form-cartao').style.display = metodo === 'cartao' ? 'block' : 'none';
    document.getElementById('form-pix').style.display = metodo === 'pix' ? 'block' : 'none';
    document.getElementById('btn-cartao').classList.toggle('ativo', metodo === 'cartao');
    document.getElementById('btn-pix').classList.toggle('ativo', metodo === 'pix');
}

// Formata campos
function formatarCartao(input) {
    input.value = input.value.replace(/\D/g, '').replace(/(\d{4})(?=\d)/g, '$1 ').trim();
}
function formatarValidade(input) {
    input.value = input.value.replace(/\D/g, '').replace(/(\d{2})(\d)/, '$1/$2');
}

// Confirma o pagamento e atualiza status do membro
function confirmarPagamento(tipo) {
    const totalElement = document.getElementById('total');
    const total = totalElement.textContent.replace('R$ ', '').replace('.', '').replace(',', '.');

    // Desabilita o botão durante o processamento
    event.target.disabled = true;
    event.target.textContent = 'Processando...';

    fetch('', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `confirmar_pagamento=1&total=${total}`
    })
    .then(r => r.json())
    .then(data => {
        if (data.sucesso) {
            // Mostra modal de sucesso
            document.getElementById('modal-confirmado').style.display = 'flex';
            // Aguarda 2 segundos e redireciona
            setTimeout(() => fecharModal(), 2000);
        } else {
            alert('❌ Erro: ' + (data.mensagem || 'Não foi possível processar seu pedido.'));
            event.target.disabled = false;
            event.target.textContent = tipo === 'cartao' ? 'Pagar com Cartão' : 'Confirmar Pagamento PIX';
        }
    })
    .catch(err => {
        console.error(err);
        alert('❌ Falha na comunicação com o servidor.');
        event.target.disabled = false;
        event.target.textContent = tipo === 'cartao' ? 'Pagar com Cartão' : 'Confirmar Pagamento PIX';
    });
}

function fecharModal() {
    window.location.href = '/zypher/VIEWS/HomeCliente.php';
}
</script>
</body>
</html>
