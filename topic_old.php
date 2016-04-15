<?php
	include_once("analyticstracking.php");
	include 'internal_api.php';
	session_start();
	if ($_SESSION["loggedin"]=='1'){
		// echo 'LOGGED IN';
	}
	else{
		$_SESSION["intended"]="topic";
		header( 'Location: login' ) ;
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/mainmenu.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">LearningX</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Help</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div id="wrapper">
      <!-- Sidebar -->
      <div id="sidebar-wrapper">
        <ul class="nav nav-sidebar">
            <li><a href="#">Home</a></li>
            <?php
              //Declare the Array
              $topics=array();
              //Set the Array to call the function (this function is in internal_api.php)
              $topics=getTopics();
              //Loop through the results and display them..
              foreach($topics as $item) {
                if ($_GET['id'] == $item["topicID"]) {
                  echo '<li class="active"><a href=topic?id=' . $item["topicID"] . '>' . $item["topic"] . '</a></li>';
                  $theTopic = $item["topic"];
                } else {
                  echo '<li><a href=topic?id=' . $item["topicID"] . '>' . $item["topic"] . '</a></li>';
                }

              }
            ?>
        </ul>
      </div>
      <!-- End of Sidebar -->
      <!-- Page Content -->
      <div id="page-content-wrapper">
        <div class="container-fluid main">
          <div class="row">
            <div class="placeholders">
              <h1 class="page-header"><?php if($theTopic) echo $theTopic ?></h1>
                  <?php
                    if (!empty($_GET['id'])){
                    	//Declare the Array
                    	$resources=array();
                      //Declare additional resources
                      $addtionalResources = array();
                    	//Set the Array to call the function (this function is in internal_api.php)
                    	$resources=getResources($_GET['id']);
                    	//Loop through the results and display them.. y
                      foreach($resources as $item) {
                        if ($item['featured'] == 1)
                          $featuredResource = $item['resource'];
                        else if ($item['resourceType'] == "text")
                          $descriptionText = $item['resource'];
                        else
                          $addtionalResources[] = $item['resource'];
                    	}
                    }

                    //Get the id of featured resource, because the video cannot be displayed by raw url
                    $tempArray = explode("watch?v=", $featuredResource);
                    $featuredResourceId = $tempArray[1];
                  ?>
              <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $featuredResourceId ?>" frameborder="0" allowfullscreen></iframe>
            </div>
  					<center><p><?php echo $descriptionText ?></p></center>
            <div class="col-md-6">
              <h2>Additional Resource</h2>
              <ul>
                <?php
                  foreach ($addtionalResources as $item) {
                    echo "<li><a href=" . $item . ">" . $item . "</a></li>";
                  }
                ?>
              </ul>
            </div>
            <div class="col-md-6">
              <h2>Practice</h2>
              <ul>
                <li><a href="#">Let's go!</a></li>
              </ul>
            </div>
            <div class="col-xs-12"><a href="#" class="btn btn-default btn-block" id="sidebar-toggle">Toggle Sidebar</a></div>
          </div>
        </div>
      </div>
      <!-- End of Page content -->





    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
    <!-- Sidebar toggle script -->
    <script>
      $(document).ready(function() {
        $("#sidebar-toggle").click( function(e){
          e.preventDefault();
          $("#wrapper").toggleClass("toggled");
        });
      });
    </script>
  </body>
</html>
