<?php

namespace Core;

use Core\HttpBasicAuthenticator;

class CorsAction
{
    public function __invoke(\Slim\Http\Request $request, \Slim\Http\Response $response) {
        return $response->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->withHeader('Access-Control-Allow-Credentials', 'true');
    }
}

class CorsMiddleware
{
    private $router;

    public function __construct(\Slim\Router $router)
    {
        $this->router = $router;
    }
    /**
     * Cors middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        // https://www.html5rocks.com/static/images/cors_server_flowchart.png
        if ($request->isOptions()
            && $request->hasHeader('Origin')
            && $request->hasHeader('Access-Control-Request-Method')) {
            return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', '*')
                ->withHeader("Access-Control-Allow-Methods", '*');
        } else {
            $response = $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Expose-Headers', '*');
            return $next($request, $response);
        }
    }
}

class App {

    private $slimApp;
    private $basicHttpAuthenticator;
    private $basicHttpAuthenticatorWithAdminPrivileges;

    const DefaultPageSize = 10;

    function __construct(){
        $this->slimApp = new \Slim\App();
        $this->basicHttpAuthenticator = new \Slim\Middleware\HttpBasicAuthentication([
            "authenticator" => new HttpBasicAuthenticator(),
            "realm" => "Protected",
            "secure" => false,
            "error" => function ($request, $response, $arguments) {
                $data = [];
                $data["status"] = 401;
                $data["message"] = $arguments["message"];
                return $response->write(json_encode($data, JSON_UNESCAPED_SLASHES));
            }
        ]);
        $this->basicHttpAuthenticatorWithAdminPrivileges = new \Slim\Middleware\HttpBasicAuthentication([
            "authenticator" => new HttpBasicAuthenticatorWithAdminPriviliege(),
            "realm" => "Protected",
            "secure" => false,
            "error" => function ($request, $response, $arguments) {
                $data = [];
                $data["status"] = 401;
                $data["message"] = $arguments["message"];
                return $response->write(json_encode($data, JSON_UNESCAPED_SLASHES));
            }
        ]);
    }

    public function GetSlimApp(){
        return $this->slimApp;
    }

    function InitializeDatabase()
    {
        $serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
        $serviceContainer->checkVersion('2.0.0-dev');
        $serviceContainer->setAdapterClass('default', 'mysql');
        $manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
        $manager->setConfiguration(array (
            'dsn' => 'mysql:host=localhost;port=3306;dbname=aceu',
            'user' => 'root',
            'password' => "Password1234$",
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
        $this->slimApp->add(new \Slim\Middleware\HttpBasicAuthentication([
            "authenticator" => new HttpBasicAuthenticator(),
            "path" => array("/api/v1/User"),
            "realm" => "Protected",
            "secure" => false,
            "error" => function ($request, $response, $arguments) {
                $data = [];
                $data["status"] = 401;
                $data["message"] = $arguments["message"];
                return $response->write(json_encode($data, JSON_UNESCAPED_SLASHES));
            }
        ]));
    }

    function AddCORS(){
        $this->slimApp->add(function ($request, $response, $next) {

            $response = $response->withHeader('Access-Control-Allow-Origin', "*");
            $response = $response->withHeader('Access-Control-Allow-Methods', $request->getHeaderLine('Access-Control-Request-Method'));
            $response = $response->withHeader('Access-Control-Allow-Headers', $request->getHeaderLine('Access-Control-Request-Headers'));
            $response = $response->withHeader('Access-Control-Allow-Credentials', 'true');

            return $next($request, $response);
        });

        /*$this->slimApp->add(function ($req, $res, $next) {
            $response = $next($req, $res);
            return $response
                ->withHeader('Access-Control-Allow-Origin', 'http://localhost:4200')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
                ->withHeader('Allow', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
        });*/

        $this->slimApp->options('/{name:.+}', CorsAction::class);
        //$this->slimApp->add('CorsMiddleware');
    }

    function RegisterHandlers() {
        $ConsumptionBuildingStateHandler = new \Core\Handlers\ConsumptionBuildingStateHandler($this->slimApp);
        $ConsumptionBuildingTypeHandler = new \Core\Handlers\ConsumptionBuildingTypeHandler($this->slimApp);
        $ConsumptionEnergyHandler = new \Core\Handlers\ConsumptionEnergyHandler($this->slimApp);
        $ConsumptionEnergyProviderHandler = new \Core\Handlers\ConsumptionEnergyProviderHandler($this->slimApp);
        $ConsumptionHeatingSystemHandler = new \Core\Handlers\ConsumptionHeatingSystemHandler($this->slimApp);
        $CallMeHandler = new \Core\Handlers\CallMeHandler($this->slimApp, $this->basicHttpAuthenticator);
        $ContactMeHandler = new \Core\Handlers\ContactMeHandler($this->slimApp, $this->basicHttpAuthenticator);
        $ConsumptionHandler = new \Core\Handlers\ConsumptionHandler($this->slimApp, $this->basicHttpAuthenticator);
        $NewsHandler = new \Core\Handlers\NewsHandler($this->slimApp, $this->basicHttpAuthenticator);
        $StaticHandler = new \Core\Handlers\StaticHandler($this->slimApp, $this->basicHttpAuthenticator);
        $StatsHandler = new \Core\Handlers\StatsHandler($this->slimApp, $this->basicHttpAuthenticatorWithAdminPrivileges);
        $UserHandler = new \Core\Handlers\UserHandler($this->slimApp, $this->basicHttpAuthenticator, $this->basicHttpAuthenticatorWithAdminPrivileges);
    }

    function Run(){
        $this->slimApp->run();
    }
}


