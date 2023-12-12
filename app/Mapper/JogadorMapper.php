<?php

namespace App\Mapper;

use App\Model\Jogador;


class JogadorMapper {

    
    public function mapFromDatabaseArrayToObjectArray($regArray) {
        $arrayObj = array();

        foreach($regArray as $reg) {
            $regObj = $this->mapFromDatabaseToObject($reg);
            array_push($arrayObj, $regObj); 
        }

        return $arrayObj;
    }


    public function mapFromJsonToObject($regJson) {
        //Reaproveita o método
        return $this->mapFromDatabaseToObject($regJson);
    }


    private function mapFromDatabaseToObject($regDatabase) {
        $obj = new Jogador();
        if(isset($regDatabase['id'])) 
            $obj->setId($regDatabase['id']);
        
        if(isset($regDatabase['nome']))
            $obj->setNome($regDatabase['nome']);
    
        if(isset($regDatabase['sobrenome']))
            $obj->setSobrenome($regDatabase['sobrenome']);

        if(isset($regDatabase['idade']))
            $obj->setIdade($regDatabase['idade']);
        
        if(isset($regDatabase['posicao']))
            $obj->setposicao($regDatabase['posicao']);
        
        if(isset($regDatabase['nacionalidade']))
            $obj->setNacionalidade($regDatabase['nacionalidade']);

        return $obj;
    }

}