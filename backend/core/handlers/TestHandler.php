<?php

namespace Core\Handlers;

use Exception;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Slim\App;
use \Core\Handlers\HandlerBase as HandlerBase;

class TestHandler extends HandlerBase {

    private $app;

    function __construct(App $app)
    {
        $this->app = $app;
        //$this->httpBasicAuthentication = $httpBasicAuthentication;
        $this->InitializeGet();
        // $this->InitializeRespond();
        // $this->InitializePost();
    }

    private function InitializeGet() {
        $this->app->get('/api/v1/test/', function (Request $request, Response $response, array $args) {
            
            return HandlerBase::PrepareGetResponse(['Bonjour, get ca mec'], $response);

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

    // private function InitializePost() {
    //     $this->app->post('/api/v1/CallMe/', function (Request $request, Response $response) {
    //         $callMe = FromJSON::CallMe($request->getBody());

    //         if($callMe == null)
    //             throw new Exception("Error deserializing json");

    //         $callMe->setId(null);
    //         $callMe->setReceived(gmdate('Y-m-d H:i:s'));

    //         if($callMe->getPhone() == null)
    //             throw new Exception("Phone not defined");

    //         $callMe->save();

    //         return HandlerBase::PreparePostResponse($response);
    //     });
    // }

    // private function InitializeRespond() {
    //     $this->app->post('/api/v1/CallMe/{id}/respond/', function (Request $request, Response $response, array $args) {
    //         $callMeQuery = CallmeQuery::create();

    //         if($args["id"] != null) {
    //             $callMe = $callMeQuery->findPk($args["id"]);
    //             if($callMe == null) throw new Exception("Id " + $args["id"] + " not found");
    //             $callMe->setRespondedOn(gmdate("Y-m-d H:i:s"));
    //             $callMe->setRespondedBy($_SESSION["userId"]);
    //             $callMe->save();
    //             $result = ToJSON::CallMe($callMe);
    //         }
    //         else {
    //             throw new Exception("Id not set");
    //         }
    //         return HandlerBase::PreparePostResponseWithData($response, $result);
    //     })->add($this->httpBasicAuthentication);
    // }
}