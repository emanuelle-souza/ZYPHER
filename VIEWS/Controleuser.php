<?php
// Controleuser.php
session_start();
// if (!isset($_SESSION['admin_id'])) {
//     header("Location: LoginAdministrador.php");
//     exit;
// }

try {
    $pdo = new PDO("mysql:host=localhost;dbname=ZYPHER_SNEAKERS", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("set names utf8");
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}

require_once '../CONTROLLERS/ControlerUserController.php';
$admin = new AdminController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $id = (int)$_POST['id_pedido'];
    $status = $_POST['status'];

    $admin->atualizarStatus($id, $status);
    echo json_encode(['success' => true]);
    exit;
}

$resumoPedidos = $admin->getResumoPedidos();
$pedidos = $admin->getPedidos();
$resumoUsuarios = $admin->getResumoUsuarios();
$usuarios = $admin->getUsuarios();

// AJAX: Atualizar status
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user_id'])) {
    $id = $_GET['user_id'];
    $usuario = $admin->getUsuarioPorId($id);

    if (!$usuario) {
        http_response_code(404);
        echo json_encode(['error' => 'Usuário não encontrado']);
        exit;
    }

    // Histórico só se for usuário normal (id_usuario > 0)
    $historico = [];
    if ($usuario['id_usuario'] > 0) {
        $historico = $admin->getHistoricoUsuario($usuario['id_usuario']);
    }

    echo json_encode([
        'usuario' => $usuario,
        'historico' => $historico
    ]);
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZYPHER - Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/zypher/CSS/ControlerUser.css">
</head>
<body>

<!-- HEADER -->
    <header>
        <div class="topo">
            <div class="logo">
                <a href="/zypher/VIEWS/HomeCliente.php">
                    <img src="/zypher/MIDIA/LogoDeitado.png" alt="Zypher Sneakers" class="logo-img">
                </a>
            </div>
            <div class="busca">
                <input type="text" placeholder="Buscar...">
                <button>🔍</button>
            </div>
            <div class="icones">
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <a href="/zypher/views/PerfilAdministrador.php" title="Meu Perfil">
                        <img src="/zypher/MIDIA/perfil.png" alt="perfil">
                    </a>
                <?php else: ?>
                    <a href="/zypher/views/LoginAdministrador.php" title="Entrar">
                        <img src="/zypher/MIDIA/perfil.png" alt="Entrar">
                    </a>
                <?php endif; ?>
            </div>
        </div>
</header>

<div class="container">
    <div class="row">
<!-- COLUNA ESQUERDA: PEDIDOS -->
<div class="col">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-4"><i class="bi bi-box-seam me-2"></i> Controle de Pedidos</h5>

            <!-- RESUMO DE PEDIDOS -->
            <div class="resumo-pedidos">
                <div class="resumo-card total">
                    <div class="resumo-icon"><i class="bi bi-cart"></i></div>
                    <div class="resumo-content">
                        <h3><?= $resumoPedidos['total'] ?></h3>
                        <p>Total</p>
                    </div>
                </div>
                <div class="resumo-card vendas">
                    <div class="resumo-icon"><i class="bi bi-currency-dollar"></i></div>
                    <div class="resumo-content">
                        <h3>R$ <?= number_format($resumoPedidos['vendas'], 2, ',', '.') ?></h3>
                        <p>Vendas</p>
                    </div>
                </div>
                <div class="resumo-card pendentes">
                    <div class="resumo-icon"><i class="bi bi-hourglass-split"></i></div>
                    <div class="resumo-content">
                        <h3><?= $resumoPedidos['pendentes'] ?></h3>
                        <p>Pendentes</p>
                    </div>
                </div>
                <div class="resumo-card enviados">
                    <div class="resumo-icon"><i class="bi bi-truck"></i></div>
                    <div class="resumo-content">
                        <h3><?= $resumoPedidos['enviados'] ?></h3>
                        <p>Enviados</p>
                    </div>
                </div>
            </div>

            <!-- TABELA DE PEDIDOS -->
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Valor</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $p): ?>
                        <tr>
                            <td><strong>#<?= str_pad($p['id_pedido'], 5, '0', STR_PAD_LEFT) ?></strong></td>
                            <td>
                                <div><?= htmlspecialchars($p['nome']) ?></div>
                                <small class="text-muted"><?= htmlspecialchars($p['email']) ?></small>
                            </td>
                            <td>R$ <?= number_format($p['total'], 2, ',', '.') ?></td>
                            <td>
                                <span class="badge <?= $p['status']=='Pendente'?'bg-warning':($p['status']=='Enviado'?'bg-info':'bg-success') ?>">
                                    <?= $p['status'] ?>
                                </span>
                            </td>
                            <td>
                                <select class="form-select form-select-sm status-select" data-id="<?= $p['id_pedido'] ?>">
                                    <option value="Pendente" <?= $p['status']=='Pendente'?'selected':'' ?>>Pendente</option>
                                    <option value="Enviado" <?= $p['status']=='Enviado'?'selected':'' ?>>Enviado</option>
                                    <option value="Entregue" <?= $p['status']=='Entregue'?'selected':'' ?>>Entregue</option>
                                </select>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <!-- COLUNA DIREITA: USUÁRIOS COM FILTRO (CORRIGIDO) -->
