<?php

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/vendor/autoload.php';

use Makler\Db;
use Makler\Router;
use Makler\Logger;
require_once CONFIG . '/funcs.php';
$routes = require CONFIG . '/routes.php';
$dataBaseConfig = require CONFIG . '/dataBaseConfig.php';

$db = Db::getInstance($dataBaseConfig);
(new Router($routes))->match($_SERVER['REQUEST_URI']);


