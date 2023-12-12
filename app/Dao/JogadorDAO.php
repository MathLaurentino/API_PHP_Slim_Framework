<?php

namespace App\Dao;

use App\Util\Connection;
use App\Mapper\JogadorMapper;
use App\Model\Jogador;

use \Exception;


class JogadorDAO {

    private $conn;
    private $jogadorMapper;

    public function __construct() {
        $this->conn = Connection::getConnection();
        $this->jogadorMapper = new JogadorMapper();
    }

    public function list() {
        $sql = 'SELECT * FROM jogador ORDER BY id';

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $this->jogadorMapper->mapFromDatabaseArrayToObjectArray($result);
    }

    public function findById(int $id) {
        $sql = 'SELECT * FROM jogador WHERE id = :id';

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue("id", $id);
        $stmt->execute();
        $result = $stmt->fetchAll();

        $arrayObj = $this->jogadorMapper->mapFromDatabaseArrayToObjectArray($result);

        if(count($arrayObj) == 0)
            return null;
        else if(count($arrayObj) > 1)
            new Exception("Mais de um registro encontrado para o ID " . $id);
        else
            return $arrayObj[0];
    }

    public function insert(jogador $jogador) {
        $sql = 'INSERT INTO jogador (nome, sobrenome, idade, posicao, nacionalidade) VALUES (:nome, :sobrenome, :idade, :posicao, :nacionalidade)';

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue("nome", $jogador->getNome());
        $stmt->bindValue("sobrenome", $jogador->getSobrenome());
        $stmt->bindValue("idade", $jogador->getIdade());
        $stmt->bindValue("posicao", $jogador->getposicao());
        $stmt->bindValue("nacionalidade", $jogador->getNacionalidade());
        $stmt->execute();

        $id = $this->conn->lastInsertId();
        $jogador->setId($id);
        return $jogador;
    }

    public function update(jogador $jogador) {
        $sql = 'UPDATE jogador SET nome = :nome, sobrenome = :sobrenome, idade = :idade, posicao = :posicao, nacionalidade = :nacionalidade WHERE id = :id';

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue("nome", $jogador->getNome());
        $stmt->bindValue("sobrenome", $jogador->getSobrenome());
        $stmt->bindValue("idade", $jogador->getIdade());
        $stmt->bindValue("posicao", $jogador->getposicao());
        $stmt->bindValue("nacionalidade", $jogador->getNacionalidade());
        $stmt->bindValue("id", $jogador->getId());
        $stmt->execute();

        return $jogador;
    }

    public function deleteById(int $id) {
        $sql = 'DELETE FROM jogador WHERE id = :id';

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue("id", $id);
        $stmt->execute();
    }

}