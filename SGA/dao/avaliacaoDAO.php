<?php


require_once "db/conexao.php";
require_once "classes/avaliacao.php";

class avaliacaoDAO
{

    public function remover($avaliacao)
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("DELETE FROM avaliacao WHERE idAliacao = :id");
            $statement->bindValue(":id", $avaliacao->getIdAvaliacao());
            if ($statement->execute()) {
                return "Registo foi excluído com êxito";
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function salvar($avaliacao)
    {
       
        global $pdo;
        
        try {
            if ($avaliacao->getIdAvaliacao() != "") {
                $statement = $pdo->prepare("UPDATE avaliacao SET Curso_idCurso=:cursoIdCurso, Turma_idTurma=:turmaIdTurma, Aluno_idAluno=:alunoIdAluno, Nota1=:nota1, Nota2=:nota2, NotaFinal-:notaFinal   WHERE idAvaliacao = :id;");
                $statement->bindValue(":id", $avaliacao->getIdAvaliacao());
            } else {
                $statement = $pdo->prepare("INSERT INTO avaliacao (Curso_idCurso, Turma_idTurma, Aluno_idAluno,Nota1,Nota2,NotaFinal) VALUES (:cursoIdCurso, :turmaIdTurma,:alunoIdAluno, :nota1, :nota2,:notaFinal)");
            }
            $statement->bindValue(":cursoIdCurso", $avaliacao->getCursoIdCurso());
            $statement->bindValue(":turmaIdTurma", $avaliacao->getTurmaIdTurma());
            $statement->bindValue(":alunoIdAluno", $avaliacao->getAlunoIdAluno());
            $statement->bindValue(":nota1", $avaliacao->getNota1());
            $statement->bindValue(":nota2", $avaliacao->getNota2());
            $statement->bindValue(":notaFinal", $avaliacao->getNotaFinal());
            var_dump($statement);
           
            

            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    return "Dados cadastrados com sucesso!";
                } else {
                    return "Erro ao tentar efetivar cadastro";
                }
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function atualizar($avaliacao)
    {
        
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT * FROM avaliacao WHERE idAvaliacao = :id");
            $statement->bindValue(":id", $avaliacao->getIdAvaliacao());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $avaliacao->setIdAvaliacao($rs->idAvaliacao);
                $avaliacao->setCursoIdCurso($rs->cursoIdCurso);
                $avaliacao->setTurmaIdTurma($rs->turmaIdTurma);
                $avaliacao->setAlunoIdAluno($rs->alunoIdAluno);
                $avaliacao->setNota1($rs->nota1);      
                $avaliacao->setNota2($rs->nota2);     
                $avaliacao->setNotaFinal($rs->notaFinal);

        

 
                return $avaliacao;
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function tabelapaginada()
    {

        //carrega o banco
        global $pdo;

        //endereço atual da página
        $endereco = $_SERVER ['PHP_SELF'];

        /* Constantes de configuração */
        define('QTDE_REGISTROS', 10);
        define('RANGE_PAGINAS', 2);

        /* Recebe o número da página via parâmetro na URL */
        $pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;

        /* Calcula a linha inicial da consulta */
        $linha_inicial = ($pagina_atual - 1) * QTDE_REGISTROS;

        /* Instrução de consulta para paginação com MySQL */
        $sql = "select ava.IdAvaliacao, ava.Curso_idCurso , a.Nome as Aluno, t.Nome as Turma, ava.Nota1, ava.Nota2, ava.NotaFinal
        FROM avaliacao ava
         JOIN aluno a ON a.idAluno = ava.Aluno_idAluno
         JOIN turma t ON t.idTurma = ava.Turma_idTurma LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM avaliacao";
        $statement = $pdo->prepare($sqlContador);
        $statement->execute();
        $valor = $statement->fetch(PDO::FETCH_OBJ);

        /* Idêntifica a primeira página */
        $primeira_pagina = 1;

        /* Cálcula qual será a última página */
        $ultima_pagina = ceil($valor->total_registros / QTDE_REGISTROS);

        /* Cálcula qual será a página anterior em relação a página atual em exibição */
        $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual - 1 : 0;

        /* Cálcula qual será a pŕoxima página em relação a página atual em exibição */
        $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual + 1 : 0;

        /* Cálcula qual será a página inicial do nosso range */
        $range_inicial = (($pagina_atual - RANGE_PAGINAS) >= 1) ? $pagina_atual - RANGE_PAGINAS : 1;

        /* Cálcula qual será a página final do nosso range */
        $range_final = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina;

        /* Verifica se vai exibir o botão "Primeiro" e "Pŕoximo" */
        $exibir_botao_inicio = ($range_inicial < $pagina_atual) ? 'mostrar' : 'esconder';

        /* Verifica se vai exibir o botão "Anterior" e "Último" */
        $exibir_botao_final = ($range_final > $pagina_atual) ? 'mostrar' : 'esconder';

        if (!empty($dados)):
            echo "
     <table class='table table-striped table-bordered'>
     <thead>
       <tr class='active'>
        <th>Codigo</th>
        <th>Curso</th>
        <th>Turma</th>
        <th>Aluno</th>
        <th>Nota1</th>
        <th>Nota2</th>
        <th>Nota Final</th>
        <th colspan='2'>Ações</th>
       </tr>
     </thead>
     <tbody>";
            foreach ($dados as $var):
                echo "<tr>
        
        <td>$var->IdAvaliacao</td>
        <td>$var->Curso_idCurso</td>
        <td>$var->Aluno</td>
        <td>$var->Turma</td>
        <td>$var->Nota1</td>
        <td>$var->Nota2</td>
        <td>$var->NotaFinal</td>
        <td><a href='?act=upd&id=$var->IdAvaliacao'><i class='ti-reload'></i></a></td>
        <td><a href='?act=del&id=$var->IdAvaliacao'><i class='ti-close'></i></a></td>
       </tr>";
            endforeach;
            echo "
</tbody>
     </table>

     <div class='box-paginacao'>
       <a class='box-navegacao  $exibir_botao_inicio' href='$endereco?page=$primeira_pagina' title='Primeira Página'>Primeira</a>
       <a class='box-navegacao $exibir_botao_inicio' href='$endereco?page=$pagina_anterior' title='Página Anterior'>Anterior</a>
";

            /* Loop para montar a páginação central com os números */
            for ($i = $range_inicial; $i <= $range_final; $i++):
                $destaque = ($i == $pagina_atual) ? 'destaque' : '';
                echo "<a class='box-numero $destaque' href='$endereco?page=$i'>$i</a>";
            endfor;

            echo "<a class='box-navegacao $exibir_botao_final' href='$endereco?page=$proxima_pagina' title='Próxima Página'>Próxima</a>
       <a class='box-navegacao $exibir_botao_final' href='$endereco?page=$ultima_pagina' title='Última Página'>Último</a>
     </div>";
        else:
            echo "<p class='bg-danger'>Nenhum registro foi encontrado!</p>
     ";
        endif;

    }


}