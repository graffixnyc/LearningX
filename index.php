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

  <div class="description" id="description">Click Here to Start!</div>

        <?php include 'menu.php';?>
            <div class="cover" id="cover"></div> 
            <div class="container" id="container">

                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                     <?php include 'header.html';?>
                     <br>
                        <center>
                            <div class="video-container" id="video">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/QkKVQHwm2V8" frameborder="0" allowfullscreen></iframe>
                            </div> 
                        </center>

                        
                        <p style="text-align: justify; margin:15px 0"><span style="float: left; color: #903; font-size: 55px; line-height: 1; padding-top: 4px; padding-right: 8px; padding-left: 3px; font-family: Georgia;">L</span>earning X is an adaptive platform designed to help users learn and to simplify the complexity of that process. For instructors: Learning X allows you to create content based on your course material. You can also view student's process to glean insights into your own teaching practices. For students: You can work through the materials as needed or you can test your knowledge by using our adaptive quiz system. To get started click here (we can link to the introduction)</p>
                        <!-- <p style="text-indent: 2em; text-align: justify">Learning X is an adaptive platform designed to help users learn and to simplify the complexity of that process. </p>
                        <p style="text-indent: 2em; text-align: justify">For instructors: Learning X allows you to create content based on your course material. You can also view student's process to glean insights into your own teaching practices. </p>
                        <p style="text-indent: 2em; text-align: justify">For students: You can work through the materials as needed or you can test your knowledge by using our adaptive quiz system. To get started click here (we can link to the introduction)</p> -->
                    </div>
                </div>
            </div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js'></script>

        <script src="js/index.js"></script>
<!--<script src="cover.js"></script>-->

    
    
    
  </body>
</html>
