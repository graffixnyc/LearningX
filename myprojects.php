<?php session_start();

ini_set('display_errors', 1);
include 'internal_api.php';

if ($_SESSION["loggedin"]=='1'){ 
	include("header.php");  
	if (!empty($_GET['c'])&& $_GET['c']==1):
		$complete=1;
						
	else:
		$complete=0;
	endif;?>
	
	<script src="/bower_components/moment/moment.js"></script>
	<link rel="import" href="bower_components/iron-list/iron-list.html">
	<link rel="import" href="bower_components/iron-icons/iron-icons.html">
	<link rel="import" href="bower_components/paper-button/paper-button.html">
	<link rel="import" href="bower_components/iron-form/iron-form.html">
	<link rel="import" href="bower_components/paper-toast/paper-toast.html">	
	<link rel="import" href="bower_components/paper-input/paper-input.html">
	<link rel="import" href="bower_components/paper-fab/paper-fab.html">

	<div class="content"><center>
		<div class="adjust">
			<br><br>
			<form is="iron-form" id="form" method="post">
				
				<paper-material elevation="3" class="card_search">
				
				<center>
					<table width="100%"  >
						<tr  align="center" >
						<?php	if ($complete==0){
									echo'<td colspan="3" ><h2>Active Projects</h2><a href="myprojects?c=1">View Completed Projects</a>';
								}
								else{
									echo'<td colspan="3" ><h2>Completed Projects</h2><a href="myprojects">View Active Projects</a>';
								}
								if(isset($_SESSION["deletedproject"])){
									echo'<h2 style="color:salmon">Project Deleted</h2>';
									unset($_SESSION["deletedproject"]);
								}
								?>
								<hr>
							</td>
						</tr>
						
						<tr valign="top">
							<td  align="left" >
								<paper-fab onClick="location.href='addproject'" class="my-fab" mini icon="add" title="Add Project"></paper-fab>
				
							</td>
							<td  valign="top" align="right">
								<paper-input style="width:11em;" class="my-class"  id="searchtext" name="query" label="Search Projects" onchange="disableSelect();"></paper-input>
							</td>
							<td width="10%" valign="bottom" align="left">
								<paper-button id="search-button" raised onclick="submitForm();">Search</paper-button>
								<button disabled type="submit" id="SubmitButton" name="submit" style="visibility:hidden;"></button>
								
							</td>
							<?php if (!empty($_POST['query'])): ?>
							<tr><td colspan="2">
									<?php	if($complete==1){
												echo'<a href="myprojects?c=1">View All Completed</a></td></tr>';
											}
											else{
												echo'<a href="myprojects">View All Active</a></td></tr>';
											
											}												
								 else:?>
									<tr  align="left" >
										<td colspan="2" > 
											<select id="sortselect" name="sortby" onchange='submitForm(true);'>
												<option value="0" selected disabled hidden>Sort By</option>
												<option value="project_name">Project Name</option>
												<option value="project_deadline">Project Deadline(Default)</option>
												<option value="client">Client Name</option>				
											  </select>
										</td>
									</tr>
								<?php endif;?> 
							
						</tr>
					</table>
				</center>
				</paper-material>
			</form>
			<template is="dom-bind" id="projects">
				<?php 
					$projects=array();
					if (empty($_POST)):
							$projects=getUserProjects($_SESSION["uid"],NULL,$complete);
							$jsonresult=json_encode($projects);
					
					elseif (!empty($_POST['query'])):
						$projects=searchProjectByName($_SESSION["uid"],$_POST['query'],$complete);
						$jsonresult=json_encode($projects);
						
					elseif (!empty($_POST['sortby'])):
						
						$projects=getUserProjects($_SESSION["uid"],$_POST['sortby'],$complete);
						$jsonresult=json_encode($projects);
						
					endif;?>
				<iron-list items='<?php echo $jsonresult;?>' as="item">
					<template>
						<div>
							<div class="item">
								<div class="pad">
									<div class="primary"><a href$="{{_getProject(item.project_id)}}"><iron-icon  icon="assignment"><iron-icon></a> &nbsp<a  href$="{{_getProject(item.project_id)}}">[[item.project_name]]</a></div>
									<div class="secondary dim">Client: <a href$="{{_getClientid(item.client_id)}}">[[item.client_name]]</a></div>
								
									<div class="secondary">Project Deadline:</div>
									<div class="secondary dim">{{_getDeadline(item.project_deadline, item.project_deadline_time)}}</div>
									<div class="secondary">{{_getTotalHours(item.project_total_hours)}}</div>
								</div>
								
							
							</div>
						</div>
					</template>
				</iron-list>
			</template>
			<paper-material elevation="3" class="card_search">
				<?php include("footer.php");?>
			</paper-material>

			
		</div>
	</div>
	<br /><br /><br /><br /><br />
	<script>
				var projects = document.getElementById('projects');
				
				//var deaddiv=document.getElementById('deadlinediv');
				projects._getProject = function (url) {
				return 'project?id=' + url;
				}
				projects._getClientid = function (id) {
					if (id!=null){
					return 'client?id=' + id
					}
					else{
						
					}
				}
				projects._getClientName = function (cid) {
					if (cid!=null){
					return 'Client: '  + cid;
				}
				else{
					return 'Client: None';
				}
			  }
			  projects._getDeadline = function (deadline, deadlinetime) {
			  if(deadline!=null){
				var timeString = deadlinetime;
				var H = +timeString.substr(0, 2);
				var h = H % 12 || 12;
				var ampm = H < 12 ? "AM" : "PM";
				timeString = h + timeString.substr(2, 3) + ampm;
				var d = deadline.slice(0, 10).split('-');   
					formatteddate=d[1] +'/'+ d[2] +'/'+ d[0]; // 10/30/2010
					return    formatteddate + ' at ' + timeString;
			}
			else{
				return 'N/A';
			}
			  }
			   projects._getTotalHours = function (totalhours) {
				return  'Total Hours to Date: '  + totalhours;
			  }
			function submitForm(select){
				if (select==true){
					document.getElementById('SubmitButton').disabled=false;

			}
			document.getElementById('SubmitButton').click();
			console.log("Submitted!")
			}
			 function disableSelect(){
				 if (document.getElementById('searchtext').value !=''){
					document.getElementById('SubmitButton').disabled=false;
					document.getElementById('sortselect').disabled=true;
					//alert (document.getElementById('searchtext').value);
				 }
				 else{
					 document.getElementById('SubmitButton').disabled=true;
					 document.getElementById('sortselect').disabled=false;
					 //alert (document.getElementById('searchtext').value);
				 }
			}
			</script>
	</body>
	</html>
 <?php }
else{
		if($complete==1){
			$_SESSION["intended"]="myprojects?c=1";
		}
		else{
			$_SESSION["intended"]="myprojects";
		}
	
	header( 'Location: login' ) ;
}
?>
<?php include("pi.php");?>