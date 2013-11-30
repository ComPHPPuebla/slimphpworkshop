<?php
$app->get('/api/songs', function() use ($app) {
    $connection = new PDO(
        'mysql:host=localhost;dbname=slimphp',
        'slimphpuser',
        'sl1mphpus3r!'
    );
    $statement = $connection->prepare('SELECT * FROM song');
    $statement->execute();
    $songs = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($songs, JSON_PRETTY_PRINT);
});

$app->post('/api/songs', function() use ($app) {
    $body =$app->request()->getBody();
    parse_str($body, $song);

    $connection = new PDO(
        'mysql:host=localhost;dbname=slimphp',
        'slimphpuser',
        'sl1mphpus3r!'
    );
    $sql = <<<QUERY
INSERT INTO song (name, artist, file_path)
VALUES (:name, :artist, :file_path)
QUERY;
    $statement = $connection->prepare($sql);
    $statement->bindParam('name', $song['name']);
    $statement->bindParam('artist', $song['artist']);
    $path = '123';
    $statement->bindParam('file_path', $path);
    $statement->execute();

    $songId = $connection->lastInsertId();

    $song['song_id'] = $songId;

    echo json_encode($song, JSON_PRETTY_PRINT);
});
