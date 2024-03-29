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

class RankingHandler extends HandlerBase {

    private $app;

    function __construct(App $app)
    {
        $this->app = $app;
        $this->InitializeGet();
    }

    private function InitializeGet() {
        $this->app->get('/api/v1/ranking/general/', function (Request $request, Response $response, array $args) {  
            $conn = Propel::getConnection();
            $sql = 'SELECT * FROM total_per_player';
            $query = $conn->prepare($sql);
            $query->execute();
            $result = array();
            $i = 1;
            foreach ($query->fetchAll() as $row) {
                array_push($result, array("rank" => $i, "id" => $row['playerid'], "score" => $row['total']));
                $i+=1;
            }

            $stmt = null;
            return HandlerBase::PrepareGetResponse($result, $response);     
        });
    }
}