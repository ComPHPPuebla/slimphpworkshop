<?php
$app->container->singleton('connection', function() {
    $config = require 'config/connection.php';

    $connection = new PDO($config['dsn'], $config['user'], $config['password']);

    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $connection->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');

    return $connection;
});
