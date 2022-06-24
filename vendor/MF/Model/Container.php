<?php

    namespace MF\Model;
    use app\Connection;

    class Container {
        
        // Métodos estáticos não exigem necessidade de criar uma instância da classe em questão (Container). A partir da refência da classe (use) é possível executar os métodos sem que aja para isso, um objeto.
        public static function getModel($model) {
            
            // Retornar o modelo solicitado já instanciado, inclusive com a conexão estabelecida
                // Criando referência para a classe
                $class = "\\app\\models\\".ucfirst($model);

                // Recuperar a instância de conexão do PDO(função getDb()) da classe Connection. Dessa forma, foi feita a conexão com o banco.
                $conn = Connection::getDb();

                return new $class($conn);
        }
    }

?>