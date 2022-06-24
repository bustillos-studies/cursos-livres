<?php

    namespace app\models;

    use MF\Model\Model;

    class Curso extends Model {

        private $id;
        private $nome;
        private $descricao;
        private $img;
        private $professor_id;
        private $status;
        private $legenda;

        public function __get($atributo) {
            return $this->$atributo;
        }
        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }

        public function criar() {

            $query = "INSERT INTO cursos (nome, descricao, id_professor, status) VALUES (:nome, :descricao, :id_professor, :status)";
            // Receber o PDO (a classe db recebe a instância do PDO na classe extendida Model)
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':descricao', $this->__get('descricao'));
            $stmt->bindValue(':id_professor', $this->__get('professor_id'));
            $stmt->bindValue(':status', $this->__get('status'));

            $stmt->execute();

            return $this;

        }

        public function editar() {

            $query = "UPDATE cursos SET nome = :nome, descricao = :descricao, status = :status WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':descricao', $this->__get('descricao'));
            $stmt->bindValue(':status', $this->__get('status'));
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $this;
        }

        public function apagar() {

            $query = "DELETE FROM cursos WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $this;

        }

        public function getCursos() {

            $query = "SELECT c.id, c.nome AS 'curso', c.descricao, u.nome, u.sobrenome, c.status, c.img, c.id_professor FROM cursos c LEFT JOIN usuarios u ON u.id = c.id_professor";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            $curso = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $curso;

        }

        public function updateImg() {
            $query = "UPDATE cursos SET img = :id WHERE cursos.id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

        }

        public function getCursoPorNome() {

            $query = "SELECT id, nome  FROM cursos WHERE nome = :nome";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->execute();

            $curso = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $curso;

        }
    }