<?php
// /zypher/views/CompraFinalizada.php
session_start();

// Verifica se tem dados da compra
if (!isset($_SESSION['ultima_compra'])) {
    header("Location: /zypher/views/HomeCliente.php");
    exit;
}

$compra = $_SESSION['ultima_compra'];
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Pedido Confirmado - Zypher Sneakers</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { 
    font-family: 'Poppins', sans-serif; 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.container {
    background: #fff;
    max-width: 700px;
    width: 100%;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    overflow: hidden;
    animation: slideUp 0.6s ease;
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.header {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    padding: 40px 30px;
    text-align: center;
    color: #fff;
}

.checkmark {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    animation: pulse 2s infinite;
}

.checkmark svg {
    width: 50px;
    height: 50px;
    stroke: #fff;
    stroke-width: 3;
    fill: none;
    stroke-dasharray: 100;
    stroke-dashoffset: 100;
    animation: draw 0.8s ease forwards;
}

@keyframes draw {
    to { stroke-dashoffset: 0; }
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.header h1 {
    font-size: 2rem;
    margin-bottom: 8px;
    font-weight: 800;
}

.header p {
    opacity: 0.95;
    font-size: 1.05rem;
}

.content {
    padding: 30px;
}

.info-box {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    border-left: 4px solid #667eea;
}

.info-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
    padding-bottom: 12px;
    border-bottom: 1px solid #e9ecef;
}

.info-row:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.info-label {
    color: #6b7280;
    font-weight: 500;
}

.info-value {
    color: #1e3a5f;
    font-weight: 700;
}

.rastreio {
    background: #fff3cd;
    border: 2px dashed #ffc107;
    padding: 16px;
    border-radius: 12px;
    text-align: center;
    margin-bottom: 20px;
}

.rastreio strong {
    color: #856404;
    font-size: 1.1rem;
    letter-spacing: 1px;
}

.produtos-lista {
    margin-bottom: 20px;
}

.produto-item {
    display: flex;
    gap: 12px;
    padding: 12px;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 10px;
}

.produto-img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    background: #e9ecef;
}

.produto-info {
    flex: 1;
}

.produto-nome {
    font-weight: 600;
    color: #1e3a5f;
    margin-bottom: 4px;
}

.produto-qty {
    color: #6b7280;
    font-size: 0.9rem;
}

.produto-preco {
    font-weight: 700;
    color: #28a745;
    text-align: right;
}

.resumo-financeiro {
    background: #1e3a5f;
    color: #fff;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 20px;
}

.resumo-linha {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    padding-bottom: 10px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.resumo-linha:last-child {
    border-bottom: none;
    font-size: 1.3rem;
    font-weight: 800;
    padding-top: 10px;
    border-top: 2px solid rgba(255,255,255,0.3);
    margin-top: 10px;
}

.actions {
    display: flex;
    gap: 12px;
}

.btn {
    flex: 1;
    padding: 14px;
    border-radius: 10px;
    border: none;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
    text-align: center;
}

.btn-primary {
    background: #667eea;
    color: #fff;
}

.btn-primary:hover {
    background: #5568d3;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102,126,234,0.4);
}

.btn-secondary {
    background: #e9ecef;
    color: #1e3a5f;
}

.btn-secondary:hover {
    background: #dee2e6;
}

.metodo-badge {
    display: inline-block;
    background: #28a745;
    color: #fff;
    padding: 4px 12px;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
}

@media (max-width: 600px) {
    .header h1 { font-size: 1.5rem; }
    .content { padding: 20px; }
    .actions { flex-direction: column; }
}
</style>
</head>
<body>

<div class="container">
    <!-- Cabeçalho de sucesso -->
    <div class="header">
        <div class="checkmark">
            <svg viewBox="0 0 52 52">
                <polyline points="14 27 22 34 38 18"/>
            </svg>
        </div>
        <h1>Pedido Confirmado! 🎉</h1>
        <p>Seu pagamento foi processado com sucesso</p>
    </div>

    <div class="content">
        <!-- Código de rastreamento -->
        <div class="rastreio">
            <div style="color:#856404; margin-bottom:6px; font-size:0.9rem;">Código de Rastreamento</div>
            <strong><?= htmlspecialchars($compra['rastreamento']) ?></strong>
        </div>

        <!-- Informações do pedido -->
        <div class="info-box">
            <div class="info-row">
                <span class="info-label">Pedido Nº</span>
                <span class="info-value">#<?= htmlspecialchars($compra['id_pedido']) ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Data</span>
                <span class="info-value"><?= htmlspecialchars($compra['data']) ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Forma de Pagamento</span>
                <span class="info-value">
                    <span class="metodo-badge"><?= htmlspecialchars($compra['metodo_nome']) ?></span>
                </span>
            </div>
            <?php if (!empty($compra['cupom'])): ?>
            <div class="info-row">
                <span class="info-label">Cupom Aplicado</span>
                <span class="info-value" style="color:#28a745;">
                    <?= htmlspecialchars($compra['cupom']) ?> 
                    (-R$ <?= number_format($compra['desconto'], 2, ',', '.') ?>)
                </span>
            </div>
            <?php endif; ?>
        </div>

        <!-- Produtos comprados -->
        <?php if (isset($compra['itens']) && !empty($compra['itens'])): ?>
        <h3 style="color:#1e3a5f; margin-bottom:12px; font-size:1.1rem;">📦 Produtos</h3>
        <div class="produtos-lista">
            <?php foreach ($compra['itens'] as $item): ?>
            <div class="produto-item">
                <img src="<?= htmlspecialchars($item['imagem'] ?? '/zypher/images/placeholder.jpg') ?>" 
                     alt="<?= htmlspecialchars($item['nome']) ?>" 
                     class="produto-img">
                <div class="produto-info">
                    <div class="produto-nome"><?= htmlspecialchars($item['nome']) ?></div>
                    <div class="produto-qty">Qtd: <?= (int)$item['quantidade'] ?></div>
                </div>
                <div class="produto-preco">
                    R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Resumo financeiro -->
        <div class="resumo-financeiro">
            <div class="resumo-linha">
                <span>Subtotal</span>
                <span>R$ <?= number_format($compra['subtotal'], 2, ',', '.') ?></span>
            </div>
            <?php if ($compra['desconto'] > 0): ?>
            <div class="resumo-linha">
                <span>Desconto</span>
                <span style="color:#20c997;">- R$ <?= number_format($compra['desconto'], 2, ',', '.') ?></span>
            </div>
            <?php endif; ?>
            <div class="resumo-linha">
                <span>Frete</span>
                <span><?= $compra['frete'] > 0 ? 'R$ ' . number_format($compra['frete'], 2, ',', '.') : 'Grátis' ?></span>
            </div>
            <div class="resumo-linha">
                <span>TOTAL PAGO</span>
                <span>R$ <?= number_format($compra['total'], 2, ',', '.') ?></span>
            </div>
        </div>

        <!-- Mensagem de entrega -->
        <div style="background:#e7f3ff; padding:16px; border-radius:10px; margin-bottom:20px; border-left:4px solid #0066cc;">
            <strong style="color:#0066cc; display:block; margin-bottom:6px;">📬 Entrega</strong>
            <span style="color:#004999;">
                Seu pedido será enviado em até 2 dias úteis. 
                Você receberá atualizações por e-mail e SMS.
            </span>
        </div>

        <!-- Ações -->
        <div class="actions">
            <a href="/zypher/views/HomeCliente.php" class="btn btn-primary">Voltar à Loja</a>
            <a href="/zypher/views/MeusPedidos.php" class="btn btn-secondary">Meus Pedidos</a>
        </div>
    </div>
</div>

<script>
// Limpa a sessão da última compra após 10 segundos (opcional)
setTimeout(() => {
    fetch('/zypher/controllers/LimparSessaoCompra.php', { method: 'POST' });
}, 10000);
</script>

</body>
</html>