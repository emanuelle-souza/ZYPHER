<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore o Mundo dos Sneakers - Zypher Sneakers</title>
    <link rel="stylesheet" href="/zypher/CSS/Explorar.css">
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
                <a href="/zypher/views/PerfilUsuario.php" title="Meu Perfil">
                    <img src="/zypher/MIDIA/perfil.png" alt="perfil">
                </a>
            </div>
        </div>
        <nav class="menu">
            <a href="/zypher/views/Feminino.php">Feminino</a>
            <a href="/zypher/views/Masculino.php">Masculino</a>
            <a href="/zypher/views/Explorar.php">Explorar</a>
            <a href="/zypher/views/QuemSomos.php">Sobre nós</a>
        </nav>
    </header>

    <!-- Banner Principal -->
    <section class="banner">
        <div class="banner-content">
            <h1>Explore o Mundo dos Sneakers</h1>
            <p>Descubra curiosidades fascinantes, aprenda a cuidar dos seus tênis e<br>mantenha-os sempre impecáveis</p>
        </div>
    </section>

    <!-- Conteúdo Principal -->
    <main class="main-content">
        <div class="content-wrapper">
            <!-- Coluna Esquerda - Curiosidades -->
            <div class="left-column">
                <h2 class="section-title">
                    🎯 Curiosidades
                </h2>
                
                <!-- Card 1 -->
                <div class="curiosity-card">
                    <img src="https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=500" alt="A Origem dos Sneakers">
                    <div class="card-body">
                        <span class="badge-historia">História</span>
                        <h3>A Origem dos Sneakers</h3>
                        <p>O termo "sneaker" surgiu no fim do século XIX, alusão ao fato de borrowed permitiam às pessoas andar "sorrateiramente", sem fazer barulho.</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="curiosity-card">
                    <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500" alt="Air Technology">
                    <div class="card-body">
                        <span class="badge-tech">Tecnologia</span>
                        <h3>Air Technology</h3>
                        <p>A tecnologia Air da Nike foi inventada por um engenheiro aeroespacial da NASA em 1979, revolucionando o conforto nos calçados esportivos.</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="curiosity-card">
                    <img src="https://images.unsplash.com/photo-1556906781-9a412961c28c?w=500" alt="Colecionismo Milionário">
                    <div class="card-body">
                        <span class="badge-mercado">Mercado</span>
                        <h3>Colecionismo Milionário</h3>
                        <p>O mercado de sneakers raros movimenta mais de $6 bilhões ao ano globalmente, com alguns pares valendo milhões de dólares.</p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="curiosity-card">
                    <img src="https://images.unsplash.com/photo-1608231387042-66d1773070a5?w=500" alt="Sustentabilidade">
                    <div class="card-body">
                        <span class="badge-futuro">Futuro</span>
                        <h3>Sustentabilidade</h3>
                        <p>Marcas inovadoras estão usando materiais reciclados, com alguns tênis feitos de até 90% de plástico oceânico reciclado.</p>
                    </div>
                </div>
            </div>

            <!-- Coluna Central - Como Lavar -->
            <div class="center-column">
                <h2 class="section-title">
                    💧 Como Lavar
                </h2>

                <!-- Limpeza Básica -->
                <div class="wash-box">
                    <div class="wash-header">
                        <span class="wash-icon pink">🧼</span>
                        <h3>Limpeza Básica Regular</h3>
                    </div>
                    <ul class="wash-list">
                        <li><span class="bullet">1</span> Remova os cadarços e palmilhas antes de lavar</li>
                        <li><span class="bullet">2</span> Use uma escova macia com água morna e sabão neutro</li>
                        <li><span class="bullet">3</span> Evite máquina de lavar - pode danificar a cola e estrutura</li>
                        <li><span class="bullet">4</span> Seque à sombra a sombra, nunca ao sol direto</li>
                    </ul>
                </div>

                <!-- Manchas Difíceis -->
                <div class="wash-box">
                    <div class="wash-header">
                        <span class="wash-icon orange">🔥</span>
                        <h3>Manchas Difíceis</h3>
                    </div>
                    <ul class="wash-list">
                        <li><span class="bullet">1</span> Para sola branca: mistura de bicarbonato e água oxigenada</li>
                        <li><span class="bullet">2</span> Para tecido: sabão de coco e escova macia</li>
                        <li><span class="bullet">3</span> Para couro: pano úmido e hidratante específico</li>
                        <li><span class="bullet">4</span> Nunca use produtos químicos agressivos</li>
                    </ul>
                </div>

                <!-- Materiais Especiais -->
                <div class="wash-box">
                    <div class="wash-header">
                        <span class="wash-icon purple">⭐</span>
                        <h3>Materiais Especiais</h3>
                    </div>
                    <ul class="wash-list">
                        <li><span class="bullet">1</span> Camurça: escova específica e spray protetor</li>
                        <li><span class="bullet">2</span> Couro: hidratante e pomada incolor</li>
                        <li><span class="bullet">3</span> Mesh/tecido: limpeza delicada com água fria</li>
                        <li><span class="bullet">4</span> Nobuck: pano úmido e evite excesso de água</li>
                    </ul>
                </div>
            </div>

            <!-- Coluna Direita - Cuidados -->
            <div class="right-column">
                <h2 class="section-title">
                    ✅ Cuidados
                </h2>

                <!-- Cards de Cuidados -->
                <div class="care-card-small blue">
                    <span class="care-icon-small">📦</span>
                    <div class="care-content-small">
                        <h4>Armazenamento Correto</h4>
                        <p>Guarde em local arejado, longe de umidade e luz solar direta. Use boxes ou prateleiras.</p>
                    </div>
                </div>

                <div class="care-card-small purple">
                    <span class="care-icon-small">🔄</span>
                    <div class="care-content-small">
                        <h4>Rodízio de Tênis</h4>
                        <p>Evite usar o mesmo par todos os dias. Alterne entre 3 pares para prolongar a vida de cada um.</p>
                    </div>
                </div>

                <div class="care-card-small green">
                    <span class="care-icon-small">🛡️</span>
                    <div class="care-content-small">
                        <h4>Proteção Preventiva</h4>
                        <p>Use spray impermeabilizante regularmente, especialmente antes da primeira vez de usar.</p>
                    </div>
                </div>

                <div class="care-card-small orange">
                    <span class="care-icon-small">👖</span>
                    <div class="care-content-small">
                        <h4>Palmilhas e Cadarços</h4>
                        <p>Troque palmilhas a cada 3-6 meses para manter o conforto e higiene. Cadarços podem ser lavados.</p>
                    </div>
                </div>

                <!-- Checklist -->
                <div class="checklist-box">
                    <h3>✓ Checklist Diário</h3>
                    <label><input type="checkbox"> Remova sujeiras após o uso</label>
                    <label><input type="checkbox"> Deixar arejar por 24h</label>
                    <label><input type="checkbox"> Limpar sujeiras superficiais</label>
                    <label><input type="checkbox"> Guardar em local apropriado</label>
                </div>

                <!-- Galeria de Imagens -->
                <div class="image-gallery">
                    <img src="https://images.unsplash.com/photo-1605348532760-6753d2c43329?w=400" alt="Sneakers 1">
                    <img src="https://images.unsplash.com/photo-1600185365926-3a2ce3cdb9eb?w=400" alt="Sneakers 2">
                </div>
            </div>
        </div>
    </main>


     <!-- Seção de Vídeos -->
    <section class="video-section">
        <div class="video-container">
            <h2 class="video-title">Aprenda com Nossos Vídeos</h2>
            <div class="video-grid">
                <!-- Vídeo 1 -->
                 <a href="https://www.youtube.com/watch?v=xVIBYWCo6C8" target="_blank" class="video-link">
                <div class="video-card">
                    <div class="video-thumbnail">
                        <img src="https://images.unsplash.com/photo-1556906781-9a412961c28c?w=600" alt="Como Lavar Tênis">
                        <button class="play-button">▶</button>
                    </div>
                    <div class="video-info">
                        <h3>Como Lavar Tênis Corretamente</h3>
                        <p> Passo a passo e técnicas profissionais de limpeza para manter seus sneakers sempre novos, confira aqui!</p>
                    </div>
                </div>
                </a>

                <!-- Vídeo 2 -->
                 <a href="https://www.youtube.com/watch?v=KCOq8myLAVc" target="_blank" class="video-link">
                <div class="video-card">
                    <div class="video-thumbnail">
                        <img src="https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=600" alt="Cuidados Essenciais">
                        <button class="play-button">▶</button>
                    </div>
                    <div class="video-info">
                        <h3>Venha conhecer os tênis sustentáveis</h3>
                        <p>Tênis ecológicos da Nike utilizam couro reciclado e tinta vegetal. Curadoria: Bernardo Gradin, especialista em soluções sustentáveis</p>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Rodapé -->
    <footer>
        <a href="/zypher/VIEWS/Politicas.php">Política de Privacidade</a> | 
        <a href="/zypher/VIEWS/Termos.php">Termos de Uso</a> | 
        <a href="/zypher/VIEWS/FaleConosco.php">Fale conosco</a>
        <p>&copy; 2025 Zypher Sneakers. Todos os direitos reservados.</p>
    </footer>
</body>
</html>