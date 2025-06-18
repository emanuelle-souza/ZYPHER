<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de usuario</title>
    <link rel="stylesheet" href="/cypher/views/css/cadastro.css">
</head>
<body>
    <div class="container">
    <div class="f1">
        <h1 class="title">CADASTRO</h1>
        <p class ="text"> Cadastre-se agora para acessar ofertas exclusivas, acompanhar seus pedidos e 
        <br>personalizar sua experiência de compra. É rápido, fácil e seguro!</p>
        <h4>Preencha seus dados e comece agora:</h4>
        <div class="form-box">
        <form action="/cypher/salvausuario" method="POST">
        <div class="input-group">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required><br><br>
        </div>
        <div class="input-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
        </div>
        <div class="input-group">
            <label for="telefone">Telefone:</label>
            <input type="number" id="telefone" name="telefone" required><br><br>
        </div>
        <div class="input-group">
            <label for="cpf">CPF:</label>
            <input type="number" id="cpf" name="cpf" required><br><br>
        </div>
        <div class="input-group">
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required><br><br>
        </div>
            
            <input class="submit-btn" type="submit" value="Cadastrar usuario">
        </form>
    <p class= "text"><a href="">Ao entrar, você concorda com nossos Termos de Uso e Política de Privacidade.</a></p>
</div></div>
 <div class="f2">
        <img src="/cypher/public/assets/midia/ouvidoria.png" class="ouvidoria">
        <img src="/cypher/public/assets/midia/logo.png" class="logo">
    </div>

</body>
</html>