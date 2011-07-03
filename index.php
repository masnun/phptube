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
        $links = $tube->getDownloadLink($_POST['url']);

        if (is_array($links)) {
            ?>
                    <b>Download Links</b> :

                        <?php
                                foreach ($links as $link) {
                                    echo "<pre><a href=\"{$link['url']}\">{$link['type']}</a></pre>";
                                }
                        ?>


                    <?php
                    } else {
                        echo "<br/><br/><pre style='color:red; font-size:14px'>{$links}</pre> " ;
                    }
                }
        ?>
</body>