<?php
if (!isset($_SESSION)) {
    session_start();
}

$usuarioLogado = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : null;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós - Zypher Sneakers</title>
    <link rel="stylesheet" href="/zypher/CSS/SobreNos.css">
</head>
<body>
     <!-- Cabeçalho / Menu -->
    <header>
        <div class="topo">
  <div class="logo">
                <a href="<?php 
    echo (isset($_SESSION['membro']) && $_SESSION['membro']) 
        ? '/zypher/VIEWS/HomeMembro.php' 
        : '/zypher/VIEWS/HomeCliente.php'; 
?>">
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
            <a href="/zypher/views/Feminino.php">Feminino</a>
            <a href="/zypher/views/Masculino.php">Masculino</a>
            <a href="/zypher/views/Explorar.php">Explorar</a>
            <a href="/zypher/views/QuemSomos.php">Sobre nós</a>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Sobre a Zypher Sneakers</h1>
            <p>Conforto que te leva além</p>
        </div>
    </section>

    <!-- Nossa História -->
    <section class="historia">
        <div class="container">
            <div class="section-header">
                <h2>Nossa História</h2>
                <div class="divider"></div>
            </div>
            
            <div class="texto-historia">
                <p>
                    A <strong>Zypher Sneakers</strong> nasceu da paixão por tênis e do desejo de oferecer 
                    produtos de qualidade excepcional para todos os estilos de vida. Desde 2020, temos 
                    nos dedicado a trazer as melhores marcas e modelos para nossos clientes.
                </p>
                <p>
                    Acreditamos que o calçado certo pode transformar não apenas seu visual, mas toda 
                    sua experiência diária. Por isso, selecionamos cuidadosamente cada produto em nosso 
                    catálogo, priorizando conforto, durabilidade e estilo.
                </p>
                <p>
                    Hoje, atendemos milhares de clientes em todo o Brasil, sempre com o compromisso de 
                    oferecer a melhor experiência de compra e produtos que realmente fazem a diferença 
                    no dia a dia.
                </p>
            </div>
        </div>
    </section>

    <!-- Nossos Valores -->
    <section class="valores">
        <div class="container">
            <div class="section-header">
                <h2>Nossos Valores</h2>
                <div class="divider"></div>
            </div>

            <div class="grid-valores">
                <div class="card-valor">
                    <div class="icone-valor icone-paixao">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                        </svg>
                    </div>
                    <h3>Paixão</h3>
                    <p>Amamos o que fazemos e isso se reflete em cada produto que oferecemos</p>
                </div>

                <div class="card-valor">
                    <div class="icone-valor icone-qualidade">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <circle cx="12" cy="12" r="6"/>
                            <circle cx="12" cy="12" r="2"/>
                        </svg>
                    </div>
                    <h3>Qualidade</h3>
                    <p>Selecionamos apenas produtos que atendem nossos altos padrões de excelência</p>
                </div>

                <div class="card-valor">
                    <div class="icone-valor icone-inovacao">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="6"/>
                            <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
                        </svg>
                    </div>
                    <h3>Inovação</h3>
                    <p>Sempre em busca das últimas tendências e tecnologias em calçados</p>
                </div>

                <div class="card-valor">
                    <div class="icone-valor icone-comunidade">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <h3>Comunidade</h3>
                    <p>Valorizamos cada cliente e construímos relações duradouras</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Estatísticas -->
    <section class="estatisticas">
        <div class="container">
            <div class="grid-stats">
                <div class="stat">
                    <p class="numero">5+</p>
                    <p class="label">Anos de Experiência</p>
                </div>
                <div class="stat">
                    <p class="numero">50k+</p>
                    <p class="label">Clientes Satisfeitos</p>
                </div>
                <div class="stat">
                    <p class="numero">1000+</p>
                    <p class="label">Produtos Vendidos</p>
                </div>
                <div class="stat">
                    <p class="numero">98%</p>
                    <p class="label">Taxa de Satisfação</p>
                </div>
            </div>
        </div>
    </section>

     <footer>
    <a href="/zypher/VIEWS/Politicas.php">Política de Privacidade</a> | 
    <a href="/zypher/VIEWS/Termos.php">Termos de Uso</a> | 
    <a href="/zypher/VIEWS/FaleConosco.php">Fale conosco</a>
    <p>&copy; 2025 Zypher Sneakers. Todos os direitos reservados.</p>
</footer>

</body>
</html>