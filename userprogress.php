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
    <link rel="import" href="css/my_custom_styles.html">
    <link rel="stylesheet" href="css/style.css">

  </head>

  <body>
        <?php include 'menu.php';?>
        
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2 center">
                        <?php include 'header.html';?>
                        <br>
                        <center>

<?php
        echo '<link rel="stylesheet" href="css/components_style.css">';

        if (isset($_SESSION["loggedin"]) &&$_SESSION["loggedin"]==1 ){
        if (isset($_SESSION["instructor"])){
            if ($_SESSION["instructor"]==1){
               echo '<h1 class="page-header"> Users\' Progress</h1>' ;
            }  
            else if ($_SESSION["instructor"]==0){
                echo '<h4 class="page-header">'. $_SESSION["fname"] . '\'s Progress</h4>';
                echo '<paper-material elevation="3" class="card">';
                echo '<div class="adjust"><div class="table-responsive"><table><tr><td align="center">Topic Name</td><td align="center">Total Answered</td><td align="center">Total Correct</td><td align="center">% Correct</td></tr>';       
                $topics=array();
                $topics=getTopics();
                foreach($topics as $t) {
                    $topicID=$t["topicID"];
                    $topicName=$t["topic"];
                    $uprogress=array();
                    $cellcolor="#ffffff";
                    $uprogress=getUserProgress($topicID, $_SESSION["uid"]);
                    if (empty($uprogress)) {
                            echo '<tr><td><a style="color:#28547a;" href="topic?id=' . $topicID . '">'.$topicName.'</td>';
                            echo '<td align="center">0</td>';
                            echo '<td align="center">0</td>';
                            echo '<td align="center">0%</td>';
                    }
                    else {
                        foreach($uprogress as $item) {
                            echo '<tr><td><a style="color:#28547a;" href="topic?id=' . $topicID . '">'.$topicName.'</td>';
                            echo '<td align="center">'.$item["totalanswered"].'/'.$item["totalquestions"]. '</td>';
                            echo '<td align="center">'.$item["totalcorrect"].'</td>';
                            $score=str_replace('%', '', $item["percentageCorrect"]) / 100;
                            if ($score < 0.7) {
                                $cellcolor='salmon';
                            }
                            elseif ($score >=0.7 and $score < 0.9) {
                                $cellcolor='#ffe37a';
                            }
                            else {
                                $cellcolor='#7affa0';
                            }
                            echo '<td align="center" style="color: #ffffff; background:'.$cellcolor.'">' .$item["percentageCorrect"].'%</td></tr>';
                        }
                    }

                }
                echo '</table></div></div></paper-material><br>';
            }
        }
    }
    else{
        $_SESSION["intended"]="userprogress";
        header( 'Location: login') ;
    }
?> 
</paper-material>
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

