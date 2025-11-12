<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suporte - Mensagens dos Clientes</title>
    <link rel="stylesheet" href="/zypher/CSS/SuporteUsuario.css">
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
                <input type="text" placeholder="Buscar mensagens...">
                <button>🔍</button>
            </div>
            <div class="icones">
                <a href="/zypher/views/SejaMembro.php"><img src="/zypher/MIDIA/coroa.png" alt="coroa"></a>
                <a href="/zypher/views/Carrinho.php"><img src="/zypher/MIDIA/carrinho.png" alt="carrinho"></a>
                <a href="/zypher/views/PerfilUsuario.php" title="Meu Perfil">
                    <img src="/zypher/MIDIA/perfil.png" alt="perfil">
                </a>
            </div>
        </div>

        <nav class="menu">
            <a href="#">Dashboard</a>
            <a href="#" class="active">Mensagens</a>
            <a href="#">Configurações</a>
        </nav>
    </header>

    <!-- Seção Principal de Suporte -->
    <section class="suporte-section">
        <div class="header-suporte">
            <div class="icon-suporte">
                <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                    <circle cx="30" cy="30" r="30" fill="#172A4E"/>
                    <path d="M30 20C23.372 20 18 25.372 18 32C18 34.104 18.526 36.084 19.448 37.81L18 42L22.355 40.584C24.038 41.476 25.964 42 28 42H30C36.628 42 42 36.628 42 30C42 23.372 36.628 18 30 18V20Z" fill="white"/>
                    <circle cx="25" cy="30" r="2" fill="#172A4E"/>
                    <circle cx="30" cy="30" r="2" fill="#172A4E"/>
                    <circle cx="35" cy="30" r="2" fill="#172A4E"/>
                </svg>
            </div>
            <div class="header-text">
                <h1>Central de Mensagens</h1>
                <p class="subtitle">Gerencie todas as mensagens dos clientes em um só lugar</p>
            </div>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">📬</div>
                <div class="stat-info">
                    <span class="stat-number">15</span>
                    <span class="stat-label">Não Lidas</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">✓</div>
                <div class="stat-info">
                    <span class="stat-number">42</span>
                    <span class="stat-label">Respondidas</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📊</div>
                <div class="stat-info">
                    <span class="stat-number">57</span>
                    <span class="stat-label">Total</span>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="filters-container">
            <button class="filter-btn active" data-filter="todas">Todas</button>
            <button class="filter-btn" data-filter="nao-lidas">Não Lidas</button>
            <button class="filter-btn" data-filter="respondidas">Respondidas</button>
            <button class="filter-btn" data-filter="urgentes">Urgentes</button>
        </div>

        <!-- Lista de Mensagens -->
        <div class="mensagens-container">
            
            <!-- Mensagem 1 - Nova -->
            <div class="mensagem-card nova">
                <div class="mensagem-header">
                    <div class="usuario-info">
                        <div class="avatar">JD</div>
                        <div class="usuario-detalhes">
                            <h3>João da Silva</h3>
                            <span class="email">joao.silva@email.com</span>
                        </div>
                    </div>
                    <div class="mensagem-meta">
                        <span class="status-badge nova-badge">Nova</span>
                        <span class="tempo">Há 2 horas</span>
                    </div>
                </div>

                <div class="mensagem-corpo">
                    <h4 class="assunto">Dúvida sobre Entrega</h4>
                    <p class="mensagem-preview">
                        Olá, gostaria de saber qual o prazo de entrega para o CEP 01310-100. 
                        Fiz uma compra há 3 dias e ainda não recebi o código de rastreamento...
                    </p>
                </div>

                <div class="mensagem-footer">
                    <button class="btn-responder">
                        <span>✉</span> Responder
                    </button>
                    <button class="btn-marcar-lida">
                        <span>✓</span> Marcar como Lida
                    </button>
                    <button class="btn-ver-detalhes">
                        Ver Detalhes
                    </button>
                </div>
            </div>

            <!-- Mensagem 2 - Nova -->
            <div class="mensagem-card nova">
                <div class="mensagem-header">
                    <div class="usuario-info">
                        <div class="avatar">MS</div>
                        <div class="usuario-detalhes">
                            <h3>Maria Santos</h3>
                            <span class="email">maria.santos@email.com</span>
                        </div>
                    </div>
                    <div class="mensagem-meta">
                        <span class="status-badge nova-badge">Nova</span>
                        <span class="tempo">Há 5 horas</span>
                    </div>
                </div>

                <div class="mensagem-corpo">
                    <h4 class="assunto">Problema com Pagamento</h4>
                    <p class="mensagem-preview">
                        Tentei realizar uma compra mas o pagamento não foi aprovado. 
                        Já verifiquei com o banco e está tudo ok. Podem me ajudar?
                    </p>
                </div>

                <div class="mensagem-footer">
                    <button class="btn-responder">
                        <span>✉</span> Responder
                    </button>
                    <button class="btn-marcar-lida">
                        <span>✓</span> Marcar como Lida
                    </button>
                    <button class="btn-ver-detalhes">
                        Ver Detalhes
                    </button>
                </div>
            </div>

            <!-- Mensagem 3 - Respondida -->
            <div class="mensagem-card respondida">
                <div class="mensagem-header">
                    <div class="usuario-info">
                        <div class="avatar">PO</div>
                        <div class="usuario-detalhes">
                            <h3>Pedro Oliveira</h3>
                            <span class="email">pedro.oliveira@email.com</span>
                        </div>
                    </div>
                    <div class="mensagem-meta">
                        <span class="status-badge respondida-badge">Respondida</span>
                        <span class="tempo">Ontem</span>
                    </div>
                </div>

                <div class="mensagem-corpo">
                    <h4 class="assunto">Solicitação de Troca</h4>
                    <p class="mensagem-preview">
                        Comprei um tênis tamanho 42 mas preciso trocar por 43. 
                        Como faço para solicitar a troca?
                    </p>
                </div>

                <div class="mensagem-footer">
                    <button class="btn-responder">
                        <span>↩</span> Responder Novamente
                    </button>
                    <button class="btn-ver-detalhes">
                        Ver Histórico
                    </button>
                </div>
            </div>

            <!-- Mensagem 4 - Nova -->
            <div class="mensagem-card nova">
                <div class="mensagem-header">
                    <div class="usuario-info">
                        <div class="avatar">AC</div>
                        <div class="usuario-detalhes">
                            <h3>Ana Costa</h3>
                            <span class="email">ana.costa@email.com</span>
                        </div>
                    </div>
                    <div class="mensagem-meta">
                        <span class="status-badge nova-badge">Nova</span>
                        <span class="tempo">Há 1 dia</span>
                    </div>
                </div>

                <div class="mensagem-corpo">
                    <h4 class="assunto">Elogio ao Atendimento</h4>
                    <p class="mensagem-preview">
                        Quero parabenizar a equipe pelo excelente atendimento! 
                        Meu pedido chegou antes do prazo e o produto é perfeito!
                    </p>
                </div>

                <div class="mensagem-footer">
                    <button class="btn-responder">
                        <span>✉</span> Responder
                    </button>
                    <button class="btn-marcar-lida">
                        <span>✓</span> Marcar como Lida
                    </button>
                    <button class="btn-ver-detalhes">
                        Ver Detalhes
                    </button>
                </div>
            </div>

            <!-- Mensagem 5 - Respondida -->
            <div class="mensagem-card respondida">
                <div class="mensagem-header">
                    <div class="usuario-info">
                        <div class="avatar">RC</div>
                        <div class="usuario-detalhes">
                            <h3>Ricardo Cardoso</h3>
                            <span class="email">ricardo.cardoso@email.com</span>
                        </div>
                    </div>
                    <div class="mensagem-meta">
                        <span class="status-badge respondida-badge">Respondida</span>
                        <span class="tempo">Há 2 dias</span>
                    </div>
                </div>

                <div class="mensagem-corpo">
                    <h4 class="assunto">Informação sobre Produto</h4>
                    <p class="mensagem-preview">
                        Gostaria de saber se vocês tem o modelo Air Max disponível 
                        em outras cores além do preto?
                    </p>
                </div>

                <div class="mensagem-footer">
                    <button class="btn-responder">
                        <span>↩</span> Responder Novamente
                    </button>
                    <button class="btn-ver-detalhes">
                        Ver Histórico
                    </button>
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

    <script>
        // Filtros de mensagens
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const filter = this.dataset.filter;
                const mensagens = document.querySelectorAll('.mensagem-card');
                
                mensagens.forEach(msg => {
                    if (filter === 'todas') {
                        msg.style.display = 'block';
                    } else if (filter === 'nao-lidas' && msg.classList.contains('nova')) {
                        msg.style.display = 'block';
                    } else if (filter === 'respondidas' && msg.classList.contains('respondida')) {
                        msg.style.display = 'block';
                    } else {
                        msg.style.display = 'none';
                    }
                });
            });
        });

        // Marcar como lida
        document.querySelectorAll('.btn-marcar-lida').forEach(btn => {
            btn.addEventListener('click', function() {
                const card = this.closest('.mensagem-card');
                card.classList.remove('nova');
                card.classList.add('respondida');
                
                const badge = card.querySelector('.status-badge');
                badge.textContent = 'Lida';
                badge.classList.remove('nova-badge');
                badge.classList.add('respondida-badge');
                
                this.remove();
            });
        });
    </script>
</body>
</html>