<div class="col">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="mb-4"><i class="bi bi-people me-2"></i> Controle de Usuários</h5>

            <!-- RESUMO COM FILTRO -->
            <div class="resumo-pedidos">
                <div class="resumo-card total filtro-ativo" data-filtro="todos">
                    <div class="resumo-icon"><i class="bi bi-person"></i></div>
                    <div class="resumo-content">
                        <h3><?= $resumoUsuarios['total'] ?></h3>
                        <p>Total</p>
                    </div>
                </div>
                <div class="resumo-card premium" data-filtro="premium">
                    <div class="resumo-icon"><i class="bi bi-star"></i></div>
                    <div class="resumo-content">
                        <h3><?= $resumoUsuarios['premium'] ?></h3>
                        <p>Membros</p>
                    </div>
                </div>
                <div class="resumo-card admins" data-filtro="admin">
                    <div class="resumo-icon"><i class="bi bi-shield-lock"></i></div>
                    <div class="resumo-content">
                        <h3><?= $resumoUsuarios['admins'] ?></h3>
                        <p>Admins</p>
                    </div>
                </div>
                <div class="resumo-card vazio" style="opacity: 0; pointer-events: none;">
                    <div class="resumo-icon"><i class="bi bi-x"></i></div>
                    <div class="resumo-content">
                        <h3>—</h3>
                        <p>—</p>
                    </div>
                </div>
            </div>

            <!-- LISTA DE USUÁRIOS -->
            <div class="list-group list-group-flush" id="lista-usuarios">
                <?php foreach ($usuarios as $u): ?>
                <div class="list-group-item user-item d-flex align-items-center py-3 
                     <?= $u['membro'] ? 'filtro-premium' : '' ?> 
                     <?= $u['is_admin'] ? 'filtro-admin' : '' ?>" 
                     data-id="<?= $u['id_usuario'] ?>" style="cursor: pointer;">
                    <div class="avatar me-3"><?= strtoupper(substr($u['nome'], 0, 2)) ?></div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong><?= htmlspecialchars($u['nome']) ?></strong>
                            <div>
                                <?php if ($u['is_admin']): ?><span class="badge bg-danger">Admin</span><?php endif; ?>
                                <?php if ($u['membro']): ?><span class="badge bg-warning text-dark">VIP</span><?php endif; ?>
                            </div>
                        </div>
                        <small class="text-muted"><?= htmlspecialchars($u['email']) ?></small>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

</div>
    </div>
</div>

<!-- FOOTER EXATO -->
<footer>
    <a href="/zypher/VIEWS/Politicas.php">Política de Privacidade</a> | 
    <a href="#">Termos de Uso</a> | 
    <a href="/zypher/VIEWS/FaleConosco.php">Fale conosco</a>
    <p>&copy; 2025 Zypher Sneakers. Todos os direitos reservados.</p>
</footer>

