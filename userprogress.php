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
        <?php include 'menu.php';?>
        
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2 center">
                        <?php include 'header.html';?>
                        <br>
                        <center>

    <div class="modal fade" id="myModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="background:#28547a">
                </h4>
              </div>
              <div class="modal-body">
                <input type="text" class="input-sm" id="txtfname" name="txtfname" value=""/>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

<?php
    echo '<link rel="stylesheet" href="css/components_style.css">';





        if (isset($_SESSION["loggedin"]) &&$_SESSION["loggedin"]==1 ){
        if (isset($_SESSION["instructor"])){
            if ($_SESSION["instructor"]==1){
                echo '<h4 class="page-header"> Users\' Progress</h4>' ;
                echo '<paper-material elevation="3" class="card">';
                echo '<div class="adjust"><div class="table-responsive"><table><tr><th>Student ID</th><th>Student Name</th><th>Completed Topics</th><th>Avg. Score</th></tr>';
                // student info
                $studentInfo=array();
                $studentInfo=getNonInstructorUsers();
                // topic info
                $topics=array();
                $topics=getTopics();
                $topic_count=count($topics);
                foreach($studentInfo as $student) {
                    // initial css
                    $cellcolor='transparent';
                    $textcolor='#000000';

                    $studentID=$student["id"];
                    $studentFName=$student["first_name"];
                    $studentUName=$student["last_name"];
                    $completed_topics=0;
                    $total_score=0;
                    $avg_score=0;
        // modal, header part
         
        echo '<div class="modal fade" id="myModal'.$studentID.'">';
        echo '  <div class="modal-dialog">';
        echo '    <div class="modal-content">';
        echo '      <div class="modal-header" style="background:#28547a;" >';
        echo '        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        echo '        <h4 class="modal-title" style="background:#28547a">'.$studentFName.'\'s Progress</h4>';
        echo '      </div>';
        // modal, body part
        echo '      <div class="modal-body">';                    
                    foreach($topics as $t) {
                        $topicID=$t["topicID"];
                        $topicName=$t["topic"];
                        $uprogress=getUserProgress($topicID, $studentID);
                        if (!empty($uprogress)) {
                            $completed_topics += 1;
                            foreach($uprogress as $p) {
                                $score=str_replace('%', '', $p["percentageCorrect"])/100;
                                $total_score += $score;
                            }
                        }
                    }
                    if ($completed_topics != 0) {
                        $avg_score=$total_score/$completed_topics;
                        if ($avg_score < 0.7) {
                            $cellcolor='salmon';
                        }
                        elseif ($avg_score >=0.7 and $avg_score < 0.9) {
                            $cellcolor='#ffe37a';
                        }
                        else {
                            $cellcolor='#7affa0';
                        }
                        $textcolor='white';
                    }
                    else {
                        $avg_score=0;
                    }
        // modal, foot
        echo '      <div class="modal-footer">';
        echo '        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
        echo '      </div>';
        echo '    </div><!-- /.modal-content -->';
        echo '  </div><!-- /.modal-dialog -->';
        echo '</div><!-- /.modal -->';


                    $display_score=$avg_score*100;
                    $display_score="$display_score%";
                    echo '<tr class="example" data-toggle="modal" data-id="'.$studentID.'"><td>'.$studentID.'</td>';
                    echo '<td>'.$studentFName.' '.$studentUName.'</td>';
                    echo '<td>'.$completed_topics.'/'.$topic_count.'</td>';
                    echo '<td style="color:'.$textcolor.'; background:'.$cellcolor.'">'.$display_score.'</td></tr>';
                }

                echo '</table></div></paper-material><br>';
            }  
            else if ($_SESSION["instructor"]==0){
                echo '<h4 class="page-header">'. $_SESSION["fname"] . '\'s Progress</h4>';
                echo '<paper-material elevation="3" class="card">';
                echo '<div class="adjust"><div class="table-responsive"><table><tr><th align="center">Topic Name</th><th align="center">Total Answered</th><th align="center">Total Correct</th><th align="center">% Correct</th></tr>';       
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

    echo'
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>    <script>
$(function(){
    $(".example").click(function(){
        var sid = $(this).data("id");
        $.ajax({
            type: "POST",
            url: "modal.php", 
            data: {data: "test"},,
            success:function(result)//we got the response
            {
                alert("Successfully called "+result);
            },
                error:function(exception){alert("Exeption:"+exception);}
            });

        alert(sid);
    });
});
</script>'
?> 
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

