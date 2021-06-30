<?php

namespace Core\Handler;

use Exception;
use Propel\Runtime\Propel;
use Propel\Runtime\Formatter\ObjectFormatter;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Slim\App;
use \Core\Handler\HandlerBase as HandlerBase;
use \Model\GamedayQuery;
use \Model\GametypeQuery;
use \Model\PlayerQuery;
use \Model\RulesQuery;
use \Model\ShopitemsQuery;
use \Core\Mapper\ToJSON;

class CatalogHandler extends HandlerBase {

    private $app;

    function __construct(App $app)
    {
        $this->app = $app;
        $this->InitializeGet();
    }

    private function GetDays(){
        $query = GamedayQuery::create();
        $queryResults = $query->find();
        $result = array();
        foreach($queryResults as $queryResult) {
            array_push($result, ToJSON::Gameday($queryResult));
        }    
        return $result;
    }
    private function GetTypes(){
        $query = GametypeQuery::create();
        $queryResults = $query->find();
        $result = array();
        foreach($queryResults as $queryResult) {
            array_push($result, ToJSON::Gametype($queryResult));
        }     
        return $result;
    }
    private function GetPlayers(){
        $playerQuery = PlayerQuery::create();
        $players = $playerQuery->find();
        $result = array();
        foreach($players as $player) {
            array_push($result, ToJSON::Player($player));
        }     
        return $result;
    }
    private function GetRules(){
        $query = RulesQuery::create();
        $queryResults = $query->find();
        $result = array();
        foreach($queryResults as $queryResult) {
            array_push($result, ToJSON::Rules($queryResult));
        }   
        return $result;
    }
    private function GetShopItems(){
        $query = ShopitemsQuery::create();
        $queryResults = $query->find();
        $result = array();
        foreach($queryResults as $queryResult) {
            array_push($result, ToJSON::ShopItem($queryResult));
        }       
        return $result;
    }

    private function InitializeGet() {
        $this->app->get('/api/v1/catalog/day/', function (Request $request, Response $response, array $args) {  
              
            return HandlerBase::PrepareGetResponse($this->GetDays(), $response);     
        });

        $this->app->get('/api/v1/catalog/type/', function (Request $request, Response $response, array $args) {  
             
            return HandlerBase::PrepareGetResponse($this->GetTypes(), $response);     
        });

        $this->app->get('/api/v1/catalog/player/{id:.*}', function (Request $request, Response $response, array $args) {  
            if($args["id"] != null && is_numeric($args["id"])) {
            }
            else {
             
                return HandlerBase::PrepareGetResponse($this->GetPlayers(), $response);
            }         
        });

        $this->app->get('/api/v1/catalog/rule/', function (Request $request, Response $response, array $args) {  
               
            return HandlerBase::PrepareGetResponse($this->GetRules(), $response);     
        });

        $this->app->get('/api/v1/catalog/shop/', function (Request $request, Response $response, array $args) {  
             
            return HandlerBase::PrepareGetResponse($this->GetShopItems(), $response);     
        });


        $this->app->get('/api/v1/catalog/', function (Request $request, Response $response, array $args) {  
             
            $result = array(
            "days" => $this->GetDays(),
            "types" => $this->GetTypes(),
            "players" => $this->GetPlayers(),
            "rules" => $this->GetRules(),
            "items" => $this->GetShopItems());
            return HandlerBase::PrepareGetResponse($result, $response);     
        });
    }
}