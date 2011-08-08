<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html
        xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Donwload Youtube Videos</title>
</head>


<body>
<form method="post">
    <pre>Type the full video URL and grab the download links:</pre>
    <input type="text" name="url" value="" style="width: 300px">
    <input type="submit" value="Go">

</form>

<?php
if (isset($_POST['url'])) {
    require_once 'PhpTube.php';
    $tube = new PhpTube();
    $videos = $tube->getDownloadLink($_POST['url']);
    var_dump($videos);
}
?>
</body>