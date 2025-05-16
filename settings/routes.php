<?php

/** @var \CrudAjax\Application $app  */

$app->router->get('/', [\App\Controllers\HomeController::class, 'index']);