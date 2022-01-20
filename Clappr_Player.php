<?php
if(!is_dir('cookies')) mkdir('cookies');
/*
    GET Clappr_Player.php?id=[GOOGLE DRIVE ID]

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
?>
<html>
   <head>
   <meta content="width=device-width, initial-scale=1" name="viewport">
   <title><?php if ($title){ echo $title; }else{ echo "Google Drive Player"; } ?></title>
    <link rel="shortcut icon" href="https://kodi.al/panel.ico"/>
    <link rel="icon" href="https://kodi.al/panel.ico"/>
    <meta name="description" content="<?php if ($title){ echo $title; }else{ echo "Google Drive Player"; } ?>" />
    <meta name="author" content="Olsion Bakiaj - Endrit Pano" />
    <meta name="referrer" content="no-referrer">
    <meta name="msapplication-TileColor" content="#0F0">
    <meta name="theme-color" content="#0F0">
    <meta name="msapplication-navbutton-color" content="#0F0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#0F0">
    <!-- CDN Player -->
   <script src="//cdn.jsdelivr.net/npm/clappr@latest/dist/clappr.min.js"></script>
   <script src="//cdn.jsdelivr.net/npm/level-selector@latest/dist/level-selector.min.js"></script>
   <script src="//cdn.jsdelivr.net/npm/clappr-chromecast-plugin@latest/dist/clappr-chromecast-plugin.min.js"></script>
   <script src="//cdn.jsdelivr.net/npm/clappr-pip@latest/dist/clappr-pip.min.js"></script>
   <script src="//cdn.jsdelivr.net/npm/dash-shaka-playback@latest/dist/dash-shaka-playback.min.js"></script>
   <script src="//cdn.jsdelivr.net/npm/clappr-playback-rate-plugin@latest/dist/clappr-playback-rate-plugin.min.js"></script>
</head>
   <body bgcolor="black" style="margin:0" oncontextmenu="return false" onkeydown="return false">
   <div id="player"></div>
      <script>
         window.onload = function() {
             var player = new Clappr.Player({
                 source: "<?php if ($file){ echo $file; }else{ echo 'https://trc4.com/no_source.mp4'; } ?>",
                 parentId: '#player',
                 mimeType: "<?php if ($type){ echo $type; }else{ echo 'video/mp4'; } ?>",
                 plugins: [LevelSelector, ChromecastPlugin, ClapprPip.PipButton, ClapprPip.PipPlugin, DashShakaPlayback, Clappr.MediaControl, PlaybackRatePlugin],
                 events: {
		 onReady: function()
			{
			var plugin = this.getPlugin('click_to_pause');
			plugin && plugin.disable();
			},
		},
                 height: '100%',
                 width: '100%',
			mediacontrol: {
			seekbar: "#0F0",
			buttons: "#0F0"
			},
                 autoPlay: false,
                 watermark: "https://png.kodi.al/tv/albdroid/logo_bar.png",
		 position: 'top-right',
                 watermarkLink: "http://albdroid.al/",
	         poster: "<?php if ($image){ echo $image; }else{ echo 'https://png.kodi.al/tv/albdroid/logo_bar.png'; } ?>",
                 shakaConfiguration: {
                 manifest: {retryParameters: {maxAttempts: Infinity}},
                 streaming: {retryParameters: {maxAttempts: Infinity}},
                 drm: {retryParameters: {maxAttempts: Infinity}},
                 },

                 playbackRateConfig: {
                 defaultValue: '1.00x',
                 options: [
                 {value: '0.10', label: '0.10x'},
                 {value: '0.25', label: '0.25x'},
                 {value: '0.50', label: '0.50x'},
                 {value: '0.75', label: '0.75x'},
                 {value: '1.00', label: '1.00x'},
                 {value: '1.25', label: '1.25x'},
                 {value: '1.50', label: '1.50x'},
                 {value: '1.75', label: '1.75x'},
                 {value: '2.00', label: '2.00x'},
                 ]
                 },
             });
         };
      </script>
   </body>
</html>
