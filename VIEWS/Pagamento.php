<?php
// /zypher/views/Pagamento.php
session_start();
require_once __DIR__ . '/../controllers/CarrinhoController.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: /zypher/login?msg=precisa-logar");
    exit;
}

$usuarioId = $_SESSION['usuario_id'];
$itens = CarrinhoController::listarCarrinho($usuarioId);
$totalCarrinho = CarrinhoController::calcularTotal($usuarioId);

// cupons disponíveis
$cupons = [
    'ZYPHER10' => 10.00,
    'ZYPHER20' => 20.00,
    'ZYPHER50' => 50.00
];

// Verifica endereço - CORRIGIDO para pegar do banco de dados
$temEndereco = false;
$enderecoInfo = null;

try {
    require_once __DIR__ . '/../config/database.php';
    $db = new Database();
    $pdo = $db->getConnection();
    
    $sqlEndereco = "SELECT * FROM endereco WHERE id_usuario = :id_usuario ORDER BY id DESC LIMIT 1";
    $stmt = $pdo->prepare($sqlEndereco);
    $stmt->execute([':id_usuario' => $usuarioId]);
    $enderecoInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($enderecoInfo) {
        $temEndereco = true;
        // Salva na sessão também
        $_SESSION['endereco_entrega'] = $enderecoInfo;
    }
} catch (PDOException $e) {
    error_log("Erro ao buscar endereço: " . $e->getMessage());
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Pagamento - Zypher Sneakers</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/zypher/CSS/Pagamento.css">
</head>
<body>

<div class="container">
    <div class="grid">
        <!-- Coluna Esquerda: Pagamento -->
        <div class="card">
            <h2>Informações de Pagamento</h2>

            <!-- Exibe endereço ou aviso -->
            <?php if ($temEndereco && $enderecoInfo): ?>
                <div class="endereco-info">
                    <strong>✓ Endereço de Entrega Confirmado</strong>
                    <span>
                        <?= htmlspecialchars($enderecoInfo['endereco_entrega'] ?? '') ?>, 
                        <?= htmlspecialchars($enderecoInfo['numero'] ?? '') ?><br>
                        <?= htmlspecialchars($enderecoInfo['cidade'] ?? '') ?> - 
                        <?= htmlspecialchars($enderecoInfo['estado'] ?? '') ?>, 
                        CEP: <?= htmlspecialchars($enderecoInfo['cep'] ?? '') ?>

                    </span>
                </div>
            <?php else: ?>
                <div class="sem-endereco">
                    ⚠️ <strong>Atenção:</strong> Nenhum endereço cadastrado. 
                    <a href="/zypher/views/EnderecoCliente.php">Adicionar agora</a>
                </div>
            <?php endif; ?>

            <h3>Método de Pagamento</h3>
            <div class="tabs">
                <button id="tabPix" class="tab-btn active">PIX</button>
                <button id="tabCard" class="tab-btn">Cartão de Crédito</button>
            </div>

            <!-- ÁREA PIX -->
            <div id="pixArea" class="payment-area active">
                <div class="pix-container">
                    <div class="qr-box">
                        <img id="qrImg" src="" alt="QR Code PIX">
                    </div>
                    <p class="pix-info">Escaneie o QR Code com seu app de banco para pagar</p>
                </div>
                
                <div class="loading" id="loadingPix">
                    <div class="spinner"></div>
                    <p style="margin-top:12px; color:#6b7280;">Processando pagamento...</p>
                </div>
                
                <button id="payPix" class="btn-primary">Confirmar Pagamento PIX</button>
            </div>

            <!-- ÁREA CARTÃO -->
            <div id="cardArea" class="payment-area">
                <div class="field campo-cartao">
                    <label>Número do Cartão</label>
                    <input id="cardNumber" class="input" placeholder="0000 0000 0000 0000" maxlength="23">
                    <img id="cardBrandImg" class="card-brand" alt="Bandeira">
                </div>
                <div class="field">
                    <label>Nome no Cartão</label>
                    <input id="cardName" class="input" placeholder="Como está no cartão">
                </div>
                <div class="row">
                    <div class="field">
                        <label>Validade</label>
                        <input id="cardExp" class="input" placeholder="MM/AA" maxlength="5">
                    </div>
                    <div class="field small">
                        <label>CVV</label>
                        <input id="cardCvv" class="input" placeholder="123" maxlength="4">
                    </div>
                </div>
                <div class="field">
                    <label>Parcelas</label>
                    <select id="cardInstallments" class="input">
                        <!-- Será preenchido pelo JavaScript -->
                    </select>
                </div>

                <!-- Cupons -->
                <div class="cupons-section">
                    <h4>💳 Cupons de Desconto</h4>
                    <div class="coupons" id="couponList">
                        <?php foreach ($cupons as $code => $val): ?>
                            <div class="coupon" data-code="<?= htmlspecialchars($code) ?>" data-value="<?= $val ?>">
                                <?= htmlspecialchars($code) ?> – R$ <?= number_format($val,2,',','.') ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="loading" id="loadingCard">
                    <div class="spinner"></div>
                    <p style="margin-top:12px; color:#6b7280;">Processando pagamento...</p>
                </div>

                <button id="payCard" class="btn-primary">Pagar com Cartão</button>
            </div>
        </div>

        <!-- Coluna Direita: Resumo -->
        <div class="card resumo">
            <h3>Resumo do Pedido</h3>
            
            <?php if (empty($itens)): ?>
                <p style="color:#6b7280; text-align:center; padding:20px;">Carrinho vazio</p>
            <?php else: ?>
                <!-- Lista produtos com imagem -->
                <?php foreach ($itens as $it): ?>
                    <div class="produto-item">
                        <img src="<?= htmlspecialchars($it['imagem'] ?? '/zypher/images/placeholder.jpg') ?>" 
                             alt="<?= htmlspecialchars($it['nome']) ?>" 
                             class="produto-img">
                        <div class="produto-info">
                            <div class="produto-nome"><?= htmlspecialchars($it['nome']) ?></div>
                            <div class="produto-qty">Quantidade: <?= (int)$it['quantidade'] ?></div>
                        </div>
                        <div class="produto-preco">
                            R$ <?= number_format($it['preco'] * $it['quantidade'], 2, ',', '.') ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <hr>
                
                <div class="summary-line">
                    <span>Subtotal</span>
                    <span id="subtotal">R$ <?= number_format($totalCarrinho,2,',','.') ?></span>
                </div>
                <div class="summary-line">
                    <span>Desconto</span>
                    <span id="desconto">R$ 0,00</span>
                </div>
                <div class="summary-line">
                    <span>Frete</span>
                    <span id="frete">Grátis</span>
                </div>
                
                <div class="summary-line total">
                    <span>Total</span>
                    <span id="totalPay">R$ <?= number_format($totalCarrinho,2,',','.') ?></span>
                </div>
            <?php endif; ?>

            <!-- Form oculto para envio -->
            <form id="finalizarForm" method="POST" action="/zypher/controllers/FinalizarCompra.php" style="display:none;">
                <input type="hidden" name="metodo_pagamento" id="inputMetodo" value="pix">
                <input type="hidden" name="cupom_code" id="inputCupom" value="">
                <input type="hidden" name="valor_final" id="inputValorFinal" value="<?= number_format($totalCarrinho,2,'.','') ?>">
            </form>
        </div>
    </div>
</div>

<script>
// Helpers
function formatBRL(n) { return n.toLocaleString('pt-BR', {minimumFractionDigits:2, maximumFractionDigits:2}); }

// Valores iniciais
let subtotal = <?= json_encode((float)$totalCarrinho) ?>;
let desconto = 0.0;
let frete = 0.0;

const subtotalEl = document.getElementById('subtotal');
const descontoEl = document.getElementById('desconto');
const freteEl = document.getElementById('frete');
const totalPayEl = document.getElementById('totalPay');
const inputValorFinal = document.getElementById('inputValorFinal');
const inputCupom = document.getElementById('inputCupom');
const inputMetodo = document.getElementById('inputMetodo');

function atualizarResumo() {
    const total = Math.max(0, subtotal - desconto + frete);
    subtotalEl.textContent = 'R$ ' + formatBRL(subtotal);
    descontoEl.textContent = desconto > 0 ? '- R$ ' + formatBRL(desconto) : 'R$ 0,00';
    totalPayEl.textContent = 'R$ ' + formatBRL(total);
    inputValorFinal.value = total.toFixed(2);
    
    // Atualiza parcelas
    atualizarParcelas(total);
}

// Atualiza select de parcelas com valores
function atualizarParcelas(total) {
    const selectParcelas = document.getElementById('cardInstallments');
    selectParcelas.innerHTML = '';
    
    const maxParcelas = 12;
    for (let i = 1; i <= maxParcelas; i++) {
        const valorParcela = total / i;
        const option = document.createElement('option');
        option.value = i;
        
        if (i === 1) {
            option.textContent = `1x de R$ ${formatBRL(total)} sem juros`;
        } else {
            option.textContent = `${i}x de R$ ${formatBRL(valorParcela)} sem juros`;
        }
        
        selectParcelas.appendChild(option);
    }
}

// Tabs PIX/Cartão
const tabPix = document.getElementById('tabPix');
const tabCard = document.getElementById('tabCard');
const pixArea = document.getElementById('pixArea');
const cardArea = document.getElementById('cardArea');

tabPix.addEventListener('click', () => {
    tabPix.classList.add('active');
    tabCard.classList.remove('active');
    pixArea.classList.add('active');
    cardArea.classList.remove('active');
    inputMetodo.value = 'pix';
});

tabCard.addEventListener('click', () => {
    tabCard.classList.add('active');
    tabPix.classList.remove('active');
    cardArea.classList.add('active');
    pixArea.classList.remove('active');
    inputMetodo.value = 'card';
});

// Gerar QR Code PIX
const qrImg = document.getElementById('qrImg');
function gerarQRCode() {
    const total = Math.max(0, subtotal - desconto + frete);
    const payload = `PIX|ZYPHER|VALOR:${total.toFixed(2)}|PEDIDO`;
    qrImg.src = 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' + encodeURIComponent(payload);
}
gerarQRCode();

// Cupons
document.querySelectorAll('.coupon').forEach(c => {
    c.addEventListener('click', () => {
        const alreadySelected = c.classList.contains('selected');
        
        document.querySelectorAll('.coupon').forEach(x => x.classList.remove('selected'));
        
        if (alreadySelected) {
            desconto = 0;
            inputCupom.value = '';
        } else {
            c.classList.add('selected');
            desconto = parseFloat(c.getAttribute('data-value')) || 0;
            inputCupom.value = c.getAttribute('data-code') || '';
        }
        
        atualizarResumo();
        gerarQRCode();
    });
});

// Detecção de bandeira do cartão
const cardNumber = document.getElementById('cardNumber');
const brandImg = document.getElementById('cardBrandImg');

function svgDataURL(brand) {
    const svgs = {
        visa: `<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 40'><rect fill='#1A1F71' width='64' height='40' rx='4'/><text x='8' y='26' font-family='Arial' font-size='18' fill='#fff' font-weight='700'>VISA</text></svg>`,
        mastercard: `<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 40'><rect fill='#fff' width='64' height='40' rx='4'/><circle cx='26' cy='20' r='10' fill='#EB001B'/><circle cx='38' cy='20' r='10' fill='#F79E1B'/></svg>`,
        amex: `<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 40'><rect fill='#2E77BB' width='64' height='40' rx='4'/><text x='10' y='26' font-family='Arial' font-size='14' fill='#fff' font-weight='700'>AMEX</text></svg>`,
        elo: `<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 40'><rect fill='#012169' width='64' height='40' rx='4'/><text x='10' y='26' font-family='Arial' font-size='12' fill='#FFD400' font-weight='700'>ELO</text></svg>`
    };
    return svgs[brand] ? 'data:image/svg+xml;utf8,' + encodeURIComponent(svgs[brand]) : '';
}

function detectBrand(num) {
    const n = num.replace(/\D/g,'');
    if (/^4/.test(n)) return 'visa';
    if (/^5[1-5]/.test(n)) return 'mastercard';
    if (/^3[47]/.test(n)) return 'amex';
    if (/^6|^50|^38/.test(n)) return 'elo';
    return '';
}

cardNumber.addEventListener('input', (e) => {
    let v = e.target.value.replace(/\D/g,'').slice(0,16);
    e.target.value = v.match(/.{1,4}/g)?.join(' ') || v;
    const brand = detectBrand(v);
    if (brand) {
        brandImg.src = svgDataURL(brand);
        brandImg.style.display = 'inline-block';
    } else {
        brandImg.style.display = 'none';
    }
});

// Formatação de validade
document.getElementById('cardExp').addEventListener('input', (e) => {
    let v = e.target.value.replace(/\D/g,'').slice(0,4);
    if (v.length >= 2) v = v.slice(0,2) + '/' + v.slice(2);
    e.target.value = v;
});

// Botões de pagamento com loading
const btnPayPix = document.getElementById('payPix');
const btnPayCard = document.getElementById('payCard');
const loadingPix = document.getElementById('loadingPix');
const loadingCard = document.getElementById('loadingCard');

btnPayPix.addEventListener('click', (e) => {
    e.preventDefault();
    btnPayPix.disabled = true;
    btnPayPix.textContent = 'Processando...';
    loadingPix.classList.add('active');
    
    inputMetodo.value = 'pix';
    
    setTimeout(() => {
        document.getElementById('finalizarForm').submit();
    }, 500);
});

btnPayCard.addEventListener('click', (e) => {
    e.preventDefault();
    
    // Validação básica
    if (!cardNumber.value || !document.getElementById('cardName').value || 
        !document.getElementById('cardExp').value || !document.getElementById('cardCvv').value) {
        alert('Por favor, preencha todos os dados do cartão');
        return;
    }
    
    btnPayCard.disabled = true;
    btnPayCard.textContent = 'Processando...';
    loadingCard.classList.add('active');
    
    inputMetodo.value = 'card';
    
    setTimeout(() => {
        document.getElementById('finalizarForm').submit();
    }, 500);
});

// Inicializa
atualizarResumo();
</script>
</body>
</html>