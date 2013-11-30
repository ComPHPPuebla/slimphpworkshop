<?php
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;

$app->container->singleton('client', function() {
    $client = new Client();
    $client->setDescription(ServiceDescription::factory('config/service.json'));

    return $client;
});
