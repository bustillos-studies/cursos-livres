<?php

    namespace app\models;

    use MF\Model\Model;

    class Usuario extends Model {

        private $id;
        private $nome;
        private $sobrenome;
        private $email;
        private $senha;
        private $cel;
        private $tel;
        private $senhanova;
        private $tipo;
        private $estudantes;

        public function __get($atributo) {
            return $this->$atributo;
        }
        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }

        // Salvar o cadastro
        public function salvar() {

            $query = "INSERT INTO usuarios(nome, sobrenome, email, senha, cel, tel) VALUES (:nome, :sobrenome, :email, :senha, :cel, :tel)";
            // Receber o PDO (a classe db recebe a instância do PDO na classe extendida Model)
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':sobrenome', $this->__get('sobrenome'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':senha', $this->__get('senha')); // md5 = criptografia = hash de 32 caracteres
            $stmt->bindValue(':cel', $this->__get('cel'));
            $stmt->bindValue(':tel', $this->__get('tel'));
            $stmt->execute();

            return $this;
        }

        public function deletar() {
            $query = "DELETE FROM usuarios WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $this;
        }

        // Validar cadastro
        public function validarCadastro() {
            $valido = true;

            if(strlen($this->__get('nome')) < 3) {
                $valido = false;
            }
            if(strlen($this->__get('sobrenome')) < 3) {
                $valido = false;
            }
            if(strlen($this->__get('email')) < 3) {
                $valido = false;
            }
            if(strlen($this->__get('senha')) < 3) {
                $valido = false;
            }

            return $valido;
        }

        public function alterar() {

            $query = "UPDATE usuarios SET nome = :nome, sobrenome = :sobrenome, email = :email, cel = :cel, tel = :tel, tipo = :tipo WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':sobrenome', $this->__get('sobrenome'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':cel', $this->__get('cel'));
            $stmt->bindValue(':tel', $this->__get('tel'));
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':tipo', $this->__get('tipo'));
            $stmt->execute();

            if ($this->__get('senhanova') != '' && $this->__get('senha') != '') {

                $query2 = "SELECT senha FROM usuarios WHERE id = :id";
                $stmt2 = $this->db->prepare($query2);
                $stmt2->bindValue(':id', $this->__get('id'));
                $stmt2->execute();

                $senhaAtual = $stmt2->fetchAll(\PDO::FETCH_ASSOC);
                $senhaAtual = $senhaAtual[0]['senha'];

                if ($this->__get('senha') == $senhaAtual) {

                    $query3 = "UPDATE usuarios SET senha = :novasenha WHERE id = :id";
                    $stmt3 = $this->db->prepare($query3);
                    $stmt3->bindValue(':id', $this->__get('id'));
                    $stmt3->bindValue(':novasenha', $this->__get('senhanova'));
                    $stmt3->execute();

                }
            }

            if ($this->__get('senhanova') != '' && $_SESSION['tipo'] >= 2 && $_SESSION['id'] != $this->__get['id']) {

                $query3 = "UPDATE usuarios SET senha = :novasenha WHERE id = :id";
                $stmt3 = $this->db->prepare($query3);
                $stmt3->bindValue(':id', $this->__get('id'));
                $stmt3->bindValue(':novasenha', $this->__get('senhanova'));
                $stmt3->execute();

            }

            return $this;

        }

        // Recuperar um usuário por email para fazer login
        public function getUsuarioPorEmail() {

            $query = "SELECT nome, email FROM usuarios WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }


        // Validar o login com o email e senha
        public function autenticar() {
            
            $query = "SELECT id, nome, sobrenome, email, cel, tel, tipo FROM usuarios WHERE email = :email AND senha = :senha";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':senha', $this->__get('senha'));
            $stmt->execute();

            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if ($usuario['id'] != '' && $usuario['nome'] != '') {
                
                $this->__set('id', $usuario['id']);
                $this->__set('nome', $usuario['nome']);
                $this->__set('sobrenome', $usuario['sobrenome']);
                $this->__set('cel', $usuario['cel']);
                $this->__set('tel', $usuario['tel']);
                $this->__set('tipo', $usuario['tipo']);

            }

            return $this;
        }

        // Validar o login com o email e senha
        public function reAutenticar() {
            
            $query = "SELECT id, nome, sobrenome, email, cel, tel, tipo FROM usuarios WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $_SESSION['id']);
            $stmt->execute();

            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if ($usuario['id'] != '' && $usuario['nome'] != '') {
                $this->__set('id', $usuario['id']);
                $this->__set('nome', $usuario['nome']);
                $this->__set('sobrenome', $usuario['sobrenome']);
                $this->__set('email', $usuario['email']);
                $this->__set('cel', $usuario['cel']);
                $this->__set('tel', $usuario['tel']);
                $this->__set('tipo', $usuario['tipo']);
            }

            return $this;
        }

        public function getEstudantes() {
            $query = "SELECT id, nome, sobrenome, email, cel, tel, tipo FROM usuarios WHERE tipo = 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getEstudantePorId() {
            $query = "SELECT id, nome, sobrenome, email, cel, tel, tipo FROM usuarios WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getEmails() {
            $query = "SELECT email, id FROM usuarios";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

?>