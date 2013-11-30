<?php
use ComPHPPuebla\MultiPartDataParser;

require 'resources/api.php';

$app->get('/api/songs', function() use ($app) {
    $statement = $app->connection->prepare('SELECT * FROM song');
    $statement->execute();
    $songs = $statement->fetchAll();

    echo json_encode($songs, JSON_PRETTY_PRINT);
});

$app->get('/api/songs/:id/file', function($id) use ($app) {
    $statement = $app->connection->prepare('SELECT * FROM song WHERE song_id = :songId');
    $statement->bindParam('songId', $id);
    $statement->execute();

    $song = $statement->fetch();

    $app->response()->headers->set('content-type', 'audio/mpeg');

    echo file_get_contents("uploads/{$song['file_path']}");
});

$app->get('/api/songs/:id', function($id) use ($app) {
    $statement = $app->connection->prepare('SELECT * FROM song WHERE song_id = :songId');
    $statement->bindParam('songId', $id);
    $statement->execute();

    $song = $statement->fetch();
    $song['file_path'] = "{$app->request()->getUrl()}/api/songs/{$id}/file";

    echo json_encode($song, JSON_PRETTY_PRINT);
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

$app->put('/api/songs/:id', function($id) use ($app) {
    $parser = new MultiPartDataParser('uploads');
    $song = $parser->parse($app->request()->getBody());

    $assignments = [];
    foreach($song as $key => $value) {
        $assignments[] = "$key = :$key";
    }

    $sql = sprintf('UPDATE song SET %s WHERE song_id = :songId', implode(', ', $assignments));
    $statement = $app->connection->prepare($sql);

    $song['songId'] = $id;
    $statement->execute($song);

    echo json_encode($song, JSON_PRETTY_PRINT);
});
