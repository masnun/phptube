<?php
/*
 * @package PhpTube - A PHP class to get youtube download links
 * @author Abu Ashraf Masnun <mailbox@masnun.me>
 * @website http://masnun.com
 *
 */

class PhpTube
{


    public function getDownloadLink($watchUrl)
    {
        try {
            $html = $this->_getHtml($watchUrl);
            if (strstr($html, 'verify-age-thumb')) {
                throw new Exception("Adult Video Detected");
            }

            if (strstr($html, 'das_captcha')) {
                throw new Exception("Captcha Found please run on a diffrent server");
            }

            if (!preg_match('/fmt_url_map=(.*?)&/', $html, $match)) {
                throw new Exception("Error Locating Downlod URL's");
            }


            $formatUrl = urldecode($match[1]);


            if (preg_match('/^(.*?)\\\\u0026/', $formatUrl, $match)) {
                $formatUrl = $match[1];
            }

            $urls = explode(',', $formatUrl);
            $foundArray = array();

            foreach ($urls as $url)
            {
                $format = explode('|', $url, 2);
                $foundArray[$format[0]] = $format[1];
            }


            $formats = array(
                '13' => array('3gp', 'Low Quality'),
                '17' => array('3gp', 'Medium Quality'),
                '36' => array('3gp', 'High Quality'),
                '5' => array('flv', 'Low Quality'),
                '6' => array('flv', 'Low Quality'),
                '34' => array('flv', 'High Quality (320p)'),
                '35' => array('flv', 'High Quality (480p)'),
                '18' => array('mp4', 'High Quality (480p)'),
                '22' => array('mp4', 'High Quality (720p)'),
                '37' => array('mp4', 'High Quality (1080p)'),
            );

            foreach ($formats as $format => $meta)
            {
                if (isset($foundArray[$format])) {
                    $videos[] = array('ext' => $meta[0], 'type' => $meta[1], 'url' => $foundArray[$format]);
                }
            }

            return $videos;
            
        } catch (Exception $e) {
            return "An error ocurred: " . $e->getMessage();
        }
    }

    private function _getHtml($url)
    {
        if (function_exists("curl_init")) {

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            return curl_exec($ch);
        } else {
            throw new Exception("No cURL module available");
        }

    }
}
