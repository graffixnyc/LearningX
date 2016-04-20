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
<script src="/bower_components/webcomponentsjs/webcomponents-lite.js"></script>
<link rel="import" href="bower_components/paper-material/paper-material.html">
<link rel="import" href="bower_components/paper-styles/paper-styles.html">
        <link rel="stylesheet" href="css/style.css">

  </head>

  <body>
        <?php include 'menu.php';?>
        
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <?php include 'header.html';?>
                        <br>
                        <center>

<?php   
    if (isset($_SESSION["instructor"])){
        if ($_SESSION["instructor"]==1){
           echo '<h1 class="page-header"> Users\' Progress</h1>' ;
        }  
        else if ($_SESSION["instructor"]==0){
            echo '<h1 class="page-header">'. $_SESSION["fname"] . '\'s Progress</h1>';
            $uprogress=array();
            // _SESSION can be found in login.php
            $uprogress=getUserProgress($topic_level=NULL, $user_id=$_SESSION["uid"]);
            //echo '<p> The level is ' .$uprogress[0]["level"]. '</p>';
            //echo '<p> The total questions is ' .$uprogress[0]["totalquestions"]. '</p>';
            //echo '<p> The total answered is ' .$uprogress[0]["totalanswered"]. '</p>';
            //echo '<p> The total correct is ' .$uprogress[0]["totalcorrect"]. '</p>';
            //echo '<p> The percentage correct is ' .$uprogress[0]["percentageCorrect"]. '</p>';
            echo '<table border=1px><tr><td>Level</td><td>Total Number of Questions</td><td>Total Questions Answered</td><td>Total Question Correct</td><td>% Answered Correctly</td></tr>';
            foreach($uprogress as $item) {
                echo '<tr><td>'.$item["level"].'</td>';
                echo '<td>'.$item["totalquestions"].'</td>';
                echo '<td>'.$item["totalanswered"].'</td>';
                echo '<td>'.$item["totalcorrect"].'</td>';
                echo '<td>'.$item["percentageCorrect"].'</td></tr>';

            }
            echo '</table>';
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

