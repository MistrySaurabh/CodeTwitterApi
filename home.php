<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

  <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
<link rel="stylesheet" href="css/home.css"/>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/tableExport.js"/>
<script type="text/javascript" src="js/jquery.base64.js"/>

    <title>CodeTwitterApi</title>

<style type="text/css">
    .tweetlayout{
        height:50%;margin:25px;
    }

    .profilediv
    {
     margin-bottom:50px;
    }

    .profileimage{
    height:50px;width:50px;margin-left:20px;margin-right:20px;margin:top:20px;float:left;
    }


.carousel-inner{
background-color:#f1f1f1;
}

</style>

<script type="text/javascript">
/*$(document).ready(function(){
  $.ajax({
    type: "GET", 
  dataType: "json",
  url: 'getUserInfo.php',
   success:function(data){
    alert(data.user_results.name);
    alert(data.user_results.screen_name);
    alert(data.user_results.profileimage);
             
   },
   error: function(){ alert("Failed.");}
});     
});
*/
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
     
 for(var i=0 ; i< data.tweet_results.length; i++) {
     Tweet=data.tweet_results[i];
    $('<div class="item"><div class="tweetlayout"><div><div class="profilediv"><img src="'+UserProfile+'" class="profileimage"/><h4>'+UserName+'<br/><h5>@'+UserScreenName+'</h5></h4></div><h2>'+Tweet+'</h2></div></div>').appendTo('.carousel-inner');
    $('<li data-target="#carousel-example-generic" data-slide-to="'+i+'"></li>').appendTo('.carousel-indicators')

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


</head>

<body>
<?php
require_once('lib/OAuth.php');
require_once('lib/twitteroauth.php');
define('CONSUMER_KEY', 'tQHzwXnuQ7yZrEdRVqpQZuouD');
define('CONSUMER_SECRET', '5Z8VA2KU0gvqfyMqfwuLIiXnHH0d58e04fWP9OO2jOQRWzamPl');
define('OAUTH_CALLBACK', '  http://saurabh.ueuo.com/callback.php');
session_start();
if(isset($_GET['logout'])){
    session_unset();
    session_destroy();
    header('Location: ' . 'index.php');
}
?>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <a class="navbar-brand" href="#"></a>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <div class="container-fluid">
               
                 <ul class="nav navbar-nav navbar-right">
                  <li><a href="?logout=true">Logout <span class="glyphicon glyphicon-log-out"></span></a></li>
                </ul>
                </div>
            </div>
            <!-- /.navbar-collapse -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
           
            <div class="col-md-9">

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
                            echo "</div>"; ?>

                            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>
                    </div>

                </div>

                <div class="row">
               <div class="btn-group">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Download Your Tweets <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            <li><a href="#">CSV</a></li>
            <li><a href="#">XLS</a></li> 
            <li><a href="#">Google-Spreadhseet</a></li>
            <li><a href="#">PDF</a></li>
            <li><a href="#">XML</a></li>
            <li><a href="#">JSON</a></li>
          </ul>
        </div>
                </div>

            </div>


               <div class="col-md-3">
                <center><p class="lead">Followers</p></center>
            
               <table id="followertable" class="table table-hover">
               <tbody>
<?php
$access_token = $_SESSION['access_token'];
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
    $user = $connection->get("account/verify_credentials");
    //print_r($user);
 $userscreenname = $user->screen_name;
$followerlist = $connection->get('followers/list',array('screen_name' => $userscreenname,'count'=>10));
        $followerarray=array();
   foreach ($followerlist->users as $follower) {
        $id = $follower->id;
        $name = $follower->name;
        $image= $follower->profile_image_url;
        $screen_name = $follower->screen_name;
      
      array_push($followerarray,$screen_name);


echo "<tr id=".$screen_name."><td><img src=".$image." height='50' width='50'/></td><td>
                        <h5>".$name."</h5>
                         <a href='#' style='color:#1da1f2'>@".$screen_name."</a></td></tr>";

            }
       $followerResponse=json_encode($followerarray);     
 header( 'Content-Type: text/html; charset=utf-8' ); 
?>

                    </tbody>
                 </table>
            </div>

        </div>

    </div>
    <!-- /.container -->

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Developed By Saurabh Mistry</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->


</body>

</html>