<!-- MODAL -->
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalhes do Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Preenchido via JS -->
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // === FILTRO DE USUÁRIOS ===
    const cards = document.querySelectorAll('.resumo-card[data-filtro]');
    const itens = document.querySelectorAll('.user-item');

    cards.forEach(card => {
        card.addEventListener('click', function() {
            const filtro = this.dataset.filtro;

            // Remove ativo
            cards.forEach(c => c.classList.remove('filtro-ativo'));
            this.classList.add('filtro-ativo');

            // Aplica filtro
            itens.forEach(item => {
                if (filtro === 'todos') {
                    item.classList.remove('filtro-escondido');
                } else if (filtro === 'premium') {
                    item.classList.toggle('filtro-escondido', !item.classList.contains('filtro-premium'));
                } else if (filtro === 'admin') {
                    item.classList.toggle('filtro-escondido', !item.classList.contains('filtro-admin'));
                }
            });
        });
    });

    // === MODAL DE USUÁRIO (só se não estiver escondido) ===
    document.querySelectorAll('.user-item').forEach(item => {
        item.addEventListener('click', function(e) {
            if (this.classList.contains('filtro-escondido')) return;
            e.stopPropagation();

            const id = this.dataset.id;
            fetch(`?user_id=${id}`)
                .then(r => r.json())
                .then(data => {
                    const u = data.usuario;
                    const h = data.historico;
                    const body = `
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nome:</strong> ${u.nome}</p>
                                <p><strong>Email:</strong> ${u.email}</p>
                                <p><strong>Telefone:</strong> ${u.telefone || 'Não informado'}</p>
                                <p><strong>CPF:</strong> ${u.cpf || 'Não informado'}</p>
                                <p><strong>Tipo:</strong> 
                                    ${u.is_admin ? '<span class="badge bg-danger">Admin</span>' : ''}
                                    ${u.membro ? '<span class="badge bg-warning text-dark">VIP</span>' : '<span class="badge bg-secondary">Comum</span>'}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Histórico de Compras</h6>
                                ${h.length ? `
                                <table class="table table-sm">
                                    <thead><tr><th>ID</th><th>Data</th><th>Valor</th><th>Status</th></tr></thead>
                                    <tbody>
                                        ${h.map(p => `
                                        <tr>
                                            <td>#${String(p.id_pedido).padStart(5,'0')}</td>
                                            <td>${new Date(p.data_pedido).toLocaleDateString('pt-BR')}</td>
                                            <td>R$ ${Number(p.total).toFixed(2).replace('.',',')}</td>
                                            <td><span class="badge ${p.status=='Pendente'?'bg-warning':(p.status=='Enviado'?'bg-info':'bg-success')}">${p.status}</span></td>
                                        </tr>`).join('')}
                                    </tbody>
                                </table>` : '<p class="text-muted">Nenhum pedido.</p>'}
                            </div>
                        </div>`;
                    document.getElementById('modalBody').innerHTML = body;
                    new bootstrap.Modal(document.getElementById('userModal')).show();
                });
        });
    });

    // === STATUS DO PEDIDO (mantido) ===
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            const id = this.dataset.id;
            const status = this.value;
            const badge = this.closest('tr').querySelector('.badge');
            fetch('', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `id_pedido=${id}&status=${status}`
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    badge.textContent = status;
                    badge.className = 'badge ' + (status=='Pendente'?'bg-warning':(status=='Enviado'?'bg-info':'bg-success'));
                }
            });
        });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.status-select').forEach(select => {
        // Salva valor antigo
        select.dataset.oldValue = select.value;
        
        select.addEventListener('focus', function() {
            this.dataset.oldValue = this.value;
        });

        select.addEventListener('change', function() {
            const id = this.dataset.id;
            const status = this.value;
            const badge = this.closest('tr').querySelector('.badge');

            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `update_status=1&id_pedido=${id}&status=${status}`
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    badge.textContent = status;
                    badge.className = 'badge ' + 
                        (status === 'Pendente' ? 'bg-warning' : 
                         status === 'Enviado' ? 'bg-info' : 'bg-success');
                } else {
                    alert('Erro ao atualizar');
                    this.value = this.dataset.oldValue;
                }
            })
            .catch(() => {
                alert('Erro de conexão');
                this.value = this.dataset.oldValue;
            });
        });
    });
});
</script>
</body>
</html>