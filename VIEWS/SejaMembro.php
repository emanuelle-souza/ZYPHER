<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seja Membro - Zypher</title>
    
    <!-- Conexão com o CSS -->
    <link rel="stylesheet" href="../zypher/CSS/LoginMembro.css">
</head>
<body>
    <div class="container">
        
        <!-- Lado esquerdo (formulário) -->
        <div class="f1">
            <h1 class="title">SEJA MEMBRO</h1>
            
            <form class="form-box" action="../CONTROLLERS/CadastroMembro.php" method="POST">
                
                <div class="input-group">
                    <label for="nome">NOME COMPLETO:</label>
                    <input 
                        type="text" 
                        id="nome" 
                        name="nome" 
                        placeholder="Digite seu nome completo" 
                        required
                    >
                </div>
                
                <div class="input-group">
                    <label for="cpf">CPF:</label>
                    <input 
                        type="text" 
                        id="cpf" 
                        name="cpf" 
                        placeholder="000.000.000-00" 
                        maxlength="14"
                        required
                    >
                </div>
                
                <div class="input-group">
                    <label for="telefone">TELEFONE:</label>
                    <input 
                        type="tel" 
                        id="telefone" 
                        name="telefone" 
                        placeholder="(00) 00000-0000" 
                        maxlength="15"
                        required
                    >
                </div>
                
                <div class="input-group">
                    <label for="email">E-MAIL:</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="seuemail@exemplo.com" 
                        required
                    >
                </div>
                
                <div class="input-group">
                    <label for="senha">SENHA:</label>
                    <input 
                        type="password" 
                        id="senha" 
                        name="senha" 
                        placeholder="Digite sua senha" 
                        minlength="6"
                        required
                    >
                </div>
                
                <button type="submit" class="submit-btn">ENVIAR</button>
            </form>
            
            <p class="text">
                Já possui uma conta? <a href="LoginMembro.php">Faça login</a>
            </p>
        </div>
        
        <!-- Lado direito (painel azul com logo) -->
        <div class="f2">
            <img src="../MIDIA/LogoDeitado.png" alt="Logo Zypher" class="logo">
            <img src="../MIDIA/Ouvidoria.png" alt="Ouvidoria" class="ouvidoria">
        </div>
        
    </div>

    <!-- Script para máscara de CPF e Telefone -->
    <script>
        // Máscara para CPF
        document.getElementById('cpf').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length <= 11) {
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            }
            
            e.target.value = value;
        });

        // Máscara para Telefone
        document.getElementById('telefone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length <= 11) {
                value = value.replace(/^(\d{2})(\d)/g, '($1) $2');
                value = value.replace(/(\d)(\d{4})$/, '$1-$2');
            }
            
            e.target.value = value;
        });
    </script>
</body>
</html>