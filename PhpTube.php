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
        //utf8 encode and convert "&"
        $html = utf8_encode($this->_getHtml($watchUrl));
        $html = str_replace("\u0026amp;","&",$html);
        
        //get format url
        preg_match_all('/url_encoded_fmt_stream_map\=(.*)/',$html,$matches);
        $formatUrl =  urldecode($matches[1][0]);
        
        //split the format url into individual urls
        $urls = preg_split('/url=/', $formatUrl);
        
        $videoUrls = array();
        
        foreach($urls as $url) 
        {
        
            // do necessary processings
            $url = urldecode($url);
            $urlparts = explode(";",$url);
            $url = $urlparts[0];
            $urlparts = explode(",",$url);
            $url = $urlparts[0];
            
            // append to container
            if(strlen($url) > 450 && strlen($url) < 600) 
            {
                $videoUrls[] = $url;
            }
        }
        
        return $videoUrls;
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
        if (function_exists("curl_init"))
        {

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            return curl_exec($ch);
        }
        else
        {
            throw new Exception("No cURL module available");
        }
    }

}
