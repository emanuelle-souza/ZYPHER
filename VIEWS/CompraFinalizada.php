<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: LoginCliente.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Compra Finalizada | Zypher Sneakers</title>
<link rel="icon" href="/zypher/MIDIA/coroa.png">
<link rel="stylesheet" href="/zypher/CSS/CompraFinalizada.css">
</head>
<body>

<div class="container" id="compra-container">
    <img src="/zypher/MIDIA/LogoDeitado.png" alt="Zypher Sneakers" class="logo">

    <div id="processo-compra">
        <p class="loading">Processando pagamento...</p>
        <div class="spinner"></div>
    </div>

    <div id="compra-finalizada" style="display: none;">
        <h1>✅ Compra Realizada!</h1>
        <p>Rastreie seu pedido com o código:</p>
        <div class="codigo" id="codigo-rastreio">---</div>
        <p>Enviamos os detalhes para seu e-mail cadastrado.</p>
        <button class="btn" onclick="window.location.href='/zypher/views/HomeCliente.php'">Voltar à loja</button>
    </div>
</div>

<script>
    // Simulação de processamento
    setTimeout(() => {
        const codigo = gerarCodigoRastreio();
        document.getElementById("processo-compra").style.display = "none";
        document.getElementById("compra-finalizada").style.display = "block";
        document.getElementById("codigo-rastreio").textContent = codigo;
    }, 2500); // tempo simulado de processamento

    // Gera um código de rastreio aleatório
    function gerarCodigoRastreio() {
        const letras = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        const numeros = Math.floor(100000 + Math.random() * 900000);
        const prefixo = letras.charAt(Math.floor(Math.random() * letras.length)) + letras.charAt(Math.floor(Math.random() * letras.length));
        return prefixo + numeros;
    }
</script>

</body>
</html>
