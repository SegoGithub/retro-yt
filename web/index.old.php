<!-- <?php
// Program to display URL of current page.

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
// fetch("http://invidio.xamh.de/api/v1/videos/", $params['v'], "?fields=formatStreams,title")
function callAPI($method, $url, $data){
  $curl = curl_init();
  switch ($method){
     case "POST":
        curl_setopt($curl, CURLOPT_POST, 1);
        if ($data)
           curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        break;
     case "PUT":
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        if ($data)
           curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        break;
     default:
        if ($data)
           $url = sprintf("%s?%s", $url, http_build_query($data));
  }
  // OPTIONS:
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array(
     'Content-Type: application/json',
  ));
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  // EXECUTE:
  $result = curl_exec($curl);
  if(!$result){die("Connection Failure");}
  curl_close($curl);
  return $result;
}

$get_data = callAPI('GET', 'https://invidio.xamh.de/api/v1/videos/', $params['v'], '?fields=formatStreams,title', false);
$response = json_decode($get_data, true);
$errors = $response['response']['errors'];
$data = $response['response']['data'][0];
echo $data;
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
</form>
<object type="application/x-shockwave-flash" data="player_flv_mini.swf" width="288" height="360">
    <param name="movie" value="player_flv_mini.swf" />
    <param name="allowFullScreen" value="true" />
    <param name="FlashVars" value="flv=videoplayback.flv%20&amp;width=288&amp;height=360&amp;autoplay=1&amp;autoload=1" />
</object>
</center>
</body>
</html>

<?php else: ?> -->

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
<form action="/" method="get">
    YT Video ID
    <input type="text" size="30" name="v">
    <br>
    <input type="submit" id="form" value="Watch">
  </form>
  <object type="application/x-shockwave-flash" data="player_flv_mini.swf" width="288" height="360">
    <param name="movie" value="player_flv_mini.swf" />
    <param name="allowFullScreen" value="true" />
    <param name="FlashVars" value="flv=videoplayback.flv%20&amp;width=288&amp;height=360&amp;autoplay=1&amp;autoload=1" />
</object>
  <p>Originally made for the <a href="http://en.wikipedia.org/wiki/Nokia_C7-00">Nokia C7-00</a></p>
</center>
</body>
</html>

<?php ?>