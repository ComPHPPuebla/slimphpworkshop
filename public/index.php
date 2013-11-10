<?php
use Slim\Slim;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;
use \Psr\Log\LogLevel;

require '../vendor/autoload.php';

$app = new Slim([
	'templates.path' => '../templates',
]);

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

$app->get('/', function() use ($app) {
	$client = new Client();
	$client->setDescription(ServiceDescription::factory('../config/service.json'));
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
	$client->setDescription(ServiceDescription::factory('../config/service.json'));
	$song = $client->saveSong([
		'name' => $name, 'artist' => $artist
	]);

	$app->redirect($app->urlFor('songsList'));

})->name('saveSong');

$app->get('/show', function() use ($app) {
	$app->render('show.html');
});

$app->get('/hola-mundo', function() {
	echo 'hola mundo';
});

$app->run();
