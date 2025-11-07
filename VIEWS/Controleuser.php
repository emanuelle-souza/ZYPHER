<?php
session_start();
require_once '../controllers/ControlerUserController.php';

$dashboard = new DashboardController();

$usuarios = $dashboard->getUsuariosRecentes();
$resumo = $dashboard->getResumo();

$historicoCompras = [];
$usuarioSelecionado = null;

if (isset($_GET['usuario_id'])) {
    $usuario_id = intval($_GET['usuario_id']);
    foreach ($usuarios as $u) {
        if ($u['id'] == $usuario_id) {
            $usuarioSelecionado = $u;
            break;
        }
    }
    if ($usuarioSelecionado) {
        $historicoCompras = $dashboard->getHistoricoCompras($usuario_id);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Controle de Usuários - Zypher Sneakers</title>
    <link rel="stylesheet" href="/zypher/CSS/ControlerUser.css" />
    <!-- Bootstrap CSS CDN para modal -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<header>
    <div class="topo">
        <div class="logo">
            <a href="/zypher/VIEWS/HomeCliente.php">
                <img src="/zypher/MIDIA/LogoDeitado.png" alt="Zypher Sneakers" class="logo-img" />
            </a>
        </div>
        <div class="busca">
            <input type="text" placeholder="Buscar..." />
            <button>🔍</button>
        </div>
        <div class="icones">
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <a href="/zypher/views/PerfilUsuario.php" title="Meu Perfil">
                    <img src="/zypher/MIDIA/perfil.png" alt="perfil" />
                </a>
            <?php else: ?>
                <a href="/zypher/views/LoginAdministrador.php" title="Entrar">
                    <img src="/zypher/MIDIA/perfil.png" alt="Entrar" />
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>

<main class="container">

    <h2 class="titulo-painel">CONTROLE DE USUÁRIOS</h2>

    <section class="resumo-e-lista">
        <div class="resumo">
            <h4>Resumo Geral</h4>
            <p><strong>Total de Usuários:</strong> <?= $resumo['totalUsuarios'] ?></p>
            <p><strong>Membros Premium:</strong> <?= $resumo['totalPremium'] ?></p>
            <p><strong>Total de Vendas:</strong> R$ <?= number_format($resumo['totalVendas'], 2, ',', '.') ?></p>
            <p><strong>Pedidos Hoje:</strong> <?= $resumo['pedidosHoje'] ?></p>
        </div>

        <div class="lista-usuarios">
            <h4>Usuários Recentes</h4>
            <?php foreach ($usuarios as $user): ?>
                <a href="?usuario_id=<?= $user['id'] ?>" class="btn btn-usuario">
                    <img src="/zypher/MIDIA/user-icon.png" alt="Usuário" />
                    <?= htmlspecialchars($user['email']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <?php if ($usuarioSelecionado): ?>
        <!-- Modal manual simples -->
        <div class="modal fade show" style="display:block; background: rgba(0,0,0,0.4);" tabindex="-1" aria-modal="true" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Informações do Usuário</h5>
                <a href="ControlerUser.php" class="btn-close" aria-label="Close"></a>
              </div>
              <div class="modal-body">
                <h6><strong>Nome:</strong> <?= htmlspecialchars($usuarioSelecionado['nome']) ?></h6>
                <p><strong>E-mail:</strong> <?= htmlspecialchars($usuarioSelecionado['email']) ?></p>
                <p><strong>Telefone:</strong> <?= htmlspecialchars($usuarioSelecionado['telefone']) ?></p>
                <p><strong>CPF:</strong> <?= htmlspecialchars($usuarioSelecionado['cpf']) ?></p>
                <p><strong>Membro Premium:</strong> <?= $usuarioSelecionado['membro'] ? 'Sim' : 'Não' ?></p>

                <hr />
                <h6>Histórico de Compras</h6>
                <?php if (!empty($historicoCompras)): ?>
                    <table class="table-historico">
                        <thead>
                            <tr>
                                <th>ID Pedido</th>
                                <th>Data</th>
                                <th>Valor Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($historicoCompras as $pedido): ?>
                                <tr>
                                    <td>#<?= $pedido['id'] ?></td>
                                    <td><?= date('d/m/Y', strtotime($pedido['data_pedido'])) ?></td>
                                    <td>R$ <?= number_format($pedido['valor_total'], 2, ',', '.') ?></td>
                                    <td><?= htmlspecialchars($pedido['status']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Sem histórico de compras.</p>
                <?php endif; ?>
              </div>
              <div class="modal-footer">
                <a href="ControlerUser.php" class="btn btn-secondary">Fechar</a>
              </div>
            </div>
          </div>
        </div>
    <?php endif; ?>

</main>

<!-- Bootstrap JS CDN para modal -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
