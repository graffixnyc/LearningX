<?php 
    include_once("analyticstracking.php");
    include 'internal_api.php';

    session_start();
    if (!empty($_POST)){
      print_r($_POST);
    //$resource=array(); 
    //$topic=addTopic($_POST["topic"]);
    
}

 
?>
<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>LearningX | Your perfect Java teacher</title>
      <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    
    <script src="/bower_components/webcomponentsjs/webcomponents-lite.js"></script>
        
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
       

  <!-- Dropdown.js -->
  
    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
    <link rel="stylesheet" href="css/style.css">
    <link rel="import" href="bower_components/paper-material/paper-material.html">
    <link rel="import" href="bower_components/paper-styles/paper-styles.html">
    <link rel="import" href="css/my_custom_styles.html">

    
    
    
  </head>

  <body>
        <?php include 'menu.php';?>
        
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <?php if (isset($_SESSION["instructor"]) && $_SESSION["instructor"]==1){   ?>
                        <center>
                           <h3>Add Resources</h2>
                      <paper-material elevation="3" class="card">
  
  <center>
    <?php if (isset($topic[0]["created"]) && $topic[0]["created"]=='Success'){?>
         <h4 style="color:red">Resource Created</h4>
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
  <paper-input class="my-class"  id="topicid"  name="topicid" style="display:none;"></paper-input>
<br><br>
<select class="myselect" id="resourceSelect" onchange="getResource()">
      <option value="0"><b>Select Resource Type</b></option>
      <option value="Video"><b>Video</b></option>
      <option value="Text"><b>Text</b></option>
      <option value="Link"><b>Link</b></option>
      
</select>
<br>
<br>

<div id="videoDiv" style="display:none;">
    <paper-input class="my-class"  id="videourl"  name="videourl" label="Enter a Video URL" ></paper-input>
    <paper-input class="my-class"  id="videotext"  name="videotext" label="Enter a Title for this Video" ></paper-input>
    <br>
  <paper-checkbox class="my-check" name="featuredcheck" id="featuredcheck" onclick="toggleFeatured();" >Featured</paper-checkbox>
  <br>
  <paper-input class="my-class"  id="featured"  name="featured"  value="0" style="display:none;"></paper-input>
<br>
</div>


<div id="textDiv" style="display:none;">
    <paper-textarea id="text" name="text" label="autoresizing textarea input"></paper-textarea>
<br>
</div>


<div id="linkDiv" style="display:none;">
    <paper-input class="my-class"  id="linkurl"  name="linkurl" label="Enter a URL" ></paper-input>
    <paper-input class="my-class"  id="linktext"  name="linktext" label="Enter a Title for this Link" ></paper-input>
   
<br>
</div>
   
      
      
      <paper-button id="my-button" raised onclick="submitForm();">Add Topic</paper-button>
      <br>
      <button type="submit" id="SubmitButton" name="submit" style="visibility:hidden;"></button>

      <paper-toast id="toast" text="Registering..."></paper-toast>
      <paper-toast  visible="false" id="toast2" text="Login Failed, Please Try Again..."></paper-toast>
    </form>
    <br>
 
 

    <script>
function getTopic() {
  //alert(jQuery("#topicSelect option:selected").val());
  document.getElementById("topicid").value=jQuery("#topicSelect option:selected").val();
}
   
function getResource() {
  if (jQuery("#resourceSelect option:selected").val()=='Video'){
    document.getElementById('videoDiv').style.display="block";
    document.getElementById('textDiv').style.display="none";
    document.getElementById('linkDiv').style.display="none";

  }
  else if (jQuery("#resourceSelect option:selected").val()=='Text'){
    document.getElementById('textDiv').style.display="block";
    document.getElementById('videoDiv').style.display="none";
    document.getElementById('linkDiv').style.display="none";

  }
    
  else if (jQuery("#resourceSelect option:selected").val()=='Link'){
    document.getElementById('linkDiv').style.display="block";
    document.getElementById('videoDiv').style.display="none";
    document.getElementById('textDiv').style.display="none";
  }
  else{
    document.getElementById('linkDiv').style.display="none";
    document.getElementById('videoDiv').style.display="none";
    document.getElementById('textDiv').style.display="none";
  }

  
}
 function toggleFeatured(){
  
      if (document.getElementById('featured').value=="1"){
        document.getElementById('featured').value="0";
      }
      else {
        alert ("Setting this video to be featured will replace the video that is currently featured(if there is one) and that video will be moved to additional resources")
        document.getElementById('featured').value="1";
      }
      alert (document.getElementById('featured').value);
    }   

    function submitForm(){
     document.getElementById('SubmitButton').click();
    
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

    </div>
    <!-- /#wrapper -->
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js'></script>

        <script src="js/index.js"></script>


    
    
    
  </body>
</html>
