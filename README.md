# PHPTube #
### The PHP Library to fetch Youtube video URIs from Watch URLs ###

- **Author:** Abu Ashraf Masnun
- **Email:** masnun@gmail.com
- **Web:** http://masnun.me

#### What is PHPTube? ####
PHPTube is a PHP Library that allows you to fetch the actual Video URIs (of multiple available formats) directly from the Youtube Watch URL.

#### How to use it? ####

    <?php
    require_once 'PhpTube.php';
    $tube = new PhpTube();
    $videos = $tube->getDownloadLink('http://www.youtube.com/watch?v=Q-0p7ogC51k');

    var_dump($videos);
    ?>
