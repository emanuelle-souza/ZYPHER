<?php
session_start();
require_once __DIR__ . '/../controllers/CarrinhoController.php';

// Redireciona se não estiver logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /zypher/login?msg=precisa-logar");
    exit;
}

// Conexão com o banco
$pdo = new PDO("mysql:host=localhost;dbname=ZYPHER_SNEAKERS;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// SE O PAGAMENTO FOI CONFIRMADO (cartão ou PIX)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar_pagamento'])) {
    try {
        $id_usuario = $_SESSION['usuario_id'];

        // Atualiza o usuário para membro
        $stmt = $pdo->prepare("UPDATE usuario SET membro = 1 WHERE id_usuario = :id");
        $stmt->execute([':id' => $id_usuario]);

        // ATUALIZA A SESSÃO NA HORA (ESSA É A PARTE MAIS IMPORTANTE!)
        $_SESSION['membro'] = true;

        // Resposta JSON para o JavaScript
        header('Content-Type: application/json');
        echo json_encode([
            'sucesso' => true,
            'mensagem' => 'Bem-vindo à Zypher Premium!'
        ]);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode([
            'sucesso' => false,
            'mensagem' => 'Erro no servidor'
        ]);
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
        </div>
    </div>
</header>

<!-- SEÇÃO DE CADASTRO -->
<section class="membro-section">
    <div class="container">
        <div class="membro-texto">
            <h2>Seja um Membro Zypher</h2>
            <p>Aproveite todos os benefícios de ser parte da nossa comunidade exclusiva!<br>
            Receba descontos, tenha acesso antecipado a lançamentos e muito mais.</p>
            <p class="preco">
                Valor de <strong>R$ 339,90</strong> ao ano.<br>
                Acesso à plataforma exclusiva para membros.<br>
                Descontos imperdíveis!
            </p>
        </div>

        <div class="membro-form">
            <h3>Escolha seu Método de Pagamento</h3>

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
                <img src="/zypher/MIDIA/QrCode.png" alt="QR Code PIX" style="width:180px; margin:10px auto; display:block;">
                <p><strong>Chave:</strong> pix@zypher.com.br</p>
                <button class="botao-pagar" onclick="confirmarPagamento('pix')">Confirmar Pagamento PIX</button>
            </div>
        </div>
    </div>
</section>

<!-- MODAL DE SUCESSO -->
<div id="modal-confirmado" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); justify-content:center; align-items:center; z-index:9999;">
    <div style="background:#fff; padding:40px; border-radius:12px; text-align:center; animation: slideIn 0.4s ease-out;">
        <h2 style="color:#28a745; font-size:28px;">Pagamento Confirmado!</h2>
        <p>Parabéns! Você agora é <strong>membro Zypher Premium</strong>!</p>
        <p>Redirecionando para a loja exclusiva em 3 segundos...</p>
    </div>
</div>

<style>
@keyframes slideIn {
    from { transform: translateY(-50px); opacity: 0; }
    to   { transform: translateY(0); opacity: 1; }
}
</style>

<!-- FAQ (mantido igual) -->
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
// Troca entre cartão e PIX
function selecionarMetodo(metodo) {
    document.getElementById('form-cartao').style.display = metodo === 'cartao' ? 'block' : 'none';
    document.getElementById('form-pix').style.display = metodo === 'pix' ? 'block' : 'none';
    document.getElementById('btn-cartao').classList.toggle('ativo', metodo === 'cartao');
    document.getElementById('btn-pix').classList.toggle('ativo', metodo === 'pix');
}

// Formatação dos campos
function formatarCartao(input) {
    input.value = input.value.replace(/\D/g, '').replace(/(\d{4})(?=\d)/g, '$1 ').trim();
}
function formatarValidade(input) {
    input.value = input.value.replace(/\D/g, '').replace(/(\d{2})(\d)/, '$1/$2');
}

// FUNÇÃO PRINCIPAL - confirma pagamento e vira membro
function confirmarPagamento(tipo) {
    const botao = event.target;
    botao.disabled = true;
    botao.textContent = 'Processando...';

    const total = document.getElementById('total').textContent
        .replace('R$ ', '')
        .replace('.', '')
        .replace(',', '.');

    fetch('', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `confirmar_pagamento=1&total=${total}`
    })
    .then(r => r.json())
    .then(data => {
        if (data.sucesso) {
            // Mostra o modal bonitinho
            document.getElementById('modal-confirmado').style.display = 'flex';

            // Depois de 3 segundos vai direto pra home de membro
            setTimeout(() => {
                window.location.href = '/zypher/VIEWS/HomeMembro.php';
            }, 3000);
        } else {
            alert('Erro: ' + (data.mensagem || 'Tente novamente'));
            botao.disabled = false;
            botao.textContent = tipo === 'cartao' ? 'Pagar com Cartão' : 'Confirmar Pagamento PIX';
        }
    })
    .catch(err => {
        console.error(err);
        alert('Falha na comunicação com o servidor');
        botao.disabled = false;
        botao.textContent = tipo === 'cartao' ? 'Pagar com Cartão' : 'Confirmar Pagamento PIX';
    });
}
</script>
</body>
</html>