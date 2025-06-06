<?php

// Ativar exibição de erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../controllers/usuarioController.php';
require_once '../controllers/enderecoController.php';

// Lógica de roteamento
$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/CYPHER/public/':
        require_once '../controllers/usuarioController.php';
        $controller = new usuarioController();
        $controller->Formulario();
        break;
    case '/CYPHER/save-usuario':
        require_once '../controllers/usuarioController.php';
        $controller =  new usuarioController();
        $controller->salvaUsuario();
        break;
    case '/codigoprojeto/delete-cadastro':
        require_once '../controllers/usuarioController.php';
        $controller = new usuarioController();
        $controller->deleteUsuarioByCpf();
        break;
    case (preg_match('/\/codigoprojeto\/update_cadastro\/(\d+)/', $request, $matches) ? true : false):
        $id_usuario = $matches[1];
        require_once '../controllers/usuarioController.php';
        $controller = new usuarioController();
        $controller->showUpdateForm($id_usuario);
        break;
    case '/codigoprojeto/update_cadastro':
        require_once '../controllers/usuarioController.php';
        $controller = new usuarioController();
        $controller->updateUsuario();
        break;
    case '/codigoprojeto/public/':
        require_once '../controllers/enderecoController.php';
        $controller = new enderecoController();
        $controller->Formularioend();
        break;
    case '/codigoprojeto/salvaend':
        require_once '../controllers/enderecoController.php';
        $controller = new enderecoController();
        $controller->salvaendereco();
        break;
    case '/codigoprojeto/update_endereco':
        require_once '../controllers/enderecoController.php';
        $controller = new enderecoController();
        $controller->updateendereco();
        break;
    case (preg_match('/\/codigoprojeto\/update_cadastro\/(\d+)/', $request, $matches) ? true : false):
        $id_usuario = $matches[1];
        require_once '../controllers/enderecoController.php';
        $controller = new enderecoController();
        $controller->showUpdateFormEnd($id_usuario);
        break;
    case '/ZYPHER_SNEAKERS/login-usuario':
        $controller = new UsuarioController();  
        $controller->loginUsuario();
        break;
    case '/ZYPHER_SNEAKERS/list-usuarios':
        $controller = new UsuarioController();
        $controller->listUsuarios();
        break;
    case '/codigoprojeto/adicionar-giftcard':
        require_once '../controllers/giftcardController.php';
        $controller = new GiftcardController();
        $controller->adicionarGiftcard();
        break;
    case '/codigoprojeto/listar-giftcards':
        require_once '../controllers/giftcardController.php';
        $controller = new GiftcardController();
        $controller->listarGiftcardsDisponiveis();
        break;
    case '/codigoprojeto/resgatar-giftcard':
        require_once '../controllers/giftcardController.php';
        $controller = new GiftcardController();
        $controller->resgatarGiftcard();
        break;

    default:
        http_response_code(404);
        echo $request;
        echo "Página não encontrada.";
        break;
}