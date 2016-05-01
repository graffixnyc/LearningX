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
                	<h2 class="page-header">Test your knowledge</h2>                	
                    <div id="questions-container">                	
                    </div>

                    <div id="congraduation" style="display: none">
                        <h4>Awesome! You've already answered all the questions~</h4>
                    </div>
                    <div id="sorry" style="display: none">
                        <h4>Sorry! You seem to need more learning on current topic</h4>
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

            // var currentTopicId = 1;

            loadTopic(1);


            function loadTopic (topicid) {
                // Using Ajax to get data of the topic
                $.ajax({
                        url: "getQuestions",
                        method: "POST",
                        dataType: "json",
                        data: {
                            topicid: topicid,
                        },
                        success: function(questions) {
                            if (!questions || questions.length === 0) {
                                console.log("currentTopic: " + topicid);
                                console.log("there is no topic");
                                return loadTopic(topicid+1);
                            }
                            // questions = JSON.parse(questions);
                            // console.log(JSON.parse(questions));
                            console.log("=================")
                            console.log(questions);
                            console.log(questions.length);
                            console.log(typeof(questions));
                            // $("#questions-container").html(JSON.stringify(questions));
                            $("#questions-container").html("");
                            for (var i = 0; i < questions.length; i++) {
                                $("#questions-container").append("<div class='question' data-id=" + (i+1) + "></div>");
                                var currentQuestionDiv = $("#questions-container div").last();
                                console.log(currentQuestionDiv);
                                currentQuestionDiv.append("<p>Qustion " + (i+1) + " of " + questions.length + " (currentTopic: " + topicid + ")</p>");
                                currentQuestionDiv.append("<p>" + questions[i].question + "</p>");
                                currentQuestionDiv.append("<div class='text-left center-block' style='width:50%'><div>");
                                var optionsDiv = currentQuestionDiv.children("div");
                                var options = questions[i].answers;
                                for (var j = 0; j < options.length; j++) {
                                    optionsDiv.append("<div class='checkbox'><label><input type='radio' name='AnswerChoices' value=" + options[j].correct + ">  " + options[j].answer + "</label></div>");
                                };

                                currentQuestionDiv.append('<input class="btn btn-primary submit" type="button" value="Select Answer">&nbsp;&nbsp;&nbsp;<input class="btn btn-default skip" type="button" value="Skip Qustion"></div>');
                            }

                            // Show the first question
                            $(".question").first().addClass("active");

                            // Estimate how users deal with current topic

                            var numberOfQuestions = $(".question").size();
                            var numberOfCorrect = 0;
                            
                            

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
                                        // Determine whether the user is eligible to go through current topic
                                        whenFinishTopic ( topicid, numberOfCorrect, numberOfQuestions);
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
                                        // $(this).parent().addClass("text-success");
                                        $(this).parent().append("<div class='alert alert-success'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> Congrats! You got it right</div>");
                                    }
                                    // if the option is selected but wrong, make it red
                                    if (this.checked && this.value == 0) {
                                        // $(this).parent().addClass("text-danger");
                                        $(this).parent().append("<div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> Sorry that was incorrect</div>");
                                        correct = 0;
                                    }
                                    // if the option is right but not selcted, make it yellow
                                    if (!this.checked && this.value == 1) {                  
                                        // $(this).parent().addClass("text-info");   
                                        $(this).parent().append("<div class='alert alert-info'><span class='glyphicon glyphicon-hand-up' aria-hidden='true'></span> I'm a right answer :)</div>");    
                                        correct = 0;
                                    } 
                                });

                                if (correct === 1) {
                                    numberOfCorrect++;
                                };
        
                                setTimeout(function(){
                                    // Move to next question
                                    var nextQuestion = currentActiveQuestion.next();
                                    currentActiveQuestion.fadeOut("slow", function () {
                                        currentActiveQuestion.removeClass("active");                                        
                                        if (nextQuestion.length) {
                                            nextQuestion.addClass("active");
                                        } else {
                                            whenFinishTopic ( topicid, numberOfCorrect, numberOfQuestions);
                                        }
                                    });
                                }, 2000);
                            });

                        },
                        error: function(error) {
                            console.log("Error when using ajax getting data of topic: " + error);
                        }

                });
            }

            function whenFinishTopic ( topicid, numberOfCorrect, numberOfQuestions) {
                if (numberOfCorrect / numberOfQuestions >= 0.1) {
                    // $("#congraduation").show();
                    // Perfect performance, move to next Topic
                    loadTopic(topicid + 1);
                    
                } else {
                    $("#sorry").show();
                }
            }

        });

    </script>
  </body>
</html>