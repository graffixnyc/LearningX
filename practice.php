<?php 
include_once("analyticstracking.php");
include 'internal_api.php';
session_start();

//Find the topic name of current topic
if (!isset($_POST["topicid"]) && isset($_SESSION['topicid'])) {
	$_POST['topicid'] = $_SESSION['topicid'];
}     
foreach(getTopics($_POST["topicid"]) as $item) {
    if ($_POST["topicid"] == $item["topicID"]) {
        $theTopic = $item["topic"];
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
                    <div id="questions-container">
                	<?php
                        //Declare the Array
                        $practice=array(); 
                        //Set the Array to call the function (this function is in internal_api.php)
                        $practice=getPractice($_POST["topicid"]);

                        $index = 0;                        
                		foreach ($practice as $item) {
                            $index++;
                			echo "<div class='question' data-id=" . $index . ">";
                            echo '<p>Question ' . $index . ' of ' . count($practice) . '</p>';
                			echo "<p>" . $item['question'] . "</p>";
                			echo "<div class='text-left center-block' style='width:50%'>";
                			$answers = getAnswers($item['questionID']);
                			foreach ($answers as $ans) {
                				echo "<div class='checkbox'><label><input type='radio' name='AnswerChoices' value=" . $ans['correct'] . ">  " . $ans['answer'] . "</label></div>";
                			}
                			
                			echo "</div>";
                			echo '<input class="btn btn-primary submit" type="button" value="Select Answer">';
                			echo "&nbsp;&nbsp;&nbsp;";
                			echo '<input class="btn btn-default skip" type="button" value="Skip Question">';
                			echo "</div>";
                		}
                	?>
                    </div>

                    <div id="congraduation" style="display: none">
                        <h4>Awesome! You've already answered all the quesitons~</h4>
                    </div>
                </div>           
            </div> 
            <?php if (!isset($_SESSION['uid'])) { ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Heads up!</strong> If you login in <a href="loginBeforePractice?topicid=<?php echo $_POST["topicid"]; ?>" class="alert-link">here</a>, you can save your progress.
            </div>
            <?php } ?> 
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

            // When click "submit" button, use AJAX to submit
            $(".question").find(".submit").click(function() {
                console.log("submit");
                var currentActiveQuestion = $(".question.active");
                // Check if every option is selected or not correlty
                // If correct, let the option be green
                // If wrong, let the option be red
                var correct = 1;
                currentActiveQuestion.find("input:radio").each(function(index) {
                    console.log(index);
                    // show all the right options
                    if (this.checked && this.value == 1) {
                        $(this).parent().addClass("text-success");
                    }
                    // if the option is selected but wrong, make it red
                    if (this.checked && this.value == 0) {
                        $(this).parent().addClass("text-danger");
                        correct = 0;
                    }
                    // if the option is right but not selcted, make it yellow
                    if (!this.checked && this.value == 1) {                  
                        $(this).parent().addClass("text-info");      
                        correct = 0;
                    } 
                });



                // If the user is logged in, submit his answer to DB
                if (<?php if(isset($_SESSION['uid'])) {echo "true";} else {echo "false";} ?>) {
                    $.ajax({
                        url: "markQuestionAnswered",
                        method: "POST",
                        data: {
                            quesitonid: currentActiveQuestion.data("id"),
                            userid: <?php if(isset($_SESSION['uid'])) {echo $_SESSION["uid"];} else {echo -1;} ?>,
                            answeredAlready: 1,
                            answeredCorrect: correct
                        }
                    }).always(function(data) {
                        console.log(data);
                        setTimeout(function(){
                            // Move to next question
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
                        }, 1000);                    
                    });
                } else {
                    setTimeout(function(){
                        // Move to next question
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
                    }, 1000); 
                }              

            });

        });

    </script>
  </body>
</html>