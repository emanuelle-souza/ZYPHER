<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários Cadastrados</title>
    <link rel="stylesheet" href="/cypher/views/css/*.css">
</head>
<body>

<h1>Usuários Cadastrados</h1>
<table border="1">
    <tr>
        <th>Nome </th>
        <th>E-mail</th>
        <th>Telefone</th>
        <th>CPF</th>
        <th>Endereço</th>

    </tr>
    <?php foreach ($usuarios as $usuario): ?>
    <tr>
        <td><?php echo $usuario['nome']; ?></td>
        <td><?php echo $usuario['email']; ?></td>
        <td><?php echo $usuario['telefone']; ?></td>
        <td><?php echo $usuario['cpf']; ?></td>
        <td><?php echo $usuario['endereco']; ?></td>
        
        <td>
            <a href="/zypher-main/update-usuario/<?php echo $usuario['id_usuario']; ?>">Atualizar</a>
            <form action="/cypher/delete-usuario" method="POST" style="display:inline;">
                <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">
                <button type="submit">Excluir</button>
            </form>
        </td>
    </tr>

        
    <?php endforeach; ?>
</table>

</body>
</html>