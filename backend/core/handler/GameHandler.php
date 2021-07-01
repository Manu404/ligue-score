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
use Model\Base\GameQuery;

class GameHandler extends HandlerBase {

    private $app;

    function __construct(App $app)
    {
        $this->app = $app;
        $this->InitializeGetSummary();
        $this->InitializeGet();
    }

    private function InitializeGetSummary() {
        $this->app->get('/api/v1/game/summary/', function (Request $request, Response $response, array $args) {  
            $conn = Propel::getConnection();
            $sql = 'SELECT * FROM total_per_match';
            $query = $conn->prepare($sql);
            $query->execute();
            $result = array();
            $i = 1;
            foreach ($query->fetchAll() as $row) {
                array_push($result, array("gameid" => $row['gameid'], "playerid" => $row['playerid'], "total" => $row['total']));
                $i+=1;
            }

            $stmt = null;
            return HandlerBase::PrepareGetResponse($result, $response);     
        });
    }

    private function GetGames(){
        $query = GameQuery::create();
        $queryResults = $query->find();
        $result = array();
        foreach($queryResults as $queryResult) {
            array_push($result, ToJSON::Game($queryResult));
        }       
        return $result;
    }

    private function InitializeGet() {
        $this->app->get('/api/v1/game/', function (Request $request, Response $response, array $args) {  
            return HandlerBase::PrepareGetResponse($this->GetGames(), $response);     
        });
    }
}