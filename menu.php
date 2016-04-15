<div id="wrapper">
        <div class="overlay"></div>
    
        <!-- Sidebar -->
        <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
            <ul class="nav sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                       Learning X
                    </a>
                </li>
                <li>
                    <a href="index"><i class="fa fa-fw fa-home"></i> Home</a>
                </li>
            <?php
                //Declare the Array
                $topics=array(); 
                //Set the Array to call the function (this function is in internal_api.php)
                $topics=getTopics();
                //Loop through the results and display them.. you can write out HTML with them as you see I'm writing out the topic and then the BR HTML tag.  If you need help concatenating the tags let me know
                foreach($topics as $item) {
            if (isset($_GET['id']) && $_GET['id'] == $item["topicID"]) {
                    echo '<li class="active"><a href=topic?id=' . $item["topicID"] . '>' . $item["topic"] . '</a></li>';
                    $theTopic = $item["topic"];
                  } else {
                    echo '<li><a href=topic?id=' . $item["topicID"] . '>' . $item["topic"] . '</a></li>';
                  }
                }
            ?>
            <li>
                   
                </li>
            </ul>
        </nav>
        <!-- /#sidebar-wrapper -->
<font class= "menutext" color="white">Menu</font>
<br>
<br>
        <!-- Page Content -->
        <div id="page-content-wrapper">
          
          <button type="button" class="hamburger is-closed animated fadeInLeft" data-toggle="offcanvas">
            <span class="hamb-top"></span>
            <span class="hamb-middle"></span>
            <span class="hamb-bottom"></span>
          </button>