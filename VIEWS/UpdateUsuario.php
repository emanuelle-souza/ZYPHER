<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Cadastro</title>
    <link rel="stylesheet" href="/zypher/views/css/*.css">
</head>
<body>

<h1>Atualizar Cadastro</h1>
<form action="/zypher/saveusuario" method="POST">
    <input type="hidden" name="id_usuario">

    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome"><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email"><br><br>

    <label for="telefone">Telefone:</label>
    <input type="text" id="telefone" name="telefone"><br><br>

    <label for="cpf">CPF:</label>
    <input type="number" id="cpf" name="cpf"><br><br>

    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha"><br><br>

    <input type="submit" value="Atualizar Cadastro" href="PerfilUsuario.php" >
</form>

</body>
</html>