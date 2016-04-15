<?php
  include_once("analyticstracking.php");
  include 'internal_api.php';
  
?>

<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>LearningX | Your perfect Java teacher</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
    <link rel="stylesheet" href="css/style.css">  
  </head>

  <body>
  <?php include 'menu.php';?>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 center">
                  <h2 class="page-header text-center"><?php if(isset($theTopic)) echo $theTopic ?></h2>
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
                  <div class="video-container">
                  <iframe class="center-block" width="560" height="315" src="https://www.youtube.com/embed/<?php echo $featuredResourceId ?>" frameborder="0" allowfullscreen></iframe> 
                  </div> 
                  <center><p><?php echo $descriptionText ?></p>
                  <table  border="0" cellspacing="5" cellpadding="5">
                  <div class="">
                    <tr>
                      <td align="left" valign="top" width="90%">
                        <h4>Additional Resources</h4>
                        </td>
                      <td align="right" valign="top" width="10%">
                        <h4>Practice</h4>
                        
                      </td>
                      </tr>
                    
                  </div>

                 
                  <tr>
                    <td align="left" valign="top" width="90%">
                         <?php
                          foreach ($addtionalResources as $item) {
                            echo "<a href=" . $item . ">" . $item . "</a><br>";
                          }
                        ?>
                      </td>
                    <td align="right" valign="top" width="10%">  
                      <ul>
                        <a href="#">Let's go!</a>
                      
                    </td>
                  </tr>
              </table>
              </center>
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