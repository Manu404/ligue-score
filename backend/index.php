<?php

require 'vendor/autoload.php';

$app = new \Core\App();
$app->InitializeDatabase();
$app->RegisterGlobalRouteBasicHttpAuthentication();
$app->RegisterErrorHandler();
$app->RegisterHandlers();
$app->AddCORS();
$app->Run();



