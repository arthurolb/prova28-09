<?php
/**
 * Created by PhpStorm.
 * User: aluno
 * Date: 16/03/2018
 * Time: 21:16
 */

include_once "estrutura/Template.php";
require_once "dao/avaliacaoDAO.php";
require_once "classes/avaliacao.php";

$template = new Template();
$object = new avaliacaoDAO();

$template->header();
$template->sidebar();
$template->navbar();


// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $cursoIdCurso = (isset($_POST["cursoIdCurso"]) && $_POST["cursoIdCurso"] != null) ? $_POST["cursoIdCurso"] : "";
    $turmaIdTurma = (isset($_POST["turmaIdTurma"]) && $_POST["turmaIdTurma"] != null) ? $_POST["turmaIdTurma"] : "";  
    $alunoIdAluno = (isset($_POST["alunoIdAluno"]) && $_POST["alunoIdAluno"] != null) ? $_POST["alunoIdAluno"] : "";
    $nota1 = (isset($_POST["nota1"]) && $_POST["nota1"] != null) ? $_POST["nota1"] : "";
    $nota2 = (isset($_POST["nota2"]) && $_POST["nota2"] != null) ? $_POST["nota2"] : "";
    $notaFinal = (isset($_POST["notaFInal"]) && $_POST["notaFInal"] != null) ? $_POST["notaFInal"] : "";
} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id= (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $cursoIdCurso = NULL;
    $turmaIdTurma = NULL;
    $alunoIdAluno = NULL;
    $nota1 = NULL;
    $nota2 = NULL;
    $notaFinal = NULL;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

    $avaliacao = new avaliacao($id, '', '','','','','');

    $resultado = $object->atualizar($avaliacao);
    $cursoIdCurso = $resultado->getCursoIdCurso();
    $turmaIdTurma = $resultado->getTurmaIdTurma();
    $alunoIdAluno = $resultado->getAlunoIdAluno();
    $nota1 = $resultado->getNota1();
    $nota2 = $resultado->getNota2();
    $notaFinal = $resultado->getNotaFinal();
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save") {
   
    $avaliacao = new avaliacao('', $cursoIdCurso, $turmaIdTurma, $alunoIdAluno, $nota1, $nota2, $notaFinal);
    var_dump($avaliacao);
    $msg = $object->salvar($avaliacao);
    $id = null;
    $cursoIdCurso = null;
    $turmaIdTurma = null;
    $alunoIdAluno = null;
    $nota1 = null;
    $nota2 = null;
    $notaFinal = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $avaliacao = new avaliacao($id, '', '','','','','');
    $msg = $object->remover($avaliacao);
    $id = null;
}

?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Avaliacões</h4>
                        <p class='category'>Lista de Avaliações do sistema</p>

                    </div>
                    <div class='content table-responsive'>

                         <form action="?act=save&id=" method="POST" name="form1">
                            <hr>
                            <i class="ti-save"></i>
                            <input type="hidden" name="id" value="<?php
                            // Preenche o id no campo id com um valor "value"
                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>"/>
                            Curso:
                            <input type="text" size="50" name="cursoIdCurso" value="<?php
                            // Preenche o cursoIdCurso no campo cursoIdCurso com um valor "value"
                            echo (isset($cursoIdCurso) && ($cursoIdCurso != null || $cursoIdCurso != "")) ? $cursoIdCurso : '';
                            ?>"/>
                            Turma:
                            <input type="text" size="7" name="turmaIdTurma" value="<?php
                            // Preenche o sigla no campo sigla com um valor "value"
                            echo (isset($turmaIdTurma) && ($turmaIdTurma != null || $turmaIdTurma != "")) ? $turmaIdTurma : '';
                            ?>"/>
                                                      Aluno:
                            <input type="text" size="50" name="alunoIdAluno" value="<?php
                            // Preenche o alunoIdAluno no campo alunoIdAluno com um valor "value"
                            echo (isset($alunoIdAluno) && ($alunoIdAluno != null || $alunoIdAluno != "")) ? $alunoIdAluno : '';
                            ?>"/>
                            Nota1:
                            <input type="numer" size="7" name="nota1" value="<?php
                            // Preenche o sigla no campo sigla com um valor "value"
                            echo (isset($nota1) && ($nota1 != null || $nota1 != "")) ? $nota1 : '';
                            ?>"/>
                                                      Nota2:
                            <input type="text" size="50" name="nota2" value="<?php
                            // Preenche o nota2 no campo nota2 com um valor "value"
                            echo (isset($nota2) && ($nota2 != null || $nota2 != "")) ? $nota2 : '';
                            ?>"/>
                            NotaFinal:
                            <input type="numer" size="7" name="notaFinal" value="<?php
                            // Preenche o sigla no campo sigla com um valor "value"
                            echo (isset($notaFinal) && ($notaFinal != null || $notaFinal != "")) ? $notaFinal : '';
                            ?>"/>
                     
                            <input type="submit" VALUE="Cadastrar"/>
                            <hr>
                        </form>


                        <?php

                        echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';

                        //chamada a paginação
                        $object->tabelapaginada();

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$template->footer();
?>
