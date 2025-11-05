<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fale Conosco - Zypher Sneakers</title>
    <link rel="stylesheet" href="/zypher/CSS/FaleConosco.css">
</head>
<body>
     <!-- Header -->
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
                <?php if (!isset($_SESSION)) session_start(); ?>

<?php if (isset($_SESSION['usuario_id'])): ?>
    <!-- Usuário logado: vai para o perfil -->
    <a href="/zypher/views/PerfilUsuario.php" title="Meu Perfil">
        <img src="/zypher/MIDIA/perfil.png" alt="perfil">
    </a>
<?php else: ?>
    <!-- Usuário não logado: mostra opções de login/cadastro -->
    <a href="/zypher/views/login.php" title="Entrar">
        <img src="/zypher/MIDIA/perfil.png" alt="Entrar">
    </a>
<?php endif; ?>
            </div>
        </div>

        <!-- Menu -->
        <nav>
            <a href="#">Feminino</a>
            <a href="#">Masculino</a>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <h1>FALE CONOSCO</h1>
        <p>Estamos aqui para ajudar! Se você tiver alguma dúvida, sugestão ou precisar de suporte, fique à vontade para entrar em contato conosco. Nossa equipe está pronta para atender você com agilidade e atenção.</p>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <form class="contact-form" action="/zypher/fale_conosco.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" placeholder="Nome:" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" placeholder="E-mail:" required>

            <label for="assunto">Assunto:</label>
            <input type="text" id="assunto" name="assunto" placeholder="Assunto:" required>

            <label for="mensagem">Mensagem:</label>
            <textarea id="mensagem" name="mensagem" placeholder="Mensagem:" required></textarea>

            <button type="submit" class="submit-btn">ENVIAR</button>
        </form>

        <div class="contact-image">
            <img src="../MIDIA/faleconosco.png" alt="Sneaker Collection">
        </div>
    </section>

    <!-- Thank You Section -->
    <section class="thank-you">
        Agradecemos o seu contato!
    </section>

    <!-- Footer -->
 <footer>
    <a href="/zypher/VIEWS/Politicas.php">Política de Privacidade</a> | 
    <a href="#">Termos de Uso</a> | 
    <a href="/zypher/VIEWS/FaleConosco.php">Fale conosco</a>
    <p>&copy; 2025 Zypher Sneakers. Todos os direitos reservados.</p>
</footer>
</body>
</html>