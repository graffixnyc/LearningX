<?php 
    include_once("analyticstracking.php");
    include 'internal_api.php';

    session_start();
    
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
                    <div class="col-lg-8 col-lg-offset-2">
                        <center>

<?php   
    if (isset($_SESSION["instructor"])){
        if ($_SESSION["instructor"]==1){
           echo '<h1 class="page-header"> Users\' Progress</h1>' ;
        }  
        else if ($_SESSION["instructor"]==0){
            echo '<h1 class="page-header">'. $_SESSION["fname"] . '\'s Progress</h1>';
        }
    }
    else{
        echo '<li><a href="register"><i class="fa fa-fw fa-user"></i> Register</a></li>';
        echo '<li><a href="login"><i class="fa fa-fw fa-sign-in"></i> Login</a></li>';
    }
?> 

                        </center>
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
