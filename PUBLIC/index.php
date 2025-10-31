<?php

// Ativar exibição de erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../controllers/usuarioController.php';
require_once '../controllers/enderecoController.php';
require_once '../controllers/ProdutoController.php';



// Lógica de roteamento
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


switch ($request) {
    case '/zypher/public/':
        require_once '../controllers/HomePageController.php';
        $controllerProduto = new HomePageController();
        $controllerProduto->exibirProdutos();
        //$controllerUsuario = new usuarioController();
        //$controllerUsuario->();
       //    require '../VIEWS/HomeCliente.php';
        break;
    case '/zypher/usuarioform.php':
        require_once '../controllers/usuarioController.php';
        $controller = new usuarioController();
        $controller->Formulario();
        break;
    case '/zypher/saveusuario':
        require_once '../controllers/usuarioController.php';
        $controller =  new usuarioController();
        $controller->saveusuario();
        break;
    case '/zypher/delete-cadastro':
        require_once '../controllers/usuarioController.php';
        $controller = new usuarioController();
        $controller->deleteUsuarioByCpf();
        break;
    case (preg_match('/\/zypher\/update_cadastro\/(\d+)/', $request, $matches) ? true : false):
        $id_usuario = $matches[1];
        require_once '../controllers/usuarioController.php';
        $controller = new usuarioController();
        $controller->showUpdateForm($id_usuario);
        break;
    case '/zypher/update_cadastro':
        require_once '../controllers/usuarioController.php';
        $controller = new usuarioController();
        $controller->updateUsuario();
        break;

    case '/zypher/salvaend':
        require_once '../controllers/enderecoController.php';
        $controller = new enderecoController();
        $controller->salvaendereco();
        break;
    case '/zypher/update_endereco':
        require_once '../controllers/enderecoController.php';
        $controller = new enderecoController();
        $controller->updateendereco();
        break;
    case (preg_match('/\/zypher\/update_cadastro\/(\d+)/', $request, $matches) ? true : false):
        $id_usuario = $matches[1];
        require_once '../controllers/enderecoController.php';
        $controller = new enderecoController();
        $controller->showUpdateFormEnd($id_usuario);
        break;
    case '/zypher/list-usuario':
        $controller = new usuarioController();
        $controller->listUsuario();
        break;
    case '/zypher/loginUsuario':
        $controller = new usuarioController();  
        $controller->loginUsuario();
        break;
    case '/zypher/adicionar-giftcard':
        require_once '../controllers/giftcardController.php';
        $controller = new GiftcardController();
        $controller->adicionarGiftcard();
        break;
    case '/zypher/listar-giftcards':
        require_once '../controllers/giftcardController.php';
        $controller = new GiftcardController();
        $controller->listarGiftcardsDisponiveis();
        break;
    case '/zypher/resgatar-giftcard':
        require_once '../controllers/giftcardController.php';
        $controller = new GiftcardController();
        $controller->resgatarGiftcard();
        break;
 
    case '/zypher/HomeCliente.php':
        $controller = new ProdutoController();
        $controller->listarProdutos();
        break;

case '/zypher/login':
    require_once '../views/login.php';
    break;


    default:
        http_response_code(404);
        echo $request;
        echo "Página não encontrada.";
        break;
}