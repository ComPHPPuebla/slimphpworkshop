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

$app->get('/edit/:id', function($id) use ($app) {
    $song = $app->client->getSong(['songId' => $id]);

    $app->render('edit.html.php', ['song' => $song, 'app' => $app]);
})->name('editSong');

$app->post('/update/:id', function($id) use ($app) {
    $name = $app->request()->post('name');
    $artist = $app->request()->post('artist');

    $values = ['name' => $name, 'artist' => $artist];

    if ($app->upload->isUploadedFile()) {
        $app->upload->upload();
        $fileName = 'uploads/' . $app->upload->getNameWithExtension();
        $values['song'] = $fileName;
    }
    $values['songId'] = $id;

    $app->client->updateSong($values);

    $app->redirect($app->urlFor('songsList'));
})->name('updateSong');

$app->get('/show', function() use ($app) {
    $app->render('show.html');
});
