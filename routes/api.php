<?php
require 'resources/api.php';

$app->get('/api/songs', function() use ($app) {
    $statement = $app->connection->prepare('SELECT * FROM song');
    $statement->execute();
    $songs = $statement->fetchAll();

    echo json_encode($songs, JSON_PRETTY_PRINT);
});

$app->post('/api/songs', function() use ($app) {
    $name = $app->request()->post('name');
    $artist = $app->request()->post('artist');

    $app->upload->upload();
    $path = $app->upload->getNameWithExtension();

    $sql = <<<QUERY
INSERT INTO song (name, artist, file_path)
VALUES (:name, :artist, :file_path)
QUERY;
    $statement = $app->connection->prepare($sql);
    $statement->bindParam('name', $name);
    $statement->bindParam('artist', $artist);
    $statement->bindParam('file_path', $path);
    $statement->execute();

    $songId = $app->connection->lastInsertId();

    $song = [
        'song_id' => $songId,
        'name' => $name,
        'artist' => $artist,
        'file_path' => $path,
    ];

    echo json_encode($song, JSON_PRETTY_PRINT);
});
