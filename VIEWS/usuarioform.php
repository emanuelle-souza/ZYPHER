<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Cadastro de usuário</title>
    <!-- ajuste o caminho se necessário -->
    <link rel="stylesheet" href="/zypher/CSS/cadastro.css">
</head>
<body>
    <div class="container">
        <div class="f1">
            <h1 class="title">CADASTRO</h1>
            <p class="text">
                Cadastre-se agora para acessar ofertas exclusivas, acompanhar seus pedidos e
                personalizar sua experiência de compra. É rápido, fácil e seguro!
            </p>

            <h4 class="subtitle">Preencha seus dados e comece agora:</h4>

            <div class="form-box">
                <form action="/zypher/saveusuario" method="POST" autocomplete="off">
                    <div class="input-group">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" required>
                    </div>

                    <div class="input-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="input-group">
                        <label for="telefone">Telefone:</label>
                        <input type="tel" id="telefone" name="telefone" required>
                    </div>

                    <div class="input-group">
                        <label for="cpf">CPF:</label>
                        <input type="text" id="cpf" name="cpf" required>
                    </div>

                    <div class="input-group">
                        <label for="senha">Senha:</label>
                        <input type="password" id="senha" name="senha" required>
                    </div>

                    <input class="submit-btn" type="submit" value="Cadastrar usuário">
                </form>

                <p class="text small">
                    <a href="/zypher/views/PoliticaCliente.php">Ao entrar, você concorda com nossos Termos de Uso e Política de Privacidade.</a>
                </p>
            </div>
        </div>

        <div class="f2">
            <!-- ajuste os paths das imagens se necessário -->
            <img src="/zypher/midia/LogoDeitado.png" alt="Logo Zypher" class="logo">
            <a href="/zypher/contato" class="ouvidoria-link" title="Suporte">
                <img src="/zypher/midia/ouvidoria.png" alt="Ouvidoria" class="ouvidoria-img">
            </a>
        </div>
    </div>
</body>
</html>
