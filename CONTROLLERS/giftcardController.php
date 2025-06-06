<?php
require_once '../models/Giftcard.php';

class GiftcardController {
    public $model;

    public function __construct() {
        $this->model = new Giftcard();
    }

    public function adicionarGiftcard() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $giftcard = new Giftcard();
            $giftcard->codigo = $_POST['codigo'] ?? null;
            $giftcard->saldo = $_POST['saldo'] ?? null;
            $giftcard->expiracao = $_POST['expiracao'] ?? null;
            $giftcard->ativo = 1; // Sempre ativo ao criar

            if ($this->model->adicionar($giftcard->codigo, $giftcard->saldo, $giftcard->expiracao, $giftcard->ativo)) {
                echo "Giftcard adicionado com sucesso!";
            } else {
                echo "Erro ao adicionar giftcard.";
            }
        } else {
            include '../views/adicionarGiftcard.php';
        }
    }

    public function listarGiftcardsDisponiveis() {
        try {
            session_start();
            if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['membro'] != 1) {
                echo "Apenas membros podem visualizar os giftcards.";
                return;
            }

            $giftcards = $this->model->listarDisponiveis();
            include '../views/listarGiftcards.php';

        } catch (Exception $e) {
            echo "Erro ao listar giftcards: " . $e->getMessage();
            return;
        }
    }

    public function resgatarGiftcard() {
        session_start();
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['membro'] != 1) {
            echo "Apenas membros podem resgatar giftcards.";
            return;
        }

        $codigo = $_POST['codigo'] ?? '';
        $resultado = $this->model->resgatar($codigo);

        if ($resultado) {
            echo "Giftcard '{$codigo}' resgatado com sucesso! Valor: R$ {$resultado['saldo']}";
        } else {
            echo "Giftcard inválido, expirado ou já utilizado.";
        }
    }
}

