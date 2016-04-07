<?php include_once("analyticstracking.php") ?>
<?php 
	session_start();
	include 'internal_api.php';
	
	if (!empty($_POST)){
		$user=array(); 
		$user=login($_POST["username"],md5($_POST["password"]));
		if ($user[0]["loggedin"]==1){
			$_SESSION["uid"]=$user[0]["uid"];
			$_SESSION["loggedin"]=$user[0]["loggedin"];
			$_SESSION["fname"]=$user[0]["firstname"];
			$_SESSION["uname"]=$user[0]["uName"];
			unset($_SESSION["loginfailed"]);
			if (isset($_SESSION["intended"])){
				echo $_SESSION["intended"];
				header( 'Location:' . $_SESSION["intended"]) ;
			}
			else{
				header( 'Location: mainmenu') ;
				//echo '<meta http-equiv="refresh" content="0; URL=mainmenu">';
			}
		}
		elseif ($user[0]["loggedin"]=='NOT IN SYSTEM') {
			header( 'Location: register') ;
		}
		else{
			$_SESSION["loginfailed"]='1';
			
			header( 'Location: login') ;
			//echo '<meta http-equiv="refresh" content="0; URL=myprojects">';
		}
	}
	else{
		
		?>
		<script src="/bower_components/webcomponentsjs/webcomponents-lite.js"></script>
		<link rel="import" href="bower_components/paper-submit/paper-submit.html">
		<link rel="import" href="bower_components/paper-input/paper-textarea.html">
		<link rel="import" href="bower_components/iron-form/iron-form.html">
		<link rel="import" href="bower_components/paper-toast/paper-toast.html">	
		<link rel="import" href="bower_components/paper-input/paper-input.html">
		<link rel="import" href="bower_components/paper-button/paper-button.html">
		
	<link rel="import" href="bower_components/paper-material/paper-material.html">
	<link rel="import" href="bower_components/paper-styles/paper-styles.html">
	<link rel="import" href="css/my_custom_styles.html">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-TileImage" content="imgs/mstile-144x144.png">
	<link rel="import" href="bower_components/font-roboto/roboto.html">
	<meta charset='utf-8'>
	<meta http-equiv="X-UA-Compatible">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->
	<link rel="stylesheet" href="css/styles.css">
	<script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="js/script.js"></script>
	<script src="https://apis.google.com/js/platform.js" async defer></script>

		<div class="adjust">
			<paper-material elevation="3" class="card">
				<paper-toast   id="toast2" text="Login Failed, Please Try Again..."></paper-toast>
				<center>
					<h2>Login to Learning X</h2>
					<?php
						if (isset($_SESSION["newreg"])){
							echo'<h2 style="color:salmon">You have been successfully registered.  Please login below. </h2>';
							unset($_SESSION["newreg"]);
						}
						if (isset($_SESSION["loginfailed"])){
							//echo "Sess" . $_SESSION["loginfailed"];
							unset($_SESSION["loginfailed"]);
							
					?>
					<script type="text/javascript">document.querySelector('#toast').dismiss();</script>
					<h2 style="color:salmon">Login Failed, Please try again </h2>
					<script type="text/javascript">document.querySelector('#toast2').show();</script>
					<?php }?>
					
					<?php if (isset($_SESSION["tokennotgood"])){
				echo'<h2 style="color:salmon">The Reset Token is invalid</h2>';
				unset($_SESSION["tokennotgood"]);
		}
			
		?>
				</center>
				<center>
					<form is="iron-form" id="form" method="post" >
					  <paper-input class="my-class"  id="email" type="email" name="username" label="Email Address" required></paper-input>
					  <paper-input class="my-class"  id="password" type="password" name="password" label="Password" required></paper-input>
					 <paper-button class="my-button" raised onclick="submitForm();">LOGIN</paper-button>
					  
					  <br> 
					  <br>
					  <a href="forgotpassword">Forgot Password</a><br>
					  <button type="submit" id="SubmitButton" name="submit" style="visibility:hidden;">
					  </button><paper-toast id="toast" text="Logging In..."></paper-toast>
					</form>
				</center>
				<br />
				<?php //include("footer.php");?>
			</paper-material>
			  <paper-button raisedButton>search!</paper-button>
			<br><br><br><br><br><br>
			
		 </div>
	 
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
		else if (document.getElementById('password').value==''){
			document.querySelector('#toast2').text= "Password Cannot be blank! Please Re-enter";
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

	<?php }?>
<?php //include("pi.php");?>