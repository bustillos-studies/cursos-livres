<?php

    namespace app\models;

    use MF\Model\Model;

    class Aula extends Model {

        private $id;
        private $id_secao;
        private $id_curso;
        private $titulo;
        private $descricao;
        private $status;

        public function __get($atributo) {
            return $this->$atributo;
        }
        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }

        public function criar() {

            $query = "INSERT INTO aulas (id_secao, titulo, descricao, status) VALUES (:id_secao, :titulo, :descricao, :status)";
            // Receber o PDO (a classe db recebe a instância do PDO na classe extendida Model)
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_secao', $this->__get('id_secao'));
            $stmt->bindValue(':titulo', $this->__get('titulo'));
            $stmt->bindValue(':descricao', $this->__get('descricao'));
            $stmt->bindValue(':status', $this->__get('status'));
            $stmt->execute();

            return $this;

        }

        public function editar() {

            $query = "UPDATE aulas SET titulo = :titulo, descricao = :descricao, id_secao = :id_secao, status = :status WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':titulo', $this->__get('titulo'));
            $stmt->bindValue(':descricao', $this->__get('descricao'));
            $stmt->bindValue(':id_secao', $this->__get('id_secao'));
            $stmt->bindValue(':status', $this->__get('status'));
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $this;
        }

        public function apagar() {

            $query = "DELETE FROM aulas WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $this;

        }

        public function getAulas() {

            $query = "SELECT a.id , a.id_secao , a.titulo, a.descricao, a.status  FROM aulas a LEFT JOIN secoes s ON s.id = a.id_secao";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            $aulas = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $aulas;

        }

        public function getAulasPorSecao() {

            $query = "SELECT a.id , a.id_secao , a.titulo, a.descricao, a.status  FROM aulas a LEFT JOIN secoes s ON s.id = a.id_secao WHERE a.id_secao = :id_secao";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_secao', $this->__get('id_secao'));
            $stmt->execute();

            $aulas = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $aulas;

        }

        public function apagarAulasPorSecao() {

            $query = "DELETE FROM aulas WHERE id_secao = :id_secao";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_secao', $this->__get('id_secao'));
            $stmt->execute();

            return $this;

        }

        public function getAulasPorCurso() {

            $query = "SELECT a.id , a.id_secao , a.titulo, a.descricao, a.status, s.id_curso FROM aulas a LEFT JOIN secoes s ON s.id = a.id_secao WHERE s.id_curso = :id_curso AND a.status = 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_curso', $this->__get('id_curso'));
            $stmt->execute();

            $aulas = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $aulas;

        }
    }

        