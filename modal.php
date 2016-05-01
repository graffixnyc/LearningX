<?php 
include "internal_api.php";
if($_POST["data"]) {
echo '
    <div class="modal fade" id="myModal'.$_POST["data"].'">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header" style="background:#28547a;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="background:#28547a">
                '.$_POST["fname"].'\'s Progress
                </h4>
              </div>
              <div class="modal-body">';

                echo '<div class="adjust"><div class="table-responsive"><table><tr><th align="center">Topic Name</th><th align="center">Total Answered</th><th align="center">Total Correct</th><th align="center">% Correct</th></tr>';       
                $topics=array();
                $topics=getTopics();
                foreach($topics as $t) {
                    $topicID=$t["topicID"];
                    $topicName=$t["topic"];
                    $uprogress=array();
                    $cellcolor="#ffffff";
                    $uprogress=getUserProgress($topicID, $_POST["data"]);
                    if (empty($uprogress)) {
                        echo '<tr><td><a style="color:#28547a;" href="topic?id=' . $topicID . '">'.$topicName.'</td>';
                        $temp_count=array();
                        $temp_count=getQuestionCount($topicID);
                            foreach($temp_count as $question_count){
                                echo '<td align="center">0/'.$question_count["count"].'</td>';
                            }
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
                echo '</table></div></div><br>';


              echo '</div><!--.modal-body-->
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->';
}
else {
    echo "Open Modal Failed!!";
}

?>

