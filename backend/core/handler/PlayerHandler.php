<?php

namespace Core\Handler;

use Exception;
use Propel\Runtime\Propel;
use Propel\Runtime\Formatter\ObjectFormatter;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Slim\App;
use \Core\Handler\HandlerBase as HandlerBase;
use \Model\PlayerQuery;
use \Core\Mapper\ToJSON;

class PlayerHandler extends HandlerBase {

    private $app;

    function __construct(App $app)
    {
        $this->app = $app;
        $this->InitializeGet();
    }

    private function InitializeGet() {
        $this->app->get('/api/v1/player/{id:.*}', function (Request $request, Response $response, array $args) {  
            if($args["id"] != null && is_numeric($args["id"])) {
            }
            else {
                $playerQuery = PlayerQuery::create();
                $players = $playerQuery->find();
                $result = array();
                foreach($players as $player) {
                    array_push($result, ToJSON::Player($player));
                }                  
                return HandlerBase::PrepareGetResponse($result, $response);
            }         
        });
    }
}