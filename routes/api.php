<?php
require 'resources/api.php';

$app->get('/api/songs', function() use ($app) {
    $statement = $app->connection->prepare('SELECT * FROM song');
    $statement->execute();
    $songs = $statement->fetchAll();

    echo json_encode($songs, JSON_PRETTY_PRINT);
});

$app->post('/api/songs', function() use ($app) {
    $body =$app->request()->getBody();
    parse_str($body, $song);

    $sql = <<<QUERY
INSERT INTO song (name, artist, file_path)
VALUES (:name, :artist, :file_path)
QUERY;
    $statement = $app->connection->prepare($sql);
    $statement->bindParam('name', $song['name']);
    $statement->bindParam('artist', $song['artist']);
    $path = '123';
    $statement->bindParam('file_path', $path);
    $statement->execute();

    $songId = $app->connection->lastInsertId();

    $song['song_id'] = $songId;

    echo json_encode($song, JSON_PRETTY_PRINT);
});
