<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de endereço</title>
    <link rel="stylesheet" href="/cypher/views/css/endeform.css">
</head>
<body>
    <div class="container">
    <div class="f1">
        <h1 class="title">ENDEREÇO</h1>
        <p class ="text"></h4>
        <div class="form-box">
        <form action="/codigoprojeto/salvaendereco" method="POST">
        <div class="input-group">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required><br><br>
        </div>
        <div class="input-group">
            <label for="telefone">Telefone:</label>
            <input type="number" id="telefone" name="telefone" required><br><br>
        </div>
        <div class="input-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
        </div>
        <div class="input-group">
            <label for="cep">Cep:</label>
            <input type="number" id="cep" name="cep" required><br><br>
        </div>
        <div class="input-group">
            <label for="endereco_entrega">Endereco de entrega:</label>
            <input type="text" id="endereco_entrega" name="endereco_entrega" required><br><br>
        </div>
        <div class="input-group">
            <label for="numero">Número:</label>
            <input type="number" id="numero" name="numero" required><br><br>
        </div>
        <div class="input-group">
            <label for="cidade">Cidade:</label>
            <input type="text" id="cidade" name="cidade" required><br><br>
        </div>
        <div class="input-group">
            <label for="estado">Estado:</label>
            <input type="text" id="estado" name="estado" required><br><br>
        </div>
            
            <input class="submit-btn" type="submit" value="Cadastrar endereço">
        </form>
    <p class= "text"><a href="">Ao cadastrar, você concorda com nossos Termos de Uso e Política de Privacidade.</a></p>
</div></div>
 <div class="f2">
        <img src="/cypher/public/assets/midia/ouvidoria.png" class="ouvidoria">
        <img src="/cypher/public/assets/midia/logo.png" class="logo">
    </div>

</body>
</html>