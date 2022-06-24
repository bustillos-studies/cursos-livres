<?php

    namespace app\controllers;

    // Recursos do miniframework
    use MF\Controller\Action;
    use MF\Model\Container;

    class AuthController extends Action {

        public function autenticar() {
            
            $usuario = Container::getModel('Usuario');
            
            $usuario->__set('email', $_POST['email']);
            $usuario->__set('senha', md5($_POST['senha']));

            $retorno = $usuario->autenticar();

            if ($usuario->__get('id') != '' && $usuario->__get('nome') != '') {
                
                session_start();

                $_SESSION['id'] = $usuario->__get('id');
                $_SESSION['nome'] = $usuario->__get('nome');
                $_SESSION['sobrenome'] = $usuario->__get('sobrenome');
                $_SESSION['email'] = $usuario->__get('email');
                $_SESSION['cel'] = $usuario->__get('cel');
                $_SESSION['tel'] = $usuario->__get('tel');
                $_SESSION['tipo'] = $usuario->__get('tipo');

                header ('Location: /inicio');

            } else {

                header('Location: /?login=erro');
                
            }
        }

        public function sair() {
            session_start();
            session_destroy();
            header('Location: /');
        }

    }

    

?>
