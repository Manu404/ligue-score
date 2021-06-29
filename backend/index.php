<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require 'vendor/autoload.php';

$app = new \Core\EntryPoint();
$app->InitializeDatabase();
$app->RegisterGlobalRouteBasicHttpAuthentication();
$app->RegisterErrorHandler();
$app->RegisterHandlers();
$app->AddCORS();
$app->Run();



