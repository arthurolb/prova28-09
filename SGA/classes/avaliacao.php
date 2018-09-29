<?php


class avaliacao
{

    private $idAvaliacao;
    private $cursoIdCurso;
    private $turmaIdTurma;
    private $alunoIdAluno;
    private $nota1;
    private $nota2;
    private $notaFinal;

    /**
     * alunos constructor.
     * @param $idAvaliacao
     * @param $turmaIdTurma
     * @param $cursoIdCurso
     */
    public function __construct($idAvaliacao, $cursoIdCurso, $turmaIdTurma,$alunoIdAluno,$nota1,$nota2,$notaFinal)
    {
        $this->idAvaliacao = $idAvaliacao;
        $this->turmaIdTurma = $turmaIdTurma;
        $this->cursoIdCurso = $cursoIdCurso;
        $this->alunoIdAluno = $alunoIdAluno;
        $this->nota1 = $nota1;
        $this->nota2 = $nota2;
        $this->notaFinal = $notaFinal;
    }



    public function getIdAvaliacao()
    {
        return $this->idAvaliacao;
    }


    public function setIdAvaliacao($idAvaliacao)
    {
        $this->idAvaliacao = $idAvaliacao;
    }





    public function getTurmaIdTurma()
    {
        return $this->turmaIdTurma;
    }

   
    public function setTurmaIdTurma($turmaIdTurma)
    {
        $this->turmaIdTurma = $turmaIdTurma;
    }



   
    public function getCursoIdCurso()
    {
        return $this->cursoIdCurso;
    }

    public function setCursoIdCurso($cursoIdCurso)
    {
        $this->cursoIdCurso = $cursoIdCurso;
    }



    public function getAlunoIdAluno()
    {
        return $this->alunoIdAluno;
    }

    public function setAlunoIdAluno($alunoIdAluno)
    {
        $this->alunoIdAluno = $alunoIdAluno;
    }


    public function getNota1()
    {
        return $this->nota1;
    }


    public function setNota1($nota1)
    {
        $this->nota1 = $nota1;
    }


    public function getNota2()
    {
        return $this->nota2;
    }

    public function setNota2($nota2)
    {
        $this->nota2 = $nota2;
    }

 

    public function setNotaFinal($notaFinal)
    {
        $this->notaFinal = $notaFinal;
    }

    public function getNotaFinal()
    {
        return $this->notaFinal;
    }

  

}
