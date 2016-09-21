<?php
session_start();

require_once('lib/OAuth.php');
require_once('lib/twitteroauth.php');
define('CONSUMER_KEY', 'tQHzwXnuQ7yZrEdRVqpQZuouD');
define('CONSUMER_SECRET', '5Z8VA2KU0gvqfyMqfwuLIiXnHH0d58e04fWP9OO2jOQRWzamPl');
define('OAUTH_CALLBACK', '	http://saurabh.ueuo.com/callback.php');

if (isset($_REQUEST['oauth_verifier'], $_REQUEST['oauth_token']) && $_REQUEST['oauth_token'] == $_SESSION['request_token']) {
	$request_token = [];
	$request_token['oauth_token'] = $_SESSION['request_token'];
	$request_token['oauth_token_secret'] = $_SESSION['request_token_secret'];
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);
	$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
	$_SESSION['access_token'] = $access_token;
	// redirect user back to index page
	//header('Location: ./');

/*		if($access_token){	
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
		$params =array('include_entities'=>'false');
		$data = $connection->get('account/verify_credentials',$params);
		if($data){
			$_SESSION['data']=$data;*/
			$redirect = 'http://' . $_SERVER['HTTP_HOST'] . '/home.php';
  			header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
		//}


	//}
}
?>