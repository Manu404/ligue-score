<?php

namespace Core\Handler;

use Exception;
use Propel\Runtime\Propel;
use Propel\Runtime\Formatter\ObjectFormatter;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Slim\App;
use \Core\Handler\HandlerBase as HandlerBase;
use \Model\GametypeQuery;
use \Core\Mapper\ToJSON;

class GameTypeHandler extends HandlerBase {

    private $app;

    function __construct(App $app)
    {
        $this->app = $app;
        $this->InitializeGet();
    }

    private function InitializeGet() {
        $this->app->get('/api/v1/game/type/', function (Request $request, Response $response, array $args) {  
            $query = GametypeQuery::create();
            $queryResults = $query->find();
            $result = array();
            foreach($queryResults as $queryResult) {
                array_push($result, ToJSON::Gametype($queryResult));
            }                  
            return HandlerBase::PrepareGetResponse($result, $response);     
        });
    }
}