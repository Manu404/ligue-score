<?php

namespace Core\Handler;

use Exception;
use Propel\Runtime\Propel;
use Propel\Runtime\Formatter\ObjectFormatter;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Slim\App;
use \Core\Handler\HandlerBase as HandlerBase;
use \Model\ShopitemsQuery;
use \Core\Mapper\ToJSON;

class ShopHandler extends HandlerBase {

    private $app;

    function __construct(App $app)
    {
        $this->app = $app;
        $this->InitializeGet();
    }

    private function InitializeGet() {
        $this->app->get('/api/v1/shop/', function (Request $request, Response $response, array $args) {  
            $query = ShopitemsQuery::create();
            $queryResults = $query->find();
            $result = array();
            foreach($queryResults as $queryResult) {
                array_push($result, ToJSON::ShopItem($queryResult));
            }                  
            return HandlerBase::PrepareGetResponse($result, $response);     
        });
    }
}