<?php 
    include_once("analyticstracking.php");
    include 'internal_api.php';

    session_start();
    if (!empty($_POST)){
      $resource=array(); 
      if (isset($_POST["text"]) && $_POST["text"]<>'') {
   
        $text=$_POST["text"];
        $resource= addResource($_POST["topicid"],"Text", $text, null, 0);
      }
      if ((isset($_POST["videourl"]) && $_POST["videourl"]<>'') && (isset($_POST["videotext"]) && $_POST["videotext"]<>'')) {
         
          if ($_POST["featured"]==1){
            
            $resource= addResource($_POST["topicid"],"Video", $_POST["videourl"], $_POST["videotext"], 1);
          }
          else{
             $resource= addResource($_POST["topicid"],"Video", $_POST["videourl"], $_POST["videotext"], 0);
          }
      }
      if ((isset($_POST["linkurl"]) && $_POST["linkurl"]<>'') && (isset($_POST["linktext"]) && $_POST["linktext"]<>'')) {
        
        $resource= addResource($_POST["topicid"],"Link", $_POST["linkurl"], $_POST["linktext"], 0);
      }
    
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
                           <h3>Add Resources</h3></center>
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
  <paper-input class="my-class"  id="resourcetype"  name="resourcetype"  style="display:none;" ></paper-input>
<br><br>
<div id="resourceDiv" style="display: none;">
<select class="myselect" id="resourceSelect" onchange="getResource()">
      <option value="0"><b>Select Resource Type</b></option>
      <option value="Video"><b>Video</b></option>
      <option value="Text"><b>Text</b></option>
      <option value="Link"><b>Link</b></option>
      
</select>
</div>
<br>
<br>

<div id="videoDiv" style="display:none;">
    <paper-input class="my-class" type="url" id="videourl" name="videourl" label="Enter a Video URL" ></paper-input>
    Include http:// i.e. http://www.site.com
    <paper-input class="my-class"  id="videotext"  name="videotext" label="Enter a Title for this Video" ></paper-input>
    <br>
  <paper-checkbox class="my-check" name="featuredcheck" id="featuredcheck" onclick="toggleFeatured();" >Featured</paper-checkbox>
  <br>
  <paper-input class="my-class"  id="featured"  name="featured"  value="0" style="display:none;"></paper-input>
<br>
</div>


<div id="textDiv" style="display:none;">
    <paper-textarea class="my-area-class" id="text" name="text" label="Resource"></paper-textarea>
    You can enter HTML Tags into this field like &ltB&gtBOLD TEXT HERE&lt/B&gt <br>
    To enter line breaks please use the &ltBR&gt HTML tag. i.e. This is on one line  &ltBR&gt this is on another
<br>
</div>


<div id="linkDiv" style="display:none;">
    <paper-input class="my-class" type="url" id="linkurl"  name="linkurl" label="Enter a URL" ></paper-input>
    Include http:// i.e. http://www.site.com
    <paper-input class="my-class"  id="linktext"  name="linktext" label="Enter a Title for this Link" ></paper-input>
   
<br>
</div>
   
      
      
      <paper-button id="my-button" class="my-button" raised onclick="submitForm();">Add Resource(s)</paper-button>
      <br>
      <button type="submit" id="SubmitButton" name="submit" style="visibility:hidden;"></button>

     
    </form>
    <br>
 
 

    <script>
function getTopic() {
  
  document.getElementById("topicid").value=jQuery("#topicSelect option:selected").val();
  if (jQuery("#topicSelect option:selected").val()==0){
    document.getElementById("resourceDiv").style.display="none";
    document.getElementById('videoDiv').style.display="none";
    document.getElementById('textDiv').style.display="none";
    document.getElementById('linkDiv').style.display="none";
    document.getElementById('resourceSelect').selectedIndex=0;
  }
  else{
    document.getElementById("resourceDiv").style.display="block";
  }
}
   
function getResource() {
  document.getElementById("resourcetype").value=jQuery("#resourceSelect option:selected").val();
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
      //alert (document.getElementById('featured').value);
    }   

    function submitForm(){

if (document.getElementById('videourl').value!='' && document.getElementById('videotext').value==''){
		document.querySelector('#toast2').text= "You Entered a Video URL without giving it a title.  Please either give it a title or remove the url and resubmit";
		document.querySelector('#toast2').show();
		document.getElementById('videoDiv').style.display="block";
    	document.getElementById('textDiv').style.display="none";
    	document.getElementById('linkDiv').style.display="none";

	}
	else if (document.getElementById('linkurl').value!='' && document.getElementById('linktext').value==''){
		document.querySelector('#toast2').text= "You Entered a Link URL without giving it a title.  Please either give it a title or remove the url and resubmit";
		document.querySelector('#toast2').show();
		document.getElementById('videoDiv').style.display="none";
    	document.getElementById('textDiv').style.display="none";
    	document.getElementById('linkDiv').style.display="block";

	}
	

	else{
	
		document.querySelector('#toast').text= "Adding Topic Resource...";
		document.querySelector('#toast').show();
		document.getElementById('SubmitButton').click();
		console.log("Submitted!")
	}

//end
     //document.getElementById('SubmitButton').click();
    
    }
    function disableType(){
      alert (document.getElementById('videourl').value);
  if (document.getElementById('videotext').value!='' || document.getElementById('videourl').value !='' 
    || document.getElementById('text').value !='' ||document.getElementById('linkurl').value !='' ||document.getElementById('linktext').value!=''){
     document.getElementById('resourceSelect').disabled=true;
  }
  else{
    document.getElementById('resourceSelect').disabled=false;
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


    
    
  </body>
</html>
