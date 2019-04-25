<?php
session_start();

include_once 'dbconnect.php';

if(isset($_COOKIE['test_code'])) {
	$test_code = $_COOKIE['test_code'];
} else {
	header("Location: tests_home.php");
}

if(isset($_GET['p_code'])) {
	$p_code = $_GET['p_code'];	
	$value = 0;
	setcookie("temp_correct",$value,time() + 28000 ,'/');
	setcookie("temp_incorrect",$value,time() + 28000 ,'/');
	$url= "test.php?q_id=".$p_code."_001";
	header("Location: $url");
}

if(isset($_GET['q_id'])) {
	$q_code = $_GET['q_id'] ;
	$_SESSION['temp_q_id'] = $q_code;
	$q_no = substr($q_code, -3);
	
	$result = mysqli_query($con, "SELECT * FROM qnskey WHERE q_code = '".$q_code."' ");
	
	if($result->num_rows > 0) {
		while($row = mysqli_fetch_array($result)) {
			$qns = $row['question'];
			
			$opt1 = $row['opt1'];
			$opt2 = $row['opt2'];
			$opt3 = $row['opt3'];
			$opt4 = $row['opt4'];
			
			$qnsImage = $row['qnsImage'];
			$ansImage = $row['ansImage'];
		}
	} else {
		header("Location: scripts/endExam.php");
	}
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> PDP | Student Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="theme-color" content="#3498db">
  <link rel="icon" href="favicon.png">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

<!-- FOR TIMER PART -->
	<style>
    .timer{
      text-align: center;
      background: white;
      font-family: sans-serif;
      font-weight: 100;
    }
    h1{
      color: red;
      font-weight: 100;
      font-size: 21px;
      margin: 8px 0px 8px;
      margin-left: 140px;
    }
     #clockdiv{
        font-family: sans-serif;
        color: red;
        display: inline-block;
        font-weight: 100;
        text-align: center;
        font-size: 12px;
        margin-left: 110px;
    }
    #clockdiv > div{
        padding: 5px;
        border-radius: 5px;
        background: #00FFFF;
        display: inline-block;
    }
    #clockdiv div > span{
        padding: 5px;
        border-radius: 5px;
        background: #fff;
        display: inline-block;
    }
    #stop{
      color: red;
      font-weight: bold;
      font-size: 21px;
      margin: 8px 0px 8px;
      margin-left: 120px;
    }
    smalltext{
        padding-top: 5px;
        font-size: 15px;
    }
    </style>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>PD</b>P</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Physics </b>PD</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

     <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">0</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 0 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->

              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">0</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 0 notifications</li>
              <li>

              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">0</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 0 tasks</li>
              <li>
                <!-- inner menu: contains the actual data -->

              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php if($_SESSION['usr_type'] == 'W') { ?>
              	<img src="dist/img/W.png" class="user-image" alt="Webmaster">
              <?php }  else { ?>
              	<img src="dist/img/S.jpg" class="user-image" alt="Student">
              <?php } ?>
              <span class="hidden-xs"><?php echo $_SESSION['usr_name'] ; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <?php if($_SESSION['usr_type'] == 'W') { ?>
            <img src="dist/img/W.png" class="img-circle" alt="Webmaster">
          <?php }  else { ?>
            <img src="dist/img/S.jpg" class="img-circle" alt="Student">
          <?php } ?>

                <p>
                  <?php echo $_SESSION['usr_name'] ; ?>
                  <small>Last Login - <?php echo $_SESSION['usr_time'];?></small>
                </p>
              </li>
              <!-- Menu Body -->

              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a disabled href="#" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <?php if($_SESSION['usr_type'] == 'W') { ?>
            <img src="dist/img/W.png" class="img-circle" alt="Webmaster">
          <?php }  else { ?>
            <img src="dist/img/S.jpg" class="img-circle" alt="Student">
          <?php } ?>
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['usr_name'] ; ?></p>
        </div>
      </div>
      <!-- search form -->
      <!--
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="active">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>TEST PANEL</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-question"></i>Test</a></li>
        <li>Live Test</li>
      </ol>
    </section>

    <!-- Main content -->
      <!-- Small boxes (Stat box) -->
        <!-- ./col -->
      
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
      	<!-- Left col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-12 connectedSortable">

          <div class="box box-warning">
            <div class="box-header">            

              <i class="fa fa-info"></i>
              <h3 class="box-title">Information</h3>
            </div>
            
                        
            <div class="box-body">
            	<div class="row">
            		<div class="col-lg-8">
                    	<p style="color:green">Each <strong>Correct Answer</strong> will fetch you <strong>4 Marks</strong>.</p>
                        <p style="color:red">Each <strong>Incorrect Answer</strong> would deduct <strong>1 Marks</strong>.</p>
                        <p>No Marks would be hence given or deducted if, you don't attempt the question.</p>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="timer">
                        <h1 id="stop"><strong>TIME LEFT</strong></h1>
                          <div>
                             <span class="test" id="test"></span>
                          </div>
                        <div id="clockdiv">
                          <div>
                            <span class="hours" id="hour"></span>
                            <div class="smalltext">Hours</div>
                          </div>
                          <div>
                            <span class="minutes" id="minute"></span>
                            <div class="smalltext">Minutes</div>
                          </div>
                          <div>
                            <span class="seconds" id="second"></span>
                            <div class="smalltext">Seconds</div>
                          </div>
                        </div>
                        </div>                    
                    </div>
                    <br>
            	</div>
            </div>
          </div>

          <!-- /.box -->
          
          <!-- Link box -->

          <div class="box box-primary box-solid">
            <div class="box-header">            

              <i class="fa fa-question"></i>
              <h3 class="box-title">Question Section</h3>
            </div>
            
            <div class="box-body">
            <div class="row">
            <div class="col-lg-12">
            	<h5 style="font-size:16pt">Question <strong><?php echo ltrim($q_no, '0') ; ?></strong></h5><br>
                <p style="font-size:18pt"><?php if($qnsImage == 'N') { echo nl2br($qns); } else { ?> <img src="uploads/<?php echo $qns ; ?>" alt="Question"width="100%"> <?php } ?></p>
            	<br>
                <?php
					$result2 = mysqli_query($con, "SELECT * FROM s_ans WHERE q_code = '".$q_code."' AND email = '".$_SESSION['usr_email']."' ");
					if($result2->num_rows > 0) {
						while($row2 = mysqli_fetch_array($result2)) {
							$val = true;
							$ans = $row2['answer'];
						}
					}
				?>
                
                <form name="ansForm" role="form" action="scripts/nextQns.php" method="post">
                	<div class="row">
            			<div class="col-lg-12">
                        
                            <div class="col-lg-3">
                                <label class="radio-inline"><input type="radio" name="ans" <?php if(isset($val) && ($ans == 'A')) { echo "checked"; } ?> value="A">A. <?php if($ansImage == 'N') { echo nl2br($opt1); } else { ?> <img src="uploads/<?php echo $opt1 ; ?>" alt="Option 1" width="100%"> <?php } ?></label>                
                            </div>
                            <div class="col-lg-3">
                                <label class="radio-inline"><input type="radio" name="ans" <?php if(isset($val) && ($ans == 'B')) { echo "checked"; } ?> value="B">B. <?php if($ansImage == 'N') { echo nl2br($opt2); } else { ?> <img src="uploads/<?php echo $opt2 ; ?>" alt="Option 1" width="100%"> <?php } ?></label>
                            </div>
                            <div class="col-lg-3">
                                <label class="radio-inline"><input type="radio" name="ans" <?php if(isset($val) && ($ans == 'C')) { echo "checked"; } ?> value="C">C. <?php if($ansImage == 'N') { echo nl2br($opt3); } else { ?> <img src="uploads/<?php echo $opt3 ; ?>" alt="Option 1" width="100%"> <?php } ?></label>
                            </div>
                            <div class="col-lg-3">
                                <label class="radio-inline"><input type="radio" name="ans" <?php if(isset($val) && ($ans == 'D')) { echo "checked"; } ?> value="D">D. <?php if($ansImage == 'N') { echo nl2br($opt4); } else { ?> <img src="uploads/<?php echo $opt4 ; ?>" alt="Option 1" width="100%"> <?php } ?></label>
                            </div>                        
           	 			</div> 
             		</div> 
                    <br><br><br>
                    <div class="row">
            			<div class="col-lg-7">
                  			<a href="#" disabled class="btn btn-info" onClick="">MARK FOR REVIEW</a>
                		</div>
                        <div class="col-lg-5">
                  			<a href="scripts/goBackQns.php" class="btn btn-warning">PREVIOUS</a>
                            &nbsp;
                            <input type="reset" class="btn btn-primary" value="Reset Answer">
                  			&nbsp;
                  			<input type="submit" class="btn btn-success" name="ansNext" value="Next">                  			
                  			&nbsp;
                  			<a href="scripts/endExam.php" class="btn btn-danger" onClick="YNconfirm(this, event)">Finish Test</a>
                		</div>
                        
                    </div>
                </form>   

              <br>     
            </div>
          </div>

          <!-- /.box -->

        </section>
        
        <section class="col-lg-12 connectedSortable">
        	<div class="box box-success">
            	<div class="box-header">            

              	<i class="fa fa-dashboard"></i>
              	<h3 class="box-title">Question Pallete</h3>
            	</div>
            
            	<div class="box-body">
            		<h4>Please Ask Your Teacher to Upgrade Your Package to have access to <strong>Mark For Review</strong> and this entire question pallete section</h4>
            	</div>
          </div>
        </section>

      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
    <strong>Copyright &copy; 2018-19 <a href="priyamdeyphysics.org" >Priyam Dey </a>| Created by <a href="mindwebs.org">MinD Webs Team</a></strong>
  </div>
