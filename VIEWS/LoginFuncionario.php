<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN FUNCIONÁRIO</title>
    <link rel="stylesheet" href="/zypher/CSS/LoginFuncionario.css">
</head>
<body>
  <body>
    <div class="container">
        <div class="f1">
        <h1 class="title">LOGIN FUNCIONÁRIO</h1>
        <br>
        <h3 class ="text">Bem-vindo à Zypher Sneakers! Faça login para editar as últimas novidades e lançar promoções exclusivas para clientes.</h3>
       
        <div class="form-box">
    <form action="/zypher/loginFuncionario" method="POST">
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

        <p class= "text"><a href="/zypher/views/PoliticaCliente.php">Ao entrar, você concorda com nossos Termos de Uso e Política de Privacidade.</a></p>

    </div>


    <div class="f2">
        <img src="/zypher/midia/LogoDeitado.png" class="logo">
        
    </div>
    </div>
</div>
</body>
</html>