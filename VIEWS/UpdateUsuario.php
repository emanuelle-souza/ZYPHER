<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Cadastro</title>
    <link rel="stylesheet" href="/cypher/views/css/*.css">
</head>
<body>

<h1>Atualizar Cadastro</h1>
<form action="/cypher/update_cadastro" method="POST">
    <input type="hidden" name="id_usuario" value="<?php echo $usuarioinfo['id_usuario']; ?>">

    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" value="<?php echo $usuarioinfo['nome']; ?>" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo $usuarioinfo['email']; ?>" required><br><br>

    <label for="telefone">Telefone:</label>
    <input type="text" id="telefone" name="telefone" value="<?php echo $usuarioinfo['telefone']; ?>" required><br><br>

    <label for="cpf">CPF:</label>
    <input type="number" id="cpf" name="cpf" value="<?php echo $usuarioinfo['cpf']; ?>"><br><br>

    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" value="<?php echo $usuarioinfo['senha']; ?>" required><br><br>

    <input type="submit" value="Atualizar Cadastro">
</form>

</body>
</html>