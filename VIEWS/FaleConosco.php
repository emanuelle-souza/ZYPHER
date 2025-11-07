<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fale Conosco - Zypher Sneakers</title>
    <link rel="stylesheet" href="/zypher/CSS/FaleConosco.css">
</head>
<body>
    <!-- Cabeçalho / Menu -->
    <header>
        <div class="topo">
            <div class="logo">
                <a href="/zypher/VIEWS/HomeCliente.php">
                    <img src="/zypher/MIDIA/LogoDeitado.png" alt="Zypher Sneakers" class="logo-img">
                </a>
            </div>
            <div class="busca">
                <input type="text" placeholder="Burcar">
                <button>🔍</button>
            </div>
            <div class="icones">
                <a href="/zypher/views/SejaMembro.php"><img src="/zypher/MIDIA/coroa.png" alt="coroa"></a>
                <a href="/zypher/views/Carrinho.php"><img src="/zypher/MIDIA/carrinho.png" alt="carrinho"></a>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <a href="/zypher/views/PerfilUsuario.php" title="Meu Perfil">
                        <img src="/zypher/MIDIA/perfil.png" alt="perfil">
                    </a>
                <?php else: ?>
                    <a href="/zypher/views/login.php" title="Entrar">
                        <img src="/zypher/MIDIA/perfil.png" alt="Entrar">
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <nav class="menu">
            <a href="#">Feminino</a>
            <a href="#">Masculino</a>
        </nav>
    </header>

    <!-- Seção Fale Conosco -->
    <section class="fale-conosco-section">
        <div class="icon-mensagem">
            <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                <circle cx="30" cy="30" r="30" fill="#1E3A5F"/>
                <rect x="18" y="22" width="24" height="16" rx="2" stroke="white" stroke-width="2" fill="none"/>
                <path d="M18 24L30 32L42 24" stroke="white" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>
        
        <h1>Fale Conosco</h1>
        <p class="subtitle">Tem alguma dúvida ou sugestão? Estamos aqui para ajudar!</p>

        <div class="content-wrapper">
            <!-- Formulário -->
            <div class="form-container">
                <h2>Envie sua Mensagem</h2>
                
                <form class="contact-form" action="/zypher/VIEWS/MensagemEnviada.php" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nome">Nome Completo *</label>
                            <input type="text" id="nome" name="nome" placeholder="Insira seu nome completo" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" placeholder="email@gmail.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="assunto">Assunto *</label>
                        <input type="text" id="assunto" name="assunto" placeholder="Sobre o que você quer falar?" required>
                    </div>

                    <div class="form-group">
                        <label for="mensagem">Mensagem *</label>
                        <textarea id="mensagem" name="mensagem" placeholder="Escreva sua mensagem aqui..." required></textarea>
                    </div>

                    <button type="submit" class="submit-btn" onclick="return true;">
                        <span>✈</span> Enviar Mensagem
                    </button>
                </form>
            </div>

            <!-- Informações de Contato -->
            <div class="info-container">
                <div class="contact-info-box">
                    <h3>Outras Formas de Contato</h3>
                    
                    <div class="contact-item">
                        <div class="contact-icon">✉</div>
                        <div>
                            <strong>Email</strong>
                            <p>contato@zyphersneakers.com</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">💬</div>
                        <div>
                            <strong>WhatsApp</strong>
                            <p>(11) 96664-9999</p>
                        </div>
                    </div>
                </div>

                <div class="horario-box">
                    <h3>Horário de Atendimento</h3>
                    
                    <div class="horario-item">
                        <span>Segunda à Sexta</span>
                        <strong>9h - 18h</strong>
                    </div>
                    
                    <div class="horario-item">
                        <span>Sábado</span>
                        <strong>9h - 14h</strong>
                    </div>
                    
                    <div class="horario-item">
                        <span>Domingo</span>
                        <strong>Fechado</strong>
                    </div>
                </div>

                <div class="resposta-rapida">
                    <strong>Resposta Rápida:</strong> Nossa equipe geralmente responde em até 24 horas úteis.
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <a href="/zypher/VIEWS/Politicas.php">Política de Privacidade</a> | 
        <a href="/zypher/VIEWS/Termos.php">Termos de Uso</a> | 
        <a href="/zypher/VIEWS/FaleConosco.php">Fale conosco</a>
        <p>&copy; 2025 Zypher Sneakers. Todos os direitos reservados.</p>
    </footer>
</body>
</html>