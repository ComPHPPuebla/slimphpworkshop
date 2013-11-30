<?php
require 'resources/web.php';

$app->get('/', function() use ($app) {
    $songs = $app->client->getSongsList();

    $app->render('index.html.php', ['songs' => $songs, 'app' => $app]);
})->name('songsList');

$app->get('/new', function() use ($app) {
    $app->render('new.html.php', ['app' => $app]);
})->name('newSong');

$app->post('/save', function() use ($app) {
    $name = $app->request()->post('name');
    $artist = $app->request()->post('artist');

    $app->upload->upload();

    $fileName = 'uploads/' . $app->upload->getNameWithExtension();

    $song = $app->client->saveSong([
        'name' => $name, 'artist' => $artist, 'song' => $fileName,
    ]);

    $app->redirect($app->urlFor('songsList'));
})->name('saveSong');

$app->get('/show', function() use ($app) {
    $app->render('show.html');
});
