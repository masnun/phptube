<?php
require_once 'PhpTube.php';
$tube = new PhpTube();
var_dump($tube->getDownloadLink("http://www.youtube.com/watch?v=sesOnXMcaBk&feature=channel"));
