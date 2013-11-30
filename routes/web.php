<?php
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;

$app->get('/', function() use ($app) {
    $client = new Client();
    $client->setDescription(ServiceDescription::factory('config/service.json'));
    $songs = $client->getSongsList();

    $app->render('index.html.php', ['songs' => $songs, 'app' => $app]);
})->name('songsList');

$app->get('/new', function() use ($app) {
    $app->render('new.html.php', ['app' => $app]);
})->name('newSong');

$app->post('/save', function() use ($app) {
    $name = $app->request()->post('name');
    $artist = $app->request()->post('artist');

    $client = new Client();
    $client->setDescription(ServiceDescription::factory('config/service.json'));
    $song = $client->saveSong([
        'name' => $name, 'artist' => $artist
    ]);

    $app->redirect($app->urlFor('songsList'));

})->name('saveSong');

$app->get('/show', function() use ($app) {
    $app->render('show.html');
});
