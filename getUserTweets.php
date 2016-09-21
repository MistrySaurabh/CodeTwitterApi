<?php
require_once('lib/OAuth.php');
require_once('lib/twitteroauth.php');
define('CONSUMER_KEY', 'tQHzwXnuQ7yZrEdRVqpQZuouD');
define('CONSUMER_SECRET', '5Z8VA2KU0gvqfyMqfwuLIiXnHH0d58e04fWP9OO2jOQRWzamPl');
define('OAUTH_CALLBACK', '	http://saurabh.ueuo.com/callback.php');
session_start();          
	$access_token = $_SESSION['access_token'];
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
 $username=$_POST['name'];
 $userprofile=$_POST['profile'];	
 $userscreenname=$_POST['screen_name'];
 //$userscreenname='narendramodi';
 if (isset($userscreenname)) {
 $timeline = $connection->get('https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name='.$userscreenname.'&count=10');
 $arr=array();


 foreach ($timeline as $i => $tweet) {
 	array_push($arr,$tweet->text);
    }

 echo json_encode(array('tweet_results'=>$arr,'name'=>$username,'screenname'=>$userscreenname,'profile'=>$userprofile));
  }

?>