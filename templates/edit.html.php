<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome to Music PHPlayer</title>
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/styles/sticky.css">
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
                <h1>Edit song</h1>
            </div>
            <form action="<?php echo $app->urlFor('updateSong', ['id' => $song['song_id']]) ?>"
                  method="post"
                  enctype="multipart/form-data">
			  <div class="form-group">
			    <label for="name">Name</label>
			    <input type="text"
			           class="form-control"
			           id="name"
			           name="name"
			           placeholder="Enter song name"
			           value="<?php echo $song['name'] ?>">
			  </div>
			  <div class="form-group">
			    <label for="artist">Artist</label>
			    <input type="text"
			           class="form-control"
			           id="artist"
			           name="artist"
			           placeholder="Artist's name"
			           value="<?php echo $song['artist'] ?>">
			  </div>
			  <div class="form-group">
			    <label for="song">Song's File</label>
			    <input type="file" id="song" name="song">
			    <p class="help-block">Only .mp3 files are allowed.</p>
			  </div>
			  <button type="submit" class="btn btn-primary">
			     <span class="glyphicon glyphicon-floppy-saved">
			         Save
			     </span>
		      </button>
			</form>
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
