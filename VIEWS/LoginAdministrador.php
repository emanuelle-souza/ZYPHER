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
    <link rel="stylesheet" href="/zypher/CSS/LoginAdm.css">
</head>
<body>
    <div class="container">
        <div class="f1">
        <h1 class="title">LOGIN ADM</h1>
        <br>
        <h3 class ="text">Bem-vindo de volta! Faça login para acessar sua conta administrativa!.</h3>
       
        <div class="form-box">
    <form action="/zypher/loginAdministrador" method="POST">
        <div class="input-group">
            <input type="name" id="nome" name="nome" placeholder="Nome" required>
        </div>
        <div class="input-group">
            <input type="email" id="email" name="email" placeholder="E-mail" required>
        </div>
        <div class="input-group">
            <input type="password" id="senha" name="senha" placeholder="Senha" required>
        </div>
        <button type="submit" class="btn-login">ENTRE</button>
    </form>
</div>
        <p class= "text"><a href="/zypher/views/PoliticaCliente.php">Ao entrar, você concorda com nossos Termos de Uso e Política de Privacidade.</a></p>

    </div>


    <div class="f2">
        <img src="/zypher/midia/LogoDeitado.png" class="logo">
         <a href="/zypher/views/FaleConosco.php" class="ouvidoria" ><img src="/zypher/midia/ouvidoria.png"></a>
        
    </div>
    </div>
</div>
</body>
</html>