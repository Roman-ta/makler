<?php

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/vendor/autoload.php';

use Makler\Db;
use Makler\Router;
use Makler\Register;

require_once CONFIG . '/funcs.php';
$routes = require CONFIG . '/routes.php';

$db = Db::getInstance();
(new Router($routes))->match($_SERVER['REQUEST_URI']);
