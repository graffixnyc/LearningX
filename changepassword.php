
<?php include_once("analyticstracking.php") ?>
<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL|E_STRICT);
include 'internal_api.php';

$useremail='';
$resetflag=0;
$_SESSION["intended"]='changepassword';
if (!empty($_GET["resettoken"])){
        
        $user=array(); 
        $user=getUsername($_GET["resettoken"]);
        if (!empty($user)){
        $useremail=$user[0]["username"];
        }
        else{
            $_SESSION["tokennotgood"]=1;
            header( 'Location: login.php');
            $useremail='';
        }
        $resetflag=1;
        
}
else{
        if ($_SESSION["loggedin"]!=1){
            //header( 'Location: login.php');
            echo 'NOT LOGGED IN';
        }
    
}
if (!empty($_POST)){
    if(isset($_POST['username'])) {
        $user=array(); 
        $user=checkUsername($_POST["username"]);
        if ($user[0]["userFound"]==1){
            $changepass=array();
            if ($resetflag==1){
                $curpass=$_GET["resettoken"];
            }
            else{
                $curpass=md5($_POST["currentpw"]);
                $useremail= $_SESSION["uname"];
            }   
        
            $changepass=changePassword($curpass,md5($_POST["password"]),$useremail,$resetflag);
            if ($changepass[0]["updated"]=='success'){
                $_SESSION["pwupdate"]=1;
                
                
            }
            else{
                    $_SESSION["pwupdate"]=0;
            }
        }
                
    }
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
                       <h2>Change Password</h2>
                        <paper-material elevation="3" class="card">
        
        <center>
                    <?php
                    if (isset($_SESSION["pwupdate"])){
                        if ($_SESSION["pwupdate"]==0){
                            
                            echo'<h4 style="color:red">Something went wrong. Wrong current password perhaps? </h4>';
                            
                        }
                        else{
                            echo'<h4 style="color:red">Password Changed.  Logging out in 2 seconds</h4>';
                            echo '<meta http-equiv="refresh" content="2;URL=http://learningx.abstractlogic.nyc/logout.php">';
                        }
                        
                        unset($_SESSION["pwupdate"]);
                    }
                        ?>
        
        <form is="iron-form" id="form" method="post">
        <?php if ($useremail !=''){ ?>
            <paper-input readonly class="my-class"  id="email" name="username" type="email" value="<?php echo $useremail;?>"  required></paper-input>
        
        <?php }
              else{?>
                  <paper-input readonly class="my-class" id="email" type="email" name="username"  value="<?php echo $_SESSION["uname"];?>"required></paper-input>
                    <paper-input class="my-class"  type="password" id="currentpw" name="currentpw" label="Current Password" required></paper-input>
        <?php  } ?>
        <paper-input class="my-class" id="password1"  type="password" name="password" label="Password" required></paper-input>
        <paper-input class="my-class" id="password2"  type="password"  label="Re-enter Password" required></paper-input>
        
     
      <button type="submit" id="SubmitButton" name="submit" style="visibility:hidden;"></button>
        <paper-button class="my-button" raised onclick="submitForm();">Change Password</paper-button>
    <paper-toast id="toast" text="Registering..."></paper-toast>
    <paper-toast  visible="false" id="toast2" text="Login Failed, Please Try Again..."></paper-toast>
                


    </form>
        
    <script>function submitForm(){
        <?php if ($resetflag==0){
            echo 'if (document.getElementById("currentpw").value==""){
        document.querySelector("#toast2").text= "Current Password Cannot be blank! Please Re-enter";
            document.querySelector("#toast2").show();}';
            ?>
        
        
        <?php 
        
        }
        ?>
     
    if (document.getElementById('password1').value==''){
        document.querySelector('#toast2').text= "New Password 1 Cannot be blank! Please Re-enter";
        document.querySelector('#toast2').show();
    }
    else if (document.getElementById('password2').value==''){
        document.querySelector('#toast2').text= "Password 2 Cannot be blank! Please Re-enter";
        document.querySelector('#toast2').show();
    }
    else{
    if (document.getElementById('password1').value == document.getElementById('password2').value){;
        document.querySelector('#toast').text= "Changing Password...";
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

    
    
    
  </body>
</html>

