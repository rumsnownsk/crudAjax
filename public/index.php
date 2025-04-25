<?php
require_once __DIR__."/../settings/config.php";
require_once __DIR__."/../settings/constants.php";
require_once __DIR__."/../helpers/helpers.php";
require_once ROOT."/vendor/autoload.php";

$app = new \CrudAjax\Application();
require_once SETTINGS.'/routes.php';

$app->run();


