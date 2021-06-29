<?php
/**
 * Created by PhpStorm.
 * User: istac
 * Date: 3/17/2018
 * Time: 1:31 PM
 */

namespace Core\Handler;

use \Psr\Http\Message\ResponseInterface as Response;
use Exception;

class HandlerBase {
    public static function PrepareGetResponse(array $result, Response $response){
        $jsonArray = array(
            "status" => 200,
            "message" => "",
            "result" => $result
        );

        $response->getBody()->write(json_encode($jsonArray));
        $response->withHeader('Content-Type', 'application/json');
        return $response;
    }

    public static function PreparePaginatedGetResponse(array $result, Response $response, $page, $limit, $count){
        $jsonArray = array(
            "status" => 200,
            "message" => "",
            "page" => $page,
            "limit" => $limit,
            "count" => $count,
            "result" => $result
        );

        $response->getBody()->write(json_encode($jsonArray));
        $response->withHeader('Content-Type', 'application/json');
        return $response;
    }

    public static function PreparePostResponse(Response $response){
        $jsonArray = array(
            "status" => 200,
            "message" => ""
        );

        $response->getBody()->write(json_encode($jsonArray));
        $response->withHeader('Content-Type', 'application/json');
        return $response;
    }

    public static function PreparePostResponseWithData(Response $response, array $result){
        $jsonArray = array(
            "status" => 200,
            "message" => "",
            "result" => $result
        );

        $response->getBody()->write(json_encode($jsonArray));
        $response->withHeader('Content-Type', 'application/json');
        return $response;
    }

    public static function PrepareErrorResponse(Exception $exception, Response $response){
        $jsonArray = array(
            "status" => 500,
            "message" => $exception->getMessage()
        );

        $response->getBody()->write(json_encode($jsonArray));
        $response->withHeader('Content-Type', 'application/json');
        $response->withStatus(500);
        return $response;
    }
}