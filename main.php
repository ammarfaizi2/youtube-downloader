<?php

require __DIR__ . "/vendor/autoload.php";

use YoutubeDownloader\Youtube;

$st = new Youtube("https://www.youtube.com/watch?v=wOS0AMCWV-I");
$st = $st->listFormat();
var_dump($st);

