<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN FUNCIONÁRIO</title>
    <link rel="stylesheet" href="/cypher/views/css/*.css">
</head>
<body>
    <h1>LOGIN FUNCIONÁRIO</h1>
    <form action="/cypher/login-funcionario" method="POST">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br>

        <a href="/cypher/views/recuperar_senha.php">ESQUECEU SENHA?</a><br><br>

        <input type="submit" value="ENTRAR"><br><br>
    </form>

</body>
</html>