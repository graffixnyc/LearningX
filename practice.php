<?php 
include_once("analyticstracking.php");
include 'internal_api.php';
session_start();

//Find the topic name of current topic
if (isset($_POST["topicid"])) {
	foreach(getTopics($_POST["topicid"]) as $item) {
	    if ($_POST["topicid"] == $item["topicID"]) {
	        $theTopic = $item["topic"];
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
    <link rel="stylesheet" href="css/normalize.css">
    <script src="/bower_components/webcomponentsjs/webcomponents-lite.js"></script>
    <link rel="import" href="bower_components/paper-material/paper-material.html">
    <link rel="import" href="bower_components/paper-styles/paper-styles.html">
    <link rel="import" href="css/my_custom_styles.html">

    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>

    <link rel="stylesheet" href="css/style.css">
  </head>

  <body>
  <?php include 'menu.php';?>
  
        <div class="container">

            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                <?php include 'header.html';?>
                	<h2 class="page-header"><?php if(isset($theTopic)) echo $theTopic ?></h2>
                	<?php
	                	//Declare the Array
						$practice=array(); 
						//Set the Array to call the function (this function is in internal_api.php)
						$practice=getPractice($_POST["topicid"]);

						//Loop through the results and display them
						// echo "<pre>";
						// print_r($practice);
						// echo "</pre>";
						// foreach($practice as $item) {
						//     echo $item['question'] . '<br>';
						// }

						// $answer = getAnswers(1);

						// //Loop through the results and display them
						// echo "<pre>";
						// print_r($answer);
						// echo "</pre>";
                	?>
                	
                    <div id="questions-container">
                	<?php
                        $index = 0;                        
                		foreach ($practice as $item) {
                			echo "<div class='question'>";
                            echo '<p>Qustion ' . ++$index . ' of ' . count($practice) . '</p>';
                			echo "<p>" . $item['question'] . "</p>";
                			echo "<div class='text-left center-block' style='width:50%'>";
                			$answers = getAnswers($item['questionID']);
                			foreach ($answers as $ans) {
                				echo "<div class='radio'><label><input type='radio'>" . $ans['answer'] . "</label></div>";
                			}
                			
                			echo "</div>";
                			echo '<input class="btn btn-primary submit" type="submit" value="Select Answer">';
                			echo "&nbsp;&nbsp;&nbsp;";
                			echo '<input class="btn btn-default skip" type="button" value="Skip Qustion">';
                			echo "</div>";
                		}
                	?>
                    </div>

                    <div id="congraduation" style="display: none">
                        <h4>Awesome! You've already answered all the quesitons~</h4>
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
    <script>
        $(document).ready(function() {
            $(".question").first().addClass("active");

            // When click "skip" button, let next question show up
            $(".question").find(".skip").click(function() {
                console.log("skip");                
                var currentActiveQuestion = $(".question.active");
                var nextQuestion = currentActiveQuestion.next();
                currentActiveQuestion.fadeOut("slow", function () {
                    currentActiveQuestion.removeClass("active");                                        
                    if (nextQuestion.length) {
                        nextQuestion.addClass("active");
                    } else {
                        // This is already the last question
                        $("#congraduation").show();
                    }
                });
                

            });

        });

    </script>
  </body>
</html>