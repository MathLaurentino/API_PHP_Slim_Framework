<?php

namespace App\Model;

use \JsonSerializable;

class Jogador implements JsonSerializable {

    private ?int $id;
    private ?string $nome;
    private ?string $sobrenome;
    private ?int $idade;
    private ?string $posicao;
    private ?string $nacionalidade;

    public function __construct() {
        $this->id = 0;
        $this->nome = null;
        $this->sobrenome = null;
        $this->idade = null;
        $this->posicao = null;
        $this->nacionalidade = null;
    }

    public function jsonSerialize(): array {
        return array("id" => $this->id,
                     "nome" => $this->nome,
                     "sobrenome" => $this->sobrenome,
                     "idade" => $this->idade,
                     "posicao" => $this->posicao,
                     "nacionalidade" => $this->nacionalidade);
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nome
     */ 
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     *
     * @return  self
     */ 
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get the value of idade
     */ 
    public function getIdade()
    {
        return $this->idade;
    }

    /**
     * Set the value of idade
     *
     * @return  self
     */ 
    public function setIdade($idade)
    {
        $this->idade = $idade;

        return $this;
    }

    /**
     * Get the value of posicao
     */ 
    public function getposicao()
    {
        return $this->posicao;
    }

    /**
     * Set the value of posicao
     *
     * @return  self
     */ 
    public function setposicao($posicao)
    {
        $this->posicao = $posicao;

        return $this;
    }


    /**
     * Get the value of sobrenome
     */ 
    public function getSobrenome()
    {
        return $this->sobrenome;
    }

    /**
     * Set the value of sobrenome
     *
     * @return  self
     */ 
    public function setSobrenome($sobrenome)
    {
        $this->sobrenome = $sobrenome;

        return $this;
    }

    /**
     * Get the value of nacionalidade
     */ 
    public function getNacionalidade()
    {
        return $this->nacionalidade;
    }

    /**
     * Set the value of nacionalidade
     *
     * @return  self
     */ 
    public function setNacionalidade($nacionalidade)
    {
        $this->nacionalidade = $nacionalidade;

        return $this;
    }
}