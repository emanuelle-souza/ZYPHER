<?php
// VIEWS/Explorar.php - Página "Explorar" com layout de três colunas similar à imagem fornecida
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Explorar - Zypher Sneakers</title>
    <link rel="stylesheet" href="../CSS/menu.css">
    <style>
        /* Estilos específicos da página Explorar (mantendo identidade visual) */
        body { font-family: Arial, sans-serif; background:#fafafa; margin:0; padding:0; }
        main { max-width:1200px; margin:24px auto; padding:0 16px; }
        .explorar-grid { display:flex; gap:20px; align-items:flex-start; }
        .col { flex:1; background:#fff; padding:18px; box-sizing:border-box; border-left:2px solid rgba(34,58,94,0.08); border-right:2px solid rgba(34,58,94,0.08); }
        .col:first-child { border-left: none; }
        .col:last-child { border-right: none; }

        /* Coluna esquerda - Como lavar seu tênis */
        .col-esquerda img.thumb { width:120px; height:auto; display:block; margin-bottom:12px; }
        .como-lavar h3 { margin:0 0 10px 0; color:#223a5e; }
        .como-lavar ol { padding-left:20px; color:#444; }
        .como-lavar li { margin-bottom:8px; line-height:1.5; }

        /* Coluna central - Curiosidades */
        .curiosidades h3 { text-align:center; color:#223a5e; margin:0 0 14px 0; }
        .curiosidades p { text-align:center; color:#666; line-height:1.7; }
        .curiosidades .gallery { display:flex; flex-direction:column; gap:12px; align-items:center; margin-top:14px; }
        .curiosidades .gallery img { width:220px; height:auto; border-radius:4px; box-shadow:0 2px 6px rgba(0,0,0,0.08); }

        /* Coluna direita - Cuidados */
        .cuidados h3 { margin:0 0 10px 0; color:#223a5e; text-align:right; }
        .cuidados p { text-align:justify; color:#444; line-height:1.6; }
        .cuidados .small-images { display:flex; gap:8px; justify-content:flex-end; margin-top:12px; }
        .cuidados .small-images img { width:72px; height:auto; border-radius:4px; }

        /* Footer spacing */
        footer { margin-top:24px; }

        @media (max-width:980px) {
            .explorar-grid { flex-direction:column; }
            .col { border-left:none; border-right:none; }
            .curiosidades .gallery img { width:90%; }
            .col { padding:14px; }
        }
    </style>
</head>
<body>

<?php include 'inc/header.php'; ?>

<main>
    <div class="explorar-grid">
        <aside class="col col-esquerda">
            <img class="thumb" src="../MIDIA/banner.png" alt="Como lavar seu tênis">
            <div class="como-lavar">
                <h3>Como lavar seu tênis?</h3>
                <ol>
                    <li>Remova cadarços e palmilhas.</li>
                    <li>Limpe com uma escova ou pano úmido.</li>
                    <li>Lave à mão com água morna e sabão neutro.</li>
                    <li>Enxágue bem e retire o excesso de água.</li>
                    <li>Deixe secar à sombra. Simples e eficaz!</li>
                </ol>
            </div>
        </aside>

        <section class="col curiosidades">
            <h3>CURIOSIDADES</h3>
            <p>Muitos jogadores famosos já escolheram nossos tênis, que unem estilo, conforto e performance, refletindo a dedicação dos grandes atletas.</p>
            <div class="gallery">
                <img src="../MIDIA/FlipZypher.png" alt="Jogador em quadra">
                <img src="../MIDIA/tenis-preto.png" alt="Tênis em close">
            </div>
        </section>

        <aside class="col cuidados">
            <h3>CUIDADOS</h3>
            <p>
                Para cuidar bem dos seus tênis, limpe-os regularmente com um pano úmido, evite exposição direta ao sol e guarde-os em locais secos. Use protetores para manter o formato e siga as instruções de lavagem do fabricante para garantir maior durabilidade.
            </p>
            <div class="small-images">
                <img src="../MIDIA/faleconosco.png" alt="Contato">
                <img src="../MIDIA/image.png" alt="Produto destaque">
            </div>
        </aside>
    </div>
</main>

<?php include 'inc/footer.php'; ?>

</body>
</html>
