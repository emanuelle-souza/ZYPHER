<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Endereço</title>
</head>
<body>

<h1>Atualizar Endereço</h1>
<form action="/codigoprojeto/update_endereco" method="POST">
    <input type="hidden" name="id_usuario" value="<?php echo $usuarioinfo['id_usuario']; ?>">

    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" value="<?php echo $usuarioinfo['nome']; ?>" required><br><br>

    <label for="telefone">Telefone:</label>
    <input type="text" id="telefone" name="telefone" value="<?php echo $usuarioinfo['telefone']; ?>" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo $usuarioinfo['email']; ?>" required><br><br>

    <label for="cep">CEF:</label>
    <input type="number" id="cep" name="cep" value="<?php echo $usuarioinfo['cep']; ?>"><br><br>

    <label for="endereco_entrega">Endereço entrega:</label>
    <input type="text" id="endereco_entrega" name="endereco_entrega" value="<?php echo $usuarioinfo['endereco_entrega']; ?>" required><br><br>

    <label for="numero">Número:</label>
    <input type="number" id="numero" name="numero" value="<?php echo $usuarioinfo['numero']; ?>"><br><br>

    <label for="cidade">Cidade:</label>
    <input type="text" id="cidade" name="cidade" value="<?php echo $usuarioinfo['cidade']; ?>"><br><br>

    <label for="estado">Estado:</label>
    <input type="text" id="estado" name="estado" value="<?php echo $usuarioinfo['estado']; ?>"><br><br>

    <input type="submit" value="Atualizar Endereço">
</form>

</body>
</html>