</div>
</div>
  </footer>

  <!-- Control Sidebar -->
  
  <aside class="control-sidebar control-sidebar-dark">
    
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    
    <div class="tab-content">
      
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <!--<li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          -->
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
       

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <!--<li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>-->
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        

      </div>
      
      
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
         

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          
<!--
          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
       -->   
        </form>
      </div>
      
    </div>
  </aside>

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
<!-- ./wrapper -->
</div>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="bower_components/raphael/raphael.min.js"></script>
<script src="bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<!--TIMER SCRIPT -->
<script>
/*
 var duration=120;
 var add_minutes=function(dt,minutes){
  return new Date(dt.getTime()+minutes*60000);
};
var startDate = <?php // echo $_COOKIE['test_st'] ; ?> ;
var deadline = add_minutes(startDate,duration).getTime();
//var deadline = <?php // echo $_COOKIE['test_et'] ; ?> ;
*/
var variable1 = <?php echo $_COOKIE['test_et'] ; ?> ;
variable1 += "000";
//var deadline = new Date("Jan 2, 2018 18:37:25").getTime();
var deadline = variable1;
 
var x = setInterval(function() {
 
var now = new Date().getTime();
var t = deadline - now;
var hours = Math.floor((t%(1000 * 60 * 60 * 24))/(1000 * 60 * 60));
var minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60));
var seconds = Math.floor((t % (1000 * 60)) / 1000);
document.getElementById("hour").innerHTML =hours;
document.getElementById("minute").innerHTML = minutes; 
document.getElementById("second").innerHTML =seconds; 
//document.getElementById("test").innerHTML = deadline; 
if (t < 0) {
        clearInterval(x);
        document.getElementById("stop").innerHTML = "TIME UP";
        document.getElementById("hour").innerHTML ='0';
        document.getElementById("minute").innerHTML ='0' ; 
        document.getElementById("second").innerHTML = '0'; 
		window.location.href = "scripts/endExam.php?key=time"; }
}, 1000);

</script>

<!-- Confirm page change script -->
<script>
	function Function1() {
		if (window.confirm('Really go to another page?'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function YNconfirm(el,ev){
		var confirm = window.confirm("Are You Sure, You Want To End The Test?");
		if(confirm){
			window.location.href = $(el).attr("href");
		}else{
			ev.preventDefault();
			
		}
	 }

</script>

</body>
</html>
