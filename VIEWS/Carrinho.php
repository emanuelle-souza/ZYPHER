<?php
session_start();
require_once __DIR__ . '/../controllers/CarrinhoController.php';

// Redireciona para o login se não estiver logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /zypher/login?msg=precisa-logar");
    exit;
}

// Lista os itens do carrinho do usuário
$itens = CarrinhoController::listarCarrinho($_SESSION['usuario_id']);
$total = 0;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho - Zypher Sneakers</title>
    <link rel="stylesheet" href="/zypher/CSS/Carrinho.css">
</head>
<body>
    <!-- Header (mantenha o seu header, apenas copie conforme necessidade) -->
    <!-- Cabeçalho / Menu -->
    <header>
        <div class="topo">
            <div class="logo">
                <a href="/zypher/VIEWS/HomeCliente.php">
                    <img src="/zypher/MIDIA/LogoDeitado.png" alt="Zypher Sneakers" class="logo-img">
                </a>
            </div>
<div class="busca">
                <button type="button">
                    <img src="/zypher/MIDIA/Lupa.png" alt="Buscar">
                </button>
                <input type="text" placeholder="Buscar tênis...">
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

       <nav class="menu">
            <a href="/zypher/views/Feminino.php">Feminino</a>
            <a href="/zypher/views/Masculino.php">Masculino</a>
            <a href="/zypher/views/Explorar.php">Explorar</a>
            <a href="/zypher/views/QuemSomos.php">Sobre nós</a>
        </nav>
    </header>

    <main>
        <div class="container-carrinho">
            <h2>Seu Carrinho</h2>

            <?php if (empty($itens)): ?>
                <p class="carrinho-vazio">Seu carrinho está vazio 🛒</p>
            <?php else: ?>
                <div id="lista-carrinho" class="carrinho-lista">
                    <?php foreach ($itens as $item): ?>
                        <?php 
                            // Segurança: garantir índices
                            $id_produto = isset($item['id_produto']) ? $item['id_produto'] : null;
                            $nome = isset($item['nome']) ? $item['nome'] : 'Produto';
                            $preco = isset($item['preco']) ? (float)$item['preco'] : 0.0;
                            $imagem = isset($item['imagem']) ? $item['imagem'] : '';
                            $tamanho = isset($item['tamanho']) ? $item['tamanho'] : '';
                            $quantidade = isset($item['quantidade']) ? (int)$item['quantidade'] : 1;

                            $subtotal = $preco * $quantidade; 
                            $total += $subtotal;
                        ?>
                        <div class="item-carrinho" data-id-produto="<?= htmlspecialchars($id_produto) ?>" data-tamanho="<?= htmlspecialchars($tamanho) ?>">
                            <img class="item-imagem" src="<?= htmlspecialchars($imagem) ?>" alt="<?= htmlspecialchars($nome) ?>"
                                 onerror="this.onerror=null; this.src='/zypher/img/placeholder.png'">
                            <div class="item-detalhes">
                                <p class="item-nome"><?= htmlspecialchars($nome) ?></p>
                                <p class="item-info item-tamanho">Tamanho: <?= htmlspecialchars($tamanho) ?></p>

                                <div class="item-quantidade-wrapper">
                                    <button class="btn-qtd diminuir" aria-label="Diminuir">−</button>
                                    <input type="number" class="input-quantidade" min="1" value="<?= $quantidade ?>" />
                                    <button class="btn-qtd aumentar" aria-label="Aumentar">+</button>
                                </div>

                                <p class="item-preco">R$ <span class="preco-unitario"><?= number_format($preco, 2, ',', '.') ?></span></p>
                                <p class="item-subtotal">Subtotal: R$ <span class="valor-subtotal"><?= number_format($subtotal, 2, ',', '.') ?></span></p>
                            </div>

                            <form class="form-remover" data-id="<?= $item['id_produto'] ?>" data-tamanho="<?= htmlspecialchars($item['tamanho']) ?>">
    <button type="button" class="btn-remover" title="Remover item">✖</button>
</form>

                        </div>
                    <?php endforeach; ?>
                </div>

<div class="carrinho-resumo">
    <p class="carrinho-total">
        Total: R$ <span id="valor-total"><?= number_format($total, 2, ',', '.') ?></span>
    </p>
<form action="../views/enderecoform.php" method="GET">
    <button type="submit" class="btn-finalizar">Finalizar Compra</button>
</form>

