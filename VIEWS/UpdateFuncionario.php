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
    <input type="hidden" name="id_funcionario" value="<?php echo $funcionarioinfo['id_funcionario']; ?>">

    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" value="<?php echo $funcionarioinfo['nome']; ?>" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo $funcionarioinfo['email']; ?>" required><br><br>

    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" value="<?php echo $funcionarioinfo['senha']; ?>" required><br><br>

    <input type="submit" value="Atualizar Cadastro">
</form>

</body>
</html>