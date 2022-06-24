<?php

    namespace MF\Model;

    abstract class Model {

        // Atributo que recebe a conexão com o banco de dados, que é a instância do PDO feita a partir do método getDb da classe Connection
        protected $db;

        public function __construct(\PDO $db) {
            // Recuperar o atributo db e atribuir a ele o parâmetro recebido no momento da instância do objeto Produto (Guardar a conexão)
            $this->db = $db;
        }
    }

?>