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
    
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
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
                  <center><p><?php echo $descriptionText ?></p></center>
                  
            </div>
            
        </div>
        
        <div class="table-responsive">
            <center>
              <table class="table">
                <thead>
                  <tr>
                    <th><h5>Additonal Resources</h5></th>
                    <th><h5>Practice</h5></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                         <?php
                          foreach ($addtionalResources as $item) {
                            echo "<a target ='_blank' href=" . $item . ">" . $item . "</a><br>";
                          }
                        ?>
                    </td>
                    <td>  
                        <button type="button" class="btn btn-success">Let's Go!</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </center>
        </div>
              <br>
              <br>
             
      </div>
      <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js'></script>
    <script src="js/index.js"></script>
  </body>
</html>