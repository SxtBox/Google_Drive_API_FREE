<?php
/*
    GET JW_Player.php?id=[GOOGLE DRIVE ID]

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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?php if ($title){ echo $title; }else{ echo "Google Drive Player"; } ?></title>
    <link rel="shortcut icon" href="https://kodi.al/panel.ico"/>
    <link rel="icon" href="https://kodi.al/panel.ico"/>
    <meta name="robots" content="noindex">
    <meta name="referrer" content="never" />
    <meta name="referrer" content="no-referrer" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
<style type="text/css">
body {
    padding: 0;
    margin: 0;
    background: #000;
    overflow: hidden
}

#player,
.jwplayer {
    position: absolute;
    top: 0;
    width: 100%;
    height: 100%
}

#loader {
    width: 180px;
    height: 180px;
    line-height: 180px;
    box-sizing: border-box;
    text-align: center;
    z-index: 9;
    display: inline-block;
    position: absolute;
    top: 50%;
    margin-top: -90px;
    left: 50%;
    margin-left: -90px
}

#loader p {
    color: #0F0;
    font-weight: 700
}

#loader:after,
#loader:before {
    opacity: 0;
    box-sizing: border-box;
    content: "\0020";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 100px;
    border: 7px solid #0F0;
    box-shadow: 0 0 90px #fff, inset 0 0 50px #0F0
}

#loader:after {
    z-index: 1;
    -webkit-animation: gdriveloader 2s infinite 1s;
    -moz-animation: gdriveloader 2s infinite 1s;
    -o-animation: gdriveloader 2s infinite 1s;
    animation: gdriveloader 2s infinite 1s
}

#loader:before {
    z-index: 2;
    -webkit-animation: gdriveloader 2s infinite;
    -moz-animation: gdriveloader 2s infinite;
    -o-animation: gdriveloader 2s infinite;
    animation: gdriveloader 2s infinite
}

@-webkit-keyframes gdriveloader {
    0% {
        -webkit-transform: scale(0);
        opacity: 0
    }

    50% {
        opacity: 1
    }

    100% {
        -webkit-transform: scale(1);
        opacity: 0
    }
}

@-moz-keyframes gdriveloader {
    0% {
        -moz-transform: scale(0);
        opacity: 0
    }

    50% {
        opacity: 1
    }

    100% {
        -moz-transform: scale(1);
        opacity: 0
    }
}

@-o-keyframes gdriveloader {
    0% {
        -o-transform: scale(0);
        opacity: 0
    }

    50% {
        opacity: 1
    }

    100% {
        -o-transform: scale(1);
        opacity: 0
    }
}

@keyframes gdriveloader {
    0% {
        transform: scale(0);
        opacity: 0
    }

    50% {
        opacity: 1
    }

    100% {
        transform: scale(1);
        opacity: 0
    }
}

@media screen and (max-width:520px) {
    #loader {
        height: 140px;
        width: 140px;
        margin-top: -90px
    }

    #movie-info .movie-cover i {
        font-size: 40px;
        margin-top: -20px;
        margin-left: -11px
    }
}

@media screen and (max-width:520px) {
    #loader {
        margin-top: -70px;
        margin-left: -70px
    }
}

#player {
    position: absolute;
    width: 100% !important;
    height: 100% !important
}

.jw-rightclick {
    display: none !important;
}
</style>
</head>
<body>

<div id="loader"></div>
<div id="player"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ssl.p.jwpcdn.com/player/v/8.8.6/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="64HPbvSQorQcd52B8XFuhMtEoitbvY/EXJmMBfKcXZQU2Rnn";</script>

<script type="text/javascript">
var videoPlayer = jwplayer("player");
videoPlayer.setup({
    sources: [{
		
        "file": "<?php if ($file){ echo $file; }else{ echo 'https://trc4.com/no_source.mp4'; } ?>",
        "type": "<?php if ($type){ echo $type; }else{ echo 'video/mp4'; } ?>",
		"image": "<?php if ($image){ echo $image; }else{ echo 'https://png.kodi.al/tv/albdroid/logo_bar.png'; } ?>",
        "label": "HD"
    }],
    title: "<?php echo $title; ?>",
    playbackRateControls: [0.25, 0.5, 0.75, 1, 2, 3],
    image: "<?php echo $image; ?>",
    autostart: false,
    controls: true,
    width: "100%",
    height: "100%",
    logo: {
        file: "https://png.kodi.al/tv/albdroid/logo_bar.png",
        position: "top-right",
    },

skin: {
    name: "",
    active: "#0F0",
    inactive: "#0F0",
    background: "transparent"
}
});

(function($) {
    function getTimer(obj) {
        return obj.data("swd_timer")
    }

    function setTimer(obj, timer) {
        obj.data("swd_timer", timer)
    }
    $.fn.showWithDelay = function(delay) {
        var self = this;
        if (getTimer(this)) {
            window.clearTimeout(getTimer(this))
        }
        setTimer(this, window.setTimeout(function() {
            setTimer(self, false);
            $(self).show()
        }, delay))
    };
    $.fn.hideWithDelay = function() {
        if (getTimer(this)) {
            window.clearTimeout(getTimer(this));
            setTimer(this, false)
        }
        $(this).hide()
    }
})(jQuery);

$(document).ready(function() {
    $("#loader").showWithDelay(500);
    window.setTimeout(function() {
        $("#loader").hideWithDelay()
    }, 500)
});

</script>
</body>
</html>