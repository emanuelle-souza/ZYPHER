<?php
// include/header.php - cabeçalho reutilizável (somente o conteúdo visual)
?>
<header>
    <div class="menu-container">
        <div class="logo">
            <a class="logo" href="HomeCliente.php"><img src="../MIDIA/LogoDeitado.png" alt="Logo Zypher Sneakers"></a>
        </div>
        <div class="pesquisar">
            <input type="text" placeholder="Pesquisar..." aria-label="Pesquisar">
            <button aria-label="Buscar">
                <img src="../MIDIA/pesquisar.png" alt="Pesquisar">
            </button>
        </div>
        <div class="icones">
            <a class="coroa" href="SejaMembro.php">
                <img src="../MIDIA/coroa.png" alt="Seja Membro" width="32" height="32">
            </a>
            <a class="perfil" href="usuarioform.php">
                <img src="../MIDIA/perfil.png" alt="Perfil" width="32" height="32">
            </a>
            <a class="carrinho" href="Carrinho.php">
                <img src="../MIDIA/carrinho.png" alt="Carrinho" width="32" height="32">
            </a>
        </div>
    </div>
    <nav class="menu-categorias">
        <ul>
            <li><a href="Produto.php?genero=feminino">FEMININO</a></li>
            <li><a href="Produto.php?genero=masculino">MASCULINO</a></li>
        </ul>
    </nav>
</header>
