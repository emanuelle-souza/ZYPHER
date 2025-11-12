<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Políticas - Zypher Sneakers</title>
  <link rel="stylesheet" href="/zypher/CSS/Politica.css" />
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

    <!--CONTEÚDO PRINCIPAL-->
    <section class="politicas">
        <h1>POLÍTICAS</h1>
        <p>
          <strong>Políticas de Compra e Entrega – Zypher Sneakers</strong><br><br>
          
          <strong>1. Compra:</strong><br>
          Ao comprar na Zypher Sneakers, você concorda com nossos termos e condições. Garantimos a segurança das suas transações.<br><br>
          
          <strong>2. Entrega:</strong><br>
          Os prazos de entrega variam conforme sua localização. Acompanhe seu pedido diretamente no site.<br><br>
          
          <strong>3. Trocas e Devoluções:</strong><br>
          Aceitamos trocas e devoluções em até 7 dias após o recebimento, desde que o produto esteja sem uso e na embalagem original.<br><br>
          
          <strong>4. Atendimento ao Cliente:</strong><br>
          Nosso time está disponível para dúvidas e suporte via chat ou e-mail.<br><br>
          
          <strong>5. Privacidade:</strong><br>
          Protegemos seus dados com segurança, garantindo a confidencialidade de suas informações.<br><br>
          
          Obrigado por escolher a Zypher Sneakers!
        </p>
      </section>

    <!--RODAPÉ-->
    <footer>
        <a href="/zypher/VIEWS/Politicas.php">Política de Privacidade</a> | 
        <a href="/zypher/VIEWS/Termos.php">Termos de Uso</a> | 
        <a href="/zypher/VIEWS/FaleConosco.php">Fale conosco</a>
        <p>&copy; 2025 Zypher Sneakers. Todos os direitos reservados.</p>
    </footer>
</body>
</html>