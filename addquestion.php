<?php 
    include_once("analyticstracking.php");
    include 'internal_api.php';

    session_start();
    if (!empty($_POST)){
    
      
     if ($_POST["topicid"]!='' && $_POST["question"]!='' ){
       $question=Array();
      $question=addQuestion($_POST["topicid"], $_POST["question"], $_POST["ac1"],$_POST["ac2"],$_POST["ac3"],$_POST["ac4"],$_POST["ac5"],$_POST["ac6"],$_POST["correctanswer"]);
    }
    
    

}
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]!=1 ){
   $_SESSION["intended"]="addquestion";
        header( 'Location: login') ;
}
else if (!isset($_SESSION["instructor"]) && $_SESSION["instructor"]==0){
  echo'YOU DO NOT HAVE ACCESS';
}
else{

 
?>
<!DOCTYPE html>
<html >
  <head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<title>LearningX | Your perfect Java teacher</title>
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
		<script src="/bower_components/webcomponentsjs/webcomponents-lite.js"></script>
        <link rel="import" href="bower_components/paper-dialog/paper-dialog.html">
        <link rel="import" href="bower_components/paper-dialog-scrollable/paper-dialog-scrollable.html">
        <link rel="import" href="bower_components/paper-input/paper-textarea.html">
        <link rel="import" href="bower_components/paper-checkbox/paper-checkbox.html">
        <link rel="import" href="bower_components/iron-form/iron-form.html">
        <link rel="import" href="bower_components/paper-toast/paper-toast.html">
        <link rel="import" href="bower_components/iron-ajax/iron-ajax.html">
        <link rel="import" href="bower_components/paper-dropdown-menu/paper-dropdown-menu.html">
        <link rel="import" href="bower_components/paper-item/paper-item.html">
  <link rel="import" href="bower_components/paper-listbox/paper-listbox.html">    
        <link rel="import" href="bower_components/paper-input/paper-input.html">
        <link rel="import" href="bower_components/paper-button/paper-button.html">
        <link rel="stylesheet" href="css/normalize.css">
       <link rel="import" href="bower_components/paper-radio-button/paper-radio-button.html">
    <link rel="import" href="bower_components/paper-radio-group.html">

  <!-- Dropdown.js -->
  
    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
    <link rel="stylesheet" href="css/style.css">
    <link rel="import" href="bower_components/paper-material/paper-material.html">
    <link rel="import" href="bower_components/paper-styles/paper-styles.html">
    <link rel="import" href="css/my_custom_styles.html">

    
    
    
  </head>

  <body>
        <?php include 'menu.php';?>
        
            <div class="container" >
             
                <div class="row" >
                    <div class="col-lg-8 col-lg-offset-2" >
                    <?php include 'header.html';?>
                        <?php if (isset($_SESSION["instructor"]) && $_SESSION["instructor"]==1){   ?>
                        
                        <center>
                           <h3>Add Question</h3></center>
                          <paper-button id="my-button2" class="my-button2"  onclick="showTaskDialog()">Instructions </paper-button>
                          <center>
                           
                          
                      <paper-material elevation="3" class="card">

 
  
  <center>
    <?php if (isset($resource[0]["created"]) && $resource[0]["created"]=='Success'){?>
         <h4 style="color:red">Resource(s) Created</h4>
         <?php }?>
            <form is="iron-form" id="form" method="post">
    
    <select class="myselect" id="topicSelect" onchange="getTopic()">
      <option value="0">Select Topic</option>
       <?php $topics=array(); 
                //Set the Array to call the function (this function is in internal_api.php)
                $topics=getTopics();
                //Loop through the results and display them.. you can write out HTML with them as you see I'm writing out the topic and then the BR HTML tag.  If you need help concatenating the tags let me know
                foreach($topics as $item) {
                  echo '<option value="' . $item["topicID"]  . '">'. $item["topic"] . '</option>';
                }
                ?>
</select>
  <paper-input class="my-class"  id="topicid"  name="topicid"  style="display:none;" ></paper-input>
<br><br>
<div id="questionDiv" style="display: none;">
<paper-input class="my-class" id="question" name="question" label="Enter a Question" ></paper-input>
    <center>
    <table  width="auto">
    <tr>
    <td colspan="2"> Correct Answer</td>
    <td></td>
    </tr>
    <tr>
    <td align="right" width="10%"> <input type="radio" name="correctanswer" id="acr1" value="ac1">&nbsp&nbsp</td>
    <td>
      <paper-input class="my-class2"  id="ac1" name="ac1" label="Enter an Answer Choice" ></paper-input>
      </td>
      </tr>
      <tr>
    <td align="right" width="10%"> <input type="radio" name="correctanswer" id="acr2" value="ac2">&nbsp&nbsp</td>
    <td>
      <paper-input class="my-class2"  id="ac2" name="ac2" label="Enter an Answer Choice" ></paper-input>
      </td>
      </tr>
      <tr>
    <td align="right" width="10%"> <input type="radio" name="correctanswer" id="acr3" value="ac3">&nbsp&nbsp</td>
    <td>
      <paper-input class="my-class2"  id="ac3" name="ac3" label="Enter an Answer Choice" ></paper-input>
      </td>
      </tr>
      <tr>
    <td align="right" width="10%"> <input type="radio" name="correctanswer" id="acr4" value="ac4">&nbsp&nbsp</td>
    <td>
      <paper-input class="my-class2"  id="ac4" name="ac4" label="Enter an Answer Choice" ></paper-input>
      </td>
      </tr>
      <tr>
    <td align="right" width="10%"> <input type="radio" name="correctanswer" id="acr5" value="ac5">&nbsp&nbsp</td>
    <td>
      <paper-input class="my-class2"  id="ac5" name="ac5" label="Enter an Answer Choice" ></paper-input>
      </td>
      </tr>
      <tr>
    <td align="right" width="10%"> <input type="radio" name="correctanswer" id="acr6" value="ac6">&nbsp&nbsp</td>
    <td>
      <paper-input class="my-class2"  id="ac6" name="ac6" label="Enter an Answer Choice" ></paper-input>
      </td>
      </tr>
     </table>
           


<paper-input class="my-class2" id="thecorrectanswer"   style="display: none;"></paper-input>
</paper-input>
</center>
</div>
 <paper-button id="my-button" name="my-button" class="my-button" raised onclick="submitForm();" style="display:none;">Add Question</paper-button>
      <br>
      <button type="submit" id="SubmitButton" name="submit" style="visibility:hidden;"></button>
    </form>
    <script>
function getTopic() {
  
  document.getElementById("topicid").value=jQuery("#topicSelect option:selected").val();
  if (jQuery("#topicSelect option:selected").val()==0){
    document.getElementById("questionDiv").style.display="none";
    document.getElementById("my-button").style.display="none";
    
  }
  else{
    document.getElementById("questionDiv").style.display="block";
    document.getElementById("my-button").style.display="block";
  }
}

    function submitForm(){
      var numofanswers=0;
      if (document.getElementById("question").value==''){
        alert ("You did not enter a question");
        return;
      }
     
      if (document.getElementById("acr1").checked){
          if(document.getElementById("ac1").value!=''){
            document.getElementById("thecorrectanswer").value=document.getElementById("acr1").value;
          }
          else{
            alert ("You Selected a correct answer without giving an answer choice");
            document.getElementById("thecorrectanswer").value='';
            return;
          }
      }
else if (document.getElementById("acr2").checked){
if(document.getElementById("ac2").value!=''){
            document.getElementById("thecorrectanswer").value=document.getElementById("acr2").value;
          }
          else{
            alert ("You Selected a correct answer without giving an answer choice");
            document.getElementById("thecorrectanswer").value=null;
            return;
          }
}
else if (document.getElementById("acr3").checked){
if(document.getElementById("ac3").value!=''){
            document.getElementById("thecorrectanswer").value=document.getElementById("acr3").value;
          }
          else{
            document.getElementById("thecorrectanswer").value=null;
            alert ("You Selected a correct answer without giving an answer choice");
            return;
            
          }
}
else if (document.getElementById("acr4").checked){
if(document.getElementById("ac4").value!=''){
            document.getElementById("thecorrectanswer").value=document.getElementById("acr4").value;
          }
          else{
            alert ("You Selected a correct answer without giving an answer choice");
            document.getElementById("thecorrectanswer").value=null;
            return;
          }
}
else if (document.getElementById("acr5").checked){
if(document.getElementById("ac5").value!=''){
            document.getElementById("thecorrectanswer").value=document.getElementById("acr5").value;
          }
          else{
            alert ("You Selected a correct answer without giving an answer choice");
            document.getElementById("thecorrectanswer").value=null;
            return;
          }
}
else if (document.getElementById("acr6").checked){
if(document.getElementById("ac6").value!=''){
            document.getElementById("thecorrectanswer").value=document.getElementById("acr6").value;
          }
          else{
            alert ("You Selected a correct answer without giving an answer choice");
            document.getElementById("thecorrectanswer").value=null;
            return;
          }
}
if (document.getElementById("ac1").value!=''){
  numofanswers++;
}
 if (document.getElementById("ac2").value!=''){
  numofanswers++;
}
 if (document.getElementById("ac3").value!=''){
  numofanswers++;
}
 if (document.getElementById("ac4").value!=''){
  numofanswers++;
}
 if (document.getElementById("ac5").value!=''){
  numofanswers++;
}
 if (document.getElementById("ac6").value!=''){
  numofanswers++;
}
if(numofanswers>=2){
     if (document.getElementById("question").value==''){
        alert ("You did not enter a question");
        return;
      }
     
}
else{
  alert ("You must supply at least 2 answers");
  return;
}
if (document.getElementById("acr1").checked || document.getElementById("acr2").checked || document.getElementById("acr3").checked || document.getElementById("acr4").checked || document.getElementById("acr5").checked || document.getElementById("acr6").checked){
  document.getElementById('SubmitButton').click();
}
else{
  alert ("You must select a correct answer");
  return;
}

}

  
    function showTaskDialog(){
			document.getElementById('instructions').toggle();
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
 <paper-toast id="toast" text="Registering..."></paper-toast>
      <paper-toast  visible="false" id="toast2" text="Login Failed, Please Try Again..."></paper-toast>
     
     
     <paper-dialog id="instructions" name="instructions" modal on-iron-overlay-closed="dismissDialog">
      <h2 style="color:  #28547a;">Instructions</h2>
       <paper-dialog-scrollable>
     <p style="color:black;font-size: 16px;font-weight: bold;">Select a topic that you want to add resources to, then select the resource type from the dropdown and fill out the information.  You can add 1 to 3 resources per form submission; 1 video, 1 text and 1 link. You can submit more than 3 resources but only 3 per form submission. Once your fill out the first resrouce you can select a different resource type from the dropdown and populate that as well.  There can be only one "Text" resource per topic.  Any resource you set to Text will replace the current text under the featured video on the topic page.  You can use HTML tags in the text resource type. There has to be one featured video per topic.  If you add a new video and select it to be featured it will replace the currently featured video (if there is one) and then move that video url to the additonal resoucres section</p>
     </paper-dialog-scrollable>
     <div class="buttons">
		<paper-button style="color:#28547a;" dialog-dismiss>OK</paper-button>
										
									</div>
    </paper-dialog>

    </div>
    <!-- /#wrapper -->
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js'></script>

        <script src="js/index.js"></script>

<?php }?>
    
    
  </body>
</html>
