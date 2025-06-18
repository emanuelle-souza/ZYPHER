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
    case '/cypher/public/':
        require_once '../controllers/usuarioController.php';
        $controller = new usuarioController();
        $controller->Formulario();
        break;
    case '/cypher/save-usuario':
        require_once '../controllers/usuarioController.php';
        $controller =  new usuarioController();
        $controller->salvaUsuario();
        break;
    case '/cypher/delete-cadastro':
        require_once '../controllers/usuarioController.php';
        $controller = new usuarioController();
        $controller->deleteUsuarioByCpf();
        break;
    case (preg_match('/\/cypher\/update_cadastro\/(\d+)/', $request, $matches) ? true : false):
        $id_usuario = $matches[1];
        require_once '../controllers/usuarioController.php';
        $controller = new usuarioController();
        $controller->showUpdateForm($id_usuario);
        break;
    case '/cypher/update_cadastro':
        require_once '../controllers/usuarioController.php';
        $controller = new usuarioController();
        $controller->updateUsuario();
        break;
    case (preg_match('/\/cypher\/update_cadastro\/(\d+)/', $request, $matches) ? true : false):
        $id_usuario = $matches[1];
        require_once '../controllers/FuncionarioController.php';
        $controller = new FuncionarioController();
        $controller->showUpdateForm($id_funcionario);
        break;
    case '/cypher/update_cadastro':
        require_once '../controllers/FuncionarioController.php';
        $controller = new FuncionarioController();
        $controller->updateFuncionario();
        break;
    case (preg_match('/\/cypher\/update_cadastro\/(\d+)/', $request, $matches) ? true : false):
        $id_usuario = $matches[1];
        require_once '../controllers/AdministradorController.php';
        $controller = new AdministradorController();
        $controller->showUpdateForm($id_adm);
        break;
    case '/cypher/update_cadastro':
        require_once '../controllers/AdministradorController.php';
        $controller = new AdiministradorController();
        $controller->updateAdministrador();
        break;
    case '/cypher/public/':
        require_once '../controllers/enderecoController.php';
        $controller = new enderecoController();
        $controller->Formularioend();
        break;
    case '/cypher/salvaend':
        require_once '../controllers/enderecoController.php';
        $controller = new enderecoController();
        $controller->salvaendereco();
        break;
    case '/cypher/update_endereco':
        require_once '../controllers/enderecoController.php';
        $controller = new enderecoController();
        $controller->updateendereco();
        break;
    case (preg_match('/\/cypher\/update_cadastro\/(\d+)/', $request, $matches) ? true : false):
        $id_usuario = $matches[1];
        require_once '../controllers/enderecoController.php';
        $controller = new enderecoController();
        $controller->showUpdateFormEnd($id_usuario);
        break;
    case '/cypher/list-usuario':
        $controller = new usuarioController();
        $controller->listUsuario();
        break;
    case '/cypher/login-usuario':
        $controller = new usuarioController();  
        $controller->loginUsuario();
        break;
    case '/cypher/adicionar-giftcard':
        require_once '../controllers/giftcardController.php';
        $controller = new GiftcardController();
        $controller->adicionarGiftcard();
        break;
    case '/cypher/listar-giftcards':
        require_once '../controllers/giftcardController.php';
        $controller = new GiftcardController();
        $controller->listarGiftcardsDisponiveis();
        break;
    case '/cypher/resgatar-giftcard':
        require_once '../controllers/giftcardController.php';
        $controller = new GiftcardController();
        $controller->resgatarGiftcard();
        break;
    case '/cypher/save-funcionario':
        $controller = new FuncionarioController();
        $controller->saveFuncionario();
        break;
    case '/cypher/login-funcionario':
        $controller = new FuncionarioController();  
        $controller->loginFuncionario();
        break;
    case '/cypher/save-administrador':
        $controller = new AdministradorController();
        $controller->saveAdministrador();
        break;
    case '/cypher/login-administrador':
        $controller = new AdministradorController();  
        $controller->loginAdministrador();
        break;

    
    case '/cypher/home':
    case '/cypher/':
        $controller = new ProdutoController();
        $controller->listarProdutos();
        break;

    default:
        http_response_code(404);
        echo $request;
        echo "Página não encontrada.";
        break;
}