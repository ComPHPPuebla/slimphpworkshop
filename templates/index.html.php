<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Welcome to Music PHPlayer</title>
	<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="styles/sticky.css">
</head>
<body>
    <div id="wrap">
		<div class="navbar navbar-default navbar-fixed-top" role="navigation">
		  <div class="container">
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="#">Music PHPlayer</a>
		    </div>
		    <div class="collapse navbar-collapse">
		      <ul class="nav navbar-nav">
		        <li class="active"><a href="#">Home</a></li>
		      </ul>
		    </div>
		  </div>
		</div>

        <div class="container">
	        <div class="page-header">
                <h1>Songs</h1>
	        </div>
	        <p>
                <a href="<?php echo $app->urlFor('newSong') ?>" class="btn btn-success" role="button">
                    <span class="glyphicon glyphicon-plus"></span>
                    New
                </a>
            </p>
            <table class="table table-striped table-bordered table-hover">
                <thead>
	                <tr>
	                    <th>Name</th>
	                    <th>Artist</th>
	                    <th></th>
	                </tr>
                </thead>
                <tbody>
					<?php foreach ($songs as $song) : ?>
                    <tr>
                        <td>
                            <a href="<?php echo $app->urlFor('showSong', ['id' => $song['song_id']])  ?>">
                                <?php echo $song['name'] ?>
                            </a>
                        </td>
                        <td><?php echo $song['artist'] ?></td>
                        <td>
                            <a href="<?php echo $app->urlFor('editSong', ['id' => $song['song_id']]) ?>">
                                Edit
                            </a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer id="footer">
      <div class="container">
        <p class="text-muted credit">Comunidad PHP Puebla</p>
      </div>
    </footer>

    <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
</body>
</html>
