<?php
	error_reporting (E_ALL ^ E_NOTICE);

	/*Just for your server-side code*/
	header('Content-Type: text/html; charset=ISO-8859-1');
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content=
		"width=device-width, initial-scale=1">

	<style>
		.thumbnail-class {
			width: 50%;
			margin: 10px;
			padding: 5px;
			border-radius: 1px;
		}

		#titleDescID {
			width: 50%;
			margin: 10px;
			padding: 10px;
		}
	</style>
</head>
<br />

<body>
	<div id="thumbnailID" class="thumbnail-class">
		<?php
		if (isset($_POST['submit'])){
			$url = $_POST['url'];
			/* Extracting the v element from the link*/
			$vString = explode("v=", $url);
			$youtubeId = $vString[1];
		}
		?>

		<div id="videoDivID"
			style="width:600px;height:317px;">
			<iframe id="iframe"
				style="width:100%;height:100%"
				src=
"https://www.youtube.com/embed/<?php echo $youtubeId; ?>"
				data-autoplay-src="
https://www.youtube.com/embed/<?php echo $youtubeId; ?>?autoplay=1">
			</iframe>
		</div>
	</div>
	<?php
		//Its different for all users
		$myApiKey = 'AIzaSyChw0CecP11cOYRSnOTlqCbYZonpYSiQx0';
		$googleApi =
			'https://www.googleapis.com/youtube/v3/videos?id ='
			. $youtubeId . '&key=' . $myApiKey . '&part=snippet';

		/* Create new resource */
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		/* Set the URL and options */
		curl_setopt($ch, CURLOPT_URL, $googleApi);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		/* Grab the URL */
		$curlResource = curl_exec($ch);

	/* Close the resource */
		curl_close($ch);

		$youtubeData = json_decode($curlResource);

		$youtubeVals = json_decode(
			json_encode($youtubeData), true);

		$urlTitle = $youtubeVals
			['items'][0]['snippet']['title'];
			
		$description = $youtubeVals
			['items'][0]['snippet']['description'];
			
	?>
	<div id="titleDescID">
		<?php
			echo '<b>Title: ' . $urlTitle . '</b>';
			echo '<b>Description: </b>' . $description;
		?>
	</div>
</body>

</html>
