<?php

/** @var \CrudAjax\Application $app  */

$app->router->get('/', [\App\Controllers\HomeController::class, 'index']);
$app->router->get('/pgn', [\App\Controllers\AjaxController::class, 'pgn']);
$app->router->post('/addCity', [\App\Controllers\AjaxController::class, 'addCity'])->withoutCsrfToken();
$app->router->get('/getCity', [\App\Controllers\AjaxController::class, 'getCity']);
$app->router->post('/updateCity', [\App\Controllers\AjaxController::class, 'updateCity'])->withoutCsrfToken();
$app->router->post('/deleteCity', [\App\Controllers\AjaxController::class, 'deleteCity'])->withoutCsrfToken();

$app->router->post('/search', [\App\Controllers\AjaxController::class, 'search'])->withoutCsrfToken();
$app->router->get('/reloadTable', [\App\Controllers\AjaxController::class, 'reloadTable']);

//$app->router->post('/reloadTable', function (){
//    response()->json([
//        'status'=> 'success',
//        'message'=>request()->getData()
//    ]);
//})->withoutCsrfToken();
