<?php

class professor
{

    private $idProfessor;
    private $nome;
    private $cargo;

    /**
     * alunos constructor.
     * @param $idAluno
     * @param $matricula
     * @param $nome
     */
    public function __construct($idProfessor, $nome, $cargo)
    {
        $this->idProfessor = $idProfessor;        
        $this->nome = $nome;
        $this->cargo = $cargo;
    }


    /**
     * @return mixed
     */
    public function getIdProfessor()
    {
        return $this->idProfessor;
    }

    /**
     * @param mixed $idAluno
     */
    public function setIdProfessor($idProfessor)
    {
        $this->idProfessor = $idProfessor;
    }


    /**
     * @return mixed
     */
    public function getcargo()
    {
        return $this->cargo;
    }

    /**
     * @param mixed $cargo
     */
    public function setcargo($cargo)
    {
        $this->cargo = $cargo;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

}
