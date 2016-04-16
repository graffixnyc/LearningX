<?php include_once("analyticstracking.php") ?>
<?php
session_start();
include 'internal_api.php';
if (!empty($_POST)){
    $user=array(); 
    $user=addUser($_POST["username"],md5($_POST["password"]),$_POST["firstname"],$_POST["lastname"]);
    if ($user[0]["created"]=='Success'){
        $_SESSION["newreg"]=1;
        header( 'Location: login') ;
    }
    else{
        header( 'Location: register') ;
    }
}
else{?>

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
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->
    
    <script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="js/script.js"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>

    
    
    
  </head>

  <body>

        <?php include 'menu.php';?>
        
            <div class="container">
                <div class="row">
                    
                        <center>
                        <h2>Register for Learning X</h2>
                            <paper-material elevation="3" class="card">
  
  <center>
    <?php if (isset($_SESSION["UserReg"])){ 
                unset($_SESSION["UserReg"]);
            ?>
    <h2 style="color:salmon">User Already Exists.</h2>
    <h3 style="color:salmon">If you forgot your password please use the forgot password link below</h3>
    <?php }?>
    <?php if (isset($_SESSION["deletedaccount"])){ 
                unset($_SESSION["deletedaccount"]);
            ?>
    <h2 style="color:salmon">Account has been deleted</h2>
    <?php }?>
    <form is="iron-form" id="form" method="post">
      <paper-input class="my-class"  id="firstname"  name="firstname" label="First Name" required></paper-input>
      <paper-input class="my-class"   id ="lastname" name="lastname" label="Last Name" required></paper-input>
      <paper-input class="my-class"  id="email" type="email" name="username" label="Email Address" required></paper-input>
      <paper-input class="my-class" id="password1"  type="password" name="password" label="Password" required></paper-input>
      <paper-input class="my-class" id="password2"  type="password"  label="Re-enter Password" required></paper-input>
      <paper-button id="my-button" raised onclick="submitForm();">Register</paper-button>
      <br>
      <button type="submit" id="SubmitButton" name="submit" style="visibility:hidden;"></button>
      <paper-toast id="toast" text="Registering..."></paper-toast>
      <paper-toast  visible="false" id="toast2" text="Login Failed, Please Try Again..."></paper-toast>
    </form>
    <script>function submitForm(){
        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (document.getElementById('firstname').value==''){
        document.querySelector('#toast2').text= "First Name Cannot be blank! Please Re-enter";
        document.querySelector('#toast2').show();
    }
    else if (document.getElementById('lastname').value==''){
        document.querySelector('#toast2').text= "Last Name Cannot be blank! Please Re-enter";
        document.querySelector('#toast2').show();
    }
    else if (document.getElementById('email').value==''){
        document.querySelector('#toast2').text= "Email Address Cannot be blank! Please Re-enter";
        document.querySelector('#toast2').show();
    }
    else if (!document.getElementById('email').value.match(mailformat)){
        document.querySelector('#toast2').text= "Invalid Email Address! Please Re-enter";
        document.querySelector('#toast2').show();
    }
    else if (document.getElementById('password1').value==''){
        document.querySelector('#toast2').text= "Password Cannot be blank! Please Re-enter";
        document.querySelector('#toast2').show();
    }

    else{
    if (document.getElementById('password1').value == document.getElementById('password2').value){;
        document.querySelector('#toast').text= "Registering...";
        document.querySelector('#toast').show();
        document.getElementById('SubmitButton').click();
        console.log("Submitted!")
    }
    else{
        
        document.querySelector('#toast2').text= "Passwords do not match! Please Re-enter";
        document.querySelector('#toast2').show();
        document.getElementById('password1').value='';
        document.getElementById('password2').value='';
        document.getElementById('password1').focus();
    }
    }
    }
       </script>
  </center>
  <br />
  
  </paper-material>
  <br>
   
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
<?php } ?>
