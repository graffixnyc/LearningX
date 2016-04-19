<?php include_once("analyticstracking.php") ?>
<?php 
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL|E_STRICT);
    
$notfound=false;    
include 'internal_api.php';
if(isset($_POST['username'])) {
        
        require 'PHPMailerAutoload.php';
        require_once('class.phpmailer.php');
        include("class.smtp.php");
        $user=array(); 
        $user=checkUsername($_POST["username"]);
        if ($user[0]["userFound"]==1){
            $userpw=array(); 
            $userpw=forgotPassword($_POST["username"]);
            if ($userpw[0]["pwset"]==1){
                $_SESSION["pwset"]=1;
                $mail = new PHPMailer;
                $mail->isSMTP();
                $mail->SMTPDebug = 0;
                $mail->Debugoutput = 'html';
                $mail->Host = "mail.learningx.abstractlogic.nyc";
                $mail->Port = 25;
                $mail->SMTPAuth = true;
                $mail->Username = "do_not_reply@learningx.abstractlogic.nyc";
                $mail->Password = "beth123";
                $mail->setFrom('do_not_reply@learningx.abstractlogic.nyc', 'DO_NOT_REPLY');
                $mail->addAddress($_POST["username"]);
                $mail->Subject = 'Learning X Password Reset';
                $mail->msgHTML('You have requested to reset your Learning X password.  Please use the link below to reset your password<br>
                <a href="http://learningx.abstractlogic.nyc/changepassword.php?resettoken='.$userpw[0]["token"] . '">Click To Reset Password</a><br> Or Paste the following into 
                your browser: <br> http://learningx.abstractlogic.nyc/changepassword.php?resettoken='.$userpw[0]["token"] );
                $mail->IsHTML(true);
                if (!$mail->send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                } else {
                }
            }
        }
        else{
            $notfound=true;
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
                     <div class="col-lg-8 col-lg-offset-2">
                     <?php include 'header.html';?>
                        <center>
                       <h2>Forgot Password</h2>
                            <paper-material elevation="3" class="card">
                <paper-toast   id="toast2" text="Login Failed, Please Try Again..."></paper-toast>
                <center>
                    
                    <?php if ($notfound==true){
                        echo'<h2 style="color:red">User not in the system. Please re-check and try again.</h2>';
                        $notfound=false;
                    }

                    if (isset($_SESSION["pwset"])){
                        echo'<h5 style="color:red">Please check your inbox for the password reset link.</h5>';
                        echo'<h5 style="color:red">If your browser does not redirect you in 5 seconds, or you do
                        not wish to wait, <a href="http://learningx.abstractlogic.nyc">click here</a>.</h5><meta http-equiv="refresh" 
                    content="5;URL=http://learningx.abstractlogic.nyc">';
                        unset($_SESSION["pwset"]);
                    }?>
                </center>
                <center>
                    <form is="iron-form" id="form" method="post"  >
                      <paper-input class="my-class" id="email" type="email" name="username" label="Email Address" required></paper-input>
                      <button type="submit" id="SubmitButton" name="submit" style="visibility:hidden;"></button>
                      <paper-button class="my-button" raised onclick="submitForm();">Reset Password</paper-button>
                      
                      <paper-toast id="toast" ></paper-toast>
                    </form>
                </center>
                <br />
                
            </paper-material>
            
            
   
                        </center>
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
 <script type="text/javascript">
     function submitForm(){
        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if (document.getElementById('email').value==''){
            document.querySelector('#toast2').text= "Email Address Cannot be blank! Please Re-enter";
            document.querySelector('#toast2').show();
        }
        else if (!document.getElementById('email').value.match(mailformat)){
            document.querySelector('#toast2').text= "Invalid Email Address! Please Re-enter";
            document.querySelector('#toast2').show();
        }
        
        else{
        document.querySelector('#toast').show();
        document.getElementById('SubmitButton').click();
        console.log("Submitted!")
        }
    }

    </script>   
    
    
  </body>
</html>

