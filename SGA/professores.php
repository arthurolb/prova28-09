<?php


include_once "estrutura/Template.php";
require_once "dao/professorDAO.php";
require_once "classes/professor.php";

$template = new Template();
$object = new professorDAO();

$template->header();
$template->sidebar();
$template->navbar();


// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
    $cargo = (isset($_POST["cargo"]) && $_POST["cargo"] != null) ? $_POST["cargo"] : "";
} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $nome = NULL;
    $cargo = NULL;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

    $professor = new professor($id, '', '');

    $resultado = $object->atualizar($professor);
    $nome = $resultado->getNome();
    $cargo = $resultado->getCargo();
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != "" && $cargo != "") {
    $professor = new professor($id, $cargo, $nome);
    $msg = $object->salvar($professor);
    $id = null;
    $nome = null;
    $cargo = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $professor = new professor($id, '', '');
    $msg = $object->remover($professor);
    $id = null;
}

?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Professor</h4>
                        <p class='category'>Lista de professores do sistema</p>

                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&id=" method="POST" name="form1">
                            <hr>
                            <i class="ti-save"></i>
                            <input type="hidden" name="id" value="<?php
                            // Preenche o id no campo id com um valor "value"
                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>"/>
                            Nome:
                            <input type="text" size="50" name="nome" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : '';
                            ?>"/>
                            Cargo:
                            <input type="numer" size="7" name="cargo" value="<?php
                            // Preenche o sigla no campo sigla com um valor "value"
                            echo (isset($cargo) && ($cargo != null || $cargo != "")) ? $cargo : '';
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
