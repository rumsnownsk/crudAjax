<?php

function app(): \CrudAjax\Application
{
    return \CrudAjax\Application::$app;
}

function request(): \CrudAjax\Request
{
    return app()->request;
}

function response(): \CrudAjax\Response
{
    return app()->response;
}

function router(): \CrudAjax\Router
{
    return app()->router;
}

function db(): \CrudAjax\Database
{
    return app()->db;
}

function abort($error = '', $code = 404)
{
    response()->setResponseCode($code);
//    echo view("errors/{$code}", ['error' => $error], false);
    echo "errors/{$code}";
    die;
}

function view($view = '', $data = [], $layout=''): string|\CrudAjax\View
{
    if($view){
        return app()->view->render($view,$data, $layout);
    }
    return app()->view;
}

function get_href($address = ''): string
{
    if (!empty($address)) {
        $address = $address.".";
    }

    $host = HOST;
    if (empty($host)) return '#';
    $arr = explode(".", $host);
    $location = end($arr);

    if ($location == 'ru') {
        return "https://{$address}iocode.{$location}";
    } elseif ($location == 'loc') {
        return "http://{$address}iocode.{$location}";
    } else return '#';
}