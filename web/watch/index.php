<?php
$config = parse_ini_file("../../config.ini");

$api = $config['ip'] . ":" . $config['port'];

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
$link = "https";
else
$link = "http";

// Here append the common URL characters.
$link .= "://";

// Append the host(domain name, ip) to the URL.
$link .= $_SERVER['HTTP_HOST'];

// Append the requested resource location to the URL
$link .= $_SERVER['REQUEST_URI'];

$url_components = parse_url($link);

// Use parse_str() function to parse the
// string passed via URL
parse_str($url_components['query'], $params);
?>
<?php if ($params['v']): ?>
<?php
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://" .$api. "/video/" . $params['v'],
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache"
  ),
));

$response = json_decode(curl_exec($curl), true);
$err = curl_error($curl);

curl_close($curl);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>
    <title>RetroYT</title>
</head>
<body>

<form action="/watch" method="get">
<a href="/"><font size="6">RetroYT</font></a>
  Video ID
  <input type="text" size="15" name="v" required>
  <select name="player">
    <option value="flash">Flash</option>
    <option value="silverlight">Silverlight</option>
  </select>
  <input type="submit" id="form" value="Watch">
</form>
<center>
<h2><?php echo $response['title'] ?></h2>
  <?php if ($params['player'] == 'flash'): ?>
  <object type="application/x-shockwave-flash" data="/player_flv_mini.swf" width="<?php echo $response['width'] ?>" height="<?php echo $response['height'] ?>">
    <param name="movie" value="/player_flv_mini.swf" />
    <param name="allowFullScreen" value="true" />
    <param name="FlashVars" value="flv=http://<?php echo $api ?>/vid/<?php echo $params['v'] ?>/videoplayback.flv&amp;autoplay=1&amp;autoload=1&amp;phpstream=1" />
  </object>
  <?php elseif ($params['player'] == 'silverlight'): ?>
    <div id="silverlightControlHost">
	<object data="data:application/x-silverlight-2," type="application/x-silverlight-2" width="<?php echo $response['width'] ?>" height="<?php echo $response['height'] ?>">
		<param name="source" value="/ClientBin/VideoPlayerM.xap"/>
		<param name="background" value="white" />
		<param name="initParams" value="m=http://<?php echo $api ?>/vid/<?php echo $params['v'] ?>/videoplayback.wmv" />
               <param name="minruntimeversion" value="2.0.31005.0" />
		<a href="http://go.microsoft.com/fwlink/?LinkId=124807" style="text-decoration: none;">
 			<img src="http://go.microsoft.com/fwlink/?LinkId=108181" alt="Get Microsoft Silverlight" style="border-style: none"/>
		</a>
	</object>
</div>
  <?php else: ?>
    <p>Player type not specified!</p>
    <a href="/">Return to main page</a>
  <?php endif; ?>
  <marquee><?php echo $response['desc'] ?></marquee>
  <p>subs: <?php echo $response['subs'] ?></p>
  <p>views: <?php echo $response['views'] ?></p>
  <p>likes: <?php echo $response['likes'] ?></p>
  <p>dislikes: <?php echo $response['dislikes'] ?></p>
</center>
</body>
</html>

<?php else: ?>
  
<?php
header("Location: /");
die();
?>

<?php endif; ?>