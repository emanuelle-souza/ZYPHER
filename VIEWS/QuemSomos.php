<?php
// Página estática "Quem Somos" para o projeto Zypher
// Local: VIEWS/QuemSomos.php
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quem Somos - Zypher Sneakers</title>
    <!-- Ajustei o caminho do CSS para a pasta CSS do projeto -->
    <link rel="stylesheet" href="../CSS/menu.css">
    <style>
        /* Layout específico da página Quem Somos, mantendo identidade visual */
        html, body { height: 100%; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; display: flex; flex-direction: column; min-height: 100vh; }
        main { flex: 1 0 auto; }
        .sobre-wrapper { max-width: 1100px; margin: 36px auto; display: flex; gap: 0; align-items: stretch; }
        .sobre-conteudo { background: #f0f0f0; padding: 64px 64px; flex: 1; box-sizing: border-box; display: flex; flex-direction: column; justify-content: center; }
        .sobre-conteudo h1 { font-size: 48px; color: #223a5e; margin: 0 0 24px 0; letter-spacing: 1px; }
        .sobre-conteudo p { color: #7b7b7b; line-height: 1.8; font-size: 18px; max-width: 640px; margin: 0 auto; text-align: center; }

        .coluna-equipe { width: 360px; background: #0b0b0b; color: #fff; padding: 40px 36px; box-sizing: border-box; display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start; position: relative; }
        .coluna-equipe h2 { font-size: 44px; margin: 8px 0 26px 0; align-self: center; letter-spacing: 2px; }
        .membro { display: flex; gap: 18px; align-items: center; margin: 18px 0; width: 100%; }
        .membro .box { width: 56px; height: 56px; background: #d9d9d9; border-radius: 2px; flex-shrink: 0; }
        .membro span { color: #e9e9e9; font-size: 18px; font-weight: 600; letter-spacing: 1px; }
        .membro:last-child .box { background: #9b9b9b; }

    /* Ícone de fone no canto inferior direito da coluna preta */
    .coluna-equipe .fone { position: absolute; right: 18px; bottom: 18px; opacity: 0.95; }

    /* Footer styles moved to global CSS (CSS/menu.css) */

        @media (max-width: 980px) {
            .sobre-wrapper { flex-direction: column; max-width: 900px; }
            .coluna-equipe { width: 100%; order: 2; padding: 28px; }
            .sobre-conteudo { padding: 36px 24px; order: 1; }
            .sobre-conteudo h1 { font-size: 34px; }
        }
    </style>
</head>
<body>
    <?php include 'inc/header.php'; ?>

    <main>
        <div class="sobre-wrapper">
            <section class="sobre-conteudo">
                <h1>QUEM SOMOS?</h1>
                <p>
                    A Zypher Sneakers nasceu da paixão pelo streetwear e da busca por inovação no mundo dos tênis. Criamos modelos que unem estilo, conforto e tecnologia, proporcionando uma experiência única a cada passo. Nosso compromisso é oferecer produtos de alta qualidade, design autêntico e que expressem a individualidade de quem os usa. Seja para o dia a dia ou para momentos especiais, a Zypher Sneakers é mais do que um tênis – é uma atitude. Explore, experimente e faça parte dessa revolução!
                </p>
            </section>
            <aside class="coluna-equipe">
                <h2>EQUIPE</h2>
                <div class="membro"><div class="box"></div><span>EMANUELLE</span></div>
                <div class="membro"><div class="box"></div><span>KAYLANE</span></div>
                <div class="membro"><div class="box"></div><span>MARIA JULIA</span></div>
                <div class="membro"><div class="box"></div><span>MIGUEL. Z</span></div>
                <div class="membro"><div class="box"></div><span>PEDRO. W</span></div>

                <div class="fone">
                    <!-- Headphone icon similar to image -->
                    <svg width="56" height="56" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C7.03 2 3 6.03 3 11v5a3 3 0 0 0 3 3h1a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1H6v-1a6 6 0 0 1 12 0v1h-1a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h1a3 3 0 0 0 3-3v-5c0-4.97-4.03-9-9-9z" fill="#ffffff" opacity="0.95"/>
                    </svg>
                </div>
            </aside>
        </div>
    </main>

    <?php include 'inc/footer.php'; ?>
</body>
</html>
