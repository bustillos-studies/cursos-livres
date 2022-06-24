<?php

    namespace app;

    // Classe para conexão com o Banco de Dados
    class Connection {

        // Método responsável por criar a conexão com o banco de dados
        public static function getDb() {
            try {

                $conn = new \PDO(
                    "mysql:host=localhost;dbname=cursos_livres;charset=utf8",
                    "root",
                    ""
                );
                // Retornar a instância do PDO
                return $conn;

            } catch (\PDOException $e) {
                // Tratar o erro
                echo $e->getMessage();
            }
        }
    }

?>