<?php

    namespace app\models;

    use MF\Model\Model;

    class Secao extends Model {

        private $id;
        private $id_curso;
        private $nome;
        private $status;

        public function __get($atributo) {
            return $this->$atributo;
        }
        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }

        public function criar() {

            $query = "INSERT INTO secoes (nome, id_curso, status) VALUES (:nome, :id_curso, :status)";
            // Receber o PDO (a classe db recebe a instância do PDO na classe extendida Model)
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':id_curso', $this->__get('id_curso'));
            $stmt->bindValue(':status', $this->__get('status'));
            $stmt->execute();

            return $this;

        }

        public function editar() {

            $query = "UPDATE secoes SET nome = :nome, id_curso = :id_curso, status = :status WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':id_curso', $this->__get('id_curso'));
            $stmt->bindValue(':status', $this->__get('status'));
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $this;
        }

        public function apagar() {

            $query = "DELETE FROM secoes WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $this;

        }

        public function apagarSecoesPorCurso() {

            $query = "DELETE FROM secoes WHERE id_curso = :id_curso";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_curso', $this->__get('id_curso'));
            $stmt->execute();    

        }

        public function getSecoes() {

            $query = "SELECT s.id , s.id_curso , s.nome AS 'secao', s.status  FROM secoes s LEFT JOIN cursos c ON c.id = s.id_curso";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            $secoes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $secoes;

        }

        public function getSecoesPorCursoStatus() {

            $query = "SELECT s.id , s.id_curso , s.nome AS 'secao', s.status  FROM secoes s LEFT JOIN cursos c ON c.id = s.id_curso WHERE s.id_curso = :id_curso AND s.status = 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_curso', $this->__get('id_curso'));
            $stmt->execute();

            $secoes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $secoes;

        }

        public function getSecoesPorCurso() {

            $query = "SELECT s.id , s.id_curso , s.nome AS 'secao', s.status  FROM secoes s LEFT JOIN cursos c ON c.id = s.id_curso WHERE s.id_curso = :id_curso";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_curso', $this->__get('id_curso'));
            $stmt->execute();

            $secoes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $secoes;

        }
    }