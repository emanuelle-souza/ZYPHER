<h2>Adicionar Giftcard</h2>
<form method="POST" action="/codigoprojeto/adicionar-giftcard">
    <label>Código:</label><br>
    <input type="text" name="codigo" required><br>

    <label>Saldo (R$):</label><br>
    <input type="number" name="saldo" step="0.01" required><br>

    <label>Data de Expiração:</label><br>
    <input type="date" name="expiracao" required><br><br>

    <button type="submit">Adicionar Giftcard</button>
</form>