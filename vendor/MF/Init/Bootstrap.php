<?php

    ## REQUISITOS NÃO FUNCIONAIS (Fora da aplicação) ## 
    ## MÉTODOS RELATIVOS AO FRAMEWORK ##

    // O termo Bootstrap é muito utilizado para estabelecer o nome de scripts de inicialização das aplicações. Este não se trata, portanto, da lib css Bootstrap, e sim de um termo muito utilizado para scripts de inicialização.

    namespace MF\Init;

    // Classe abstrata é uma classe definida de forma análoga a qualquer tipo de classe, a diferença é que a classe abstrata não pode ser instanciada, pode somente ser herdada.
    abstract class Bootstrap {

        // Definição do atributo Routes
        private $routes;

        // Método abstrato
        // Significa que este método, quando herdado por uma classe filha, deverá ser implementado na classe filha. Obrigatóriamente, é necessário definir este método a visibilidade definida como protected
        abstract protected function initRoutes();

        // Método construtor que será executado no momento em que a instância de um objeto for feito com base nessa classe "Route". Essa execução deste método está sendo feito em "index.php".
        public function __construct() {
            // Executar o método initRoutes(), que configura o array de rotas.
            $this->initRoutes();
            // Executar o método run() e atribuindo a URL retornada pelo método getUrl()
            $this->run($this->getUrl());
        }

        // Métodos getters e setters para manipular o atributo privado $routes
        public function getRoutes() {
            // Retornar o atributo $routes
            return $this->routes;
        }
        public function setRoutes(array $routes) {
            // Recuperar o atributo $routes e associar o valor recebido por parâmetro como sendo o valor do atributo
            $this->routes = $routes;
        }

        // Método para Executar a instância dinâmica do objeto
        protected function run($url) {
            foreach ($this->getRoutes() as $key => $route) {
                // Verificar se a URL digitada for compatível com alguma rota registrada dentro da aplicação e tomar uma decisão
                if( $url == $route['route'] ){
                    // Montagem do nome da classe que será instanciada
                    $class = "app\\controllers\\".ucfirst($route['controller']);

                    // Realizando a instância da classe retornada com base no array de rotas
                    $controller = new $class;

                    // Disparar os respectivos métodos da classe (actions)
                        // Recuperar a action da rota
                        $action = $route['action'];

                        //Executando a ação da rota
                        $controller->$action();
                }
            }
        }
        
        // Retornar a URL corrente do usuário, qual que é o acesso que ele está fazendo através do navegador.
        protected function getUrl() {
            // A superglobal $_SERVER, que é um array, retorna todos os detalhes do servidor da aplicação.
            // Uma variável contida nesse array é o REQUEST_URI, que armazena a URL acessada.
            // A função parse_url: recebe uma url, interpreta e retorna os seus respectivos componentes em formato de array (variável contida nele: "path", que armazena apenas a URL, também existe a variável "query", que armazena parâmetros submetidos pela página). 
            // Como o parse retorna um Array, é preciso utilizar a constante do php "PHP_URL_PATH", na qual, passando pela leitura do parse_url, retornará apenas o valor contido na variável "path", contida no array gerado pelo parse_url.
            return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        }

    }


?>