<?php

define("ROOT", dirname(__DIR__));
const ERROR_LOGS = ROOT.'/tmp/errors.log';
const SETTINGS = ROOT.'/settings';
const APP = ROOT.'/app';
const VIEWS = APP.'/Views';
const LAYOUT = 'default';

$setting = require_once SETTINGS . "/config.php";


define("CONFIG_DB", $setting['db']);

define("PAGINATION_SETTINGS", $setting['pagination']);