<?php

namespace Core\Handlers;

use Exception;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Slim\App;
use \Core\Handlers\HandlerBase as HandlerBase;
use \Model\GameQuery;
use \Model\Game;
use \Model\Gametype;

class TestHandler extends HandlerBase {

    private $app;

    function __construct(App $app)
    {
        $this->app = $app;
        $this->InitializeGet();
    }

    private function InitializeGet() {
        $this->app->get('/api/v1/test/', function (Request $request, Response $response, array $args) {
            
            $gameQuery = GameQuery::create();
            $game = $gameQuery->findPk(1);
            return HandlerBase::PrepareGetResponse(array("id" => $game->getId(), "type" => $game->getType(), "date" => $game->getDayId()), $response);

            // if($args["id"] != null && is_numeric(args["id"])) {
            //     $callMeQuery = CallmeQuery::create();
            //     $callMe = $callMeQuery->findPk($args["id"]);
            //     if($callMe == null) throw new Exception("Id '".$args["id"]."' not found");
            //     $result = ToJSON::CallMe($callMe);
            //     return HandlerBase::PrepareGetResponse($result, $response);
            // }
            // else {
            //     $page = (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0) ? intval($_GET['page']) : 1;
            //     $limit = (isset($_GET['limit']) && is_numeric($_GET['limit'])) ? intval($_GET['limit']) : CoreApp::DefaultPageSize;

            //     $callMeQuery = CallmeQuery::create()->orderByReceived('desc')->paginate($page, $limit);
            //     $result = array();
            //     foreach($callMeQuery as $callMe) {
            //         array_push($result, ToJSON::CallMe($callMe));
            //     }
            //     return HandlerBase::PreparePaginatedGetResponse($result, $response, $page, $limit, $callMeQuery->getNbResults());
            // }
        });
    }
}