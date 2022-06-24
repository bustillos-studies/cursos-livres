<?php

    namespace app\controllers;

    // Recursos do miniframework
    use MF\Controller\Action;
    use MF\Model\Container;
    

    class IndexController extends Action {

        // Métodos que representam as actions da especificação da arquitetura MVC.
        // Actions são estes métodos contido nessa classe controladora.

        public function index() {

            $this->view->login = isset($_GET['login']) ? $_GET['login'] : '';

            $this->titulo = 'Cursos Livres';

            // Requisitando o método render e enviando a ele o nome da view e os dados contidos na mesma.
            $this->render('index');
        }

        public function cadastrar() {

            $this->view->usuario = array(
                'nome' => '',
                'sobrenome' => '',
                'email' => '',
                'senha' => '',
                'cel' => '',
                'tel' => ''
            );

            $this->titulo = 'Cadastro';

            $this->view->erroCadastro = false;

            $this->render('cadastrar');
        }

        public function registrar() {

            // Receber dados do formulário

            $usuario = Container::getModel('Usuario');

            $usuario->__set('nome', $_POST['nome']);
            $usuario->__set('sobrenome', $_POST['sobrenome']);
            $usuario->__set('email', $_POST['email']);
            $usuario->__set('senha', md5($_POST['senha']));
            $usuario->__set('cel', $_POST['cel']);
            $usuario->__set('tel', $_POST['tel']);
            $usuario->__set('tipo', 1);
            $this->titulo = 'Cadastro';

            if ($usuario->validarCadastro() && count($usuario->getUsuarioPorEmail()) == 0 ) {
                $usuario->salvar();
                $this->render('cadastro');
            } else {

                $this->view->usuario = array(
                    'nome' => $_POST['nome'],
                    'sobrenome' => $_POST['sobrenome'],
                    'email' => $_POST['email'],
                    'senha' => $_POST['senha'],
                    'cel' => $_POST['cel'],
                    'tel' => $_POST['tel'],
                );

                $this->view->erroCadastro = true;

                $this->render('cadastrar');

            }

        }

    }


?>