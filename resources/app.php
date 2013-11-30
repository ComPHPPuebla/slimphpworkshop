<?php
use Upload\Storage\FileSystem;
use Upload\File;
use Upload\Validation\Mimetype;
use Upload\Validation\Size;

$app->container->singleton('upload', function() {
    $storage = new FileSystem('uploads', $overwrite = true);
    $upload = new File('song', $storage);
    $upload->addValidations([
        new Mimetype('audio/mpeg'),
        new Size('10M'),
    ]);

    return $upload;
});
