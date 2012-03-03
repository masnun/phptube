<?php
require_once 'PhpTube.php';
$tube = new PhpTube();
$videos = $tube->getDownloadLink('http://www.youtube.com/watch?v=Q-0p7ogC51k');

var_dump($videos);
?>
                   
