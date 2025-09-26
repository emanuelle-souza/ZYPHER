 <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Zypher Sneakers</title>
        <link rel="stylesheet" href="../CSS/LoginCliente.css">
    </head>
    <body>
        <main>
            <div class="login-wrapper">
                <div class="container-login">
                    <h2>LOGIN</h2>
                    <form action="/zypher/loginUsuario" method="POST">
                        <input type="email" id="email" name="email" placeholder="E-MAIL:" required>
                        <input type="password" id="senha" name="senha" placeholder="SENHA:" required>
                        <div class="links">
                            <a href="/zypher/views/RecuperarSenha.php">ESQUECEU A SENHA?</a>
                        </div>
                        <button type="submit" id="btn-login">ENTRAR</button>
                    </form>

                    <div class="links" style="margin-top:18px;">
                        <a href="/zypher/views/usuarioform.php">CADASTRAR-SE</a><br><br>
                        <a href="">SOU MEMBRO</a>
                    </div>
                </div>
                <div class="logo">
                    <img src="../MIDIA/LogoDeitado.png" alt="Logo Zypher Sneakers">
                </div>
            </div>
        </main>
    </body>
    </html>