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
<html >
  <head>
    <meta charset="UTF-8">
    <title>LearningX | Your perfect Java teacher</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
    <link rel="stylesheet" href="css/style.css">  
  </head>

  <body>
        <div id="wrapper">
        <div class="overlay"></div>
    
        <!-- Sidebar -->
        <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
            <ul class="nav sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                       Learning X
                    </a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-fw fa-home"></i> Home</a>
                </li>
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
        </nav>
        <!-- /#sidebar-wrapper -->
        <font color="white">Menu</font>
        <br>
        <br>
        <!-- Page Content -->
        <div id="page-content-wrapper">          
          <button type="button" class="hamburger is-closed animated fadeInLeft" data-toggle="offcanvas">
            <span class="hamb-top"></span>
            <span class="hamb-middle"></span>
            <span class="hamb-bottom"></span>
          </button>
          <div class="container">
              <div class="row">
                  <div class="col-lg-8 col-lg-offset-2 center">
                    <h1 class="page-header text-center"><?php if(isset($theTopic)) echo $theTopic ?></h1>
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
                    <iframe class="center-block" width="560" height="315" src="https://www.youtube.com/embed/<?php echo $featuredResourceId ?>" frameborder="0" allowfullscreen></iframe>  
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
                  </div>
              </div>
          </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js'></script>
    <script src="js/index.js"></script>
  </body>
</html>