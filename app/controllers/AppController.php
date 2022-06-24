<?php

    namespace app\controllers;

    // Recursos do miniframework
    use MF\Controller\Action;
    use MF\Model\Container;

    class AppController extends Action {

        public function inicio() {

            $this->validaAutenticacao();

            $this->titulo = 'Início';

            $curso = Container::getModel('Curso');
            $this->cursos = $curso->getCursos();

            $this->render('inicio');

        }

        public function curso() {

            $this->validaAutenticacao();

            $curso = Container::getModel('Curso');
            $cursos = $curso->getCursos();
            
            foreach ($cursos as $i => $curso) {
                if($curso['id'] == $_GET['id']) {
                    $this->curso = $curso;
                }
            }

            $secao = Container::getModel('Secao');
            $secao->__set('id_curso', $_GET['id']);
            $this->secoes = $secao->getSecoesPorCursoStatus();

            $aula = Container::getModel('Aula');
            $aula->__set('id_curso', $_GET['id']);
            $this->aulas = $aula->getAulasPorCurso();


            $this->titulo = $this->curso['curso'];

            $this->render('curso/curso');

        }

        public function perfil() {

            $this->validaAutenticacao();

            $this->titulo = 'Meu perfil';

            $this->view->erroAlterar = false;

            $this->render('usuario/perfil');

        }

        public function perfilEstudante() {

            $this->validaAutenticacao();
            $this->titulo = 'Estudante';
            
            if($_SESSION['tipo'] >= 2) {

                if (isset($_GET['id'])) {

                    $estudante = Container::getModel('Usuario');
                    $estudante->__set('id', $_GET['id']);
                    $dados = $estudante->getEstudantePorId();
                    $this->estudante = $dados[0];

                    $this->view->erroAlterar = false;

                    $this->render('estudantes/perfilEstudante');

                } else {

                    header('Location: /estudantes');

                }

            } else {

                header('Location: /inicio');

            }

        }

        public function alterarPerfilEstudante() {

            $this->validaAutenticacao();

            if ($_SESSION['tipo'] >= 2) {

                $verifica_email = $this->verificarEmail($_POST['email'], $_POST['id']);

                if($verifica_email) {

                    header('Location: /estudante?status=2&id='.$_POST['id']);

                } else {

                    $usuario = Container::getModel('Usuario');

                    $usuario->__set('id', $_POST['id']);
                    $usuario->__set('nome', $_POST['nome']);
                    $usuario->__set('sobrenome', $_POST['sobrenome']);

                    $usuario->__set('email', $_POST['email']);
                    $usuario->__set('cel', $_POST['cel']);
                    $usuario->__set('tel', $_POST['tel']);

                    $dados = $usuario->getEstudantePorId();
                    $this->estudante = $dados[0];
              

                    if ($_POST['tipo'] == '') {
                        $usuario->__set('tipo', $this->estudante['tipo']);
                    } else if ($_POST['tipo'] != '' && $_POST['tipo'] != 'null') {
                        $usuario->__set('tipo', $_POST['tipo']);
                    }

                    if ($_POST['senhanova'] != ''){
                    $usuario->__set('senhanova', md5($_POST['senhanova']));
                    } 
                    
                    if($usuario->alterar()) {

                    $this->view->erroAlterar = false;
                    $this->titulo = 'Estudante';

                    header('Location: /estudante?status=1&id='.$this->estudante['id']);

                    }

                }
    
            }  else {

                header('Location: /inicio');

            } 
        }

        public function alterarPerfil() {

            $this->validaAutenticacao();

            $verifica_email = $this->verificarEmail($_POST['email'], $_SESSION['id']);

            if($verifica_email) {

                header('Location: /perfil?status=2');

            } else {
                
                $usuario = Container::getModel('Usuario');

                $usuario->__set('id', $_POST['id']);
                $usuario->__set('nome', $_POST['nome']);
                $usuario->__set('sobrenome', $_POST['sobrenome']);
                $usuario->__set('email', $_POST['email']);
                $usuario->__set('cel', $_POST['cel']);
                $usuario->__set('tel', $_POST['tel']);
				$usuario->__set('tipo', $_SESSION['tipo']);
                

                if ($_POST['senha'] != '' && $_POST['senhanova'] != ''){
                $usuario->__set('senhanova', md5($_POST['senhanova']));
                $usuario->__set('senha', md5($_POST['senhanova']));
                } 
                
                if($usuario->alterar()) {

                    session_destroy();

                    $usuario = Container::getModel('Usuario');

                    $retorno = $usuario->reAutenticar();

                    if ($usuario->__get('id') != '' && $usuario->__get('nome') != '') {
                        
                        session_start();

                        $_SESSION['id'] = $usuario->__get('id');
                        $_SESSION['nome'] = $usuario->__get('nome');
                        $_SESSION['sobrenome'] = $usuario->__get('sobrenome');
                        $_SESSION['email'] = $usuario->__get('email');
                        $_SESSION['cel'] = $usuario->__get('cel');
                        $_SESSION['tel'] = $usuario->__get('tel');
                        $_SESSION['tipo'] = $usuario->__get('tipo');

                    }

                $this->view->erroAlterar = false;
                $this->titulo = 'Alterar perfil';

                header('Location: /perfil?status=1');

                }
            }
        }

        // Sistema para "Esqueci a senha" - Em desenvolvimento... 
            // public function alterarSenhaPerfil() {

            //     $email = $_POST['email'];
            //     $verificar_email = $this->verificarEmail($email);
                
            //     if ($verificar_email) {


            //     }

            // }

            // public function gerarSenha($tamanho, $maiusculas, $minusculas, $numeros, $simbolos){
            //     $senha = "";
            //     $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
            //     $mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
            //     $nu = "0123456789"; // $nu contem os números
            //     $si = "@*"; // $si contem os símbolos
            
            //     if ($maiusculas){
            //           // se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $senha
            //           $senha .= str_shuffle($ma);
            //     }
            
            //     if ($minusculas){
            //         // se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $senha
            //         $senha .= str_shuffle($mi);
            //     }
            
            //     if ($numeros){
            //         // se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $senha
            //         $senha .= str_shuffle($nu);
            //     }
            
            //     if ($simbolos){
            //         // se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $senha
            //         $senha .= str_shuffle($si);
            //     }
            
            //     // retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho
            //     return substr(str_shuffle($senha),0,$tamanho);
            // }

        public function deletarPerfil(){

            $this->validaAutenticacao();
            if ($_SESSION['tipo'] == 1) {

                $usuario = Container::getModel('Usuario');
                $usuario->__set('id',$_SESSION['id']);
                $usuario->deletar();

                $this->titulo = 'Deletar perfil';
                $this->render('usuario/deletarPerfil');
                session_destroy();

            } else if ($_SESSION['tipo'] > 1) {

                $usuario = Container::getModel('Usuario');
                $usuario->__set('id',$_GET['id']);
                $usuario->deletar();

                
                header('Location: /estudantes');

            }

        }

        public function cursos() {

            $this->validaAutenticacao();

            $this->titulo = 'Cursos';
            
            if($this->tipo['numero'] >= 2) {

                    
                $curso = Container::getModel('Curso');
                
                $this->cursos = $curso->getCursos();



                $secao = Container::getModel('Secao');

                $this->secoes = $secao->getSecoes();
                
                if(isset($_GET['idc'])) {
                    $secao->__set('id_curso', $_GET['idc']);
                    $this->secoesPorCurso = $secao->getSecoesPorCurso();
                }



                $aula = Container::getModel('Aula');

                $this->aulas = $aula->getAulas();

                if(isset($_GET['idse'])) {
                    $aula->__set('id_secao', $_GET['idse']);
                    $this->aulasPorSecao = $aula->getAulasPorSecao();
                }

                $this->render('cursos');

            } else {

                header('Location: /inicio');

            }

        }

        // ------------------------------------ //

        public function criarCurso() {

            $this->validaAutenticacao();

            $this->titulo = 'Criar curso';
            
            if($this->tipo['numero'] >= 2) {

                $verifica = $this->verificarNomeCurso($_POST['nome']);

                if (!$verifica){

                    $curso = Container::getModel('Curso');
                    $nome_curso = $_POST['nome'];
                    $curso->__set('nome', $_POST['nome']);
                    $curso->__set('descricao', $_POST['descricao']);
                    $curso->__set('professor_id', $_SESSION['id']);
                    $curso->__set('status', 1);
                    $curso->criar();

                    // if(isset($_FILES['img'])) {

                    //     $extensao = strtolower(substr($_FILES['img']['name'], -4));
                    //     $novoNome = md5(time()) . $extensao;
                    //     $diretorio = "upload/";

                    //     move_uploaded_file($_FILES['img']['tmp_name'], $diretorio.$novoNome);

                    //     $curso->__set();

                    // }

                    
                    $curso->__set('nome', $nome_curso);
                    $infoCurso = $curso->getCursoPorNome();
                    $legenda = $infoCurso[0]['id'];
                    $curso->__set('id', $legenda);
                    $curso->updateImg();

                    // Salvar img na pasta
                    $this->imgInsert($legenda);

                    header('Location: /cursos?status=1#cursoc');
                
                } else {
                    
                    header('Location: /cursos?erro=existe#cursoc');
                }

            } else {

                header('Location: /inicio');

            }
        }

        public function verificarNomeCurso($nome) {
            $curso = Container::getModel('Curso');
            $cursos = $curso->getCursos();
            $erro = 0;
            foreach ($cursos as $key => $unidade_curso) {
                if($unidade_curso['curso'] == $nome) { 
                    $erro = 1;
                }
            }
            return $erro;
        }
        
        public function imgInsert($legenda) {

            $img = $_FILES['img'];
            $tamanho = 100000;  // 1MB
            $erro = 0;

            // Validar tipo de imagem

            if (!preg_match('/^(image)\/(jpeg)$/', $img['type'])) {
                $erro = 'A imagem deve ser do tipo .JPG';
            }

            // Validar tamanho
            if ($img['size'] > $tamanho) {
                $erro = 'A imagem precisa ser menor que 1MB';
            }

            if ($erro == 0) {
                
                $ext = pathinfo($img['name']);

                $nome_img = $legenda.'.'.$ext['extension'];

                $caminho_img = $_SERVER['DOCUMENT_ROOT'].'/img/'.$nome_img;

                move_uploaded_file($img['tmp_name'], $caminho_img);

            } else {
                return $erro;
            }

        }

        // ------------------------------------------------------------------------- //


        public function editarCurso() {

            $this->validaAutenticacao();

            $this->titulo = 'Editar curso';

            if($this->tipo['numero'] >= 2) {

                $curso = Container::getModel('Curso');

                $cursos = $curso->getCursos();

                $i = 0;
                while ($cursos[$i]['id'] != $_POST['id']) {
                    $i++;
                }

                if($cursos[$i]['id'] == $_POST['id']) {

                    if ($_POST['id'] == '') {
                        $curso->__set('id', $cursos[$i]['id']);
                    } else if ($_POST['id'] != '') {
                        $curso->__set('id', $_POST['id']);
                    }

                    if ($_POST['nome'] == '') {
                        $curso->__set('nome', $cursos[$i]['curso']);
                    } else if ($_POST['nome'] != '') {
                        $curso->__set('nome', $_POST['nome']);
                    }

                    if ($_POST['descricao'] == '') {
                        $curso->__set('descricao', $cursos[$i]['descricao']);
                    } else if ($_POST['descricao'] != '') {
                        $curso->__set('descricao', $_POST['descricao']);
                    }
                    
                    if ($_POST['status'] == '') {
                        $curso->__set('status', $cursos[$i]['status']);
                    } else if ($_POST['status'] != '') {
                        $curso->__set('status', $_POST['status']);
                    }
                }

                $curso->editar();
                
                header('Location: /cursos?status=2#cursoe');

            } else {

                header('Location: /inicio');

            }

        }

        public function apagarCurso() {

            $this->validaAutenticacao();

            $this->titulo = 'Apagar curso';

            if($this->tipo['numero'] >= 2) {

                $curso = Container::getModel('Curso');
                $id_curso = $_POST['id'];
                $curso->__set('id', $_POST['id']);
                
                $secao = Container::getModel('Secao');
                $secao->__set('id_curso', $id_curso);

                $secoes = $secao->getSecoesPorCurso();
                foreach($secoes as $key => $unidade_secao){
                    $id_secao = $unidade_secao['id'];
                    
                    $aula = Container::getModel('Aula');
                    $aula->__set('id_secao', $id_secao);
                    $aula->apagarAulasPorSecao();
                }

                $secao->apagarSecoesPorCurso();
                $curso->apagar();

                unlink($_SERVER['DOCUMENT_ROOT']."/img/".$id_curso.".jpg");
                
                header('Location: /cursos?status=3#cursoa');

            } else {
                header('Location: /inicio');
            }

        }
        
        public function criarSecao() {

            $this->validaAutenticacao();

            $this->titulo = 'Criar seção';
            
            if($this->tipo['numero'] >= 2) {

                $secao = Container::getModel('Secao');
                $secao->__set('nome', $_POST['nome']);
                $secao->__set('id_curso', $_POST['id_curso']);
                if($_POST['status'] != '') {
                    $secao->__set('status', $_POST['status']);
                } else if ($_POST['status'] == '') {
                    $secao->__set('status', 1);
                }
                $secao->criar();

                header('Location: /cursos?status=4#secaoc');

            } else {

                header('Location: /inicio');

            }
        }
        
        public function editarSecao() {

            $this->validaAutenticacao();

            $this->titulo = 'Editar seção';

            if($this->tipo['numero'] >= 2) {

                $secao = Container::getModel('Secao');

                $secao->__set('id_curso', $_POST['id_curso']);

                $secoes = $secao->getSecoes();

                $i = 0;
                while ($secoes[$i]['id'] != $_POST['id']) {
                    $i++;
                }

                $secao->__set('id', $_POST['id']);

                if ($_POST['id_curso'] == '') {
                    $secao->__set('id_curso', $secoes[$i]['id_curso']);
                } else if ($_POST['id_curso'] != '') {
                    $secao->__set('id_curso', $_POST['id_curso']);
                }

                if ($_POST['nome'] == '') {
                    $secao->__set('nome', $secoes[$i]['secao']);
                } else if ($_POST['nome'] != '') {
                    $secao->__set('nome', $_POST['nome']);
                }
                
                if ($_POST['status'] == '') {
                    $secao->__set('status', $secoes[$i]['status']);
                } else if ($_POST['status'] != '') {
                    $secao->__set('status', $_POST['status']);
                }

                $secao->editar();
                
                header('Location: /cursos?status=5#secaoe');

            } else {

                header('Location: /inicio');

            }

        }
        
        public function apagarSecao() {

            $this->validaAutenticacao();

            $this->titulo = 'Apagar seção';

            if($this->tipo['numero'] >= 2) {

                $secao = Container::getModel('Secao');
                $secao->__set('id', $_POST['id']);

                $secoes = $secao->getSecoes();
                foreach($secoes as $key => $unidade_secao){
                    $id_secao = $unidade_secao['id'];
                    
                    $aula = Container::getModel('Aula');
                    $aula->__set('id_secao', $id_secao);
                    $aula->apagarAulasPorSecao();
                }

                $secao->apagar();
                
                header('Location: /cursos?status=6#secaoa');

            } else {
                header('Location: /inicio');
            }

        }

        public function criarAula() {

            $this->validaAutenticacao();

            $this->titulo = 'Criar aula';
            
            if($this->tipo['numero'] >= 2) {

                $aula = Container::getModel('Aula');
                $aula->__set('id_secao', $_POST['id_secao']);
                $aula->__set('titulo', $_POST['titulo']);
                $aula->__set('descricao', $_POST['descricao']);

                if($_POST['status'] != '') {
                    $aula->__set('status', $_POST['status']);
                } else if ($_POST['status'] == '') {
                    $aula->__set('status', 1);
                }

                $aula->criar();

                header('Location: /cursos?status=7#aulac');

            } else {

                header('Location: /inicio');

            }
        }
        
        public function editarAula() {

            $this->validaAutenticacao();

            $this->titulo = 'Editar aula';

            if($this->tipo['numero'] >= 2) {

                $aula = Container::getModel('Aula');

                $aula->__set('id_secao', $_POST['id_secao']);

                $aulas = $aula->getAulasPorSecao();

                $i = 0;
                while ($aulas[$i]['id'] != $_POST['id']) {
                    $i++;
                }

                $aula->__set('id', $_POST['id']);

                if ($_POST['titulo'] == '') {
                    $aula->__set('titulo', $aulas[$i]['titulo']);
                } else if ($_POST['titulo'] != '') {
                    $aula->__set('titulo', $_POST['titulo']);
                }

                if ($_POST['descricao'] == '') {
                    $aula->__set('descricao', $aulas[$i]['descricao']);
                } else if ($_POST['descricao'] != '') {
                    $aula->__set('descricao', $_POST['descricao']);
                }
                
                if ($_POST['status'] == '') {
                    $aula->__set('status', $aulas[$i]['status']);
                } else if ($_POST['status'] != '') {
                    $aula->__set('status', $_POST['status']);
                }

                $aula->editar();
                
                header('Location: /cursos?status=8#aulae');

            } else {

                header('Location: /inicio');

            }

        }
        
        public function apagarAula() {

            $this->validaAutenticacao();

            $this->titulo = 'Apagar aula';

            if($this->tipo['numero'] >= 2) {

                $aula = Container::getModel('Aula');

                $aula->__set('id', $_POST['id']);

                $aula->apagar();
                
                header('Location: /cursos?status=9#aulaa');

            } else {
                header('Location: /inicio');
            }

        }

        public function validaAutenticacao() {

            session_start();

            if(!isset($_SESSION['id']) || $_SESSION['id'] == '' && !isset($_SESSION['nome']) || $_SESSION['nome'] == '' ) {
                header('Location: /?login=erro2');
            }

            $usuario = Container::getModel('Usuario');
            $usuario->__set('id', $_SESSION['id']);
            $usuario->__set('nome', $_SESSION['nome']);
            $usuario->__set('sobrenome', $_SESSION['sobrenome']);
            $usuario->__set('email', $_SESSION['email']);
            $usuario->__set('cel', $_SESSION['cel']);
            $usuario->__set('tel', $_SESSION['tel']);
            $usuario->__set('tipo', $_SESSION['tipo']);

            if($_SESSION['tipo'] == 1) {
                $this->tipo['cargo'] = 'Estudante';
                $this->tipo['numero'] = 1;
            } else if ($_SESSION['tipo'] == 2) {
                $this->tipo['cargo'] = 'Professor';
                $this->tipo['numero'] = 2;
            } else if ($_SESSION['tipo'] == 3) {
                $this->tipo['cargo'] = 'Desenvolvedor';
                $this->tipo['numero'] = 3;
            }

        }

        public function estudantes() {

            $this->validaAutenticacao();
            $this->titulo = 'Estudantes';
            
            if ($_SESSION['tipo'] >= 2) {

                $usuario = Container::getModel('Usuario');
                $this->estudantes = $usuario->getEstudantes();
                
                $this->render('estudantes/estudantes');
            } else {
                header('Location: /inicio');
            }
        }

        public function verificarEmail($email, $id) {

            $usuario = Container::getModel('Usuario');
            $emails = $usuario->getEmails();

            $existe = 0;
            foreach($emails as $key => $itemEmail){

                if($email == $itemEmail['email']){

                    if($id != $itemEmail['id']) {
                        $existe = 1;
                    }

                } 
            }

            return $existe;

        }
    }
?>