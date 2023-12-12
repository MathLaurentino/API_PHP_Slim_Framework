<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

use App\Controller\JogadorController;

require_once(__DIR__ . '/vendor/autoload.php');

$app = AppFactory::create();
$app->setBasePath("/api_fut");

$app->addBodyParsingMiddleware(); 
$app->addErrorMiddleware(true, true, true); 

//Rotas de teste
$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Olá Mundo!");
    return $response;
});

$app->get("/jogadores", JogadorController::class . ":listar");
$app->get("/jogadores/{id}", JogadorController::class . ":buscarPorId");
$app->post("/jogadores", JogadorController::class . ":inserir");
$app->put("/jogadores/{id}", JogadorController::class . ":atualizar");
$app->delete("/jogadores/{id}", JogadorController::class . ":deletar");

$app->run();