<?php

namespace Core;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Middleware\HttpBasicAuthentication;
use Slim\Exception\HttpNotFoundException;
use Slim\Container;

use \Core\Handler\HandlerBase as HandlerBase;

class EntryPoint {

    private $slimApp;
    // private $basicHttpAuthenticator;
    // private $basicHttpAuthenticatorWithAdminPrivileges;

    const DefaultPageSize = 10;

    function __construct(){
        $this->slimApp = AppFactory::create();
        $this->slimApp->setBasePath("/index.php");
        // $this->basicHttpAuthenticator = new \Slim\Middleware\HttpBasicAuthentication([
        //     "authenticator" => new HttpBasicAuthenticator(),
        //     "realm" => "Protected",
        //     "secure" => false,
        //     "error" => function ($request, $response, $arguments) {
        //         $data = [];
        //         $data["status"] = 401;
        //         $data["message"] = $arguments["message"];
        //         return $response->write(json_encode($data, JSON_UNESCAPED_SLASHES));
        //     }
        // ]);
        // $this->basicHttpAuthenticatorWithAdminPrivileges = new \Slim\Middleware\HttpBasicAuthentication([
        //     "authenticator" => new HttpBasicAuthenticatorWithAdminPriviliege(),
        //     "realm" => "Protected",
        //     "secure" => false,
        //     "error" => function ($request, $response, $arguments) {
        //         $data = [];
        //         $data["status"] = 401;
        //         $data["message"] = $arguments["message"];
        //         return $response->write(json_encode($data, JSON_UNESCAPED_SLASHES));
        //     }
        // ]);
    }

    public function GetSlimApp(){
        return $this->slimApp;
    }

    function InitializeDatabase()
    {
        $serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
        $serviceContainer->checkVersion(2);
        $serviceContainer->setAdapterClass('default', 'mysql');
        $manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
        $manager->setConfiguration(array (
          'dsn' => 'mysql:host=192.168.89.1;port=3306;dbname=mtg_league',
          'user' => 'mtg_league',
          'password' => 'tmp123',
          'settings' =>
          array (
            'charset' => 'utf8',
            'queries' =>
            array (
            ),
          ),
          'classname' => '\\Propel\\Runtime\\Connection\\ConnectionWrapper',
          'model_paths' =>
          array (
            0 => 'src',
            1 => 'vendor',
          ),
        ));
        $manager->setName('default');
        $serviceContainer->setConnectionManager('default', $manager);
        $serviceContainer->setDefaultDatasource('default');
        
        $serviceContainer->initDatabaseMaps(array (
            'default' => 
            array (
              0 => '\\Model\\Map\\GameTableMap',
              1 => '\\Model\\Map\\GamedayTableMap',
              2 => '\\Model\\Map\\GamedayrulesetTableMap',
              3 => '\\Model\\Map\\GameplayersTableMap',
              4 => '\\Model\\Map\\GametypeTableMap',
              5 => '\\Model\\Map\\PlayerBuyTableMap',
              6 => '\\Model\\Map\\PlayerTableMap',
              7 => '\\Model\\Map\\ReservationTableMap',
              8 => '\\Model\\Map\\RulesTableMap',
              9 => '\\Model\\Map\\RulesetRulesTableMap',
              10 => '\\Model\\Map\\RulesetTableMap',
              11 => '\\Model\\Map\\ShopitemsTableMap',
              12 => '\\Model\\Map\\TransactionsTableMap',
            ),
          ));
    }

    function RegisterErrorHandler () {
        $container = $this->slimApp->getContainer();
        $container['errorHandler'] = function ($container) {
            return function ($request, $response, $exception) use ($container) {
                $jsonResponse = array(
                    "status" => 500,
                    "error" => $exception->getMessage()
                );

                return $container['response']
                    ->withStatus(500)
                    ->withHeader('Content-Type', 'application/json')
                    ->write(json_encode($jsonResponse));
            };
        };
    }

    function RegisterGlobalRouteBasicHttpAuthentication(){
        // $this->slimApp->add(new \Slim\Middleware\HttpBasicAuthentication([
        //     "authenticator" => new HttpBasicAuthenticator(),
        //     "path" => array("/api/v1/User"),
        //     "realm" => "Protected",
        //     "secure" => false,
        //     "error" => function ($request, $response, $arguments) {
        //         $data = [];
        //         $data["status"] = 401;
        //         $data["message"] = $arguments["message"];
        //         return $response->write(json_encode($data, JSON_UNESCAPED_SLASHES));
        //     }
        // ]));
    }

    function AddCORS(){
        $this->slimApp->options('/{routes:.+}', function ($request, $response, $args) {
            return $response;
        });
        
        $this->slimApp->add(function ($request, $handler) {
            $response = $handler->handle($request);
            return $response
                    ->withHeader('Access-Control-Allow-Origin', '*')
                    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
        });
    }

    function RegisterHandlers() {
        // $TestHandler = new \Core\Handler\TestHandler($this->slimApp);
        // $PlayerHandler = new \Core\Handler\PlayerHandler($this->slimApp);
        // $ShopHandler = new \Core\Handler\ShopHandler($this->slimApp);
        // $RuleHandler = new \Core\Handler\RuleHandler($this->slimApp);
        // $GdHandler = new \Core\Handler\GameDayHandler($this->slimApp);
        // $GtHandler = new \Core\Handler\GameTypeHandler($this->slimApp);
        
        $RkHandler = new \Core\Handler\RankingHandler($this->slimApp);
        $CatalogHandler = new \Core\Handler\CatalogHandler($this->slimApp);

        $this->slimApp->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
            throw new \Slim\Exception\HttpNotFoundException($request);
        });
    }

    function Run(){
        $this->slimApp->run();
    }
}


