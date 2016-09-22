#Documentation
This Project performs following operations using Twitter API V-1.1

* User Login With Twitter
* Display User Detail 
* Display Recent Tweets in Bootstrap Carousel Slider
* Display User's Followers in List
* User Can Post a Tweet
* On Click Of Follower List Item , Display Follower's Tweets in Slideshow without Page reload using Ajax


## Part-1 : User Login With Twitter Api 
* First of all you to create an app @ [Tweeter Developer Console](https://apps.twitter.com/)

* Here we are using 3rd party Library [twitteroauth](https://github.com/abraham/twitteroauth) for login with Twitter.

### Configuration
``` 
require_once('lib/OAuth.php');
require_once('lib/twitteroauth.php');
define('CONSUMER_KEY', 'tQHzwXnuQ7yZrEdRVqpQZuouD');
define('CONSUMER_SECRET', '5Z8VA2KU0gvqfyMqfwuLIiXnHH0d58e04fWP9OO2jOQRWzamPl');
define('OAUTH_CALLBACK', '  http://saurabh.ueuo.com/callback.php'); 
```

### Index Page Design
![screenshot 799](https://cloud.githubusercontent.com/assets/16002832/18734215/bd1fd12c-808f-11e6-9bb7-2a80ec1e38f2.png)


### Request For Authorization Url On Click Of SignIn Button
```
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

```

### Redirect To Home Page After Getting AuthorizationUrl
```
if(isset($_GET['oauth_token'])){
  		header('Location: ' .'home.php');
}
```

## Part-2 : Get User Information
```
$access_token = $_SESSION['access_token'];
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
    $user = $connection->get("account/verify_credentials");
   
   $name=$user->name;
   $screenname=$user->screen_name;
   $profileimage=$user->profile_image_url;
```

## Part-3 : Get User's Tweets 
```
$access_token = $_SESSION['access_token'];
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
    $user = $connection->get("account/verify_credentials");
   
  $screenname=$user->screen_name;

  $timeline = $connection->get('statuses/user_timeline', array('screen_name' => $screenname,'count'=>10,'exclude_replies'=>true));
   foreach($timeline as $i =>$tweet) {
    echo $tweet->text;
    }

```
### Home Page Design
![screenshot 796](https://cloud.githubusercontent.com/assets/16002832/18734605/c550a228-8093-11e6-9ae3-98527aea3cc7.png)



### Setting Up Bootstrap Carousel Slider
```
<div class="row carousel-holder">

<div class="col-md-12">
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
<?php 
$access_token = $_SESSION['access_token'];

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
  
   $user = $connection->get("account/verify_credentials");
   $name=$user->name;
   $screenname=$user->screen_name;
   $profileimage=$user->profile_image_url;

  $timeline = $connection->get('statuses/user_timeline', array('screen_name' => $screenname,'count'=>10,'exclude_replies'=>true));
 
if(sizeof($timeline)==0){
    echo "<ol class='carousel-indicators'><li data-target='#carousel-example-generic' data-slide-to='0' class='active'></li></ol><div class='carousel-inner'><div class='item active'><div class='tweetlayout'>
    <div><div class='profilediv'><img src='".$profileimage."' class='profileimage'/><h4>".$name."<br/><h5>@".$screenname."</h5></h4></div><h2>No Tweets Available</h2></div></div></div>";
 }
 else {
  
    echo "<ol class='carousel-indicators'>";
       foreach($timeline as $i =>$tweet) { 
        if($i==0){
    echo "<li data-target='#carousel-example-generic' data-slide-to=".$i." class='active'></li>";
        }else
        {
 echo "<li data-target='#carousel-example-generic' data-slide-to=".$i." ></li>";
        }
          }
                            echo "</ol>";
                            echo "<div class='carousel-inner'>";
                             foreach($timeline as $i => $tweet) { 
                                if($i==0){
                                echo "<div class='item active'>
                                <div class='tweetlayout'>
                                         <div>
                                         <div class='profilediv'><img src='".$profileimage."' class='profileimage'/>
                                         <h4>".$name."<br/><h5>@".$screenname."</h5></h4>
                                        </div>
                                         <h2>".$tweet->text."</h2>
                                         </div>      
                                    </div>
                                </div>";
                                }else
                                {
                        echo "<div class='item'> 
                                <div class='tweetlayout'>
                                         <div>
                                          <div class='profilediv'><img src='".$profileimage."' class='profileimage'/>
                                         <h4>".$name."<br/><h5>@".$screenname."</h5></h4>
                                        </div>
                                         <h2>".$tweet->text."</h2>
                                         </div>      
                                    </div>
                                </div>";
                                }
                            }
                            echo "</div>";
 }
   ?>

                            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>
                    </div>

                </div>

```


## Part-4 : Get User's Follower Names
```
$access_token = $_SESSION['access_token'];
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
    
    $user = $connection->get("account/verify_credentials");
    
    $userscreenname = $user->screen_name;

$followerlist = $connection->get('followers/list',array('screen_name' => $userscreenname,'count'=>10));
$followerarray=array();

foreach ($followerlist->users as $follower) {
        $id = $follower->id;
        $name = $follower->name;
        $image= $follower->profile_image_url;
        $screen_name = $follower->screen_name;
        array_push($followerarray,$screen_name);


echo "<tr id=".$screen_name."><td><img src=".$image." height='50' width='50'/></td>
<td><h5>".$name."</h5><a href='#' style='color:#1da1f2'>@".$screen_name."</a></td>
</tr>";
}

``` 
## Part-5 : Load Follower's Tweet On Same Bootstrap Carousel Slider Using Ajax
```
<script type="text/javascript">

$(document).on('click','#followertable tr',function()
   {
   var ScreenName = $(this).closest('tr').attr('id');
   var Profile = $(this).closest('tr').find('td:eq(0) img').attr('src');  
   var Name=$(this).closest('tr').find('td:eq(1) h5').text();

   $.ajax({
  type: "POST", 
  dataType: "json",
  data:{name:Name,profile:Profile,screen_name:ScreenName},
  
  url: 'getUserTweets.php',
  
   success:function(data){
    var UserName=data.name;
    var UserScreenName=data.screenname;
    var UserProfile=data.profile;
  
    $('#carousel-example-generic').find('.item').remove();
    $('.carousel-indicators').empty();
  

     if(data.tweet_results.length==0){
 $('<div class="item"><div class="tweetlayout"><div><div class="profilediv"><img src="'+UserProfile+'" class="profileimage"/><h4>'+UserName+'<br/><h5>@'+UserScreenName+'</h5></h4></div><h2>No Tweets Available</h2></div></div>').appendTo('.carousel-inner');
    $('<li data-target="#carousel-example-generic" data-slide-to="'+i+'"></li>').appendTo('.carousel-indicators');
     }else{
for(var i=0 ; i< data.tweet_results.length; i++) {
     Tweet=data.tweet_results[i];
    $('<div class="item"><div class="tweetlayout"><div><div class="profilediv"><img src="'+UserProfile+'" class="profileimage"/><h4>'+UserName+'<br/><h5>@'+UserScreenName+'</h5></h4></div><h2>'+Tweet+'</h2></div></div>').appendTo('.carousel-inner');
    $('<li data-target="#carousel-example-generic" data-slide-to="'+i+'"></li>').appendTo('.carousel-indicators');
  }
     }
 
  $('.item').first().addClass('active');
  $('.carousel-indicators > li').first().addClass('active');
  $('#carousel-example-generic').carousel();

   },
   error: function(){ alert("Failed.");}
});  
return false;
});

</script>
```

### getUserTweets.php
```
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

 if (isset($userscreenname)) {
 $timeline = $connection->get('https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name='.$userscreenname.'&count=10');
 $arr=array();


 foreach ($timeline as $i => $tweet) {
 	array_push($arr,$tweet->text);
    }

 echo json_encode(array('tweet_results'=>$arr,'name'=>$username,'screenname'=>$userscreenname,'profile'=>$userprofile));
  }

?>
```

## Part-6 : User Can Post Tweet
```
$status=$_POST['status'];
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	$post = $connection->post('statuses/update', array('status' => $status));

```
## Part-7 : Logout User
Redirecting User To SignIn Page
```
if(isset($_GET['logout'])){
    session_unset();
    session_destroy();
    header('Location: ' . 'index.php');
}
```

