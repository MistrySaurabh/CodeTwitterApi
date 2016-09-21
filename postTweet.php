<?php
require_once('lib/OAuth.php');
require_once('lib/twitteroauth.php');
define('CONSUMER_KEY', 'tQHzwXnuQ7yZrEdRVqpQZuouD');
define('CONSUMER_SECRET', '5Z8VA2KU0gvqfyMqfwuLIiXnHH0d58e04fWP9OO2jOQRWzamPl');
define('OAUTH_CALLBACK', '	http://saurabh.ueuo.com/callback.php');
session_start();          
$access_token = $_SESSION['access_token'];
$status=$_POST['status'];
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	$post = $connection->post('statuses/update', array('status' => $status));
//	print_r($post);
?>