</div>

            <?php endif; ?>
        </div>
    </main>

     <footer>
    <a href="/zypher/VIEWS/Politicas.php">Política de Privacidade</a> | 
    <a href="#">Termos de Uso</a> | 
    <a href="/zypher/VIEWS/FaleConosco.php">Fale conosco</a>
    <p>&copy; 2025 Zypher Sneakers. Todos os direitos reservados.</p>
</footer>

    <script>
    // Funções utilitárias
    function formatBRL(num) {
        return num.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    // Atualiza subtotal do item e total geral no DOM
    function recalcularTotais() {
        let total = 0;
        document.querySelectorAll('.item-carrinho').forEach(item => {
            const precoText = item.querySelector('.preco-unitario').textContent.replace(/\./g,'').replace(',', '.');
            const preco = parseFloat(precoText) || 0;
            const quantidade = parseInt(item.querySelector('.input-quantidade').value) || 0;
            const subtotal = preco * quantidade;
            item.querySelector('.valor-subtotal').textContent = formatBRL(subtotal);
            total += subtotal;
        });
        document.getElementById('valor-total').textContent = formatBRL(total);
    }

    // Faz request para atualizar quantidade no servidor
    async function enviarAtualizacaoQuantidade(id_produto, tamanho, quantidade) {
        try {
            const form = new FormData();
            form.append('id_produto', id_produto);
            form.append('tamanho', tamanho);
            form.append('quantidade', quantidade);

            const resp = await fetch('/zypher/controllers/AtualizarQuantidadeCarrinho.php', {
                method: 'POST',
                body: form
            });
            const data = await resp.json();
            if (!data.success) {
                console.error('Erro atualização:', data.message || data);
            }
            return data;
        } catch (err) {
            console.error('Erro fetch atualizar quantidade', err);
            return { success: false };
        }
    }

    // Faz request para remover item no servidor
    async function enviarRemoverItem(id_produto, tamanho) {
        try {
            const form = new FormData();
            form.append('id_produto', id_produto);
            form.append('tamanho', tamanho);

            const resp = await fetch('/zypher/controllers/RemoverItemsCarrinho.php', {
                method: 'POST',
                body: form
            });
            const data = await resp.json();
            return data;
        } catch (err) {
            console.error('Erro fetch remover item', err);
            return { success: false };
        }
    }

    // Event delegation para botões de mais/menos e remover
    document.addEventListener('click', async (e) => {
        // aumentar
        if (e.target.matches('.btn-qtd.aumentar')) {
            const item = e.target.closest('.item-carrinho');
            const input = item.querySelector('.input-quantidade');
            let val = parseInt(input.value) || 0;
            val++;
            input.value = val;

            const id_produto = item.getAttribute('data-id-produto');
            const tamanho = item.getAttribute('data-tamanho');

            await enviarAtualizacaoQuantidade(id_produto, tamanho, val);
            recalcularTotais();
        }

        // diminuir
        if (e.target.matches('.btn-qtd.diminuir')) {
            const item = e.target.closest('.item-carrinho');
            const input = item.querySelector('.input-quantidade');
            let val = parseInt(input.value) || 0;
            if (val > 1) {
                val--;
                input.value = val;
                const id_produto = item.getAttribute('data-id-produto');
                const tamanho = item.getAttribute('data-tamanho');

                await enviarAtualizacaoQuantidade(id_produto, tamanho, val);
                recalcularTotais();
            } else {
                // se quiser comportamento de remover ao diminuir para 0, descomente
                // e.g., chamar enviarRemoverItem e remover DOM
            }
        }

        // remover
        if (e.target.matches('.btn-remover')) {
            const item = e.target.closest('.item-carrinho');
            const id_produto = item.getAttribute('data-id-produto');
            const tamanho = item.getAttribute('data-tamanho');

            const confirmado = confirm('Remover este item do carrinho?');
            if (!confirmado) return;

            const result = await enviarRemoverItem(id_produto, tamanho);
            if (result.success) {
                item.remove();
                recalcularTotais();
            } else {
                alert('Erro ao remover item do carrinho.');
            }
        }
    });

    // evento quando usuário altera o input de número diretamente
    document.addEventListener('change', async (e) => {
        if (e.target.matches('.input-quantidade')) {
            const input = e.target;
            let val = parseInt(input.value) || 1;
            if (val < 1) { val = 1; input.value = 1; }

            const item = input.closest('.item-carrinho');
            const id_produto = item.getAttribute('data-id-produto');
            const tamanho = item.getAttribute('data-tamanho');

            await enviarAtualizacaoQuantidade(id_produto, tamanho, val);
            recalcularTotais();
        }
    });

    // Inicial
    recalcularTotais();
    </script>
</body>
</html>