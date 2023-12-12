<?php

namespace App\Service;

use App\Model\Jogador;

class JogadorService {

    public function validar(Jogador $jogador) {
        if(! $jogador->getNome())
            return "O campo nome é obrigatório.";

        if(! $jogador->getSobrenome())
            return "O campo sobrenome é obrigatório.";
            
        if(! $jogador->getIdade())
            return "O campo idade é obrigatório.";
        
        if(! $jogador->getposicao())
            return "O campo posicao é obrigatório.";
        
        if(! $jogador->getNacionalidade())
            return "O campo nacionalidade é obrigatório.";
        
        return null;
    }
    
}