<?php

	//Pull the file and title boolean from the GET request
	$sFile      = $_GET['sFile'];
	$noTitle	= $_GET['title'];
	if (!$noTitle){
		$noTitle = 0;
	}
	
	//Check to see that sFile actually has a value
	if (($sFile == '') || ($sFile == '/')) {
		$fileError =	"<h3>There is an error on the page. Most likely it is due to a malformed URL.</h3>" .
						"<p>The URL should be formed as follows:<br />" .
						"<ul>" . 
						"<li>http://deit.desales.edu/MediaPlayer/index.php?sFile=/faculty/[your last name]/[name of file]</li>" .
						"<li>Example: <a href='http://deit.desales.edu/MediaPlayer/index.php?sFile=/faculty/sturoscy/CSSversusTables.flv'>http://deit.desales.edu/MediaPlayer/index.php?sFile=/faculty/sturoscy/CSSversusTables.flv</a></li>" . 
						"</ul></p>" . 
						"<p>If you continue to experience issues, please contact DEIT at <a href='mailto:deit@desales.edu'>deit@desales.edu</a> or at 610.282.1100 x2290.</p>";
	} else {
		$fileError = "";
	}

	//Determine its extension
	$xmlpattern = "/\.xml/";
	$flvpattern = "/\.flv/";
	$movpattern = "/\.mov/";
	$mp3pattern = "/\.mp3/";
	$m4vpattern = "/\.m4v/";
	$mp4pattern = "/\.mp4/";
	$wmvpattern = "/\.wmv/";
	
	//Set all to false
	$xml = false;
	$flv = false;
	$mov = false;
	$m4v = false;
	$mp3 = false;
	$mp4 = false;
	$wmv = false;
	
	//Get file type
	if (preg_match($xmlpattern, $sFile, $matches)){
		$xml = true;
		$fileType   = "xml";
		$fileOutput = "'playlistfile': '" . $sFile . "'";
	} elseif (preg_match($flvpattern, $sFile, $matches)) {
		$flv = true;
		$fileType = "flv";
		$fileOutput = "'file': '" . $sFile . "'";
	} elseif (preg_match($movpattern, $sFile, $matches)) {
		$mov = true;
		$fileType = "mov";
		$fileOutput = "'file': '" . $sFile . "'";
	} elseif (preg_match($m4vpattern, $sFile, $matches)) {
		$m4v = true;
		$fileType = "m4v";
		$fileOutput = "'file': '" . $sFile . "'";
	} elseif (preg_match($mp3pattern, $sFile, $matches)) {
		$mp3 = true;
		$fileType = "mp3";
		$fileOutput = "'file': '" . $sFile . "'";
	} elseif (preg_match($mp4pattern, $sFile, $matches)) {
		$mp4 = true;
		$fileType = "mp4";
		$fileOutput = "'file': '" . $sFile . "'";
	} elseif (preg_match($wmvpattern, $sFile, $matches)) {
		$wmv = true;
		$fileType = "wmv";
		$fileOutput = "'file': '" . $sFile . "'";
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link type="text/css" rel="stylesheet" href="stylesheets/grid.css" media="screen" />
		<link type="text/css" rel="stylesheet" href="stylesheets/main.css" media="screen" />
		<link type="text/css" rel="stylesheet" href="stylesheets/playlist.css" media="screen" />
		
		<!-- Let's get IE to play nice -->
		<!--[if lt IE 8]>
			<style type="text/css">
				#header {margin-bottom: 0px;}
				#main_player {margin-top: 0px;}
			</style>
		<![endif]-->
		
		<script src="http://www.google.com/jsapi?key=ABQIAAAAouTcR5pargXhEAtm4CODuhR1IgWQluDLEZuG6zC4jkkgj3hPMhT_DiGugOsQJmWOxV5nYZepBkPkxg" type="text/javascript"></script>
		<script type="text/javascript">
			google.load("jquery", "1");
			google.load("jqueryui", "1");
			google.load("swfobject", "2");
		</script>
		<script type="text/javascript" src="javascript/jwplayer.js"></script>
		<script type="text/javascript" src="javascript/flash-detect-min.js"></script>
		<script type="text/javascript">

			//Load the playlist js file via an ajax call based on whether or not title is true/false/undefined
			google.setOnLoadCallback(function() {

				//Get Boolean value from PHP GET for conditional statement below
				var title = <?php echo($noTitle); ?>;

				//Get file type from PHP for conditional statement below
				var file  = "<?php echo($fileType); ?>";

				//Set the title, or not
				if(file == "xml") {
					$.getScript("javascript/jquery.playlist.js");
				}else if(title == 0) {
					$("#player_margin").css({"margin" : "auto", "width" : "640px"});
				} else if (title == 1) {
					$.getScript("javascript/jquery.playlist.js");
				}
			})

		</script>
		<script src="http://cdn.jquerytools.org/1.2.2/all/jquery.tools.min.js"></script>
		<title>DeSales University Media Player</title>
	</head>
	<body>
		<div class="container_12">
			<div id="header" class="grid_10">
				<!-- <img src="images/media_logo.png" alt="Media Player" title="Media Player" /> -->
			</div>
			<div class="clear"></div>
			
			<div id="flash_error" class="grid_10"></div>
			<div class="clear"></div>
			
			<div id="file_error" class="grid_12">
				<?php echo ($fileError); ?>
			</div>
			<div class="clear"></div>

			<div id="player_margin">
				<div id="main_player"></div>
			</div>
			<div class="clear"></div>
		</div>
	</body>
	<script type="text/javascript">
		google.setOnLoadCallback(function() {
			
			//Flash detection script
			if(!FlashDetect.installed) {
				//Flash is not installed
				var flashError = "<h3>You do not have Flash Player installed. <br /><br />Please visit <a href='http://get.adobe.com/flashplayer/' target='_window'>http://get.adobe.com/flashplayer/</a>" + 
								 " to download and install the newest version of Flash.</h3>";
				$("#flash_error").html(flashError);
				$("#main_player").css({display : 'none'});
			} else {
				if (FlashDetect.versionAtLeast(10)){
					//Flash is installed
					//Call the embed function below
					embed();
				} else {
					//Outdated version of Flash
					var flashError = "<h3>You need to update your version of Flash. <br /><br />Please visit <a href='http://get.adobe.com/flashplayer/' target='_window'>http://get.adobe.com/flashplayer/</a>" + 
									 " to download and install the newest version of Flash.</h3>";
					$("#flash_error").html(flashError);
					$("#main_player").css({display : 'none'});
				}
			}
		})
	</script>
	<script type="text/javascript">
		
		//Embed the player
		//This is only called if the flash detection script is true
		function embed() {

			var flashvars = {
				'autostart':	'false',
				'bufferlength':	'5',
				'description':	'File: <?php echo($sFile); ?>',
				<?php echo($fileOutput) ; ?>,
				'logo.file':	'http://deit.desales.edu/MediaPlayer/images/media_logo_watermark.png',
				'skin':			'http://deit.desales.edu/MediaPlayer/skins/five/five.zip',
				'streamer':		'rtmp://mediasrv01.desales.edu/vod/',
				'provider':		'rtmp',
				'title':		'DeSales University Media Player',

				//Google plugin
				'plugins':					'gapro-1',
				'gapro.accountid':			'UA-15284864-3',
		    	'gapro.trackstarts':		'true',
				'gapro.trackpercentages':	'true', 
				'gapro.tracktime': 			'true'
			};

			var params = {
				'allowfullscreen':		'true',
				'allowscriptaccess':	'always',
				'wmode':				'opaque'
			};

			var attributes = {
				'id': 	'player1',
				'name':	'player1'
			};

			//The player version is indicated by the folder name i.e. /mediaplayer56 = jwPlayer version 5.6
			swfobject.embedSWF('http://deit.desales.edu/MediaPlayer/includes/licensed/mediaplayer56/player.swf', 'main_player', '640', '480', '9', 'false', flashvars, params, attributes);
		};

		google.setOnLoadCallback(embed);
	</script>
</html>