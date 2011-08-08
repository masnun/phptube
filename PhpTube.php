<?php
/*
 * @package PhpTube - A PHP class to get youtube download links
 * @author Abu Ashraf Masnun <mailbox@masnun.me>
 * @website http://masnun.com
 *
 */

class PhpTube
{

    /**
     * Parses the youtube URL and returns error message or array of download links
     *
     * @param  $watchUrl the URL of the Youtube video
     * @return string|array the error message or the array of download links
     */

    public function getDownloadLink($watchUrl)
    {
        try {
            //Scrape the HTML
            $html = $this->_getHtml($watchUrl);

            
            if (strstr($html, 'verify-age-thumb')) {
                throw new Exception("Adult Video Detected");
            }

            if (strstr($html, 'das_captcha')) {
                throw new Exception("Captcha Found please run on a diffrent server");
            }

            if (!preg_match_all('/url_encoded_fmt_stream_map=(.*?)&/', $html, $match)) {
                throw new Exception("Error Locating Downlod URL's");
            }


            // Decode format map
            $formatUrl = urldecode($match[1][0]);


            if (preg_match('/^(.*?)\\\\u0026/', $formatUrl, $match)) {
                $formatUrl = $match[1];
            }

            if ($formatUrl) {

                // break the parts of the url
                $urlParts = explode(",", $formatUrl);
                $foundVideos = array();

                foreach ($urlParts as $urlMap) {
                    parse_str($urlMap, $data);
                    $foundVideos[] = $data;
                }

                return $foundVideos;

            } else {
                throw new Exception("The video has no download candidates");
            }

        } catch (Exception $e) {
            return "An error ocurred: " . $e->getMessage();
        }
    }

    /**
     * A wrapper around the cURL library to fetch the content of the url
     *
     * @throws Exception if the curl extension is not available (or loaded)
     * @param  $url the url of the page to fetch the content of
     * @return string the content of the url
     */
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
