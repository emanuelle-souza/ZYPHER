<?php
require_once '../models/administrador.php';


class AdministradorController {

    public function loginAdministrador() {
    

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $administrador = new Administrador();
    $administradorExistente = $administrador->buscarPorEmail($email);

    if ($administradorExistente) {
            // Verifica senha — troque para password_verify se estiver usando hash
            if (password_verify($senha, $administradorExistente['senha'])) {
    
   
                $_SESSION['id_adm'] = $administradorExistente['id_adm'];
                $_SESSION['nome'] = $administradorExistente['nome'];
                $_SESSION['email'] = $administradorExistente['email'];
    
                // Redireciona para a home
                header('Location: /zypher/views/Controleuser.php');
                exit();
            } else {
        echo "Email ou senha incorretos!";
    }
}
}
}
