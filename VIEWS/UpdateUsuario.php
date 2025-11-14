<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atualizar Cadastro</title>
  <link rel="stylesheet" href="/zypher/CSS/perfil-atualizar.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<div class="perfil-container">

  <!-- CARD PRINCIPAL -->
  <div class="form-card polido">
    
    <!-- TÍTULO CENTRALIZADO -->
    <h1 class="titulo-central">Atualizar Cadastro</h1>

    <!-- FORMULÁRIO -->
    <form action="/zypher/saveusuario" method="POST" class="form-content">
      <input type="hidden" name="id_usuario">

      <!-- NOME -->
      <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" placeholder="Nome completo">
      </div>

      <!-- EMAIL -->
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="seu@email.com">
      </div>

      <!-- TELEFONE + CPF -->
      <div class="form-row">
        <div class="form-group half">
          <label for="telefone">Telefone</label>
          <input type="text" id="telefone" name="telefone" placeholder="(11) 98765-4321">
        </div>
        <div class="form-group half">
          <label for="cpf">CPF</label>
          <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00">
        </div>
      </div>

      <!-- SENHA -->
      <div class="form-group">
        <label for="senha">Nova Senha</label>
        <input type="password" id="senha" name="senha" placeholder="Deixe em branco para manter atual">
      </div>

      <!-- BOTÃO -->
      <button type="submit" class="btn-salvar">
        <i class="bi bi-check2"></i> Atualizar Cadastro
      </button>
    </form>
  </div>

</div>

</body>
</html>