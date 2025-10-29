<?php

if (!isset($_SESSION)) {
    session_start();
}
?>
 
 <!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login cliente</title>
    <link rel="stylesheet" href="/zypher/CSS/LoginCliente.css">
</head>
<body>
    <div class="container">
        <div class="f1">
        <h1 class="title">LOGIN</h1>
        <br><br><br>
        <h3 class ="text">Bem-vindo à Zypher Sneakers! Faça login para acessar as últimas novidades, promoções exclusivas e aproveitar a melhor experiência de compra.</h3>
       
        <div class="form-box">
    <form action="/zypher/loginUsuario" method="POST">
        <div class="input-group">
            <input type="email" id="email" name="email" placeholder="E-mail" required>
        </div>
        <div class="input-group">
            <input type="password" id="senha" name="senha" placeholder="Senha" required>
        </div>
        <div class="links">
            <a href="/zypher/views/RecuperarSenha.php">ESQUECEU A SENHA?</a>
        </div>
        <button type="submit" class="btn-login">ENTRE</button>
    </form>
</div>

        <p class="CADASTRO"><a href="/zypher/views/usuarioform.php">CADASTRAR-SE</a></p>
       
        <p class="MEMBRO"><a href="/zypher/views/SejaMembro.php">SOU MEMBRO</a></p>

        <p class= "text"><a href="/zypher/views/PoliticaCliente.php">Ao entrar, você concorda com nossos Termos de Uso e Política de Privacidade.</a></p>

    </div>


    <div class="f2">
        <img src="/zypher/midia/LogoDeitado.png" class="logo">
        <img src="/zypher/midia/ouvidoria.png" class="ouvidoria">
    </div>
    </div>
</div>
</body>
</html>
 
 
 
 
 
 
 
 
 
 
