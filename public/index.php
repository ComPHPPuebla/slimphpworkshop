<?php
use Slim\Slim;

chdir(__DIR__ . '/../');
require 'vendor/autoload.php';

$app = new Slim([
    'templates.path' => 'templates',
]);

require 'routes/api.php';
require 'routes/web.php';

$app->run();
