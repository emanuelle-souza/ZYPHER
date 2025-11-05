<?php
session_start();
require_once '../config/database.php'; // adiciona a conexão
require_once '../controllers/ProdutoController.php';

$db = new Database();
$pdo = $db->getConnection();

// Pega id da URL
$id = isset($_GET['id']) ? $_GET['id'] : null;
if ($id) {
    $produto = ProdutoController::buscarProdutoPorId($id);
    if (!$produto) {
        die("Produto não encontrado.");
    }
} else {
    die("Produto não encontrado.");
}

// --- Segurança e valores padrão ---
$nome = htmlspecialchars($produto['nome'] ?? 'Produto');
$preco = isset($produto['preco']) ? floatval($produto['preco']) : 0.00;
$descricao_curta = $produto['descricao_curta'] ?? $produto['descricao'] ?? '';
$descricao_curta = htmlspecialchars($descricao_curta);
$descricao_full = htmlspecialchars($produto['descricao'] ?? $descricao_curta);

// Onde as imagens ficam no servidor (ajuste se necessário)
define('IMAGES_DIR', '/zypher/MIDIA/produtos/');

// Tratamento do campo de imagem vindo do banco:
// - se for URL (http/https) usa como está
// - se for caminho local ou nome de arquivo, usa IMAGES_DIR . basename(...)
$rawImagem = $produto['imagem_principal'] ?? $produto['imagem'] ?? '';
$rawImagem = trim($rawImagem);

if ($rawImagem === '') {
    $imgSrc = '/zypher/MIDIA/placeholder.png'; // imagem padrão quando não existir
} elseif (preg_match('/^https?:\/\//i', $rawImagem)) {
    $imgSrc = $rawImagem;
} else {
    // Se o DB guardou um caminho absoluto do Windows (ex: C:\...), pegamos apenas o basename
    $imgFile = basename(str_replace('\\', '/', $rawImagem));
    $imgSrc = IMAGES_DIR . $imgFile;
}

// Id do produto (garante int)
$id_produto = intval($produto['id'] ?? $id);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $nome ?> - Zypher Sneakers</title>
    <link rel="stylesheet" href="/zypher/CSS/Produto.css">
    <style>
        /* Pequeno estilo para mostrar botão de tamanho ativo (pode remover se já tiver no CSS) */
        .size-btn { padding:8px 12px; margin:6px; border-radius:8px; border:1px solid #ddd; background:#fff; cursor:pointer; }
        .size-btn.active { background:#172A4E; color:#fff; border-color:#172A4E; }
    </style>
</head>
<body>
  <!-- Cabeçalho / Menu -->
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

        <nav class="menu">
            <a href="#">Feminino</a>
            <a href="#">Masculino</a>
        </nav>
    </header>

<main class="produto-container">
    <section class="imagens">
        <!-- Usa IMG SRC processado no PHP; alt seguro -->
        <img id="img-principal" src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= $nome ?>">
        <?php if (!empty($produto['imagem_secundaria'])): 
            $sec = $produto['imagem_secundaria'];
            if (preg_match('/^https?:\/\//i', $sec)) $secSrc = $sec;
            else $secSrc = IMAGES_DIR . basename(str_replace('\\','/',$sec));
        ?>
            <img src="<?= htmlspecialchars($secSrc) ?>" alt="Outra imagem do produto">
        <?php endif; ?>
    </section>

    <section class="detalhes">
        <h1 id="nome-produto"><?= $nome ?></h1>
        <p class="descricao-curta"><?= $descricao_curta ?></p>
        <p class="preco">
            <span id="preco-pix">R$<?= number_format($preco, 2, ',', '.') ?> no pix</span> 
            ou em até <span class="parcelas">12x sem juros</span>
        </p>
        
<form action="../controllers/AdicionarCarrinho.php" method="POST" class="form-carrinho">
    <input type="hidden" name="id_produto" value="<?= $id_produto ?>">

    <div class="tamanhos">
        <h3>Selecione um tamanho:</h3>
        <div class="botoes-tamanho">
  <?php foreach ([38, 39, 40, 41, 42, 43, 44, 45] as $t): ?>
    <label class="size-btn">
      <input type="radio" name="tamanho" value="<?= $t ?>" required style="display:none;"> <?= $t ?>
    </label>
  <?php endforeach; ?>
</div>

    </div>

    <button type="submit" class="botao-carrinho">ADICIONAR AO CARRINHO</button>
</form>


        <div class="detalhe">
            <h4>Detalhe:</h4>
            <p><?= $descricao_full ?></p>
        </div>

        <div class="avaliacao">
            <h4>Avaliação (1):</h4>
            <div class="avaliacao-item">
                <img src="/zypher/MIDIA/perfil.png" alt="Usuário">
                <div>
                    <strong>Sarah Souza</strong>
                    <p>Conforto, estabilidade e estilo impecável!</p>
                    <p>★★★★★</p>
                </div>
            </div>
        </div>
    </section>
</main>

<footer>
    <a href="/zypher/VIEWS/Politicas.php">Política de Privacidade</a> | 
    <a href="#">Termos de Uso</a> | 
    <a href="/zypher/VIEWS/FaleConosco.php">Fale conosco</a>
    <p>&copy; 2025 Zypher Sneakers. Todos os direitos reservados.</p>
</footer>



<script>
  const sizeButtons = document.querySelectorAll('.size-btn');

  sizeButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      // Remove active de todos
      sizeButtons.forEach(b => b.classList.remove('active'));
      // Adiciona active ao clicado
      btn.classList.add('active');
      // Marca o input como checked
      btn.querySelector('input').checked = true;
    });
  });
</script>

</body>
</html>
