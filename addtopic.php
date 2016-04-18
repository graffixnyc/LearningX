<?php 
    include_once("analyticstracking.php");
    include 'internal_api.php';

    session_start();
    if (!empty($_POST)){
    $topic=array(); 
    $topic=addTopic($_POST["topic"]);
    
}

 
?>
<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>LearningX | Your perfect Java teacher</title>
    
    
    <script src="/bower_components/webcomponentsjs/webcomponents-lite.js"></script>
        <link rel="import" href="bower_components/paper-submit/paper-submit.html">
        <link rel="import" href="bower_components/paper-input/paper-textarea.html">
        <link rel="import" href="bower_components/iron-form/iron-form.html">
        <link rel="import" href="bower_components/paper-toast/paper-toast.html">    
        <link rel="import" href="bower_components/paper-input/paper-input.html">
        <link rel="import" href="bower_components/paper-button/paper-button.html">
        <link rel="stylesheet" href="css/normalize.css">
    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
    <link rel="stylesheet" href="css/style.css">
    <link rel="import" href="bower_components/paper-material/paper-material.html">
    <link rel="import" href="bower_components/paper-styles/paper-styles.html">
    <link rel="import" href="css/my_custom_styles.html">

    
    
    
  </head>

  <body>
        <?php include 'menu.php';?>
        <?php include 'header.html';?>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <?php if (isset($_SESSION["instructor"]) && $_SESSION["instructor"]==1){   ?>
                        <center>
                           <h3>Create Topic</h2>
                      <paper-material elevation="3" class="card">
  
  <center>
    <?php if (isset($topic[0]["created"]) && $topic[0]["created"]=='Success'){?>
         <h4 style="color:red">Topic Created</h4>
         <?php }?>
    <form is="iron-form" id="form" method="post">
      <paper-input class="my-class"  id="topic"  name="topic" label="Enter a New Topic Name" required></paper-input>
      <paper-button id="my-button" raised onclick="submitForm();">Add Topic</paper-button>
      <br>
      <button type="submit" id="SubmitButton" name="submit" style="visibility:hidden;"></button>
      <paper-toast id="toast" text="Registering..."></paper-toast>
      <paper-toast  visible="false" id="toast2" text="Login Failed, Please Try Again..."></paper-toast>
    </form>
    <script>function submitForm(){
       
    if (document.getElementById('topic').value==''){
        document.querySelector('#toast2').text= "Topic Name Cannot be blank! Please Re-enter";
        document.querySelector('#toast2').show();
    }
    
    else{
    
        document.querySelector('#toast').text= "Adding Topic...";
        document.querySelector('#toast').show();
        document.getElementById('SubmitButton').click();
        console.log("Submitted!")
    }
    
    }
    
       </script>
  </center>
  <br />
  
  </paper-material>
                        </center>
                        <?php } else {?>
                        <h1> you do not have access</h1>

                        <?php }?>

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
