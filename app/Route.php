<?php

    ## REQUISITOS FUNCIONAIS (Dentro da aplicação) ## 


    // Associar os namespaces como o nome dos respectivos diretórios.
    // Essa portanto, é a especificação PSR-4, onde espera que o script contido dentro de um determinado diretório esteja em um namespace compatível com aquele respectivo diretório.
    namespace app;

    // Utilizar a classe Bootstrap contida no namespace \MF\Init\
    use MF\Init\Bootstrap;

    class Route extends Bootstrap {

        // Verificar quais são as rotas que a aplicação possui
        // initRoutes = Iniciar as rotas
        protected function initRoutes() {
            // Criando duas rotas, caso entre em alguma delas, tomar decisões
            $routes['home'] = array(
                // Indicar que o controlador que entrará em ação é o indexController.php
                    // Definindo um índice chamado "route" que recebe a rota raiz "/".
                    'route' => '/',
                    // Definindo o controller
                    'controller' => 'indexController',
                    // Definir a ação dentro do controlador que será disparada quando essa rota for requisitada
                    'action' => 'index'
            );

            $routes['cadastrar'] = array(
                'route' => '/cadastrar',
                'controller' => 'indexController',
                'action' => 'cadastrar'
            );

            $routes['registrar'] = array(
                'route' => '/registrar',
                'controller' => 'indexController',
                'action' => 'registrar'
            );
            
            $routes['deletarPerfil'] = array(
                'route' => '/deletarPerfil',
                'controller' => 'AppController',
                'action' => 'deletarPerfil'
            );

            $routes['autenticar'] = array(
                'route' => '/autenticar',
                'controller' => 'AuthController',
                'action' => 'autenticar'
            );

            $routes['inicio'] = array(
                'route' => '/inicio',
                'controller' => 'AppController',
                'action' => 'inicio'
            );

            $routes['sair'] = array(
                'route' => '/sair',
                'controller' => 'AuthController',
                'action' => 'sair'
            );

            $routes['perfil'] = array(
                'route' => '/perfil',
                'controller' => 'AppController',
                'action' => 'perfil'
            );

            $routes['estudantes'] = array(
                'route' => '/estudantes',
                'controller' => 'AppController',
                'action' => 'estudantes'
            );

            $routes['perfilEstudante'] = array(
                'route' => '/estudante',
                'controller' => 'AppController',
                'action' => 'perfilEstudante'
            );

            $routes['alterarPerfilEstudante'] = array(
                'route' => '/estudante/alterar',
                'controller' => 'AppController',
                'action' => 'alterarPerfilEstudante'
            );

            $routes['alterarPerfil'] = array(
                'route' => '/alterarPerfil',
                'controller' => 'AppController',
                'action' => 'alterarPerfil'
            );

            $routes['cursos'] = array(
                'route' => '/cursos',
                'controller' => 'AppController',
                'action' => 'cursos'
            );

            $routes['editarCurso'] = array(
                'route' => '/cursos/editar',
                'controller' => 'AppController',
                'action' => 'editarCurso'
            );

            $routes['criarCurso'] = array(
                'route' => '/cursos/criar',
                'controller' => 'AppController',
                'action' => 'criarCurso'
            );

            $routes['apagarCurso'] = array(
                'route' => '/cursos/apagar',
                'controller' => 'AppController',
                'action' => 'apagarCurso'
            );

            $routes['curso'] = array(
                'route' => '/curso',
                'controller' => 'AppController',
                'action' => 'curso'
            );

            $routes['criarSecao'] = array(
                'route' => '/cursos/criarSecao',
                'controller' => 'AppController',
                'action' => 'criarSecao'
            );

            $routes['editarSecao'] = array(
                'route' => '/cursos/editarSecao',
                'controller' => 'AppController',
                'action' => 'editarSecao'
            );

            $routes['apagarSecao'] = array(
                'route' => '/cursos/apagarSecao',
                'controller' => 'AppController',
                'action' => 'apagarSecao'
            );

            $routes['criarAula'] = array(
                'route' => '/cursos/criarAula',
                'controller' => 'AppController',
                'action' => 'criarAula'
            );

            $routes['editarAula'] = array(
                'route' => '/cursos/editarAula',
                'controller' => 'AppController',
                'action' => 'editarAula'
            );

            $routes['apagarAula'] = array(
                'route' => '/cursos/apagarAula',
                'controller' => 'AppController',
                'action' => 'apagarAula'
            );
            

            // Criado os arrays de rotas, passar os parâmetros desse array ao atributo privado $routes utilizando o método setter
            $this->setRoutes($routes);
        }

    }

?> 