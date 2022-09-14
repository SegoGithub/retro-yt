<?php
$api = "192.168.0.223";

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
  CURLOPT_URL => "http://" .$api. ":8080/v1/retroyt/flash/" . $params['v'],
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

echo $response;
curl_close($curl);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RetroYT</title>
</head>
<body>
<center><h1>RetroYT</h1>
<h2 id="title"></h2>
<form action="/" method="get">
  YT Video ID
  <input type="text" size="30" name="v">
  <br>
  <input type="submit" id="form" value="Watch">
  <h2><?php echo $response['title'] ?></h2>
  <object type="application/x-shockwave-flash" data="/player_flv_mini.swf" width="<?php echo $response['width'] ?>" height="<?php echo $response['height'] ?>">
    <param name="movie" value="/player_flv_mini.swf" />
    <param name="allowFullScreen" value="true" />
    <param name="FlashVars" value="flv=http://192.168.0.223:8080/vid/<?php echo $params['v'] ?>/videoplayback.flv&amp;autoplay=1&amp;autoload=1" />
  </object>
  <p><?php echo $response['desc'] ?></p>
  <p>subs: <?php echo $response['subs'] ?></p>
  <p>views: <?php echo $response['views'] ?></p>
  <p>likes: <?php echo $response['likes'] ?></p>
  <p>dislikes: in the future</p>
</form>
</center>
</body>
</html>

<?php else: ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RetroYT</title>
</head>
<body>
<center><h1>RetroYT</h1>
<h2>yt for old devices with flash</h2>
<form action="/" method="get">
  YT Video ID
  <input type="text" size="30" name="v">
  <br>
  <input type="submit" id="form" value="Watch">
</form>
</center>
</body>
</html>

<?php endif; ?>