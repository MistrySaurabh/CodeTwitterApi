<!DOCTYPE html>
<html>
<head>
  <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"/>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <title>Twitter Demo</title>

<style type="text/css">
   body{background-color:#fff;}
#btnlogin{background-color:#1da1f2;color:#fff;}
</style>

</head>

<body>
<div class="container">
<center style="margin-top:15%">
 <h1>Twitter Login Demo</h1><br/>
 <img src="images/twitterIcon175x175.png" class="img-responsive img-circle" height="80" width="80" alt="Twitter Logo"/>
  <br/>
  
 
<?php
require_once('lib/OAuth.php');
require_once('lib/twitteroauth.php');
define('CONSUMER_KEY', 'tQHzwXnuQ7yZrEdRVqpQZuouD');
define('CONSUMER_SECRET', '5Z8VA2KU0gvqfyMqfwuLIiXnHH0d58e04fWP9OO2jOQRWzamPl');
define('OAUTH_CALLBACK', '	http://saurabh.ueuo.com/callback.php');

session_start();

if(!isset($_GET['oauth_token'])) {
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
	$request_token = $connection->getRequestToken(OAUTH_CALLBACK); 
	if($request_token){
		$token = $request_token['oauth_token'];
		$_SESSION['request_token'] = $token ;
		$_SESSION['request_token_secret'] = $request_token['oauth_token_secret'];
		$login_url = $connection->getAuthorizeURL($token);
	}
}
if(isset($_GET['oauth_token'])){
  		header('Location: ' .'home.php');
}
if(isset($login_url)){
	echo "<p><a class='btn btn-lg' id='btnlogin' href='$login_url' role='button'>Signin With Twitter</a></p>";
}
?>

</div>
</center>

</body>
</html>

 