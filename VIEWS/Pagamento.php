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

// 🔹 Sempre inicializa as variáveis
$itens = [];
$total = 0;

// 🔹 Busca os itens do carrinho do usuário
$itens = CarrinhoController::listarCarrinho($_SESSION['usuario_id']);
if (is_array($itens)) {
    foreach ($itens as $item) {
        $preco = isset($item['preco']) ? (float)$item['preco'] : 0;
        $quantidade = isset($item['quantidade']) ? (int)$item['quantidade'] : 1;
        $total += $preco * $quantidade;
    }
}

// 🔹 Se o pagamento foi confirmado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar_pagamento'])) {
    $id_usuario = $_SESSION['usuario_id'];
    $total = (float)($_POST['total'] ?? 0);
    $cupom_codigo = $_POST['cupom'] ?? null;
    $cupom_desconto = (float)($_POST['desconto'] ?? 0);

    // Cria o pedido
    $stmt = $pdo->prepare("
        INSERT INTO pedido (id_usuario, total, cupom_codigo, cupom_desconto, status, data_pedido)
        VALUES (:id_usuario, :total, :cupom_codigo, :cupom_desconto, 'Pendente', NOW())
    ");
    $stmt->execute([
        ':id_usuario' => $id_usuario,
        ':total' => $total,
        ':cupom_codigo' => $cupom_codigo,
        ':cupom_desconto' => $cupom_desconto
    ]);

    $id_pedido = $pdo->lastInsertId();

    // Insere itens do carrinho em pedido_produto
    $stmt_item = $pdo->prepare("
        INSERT INTO pedido_produto (id_pedido, id_produto, quantidade)
        VALUES (:id_pedido, :id_produto, :quantidade)
    ");

    foreach ($itens as $item) {
        $stmt_item->execute([
            ':id_pedido' => $id_pedido,
            ':id_produto' => $item['id_produto'],
            ':quantidade' => $item['quantidade']
        ]);
    }

    // Limpa carrinho
    CarrinhoController::limparCarrinho($id_usuario);

    echo json_encode(['sucesso' => true]);
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Finalizar Pagamento - Zypher Sneakers</title>
    <link rel="stylesheet" href="/zypher/CSS/pagamento.css">
</head>
<body>

<header>
    <div class="topo">
        <div class="logo">
            <a href="/zypher/VIEWS/HomeCliente.php">
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

<div class="container">
    <div class="itens-pedido">
        <h2>Itens do Pedido</h2>
        <?php foreach ($itens as $item): ?>
            <?php 
                $nome = htmlspecialchars($item['nome'] ?? 'Produto');
                $tamanho = htmlspecialchars($item['tamanho'] ?? '');
                $quantidade = (int)($item['quantidade'] ?? 1);
                $preco = (float)($item['preco'] ?? 0);
                $imagem = htmlspecialchars($item['imagem'] ?? '/zypher/img/placeholder.png');
                $subtotal = $preco * $quantidade;
            ?>
            <div class="item">
                <img src="<?= $imagem ?>" alt="<?= $nome ?>" onerror="this.src='/zypher/img/placeholder.png'">
                <div>
                    <h4><?= $nome ?></h4>
                    <p>Tam: <?= $tamanho ?> | Qtd: <?= $quantidade ?></p>
                    <p><strong>R$ <?= number_format($preco, 2, ',', '.') ?></strong></p>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="cupom">
            <input type="text" id="cupom" placeholder="Código do cupom (CUP5, CUP10, CUP15)">
            <button onclick="aplicarCupom()">Aplicar Cupom</button>
        </div>
    </div>

    <div class="pagamento">
        <h2>Pagamento</h2>

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

            <label>Parcelas</label>
            <select id="parcelas"></select>

            <div class="resumo">
                <p>Subtotal: <span id="subtotal">R$ <?= number_format($total, 2, ',', '.') ?></span></p>
                <p>Desconto: <span id="desconto">- R$ 0,00</span></p>
                <p><strong>Total: <span id="total">R$ <?= number_format($total, 2, ',', '.') ?></span></strong></p>
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

<!-- MODAL DE CONFIRMAÇÃO -->
<div id="modal-confirmado" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center;">
    <div style="background:#fff; padding:40px; border-radius:10px; text-align:center;">
        <h2 style="color:#28a745;">✅ Pagamento Confirmado!</h2>
        <p>Obrigado por comprar com a Zypher Sneakers!</p>
        <button onclick="fecharModal()" style="margin-top:15px; background:#001f3f; color:white; border:none; padding:10px 20px; border-radius:6px;">Voltar à Loja</button>
    </div>
</div>

<script>
let subtotal = <?= $total ?>;
let desconto = 0;

// Atualiza as parcelas (com valor na frente)
function atualizarParcelas() {
    const select = document.getElementById('parcelas');
    select.innerHTML = '';
    for (let i = 1; i <= 12; i++) {
        const valor = ((subtotal - desconto) / i).toFixed(2).replace('.', ',');
        const option = document.createElement('option');
        option.value = i;
        option.text = `${i}x de R$ ${valor}`;
        select.appendChild(option);
    }
}
atualizarParcelas();

// Aplica cupom
function aplicarCupom() {
    const codigo = document.getElementById('cupom').value.trim().toUpperCase();
    let porcentagem = 0;
    if (codigo === 'CUP5') porcentagem = 5;
    else if (codigo === 'CUP10') porcentagem = 10;
    else if (codigo === 'CUP15') porcentagem = 15;
    else return alert('Cupom inválido.');

    desconto = subtotal * (porcentagem / 100);
    document.getElementById('desconto').textContent = `- R$ ${desconto.toFixed(2).replace('.', ',')}`;
    document.getElementById('total').textContent = `R$ ${(subtotal - desconto).toFixed(2).replace('.', ',')}`;
    atualizarParcelas();
}

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

// Simula confirmação
function confirmarPagamento(tipo) {
    const total = (subtotal - desconto).toFixed(2);
    const cupom = document.getElementById('cupom').value.trim();
    const descontoValor = desconto.toFixed(2);

    fetch('', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `confirmar_pagamento=1&total=${total}&cupom=${cupom}&desconto=${descontoValor}`
    })
    .then(r => r.json())
    .then(data => {
        if (data.sucesso) {
            document.getElementById('modal-confirmado').style.display = 'flex';
        } else {
            alert('Erro ao registrar pedido.');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Falha na comunicação com o servidor.');
    });
}

function fecharModal() {
    window.location.href = '/zypher/VIEWS/HomeCliente.php';
}
</script>

</body>
</html>
