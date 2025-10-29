<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login?msg=precisa-logar");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Endereço de Entrega - Zypher Sneakers</title>
    <link rel="stylesheet" href="/zypher/CSS/checkout.css">
</head>
<body>
    <header>
        <div class="logo-topo">
            <a href="/zypher/views/HomeCliente.php"><img src="/zypher/MIDIA/logo.png" alt="Zypher Sneakers"></a>
        </div>
    </header>

    <main class="container-endereco">
        <div class="card-endereco">
            <h2>Formulário de Endereço</h2>
            <form action="Pagamento.php" method="POST" id="formEndereco">
                <label>Nome completo:</label>
                <input type="text" name="nome" required>

                <label>Telefone:</label>
                <input type="text" name="telefone" required placeholder="(11) 99999-9999">

                <label>E-mail:</label>
                <input type="email" name="email" required>

                <label>CEP:</label>
                <input type="text" name="cep" id="cep" maxlength="9" required placeholder="00000-000">

                <label>Endereço de Entrega:</label>
                <input type="text" name="endereco" id="endereco" required>

                <div class="linha-campos">
                    <div>
                        <label>N°:</label>
                        <input type="text" name="numero" required>
                    </div>
                    <div>
                        <label>Cidade:</label>
                        <input type="text" name="cidade" id="cidade" required>
                    </div>
                    <div>
                        <label>Estado:</label>
                        <input type="text" name="estado" id="estado" required>
                    </div>
                </div>

                <button type="submit" class="btn-enviar">CONTINUAR PARA PAGAMENTO</button>
            </form>
        </div>
    </main>

    <script>
    // Auto preencher endereço via ViaCEP
    document.getElementById('cep').addEventListener('blur', async function() {
        const cep = this.value.replace(/\D/g, '');
        if (cep.length === 8) {
            const resposta = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            const dados = await resposta.json();
            if (!dados.erro) {
                document.getElementById('endereco').value = dados.logradouro || '';
                document.getElementById('cidade').value = dados.localidade || '';
                document.getElementById('estado').value = dados.uf || '';
            } else {
                alert('CEP não encontrado.');
            }
        }
    });
    </script>
</body>
</html>
