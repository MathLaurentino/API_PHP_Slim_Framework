<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Dao\JogadorDAO;
use App\Mapper\JogadorMapper;
use App\Service\JogadorService;
use App\Util\MensagemErro;

use \PDOException;

class JogadorController {

	private $jogadorDAO;
	private $jogadorMapper;
	private $jogadorService;

	public function __construct() {
		$this->jogadorDAO = new JogadorDAO();
		$this->jogadorMapper = new JogadorMapper();
		$this->jogadorService = new JogadorService();
	}




    public function listar(Request $request, Response $response, array $args): Response {
		$jogador= $this->jogadorDAO->list();

		$json = json_encode($jogador, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

		$response->getBody()->write($json);

		return $response
				->withStatus(200) //OK
				->withHeader("Content-Type", "application/json"); 
    }




	public function buscarPorId(Request $request, Response $response, array $args): Response {
		$id = $args["id"];
		$jogador = $this->jogadorDAO->findById($id);

		if($jogador) {
			$json = json_encode($jogador, 
						JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

			$response->getBody()->write($json);

			return $response
					->withHeader("Content-Type", "application/json")
					->withStatus(200); //OK
		}

		return $response->withStatus(404); //NOT FOUND
    }




	public function inserir(Request $request, Response $response, array $args): Response {

		//Retorna o JSON da requisição no formato de array assoc
		$jsonArrayAssoc = $request->getParsedBody();
		$jogador = $this->jogadorMapper->mapFromJsonToObject($jsonArrayAssoc);

		//TODO - Validar os dados
		$erro=$this->jogadorService->validar($jogador);
		if($erro){
			$jsonErro = MensagemErro::getJSONErro($erro, "", 400);
			$response->getBody()->write($jsonErro);
			return $response
						->withHeader("Content-Type", "application/json")
						->withStatus(400); // BAD_REQUEST
		}

		//Insere o registro do jogador na base de dados
		try {
			$jogador = $this->jogadorDAO->insert($jogador);
			$json = json_encode($jogador, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

			$response->getBody()->write($json);
			return $response
					->withHeader("Content-Type", "application/json")
					->withStatus(201); //CREATED
		
		
		} catch(PDOException $ex) {
			//Em caso de erro ao inserir o jogador, este bloco será executado
			$jsonErro = MensagemErro::getJSONErro("Erro ao inserir o jogador!", $ex->getMessage());
			$response->getBody()->write($jsonErro);
			return $response
					->withHeader('Content-Type', 'application/json')
					->withStatus(500); //INTERNAL_SERVER_ERROR
		}
	}




	public function atualizar(Request $request, Response $response, array $args): Response {
		$id = $args['id'];
		$jogador = $this->jogadorDAO->findById($id);
		
		if($jogador) { 
			//Carrega o jogador que veio na requisição em formato JSON
			$jogadorArrayAssoc = $request->getParsedBody(); //Retorna um array a partir do JSON
			$jogador = $this->jogadorMapper->mapFromJsonToObject($jogadorArrayAssoc);
			$jogador->setId($id);

			//TODO - Validar os dados
			$erro=$this->jogadorService->validar($jogador);
			if($erro){
				$jsonErro = MensagemErro::getJSONErro($erro, "", 400);
				$response->getBody()->write($jsonErro);
				return $response
							->withHeader("Content-Type", "application/json")
							->withStatus(400); // BAD_REQUEST
			}

			try {
				//Atualiza o jogador no banco de dados
				$jogador = $this->jogadorDAO->update($jogador);		

				$response->getBody()->write(json_encode($jogador, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
				return $response
						->withHeader('Content-Type', 'application/json')
						->withStatus(200); //OK
			
			} catch(PDOException $ex) {
				//Em caso de erro ao atualizar o jogador, este bloco será executado
				$jsonErro = MensagemErro::getJSONErro("Erro ao atualizar o jogador!", $ex->getMessage());
				$response->getBody()->write($jsonErro);
				return $response
						->withHeader('Content-Type', 'application/json')
						->withStatus(500); //INTERNAL_SERVER_ERROR
			}
		}

		return $response->withStatus(404); //NOT_FOUND
    }




	public function deletar(Request $request, Response $response, array $args): Response {
		$id = $args['id'];
		$jogador = $this->jogadorDAO->findById($id);
		
		if($jogador) { 
			try {
				//Deleta do banco de dados
				$this->jogadorDAO->deleteById($id);
				return $response->withStatus(200); //OK
			} catch(PDOException $ex) {
				
				//Em caso de erro ao atualizar o jogador, este bloco será executado
				$jsonErro = MensagemErro::getJSONErro("Erro ao deletar o jogador!", $ex->getMessage());
				$response->getBody()->write($jsonErro);
				return $response
						->withHeader('Content-Type', 'application/json')
						->withStatus(500); //INTERNAL_SERVER_ERROR
			}
		}

		return $response->withStatus(404); //NOT_FOUND
    }
	
}