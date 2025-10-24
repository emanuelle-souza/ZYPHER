<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seja Membro - Zypher</title>
    <link rel="stylesheet" href="/zypher/CSS/SejaMembro.css">
</head>
<body>
    <div class="membro-container">

        <!-- Seção esquerda -->
        <div class="membro-esquerda">
            <div class="logo-area">
                <img src="/zypher/MIDIA/Logo.png" alt="Logo Zypher" class="logo">
                <h2>Seja Membro</h2>
            </div>

            <div class="form-card">
                <h3>Cadastro aos Membros</h3>

                <form action="../CONTROLLERS/CadastroMembro.php" method="POST" class="formulario">
                    <input type="text" name="nome" placeholder="Nome" required>
                    <input type="text" name="sobrenome" placeholder="Sobrenome" required>
                    <input type="text" name="cpf" placeholder="CPF" maxlength="14" required>
                    <input type="text" name="data" placeholder="00/00/0000" required>
                    <input type="email" name="email" placeholder="E-mail" required>
                    <input type="password" name="senha" placeholder="Senha" minlength="6" required>

                    <button type="submit">Enviar</button>
                </form>

                <p class="cadastro-texto">Novo por aqui? <a href="#">Assine agora.</a></p>
            </div>
        </div>

        <!-- Seção direita -->
        <div class="membro-direita">
            <img src="/zypher/MIDIA/banner-membro.png" alt="Banner Membro" class="banner-img">

            <div class="info-box">
                <div class="info-text">
                    <p>Valor de <strong>R$ 336,99</strong> ao ano.</p>
                    <p>
                        Acesso à plataforma exclusiva para membros.<br>
                        Acesso antecipado a lançamentos.<br>
                        Descontos imperdíveis!
                    </p>
                    <div class="ouvidoria"><a href="#"><img src="/zypher/MIDIA/ouvidoria.png" alt="ouvidoria" class="ouvidoria"></a></div>
                </div>
            </div>

            <footer>
                <p>Copyright © 2025 Zypher Inc. Todos os direitos reservados.</p>
                <p>Lojas Zypher · CNPJ: 62.555.688/0001-37</p>
                <p>Av. Prefeito Jesuíno Ray, Salto - SP · 13325-620</p>
                <div class="links">
                    <a href="#">Política de privacidade</a> |
                    <a href="#">Termos e condições</a>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>
