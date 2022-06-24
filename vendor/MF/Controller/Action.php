<?php

    namespace MF\Controller;

    abstract class Action {

        protected $view;

        public function __construct() {
            // A classe stdClass é uma classe nativa do PHP, através dela é possível criar objetos padrões (std = standard). É possível criar objetos vazios que poderão ser dinamicamente compostos por atributos durante a lógica do processamento da aplicação.
            // Atribuindo o objeto vazio ao atributo $view
            $this->view = new \stdClass();
                
        }

        
        // Método para renderizar o layout
        protected function render($view, $layout = 'layout') {
            $this->view->page = $view;
            // Teste para verificar se a variável $layout representa um arquivo que existe
            if(file_exists("../app/views/".$layout.".phtml")) {
                // Requisição do arquivo do layout
                    require_once "../app/views/".$layout.".phtml";
            } else {
                $this->content();
            }

        }

        // Método para receber a View que será acessada para realizar o processo de require.
        protected function content() {
            // Método get_class retorna todo o diretório e o nome da classe atual indicada
            $classAtual = get_class($this);
            // Substituindo o nome dos diretórios pais ('App\Controllers\') contidos na variável $classAtual por um valor nulo, restando apenas o nome da Classe.
            // Atribuindo o novo valor obtido a variável classAtual.
            $classAtual = str_replace('app\\controllers\\', '', $classAtual);
            // Removendo o nome "Controller" para restar apenas o nome inicial da classe e transformando o resultado em caracteres minúsculos.
            $classAtual = strtolower(str_replace('Controller', '', $classAtual));

            // Requisitar a View(Visualização para o usuário final) da respectiva view recebida por parâmetro.
            require_once "../app/views/".$classAtual."/".$this->view->page.".phtml";
        }



    }

?>

