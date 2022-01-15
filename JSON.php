<?php
/*
    GET JSON.php?id=[GOOGLE DRIVE ID]

    INFO
    this script is limited
    if you make too many requests google blocks you for a few minutes
    should try again after 1 - 2 or more minutes.
*/

error_reporting(0);
date_default_timezone_set("Europe/Tirane");

    function Get_Thumbnail($id)
    {
		$Get_Thumbnail = sprintf('https://drive.google.com/thumbnail?id=%s&authuser=0&sz=w640-h360-n-k-rw', $id);
        return $Get_Thumbnail;
    }

include_once dirname(__FILE__) . "/vendor/autoload.php";
use Google_Drive\StreamingLinkGenerator\Generator;
use Google_Drive\StreamingLinkGenerator\StreamingLink;
use Google_Drive\StreamingLinkGenerator\CookieLoader\SimpleCookieLoader;
$cookie_loader = new SimpleCookieLoader(dirname(__FILE__) . "/cookies/cookies.json");
$generate_url = new Generator($cookie_loader);
// do not disable cookies, it is important every click should be deleted automatically!
$cookies_path = "cookies/cookies.json";
    if (file_exists($cookies_path)) {
        unlink($cookies_path);
    }

//$get_stream_id = isset($_GET["id"]) && !empty($_GET["id"]) ? $_GET["id"] : "1g8D9QxK8khb5F_BD288D3lVE-5mL_9Mt";
$get_stream_id = (isset($_GET["id"]) ? $_GET["id"] : "1g8D9QxK8khb5F_BD288D3lVE-5mL_9Mt"); // GOOGLE DRIVE ID
$generate_stream_url = $generate_url->generate($get_stream_id);

$title = $generate_stream_url->getName();
$title = preg_replace('/\\.[^.\\s]{3,4}$/', '', $title);
$file = $generate_stream_url->getStreamingLink(); // RAW URL
$stream_url = $generate_stream_url->getDownloadLink(); // Download URL
$image = Get_Thumbnail($get_stream_id);
$type = $generate_stream_url->getContentType();

$json_data = new stdClass;
$json_data->title = $title;
$json_data->file = $file;
$json_data->download = $stream_url;
$json_data->image = $image;
$json_data->type = $type;
$json_data->label = "HD";

echo str_replace('\\/', '/', json_encode((($json_data))));
?>