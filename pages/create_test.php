<?php
session_start();

if(!isset($_SESSION['count'])) {
$_SESSION['count'] = 1;
$_SESSION['count'] = str_pad($_SESSION['count'], 3, '0', STR_PAD_LEFT);
}

/*
$qnsImageVariable = 'N';
$ansImageVariable = 'N';
*/

$test_set = false;

include_once 'dbconnect.php';

if(!isset($_SESSION['usr_id'])) {
	header("Location:index.php");
}


function randomKey() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 6; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
$time = date("Y-m-d H:i:s");
$t=time();

$p_code = randomKey();

//PAPER DETAILS SETTING PART

if(isset($_POST['testCnf'])) {

	$name = mysqli_real_escape_string($con,$_POST['name']);
	$topic = mysqli_real_escape_string($con,$_POST['topic']);
	$class = mysqli_real_escape_string($con,$_POST['class']);
	$testtime = mysqli_real_escape_string($con,$_POST['time']);
	$code = mysqli_real_escape_string($con,$_POST['p_code']);
		
	$result = mysqli_query($con, "INSERT INTO tests (name,topic,class,p_code,time) VALUES('".$name."','".$topic."','".$class."','".$code."','".$testtime."') ");
	
	if($result) {
		setcookie("paperCode", $code, time()+28800, '/');
		$test_set = true;
		header("Location:create_test.php");
	} else {
		$test_set = false;
		?>
        <script>
			alert("SOME ERROR OCCURED, PLEASE TRY AGAIN LATER!!!");
		</script>		
        <?php
	}
}



?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> PDP | Admin Dashboard</title>
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

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini" onunload="deleteQcode()">
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
              <?php } else if($_SESSION['usr_type'] == 'A') { ?>
              	<img src="dist/img/A.jpg" class="user-image" alt="Administrator">
              <?php } else { ?>
              	<img src="dist/img/S.jpg" class="user-image" alt="Student">
              <?php } ?>
              <span class="hidden-xs"><?php echo $_SESSION['usr_name'] ; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <?php if($_SESSION['usr_type'] == 'W') { ?>
            <img src="dist/img/W.png" class="img-circle" alt="Webmaster">
          <?php } else if($_SESSION['usr_type'] == 'A') { ?>
            <img src="dist/img/A.jpg" class="img-circle" alt="Administrator">
          <?php } else { ?>
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
                  <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
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
          <?php } else if($_SESSION['usr_type'] == 'A') { ?>
            <img src="dist/img/A.jpg" class="img-circle" alt="Administrator">
          <?php } else { ?>
            <img src="dist/img/S.jpg" class="img-circle" alt="Student">
          <?php } ?>
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['usr_name'] ; ?></p>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li>
          <a href="index.php">
            <i class="fa fa-dashboard"></i> <span>HOME</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
          <a href="register.php">
            <i class="fa fa-files-o"></i>
            <span>CREATE USER</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li class="active">
          <a href="#">
            <i class="fa fa-th"></i> <span>CREATE TESTS</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>VIEW RESULTS</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>VIEW TESTS</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-edit"></i> <span>TOPICS</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-table"></i> <span>NOTICES</span>
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
        <li class="active"><a href="#"><i class="fa fa-question"></i>Teachers Section</a></li>
        <li>Create Tests</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->

      <!-- Main row -->
      <div class="row">
      
      	<!-- Left col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-12 connectedSortable">

          <!-- Link box -->

          <div class="box box-primary">
            <div class="box-header">            

              <i class="fa fa-question"></i>

              <h3 class="box-title">
                Create Test
              </h3>
            </div>
            <div class="box-body">
            	<div class="row">
                	<div class="col-lg-12">
                    <?php
						if(isset($_COOKIE['paperCode'])) {
							$retrival = mysqli_query($con, "SELECT * FROM tests WHERE p_code = '" . $_COOKIE['paperCode'] . "'");
							
							if ($rowR = mysqli_fetch_array($retrival)) {
								$rname = $rowR['name'];
								$rclass = $rowR['class'];
								$rtopic = $rowR['topic'];
								$rtime = $rowR['time'];
							}
						}
						
					?>
             			<form role="form" name="testform" action="<?php echo $_SERVER['PHP_SELF'] ; ?>" method="post">
                        <div class="row">
                            <div class="col-lg-6 col-xs-12">    
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-diamond"></i></span>
                                    <input type="text" name="name" class="form-control" placeholder="Test Name" <?php if(isset($_COOKIE['paperCode'])) { echo "value=\"".$rname."\"" ; } ?>  required>
                                </div> 
                            </div>
                            <div class="col-lg-6 col-xs-12">  
                            	<div class="input-group">
                					<span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                					<input type="text" name="topic" class="form-control" placeholder="Test Topic" <?php if(isset($_COOKIE['paperCode'])) { echo "value=\"".$rtopic."\"" ; } ?> required>
              					</div> 
                            </div>
                        </div>
                    		<br>
                        <div class="row">
                            <div class="col-lg-3 col-xs-6">
								<div class="input-group">
                					<span class="input-group-addon"><i class="fa fa-clone"></i></span>
                					<input type="text" name="class" class="form-control" placeholder="Class" <?php if(isset($_COOKIE['paperCode'])) { echo "value=\"".$rclass."\"" ; } ?> required maxlength="3">
              					</div> 
                            </div>
                            <div class="col-lg-3 col-xs-6">
								<div class="input-group">
                					<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                					<input type="text" name="time" class="form-control" placeholder="Time (in minutes)" <?php if(isset($_COOKIE['paperCode'])) { echo "value=\"".$rtime."\"" ; } ?> required maxlength="3">
              					</div> 
                            </div>  
                            <div class="col-lg-6 col-xs-12">                             	
                            	<div class="input-group">                                
                                	<span class="input-group-addon"><i class="fa"></i> Paper Code : </span>
                                    <input type="text" name="p_code" class="form-control" placeholder="Paper Code" value="<?php if(isset($_COOKIE['paperCode'])) { echo $_COOKIE['paperCode'] ; } else { echo $p_code; } ?>" <?php  if(isset($_COOKIE['paperCode'])) { echo "disabled" ; } ?> required>
                                </div> 
                            </div>                      
                        </div>
                    		<br>
                        <div class="row">   
                        	<div class="col-lg-4 col-xs-2">
                            </div> 
                        	<div class="col-lg-3 col-xs-8">
          						<button type="submit" name="testCnf" <?php  if(isset($_COOKIE['paperCode'])) { echo "disabled" ; } ?> class="btn btn-primary btn-block btn-flat">Submit Test Details</button>
        					</div>
                            <!--
                            <div class="col-xs-4">
          						<button name="testDel" <?php  //if(!isset($_COOKIE['paperCode'])) { echo "disabled" ; } ?> onclick="deleteMe()" class="btn btn-danger btn-block btn-flat">Delete Test</button>
        					</div>
                            -->
                        </div>    
                    	</form>
                        <br>
                        <center><p style="color:red">You Cannot set any new question in the following 8 Hours, and you have to complete this question in the followng 8 Hours only</p></center>
                    </div>
            	</div>              
               	<div class="row">
                	<div class="col-lg-12">
                    <center><h2>Question Section</h2></center>
                    <br>
                        <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                          <th>No</th>
                          <th>Question</th>
                          <th>A</th>
                          <th>B</th>
                          <th>C</th>
                          <th>D</th>
                          <th>Answer</th>
                          <th>Settings</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($_COOKIE['paperCode'])) {
                            $resultQ = mysqli_query($con, "SELECT * FROM qnskey WHERE p_code = '".$_COOKIE['paperCode']."' ORDER BY q_code ");
                            if ($resultQ->num_rows > 0) {
                            while($rowQ = $resultQ->fetch_assoc()) { 
                        ?>
                        <tr>
                          <td><?php echo $rowQ['q_code']; ?></td>
                          <td><?php if($rowQ['qnsImage'] == 'N') { echo nl2br($rowQ['question']); } else { ?> <img src="uploads/<?php echo $rowQ['question'] ; ?>" alt="Question"width="100%"> <?php } ?></td>
                          <td><?php if($rowQ['ansImage'] == 'N') { echo nl2br($rowQ['opt1']); } else { ?> <img src="uploads/<?php echo $rowQ['opt1'] ; ?>" alt="Option 1" width="100%"> <?php } ?></td>
                          <td><?php if($rowQ['ansImage'] == 'N') { echo nl2br($rowQ['opt2']); } else { ?> <img src="uploads/<?php echo $rowQ['opt2'] ; ?>" alt="Option 2" width="100%"> <?php } ?></td>
                          <td><?php if($rowQ['ansImage'] == 'N') { echo nl2br($rowQ['opt3']); } else { ?> <img src="uploads/<?php echo $rowQ['opt3'] ; ?>" alt="Option 3" width="100%"> <?php } ?></td>
                          <td><?php if($rowQ['ansImage'] == 'N') { echo nl2br($rowQ['opt4']); } else { ?> <img src="uploads/<?php echo $rowQ['opt4'] ; ?>" alt="Option 4" width="100%"> <?php } ?></td>
                          <td><?php echo $rowQ['ans']; ?></td>
                          <td>
                          <a href="scripts/deleteqns.php?id=<?php echo $rowQ['id'] ; ?>">Delete</a>
                          </td>
                        </tr>
                        <?php }
                        } 
						}?>
                        </tbody>
                        <tfoot>

                        </tfoot>
                      </table>
                    
                    </div>
            	</div>
                <br>
                <div class="row">
                	<div class="col-lg-12">
                    <center><h3>Add Questions</h3></center>
                    <br>
                    <?php if(isset($_COOKIE['paperCode'])) { ?>
                    
                    <form role="form" name="qnsform" action="scripts/qnsImg.php" method="post" enctype="multipart/form-data">
                    	<div class="row">
                        	<div class="col-lg-4 col-xs-12">
                            	<div class="input-group">
                                    <span class="input-group-addon"><i class=""></i>No :</span>
                                    <input type="text" name="q_code" class="form-control" placeholder="Qns No" value="<?php echo $_COOKIE['paperCode']."_".$_SESSION['count'] ; ?>" required>
                                </div>                    	
                    		</div>
                            
                            <div class="col-lg-4 col-xs-6">
                        		<div class="input-group">
                                	<input type="checkbox" onClick="if(this.checked){qnsImage()}else{qnsText()}" <?php if(isset($_SESSION['tmp_img'])) { echo "checked";} ?> name="qnsCheck"> Is Question Image ?
                                </div>
                            </div> 
                            <div class="col-lg-4 col-xs-6">
                            	<div class="input-group">
                                	<input type="checkbox" onClick="if(this.checked){ansImage()}else{ansText()}" name="ansCheck"> Are Ans Image(s) ?
                                </div>                        	
                            </div>                         
                        </div>
                        <br>
                        <div class="row">
                        	<div class="col-lg-12 col-xs-12">
                    			<div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-question"></i></span>
                                    <textarea style="resize:none" name="question" id="question" rows="4" class="form-control" placeholder="Please Type Your Question" required maxlength="1200"></textarea>
                                    <label style="display:none" id="qnsImageLbl">Upload Question Image File</label>
                                    <input type="file" name="qnsImageFile" id="qnsImageFile" style="display:none" >
                                </div>
                    		</div>  
                        </div>
                        <br>
                        Options : <br>
                        <div class="row">
                        	<div class="col-lg-3 col-xs-6">
                            	<div class="input-group">
                                    <span class="input-group-addon">A</span>
                                    <textarea style="resize:none" name="opt1" id="opt1" rows="2" class="form-control" placeholder="Option 1" required maxlength="120"></textarea>
                                    
                                    <input type="file" name="ansImageFile1" id="ansImageFile1" style="display:none" >
                                </div>
                            </div>
                            <div class="col-lg-3 col-xs-6">
                            	<div class="input-group">
                                    <span class="input-group-addon">B</span>
                                    <textarea style="resize:none" name="opt2" id="opt2" rows="2" class="form-control" placeholder="Option 1" required maxlength="120"></textarea>
                                    
                                    <input type="file" name="ansImageFile2" id="ansImageFile2" style="display:none" >
                                </div>
                            </div>
                            <div class="col-lg-3 col-xs-6">
                            	<div class="input-group">
                                    <span class="input-group-addon">C</span>
                                    <textarea style="resize:none" name="opt3" id="opt3" rows="2" class="form-control" placeholder="Option 1" required maxlength="120"></textarea>
                                    
                                    <input type="file" name="ansImageFile3" id="ansImageFile3" style="display:none" >
                                </div>
                            </div>
                            <div class="col-lg-3 col-xs-6">
                            	<div class="input-group">
                                    <span class="input-group-addon">D</span>
                                    <textarea style="resize:none" name="opt4" id="opt4" rows="2" class="form-control" placeholder="Option 1" required maxlength="120"></textarea>
                                   
                                    <input type="file" name="ansImageFile4" id="ansImageFile4" style="display:none" >
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">    
                            <div class="col-lg-3 col-xs-6">
                            	<div class="input-group">
                                    <span class="input-group-addon"><i class=""></i>Ans : </span>
                                    <!--<input type="text" name="ans" class="form-control" placeholder="Answer Option" required maxlength="2" autocomplete="off">-->
                                    <select name="ans" class="form-control" required>
                                      <option value="--" disabled selected>Option</option>
                                      <option value="A">A</option>
                                      <option value="B">B</option>
                                      <option value="C">C</option>
                                      <option value="D">D</option>
                                      <option value=" ">NOTA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xs-6">
                            	<input type="submit" name="sendQns" value="Add Qns" class="btn btn-success">
                            </div>
                    	</div>
                        
                    </form>
                        <?php } else {
							echo "<center><p style=\"color:red\">SET QUESTION DETAILS FIRST ABOVE</p></center>"; } ?>
                    </div>
                    <br>
                </div>
                <br>
                <!-- PART OF QUESTION IMAGE UPLOAD -->
                
                	<div class="row" id="qnsDiv" <?php if(!isset($_SESSION['tmp_img'])) { ?> style="display:none" <?php } ?>>   
                    	<center><h3 style="color:RED">Select Image For Question</h3></center>     <br>            	
                        <form method="POST" name="uploadForm" action="scripts/upload.php" enctype="multipart/form-data" id="uploadForm"> 
                         <div class="col-lg-8 col-xs-12">                     
                             <div class="form-group">                                   
                                  <input type="file" name="image" id="image" >                                  
                             </div> 
                             <br>
                             <div id="show_pic_qns">
								<?php if(isset($_SESSION['tmp_img'])) {
                                    echo $_SESSION['tmp_img'];
                                    unset($_SESSION['tmp_img']);
                                    echo "<br>";
                                    echo nl2br($_SESSION['tmp_img_script']);
                                    $script_to_add = "</span>".$_SESSION['tmp_img_script']."<span>";
                                    $location = $_SESSION['tmp_img_location'];
                                    unset($_SESSION['tmp_img_script']);
                                    unset($_SESSION['tmp_img_location']);
                                    
                                } ?>
                                                     
                             </div> 
                             
                		</div>
                             
                         <div class="col-lg-4 col-xs-12">
                             <div class="form-group">  
                                  <input class="btn btn-success btn-sm" name = "upload_image" value="Upload Image" type="submit">  
                             </div> 
                             <?php if(isset($script_to_add)) { ?>
               					 <button class="btn btn-primary" type="button" name ="add_img" onclick="myFunction()" id="add_img">Set Image As Question</button>
                			 <?php } ?>
                         </div> 
                                            
                        </form>    
                        
						<script>
                            
                            function myFunction() {
                                //var inval = document.getElementById("content").value;
                                var fval = '<?php echo $location; ?>';
                                document.getElementById("question").value = fval;
                                document.getElementById("show_pic_qns").innerHTML = "";
                            }
                            
                        </script>                                        
                    </div>
                    
                <!--END OF QNS ADD IMAGE PART -->
				
                 <!-- PART OF QUESTION IMAGE UPLOAD -->
                
                	<div class="row" id="ansDiv" <?php if(!isset($_SESSION['tmp_img_2'])) { ?> style="display:none" <?php } ?>>   
                    	<center><h3 style="color:RED">Select Image For Answer(s)</h3></center>     <br>            	
                        <form method="POST" name="uploadForm2" action="scripts/upload2.php" enctype="multipart/form-data" id="uploadForm"> 
                         <div class="col-lg-8 col-xs-12">                     
                             <div class="form-group">                                   
                                  <input type="file" name="image" id="image" >                                  
                             </div> 
                             <br>
                             <div id="show_pic_ans">
								<?php if(isset($_SESSION['tmp_img_2'])) {
                                    echo $_SESSION['tmp_img_2'];
                                    unset($_SESSION['tmp_img_2']);
                                    echo "<br>";
                                    echo nl2br($_SESSION['tmp_img_script_2']);
                                    $script_to_add = "</span>".$_SESSION['tmp_img_script_2']."<span>";
                                    $location = $_SESSION['tmp_img_location_2'];
                                    unset($_SESSION['tmp_img_script_2']);
                                    unset($_SESSION['tmp_img_location_2']);
                                    
                                } ?>
                                                     
                             </div> 
                             
                		</div>
                             
                         <div class="col-lg-4 col-xs-12">
                             <div class="form-group">  
                                  <input class="btn btn-success btn-sm" name = "upload_image_2" value="Upload Image" type="submit">  
                             </div> 
                             <?php if(isset($script_to_add)) { ?>
                             <p>Set Image As</p>
               					 <button class="btn btn-primary" type="button" onclick="myFunction1()" >Option <strong>A</strong></button>
                                 <div id="txt_opt1"></div>
                                 <button class="btn btn-primary" type="button" onclick="myFunction2()" >Option <strong>B</strong></button>
                                 <div id="txt_opt2"></div>
                                 <button class="btn btn-primary" type="button" onclick="myFunction3()" >Option <strong>C</strong></button>
                                 <div id="txt_opt3"> </div>
                                 <button class="btn btn-primary" type="button" onclick="myFunction4()" >Option <strong>D</strong></button>
                                 <div id="txt_opt4"></div>
                			 <?php } ?>
                         </div> 
                                            
                        </form>    
                        
						<script>
                            
                            function myFunction1() {
                                //var inval = document.getElementById("content").value;
                                var fval = '<?php echo $location; ?>';
                                document.getElementById("opt1").value = fval;
                                document.getElementById("show_pic_ans").innerHTML = "<h4> Select Next Image </h4>";
								document.getElementById("txt_opt1").innerHTML = "&nbsp; Option A is Set";
								<?php //$_SESSION['tmp_opt1'] = "Option A is Set"; ?>
                            }
							
							
							function myFunction2() {
                                //var inval = document.getElementById("content").value;
                                var fval = '<?php echo $location; ?>';
                                document.getElementById("opt2").value = fval;
                                document.getElementById("show_pic_ans").innerHTML = "<h4> Select Next Image </h4>";
								document.getElementById("txt_opt2").innerHTML = "&nbsp; Option B is Set";
								<?php //$_SESSION['tmp_opt2'] = "Option B is Set"; ?>
                            }
							
							function myFunction3() {
                                //var inval = document.getElementById("content").value;
                                var fval = '<?php echo $location; ?>';
                                document.getElementById("opt3").value = fval;
                                document.getElementById("show_pic_ans").innerHTML = "<h4> Select Next Image </h4>";
								document.getElementById("txt_opt3").innerHTML = "&nbsp; Option C is Set";
								<?php //$_SESSION['tmp_opt3'] = "Option C is Set"; ?>
                            }
							
							function myFunction4() {
                                //var inval = document.getElementById("content").value;
                                var fval = '<?php echo $location; ?>';
                                document.getElementById("opt4").value = fval;
                                document.getElementById("show_pic_ans").innerHTML = "<h4> Select Next Image! Ignore If Done </h4>";
								document.getElementById("txt_opt4").innerHTML = "&nbsp; Option D is Set";
								<?php //$_SESSION['tmp_opt4'] = "Option D is Set"; ?>
                            }
                            
                        </script>                                        
                    </div>
                    
                <!--END OF QNS ADD IMAGE PART -->
                    
                <br>
                <div class="row">
                    <div class="col-lg-12">
                    	<center><a href="scripts/qnsComplete.php"><button type="" name="" class="btn btn-success">Finalize QNS and Close Paper</button></a></center>
                    </div>
				</div>
            </div>

          </div>
          <!--Script for Image change and text change-->
		  <script>
		  
		  function qnsImage(){
			  document.getElementById("qnsDiv").style.display = "";
			  /*document.getElementById("question").style.display = "none";
			  document.getElementById("qnsImageFile").style.display = "";
			  document.getElementById("qnsImageLbl").style.display = "";*/
		  }
		  function qnsText(){
			  document.getElementById("qnsDiv").style.display = "none";
			  /*document.getElementById("question").style.display = "";
			  document.getElementById("qnsImageFile").style.display = "none";
			  document.getElementById("qnsImageLbl").style.display = "none";*/
		  }
		  
		  function ansImage(){
			  document.getElementById("ansDiv").style.display = "";
			/*  for(var i=1; i< 5; i++) {
				var optVar = "opt" + i; 
				var imgVar = "ansImageFile" + i; 
			  	document.getElementById(optVar).style.display = "none";
			  	document.getElementById(imgVar).style.display = "";
			  } */
		  }
		  function ansText(){
			  document.getElementById("ansDiv").style.display = "none"; 
		/*	  for(var i=1; i< 5; i++) {
				var optVar = "opt" + i; 
				var imgVar = "ansImageFile" + i; 
			  	document.getElementById(optVar).style.display = "";
			  	document.getElementById(imgVar).style.display = "none";
			  } */
		  }
		  
		  </script>

          <!-- /.box -->

        </section>
        <!-- Left col -->
        
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
</div>
<!-- ./wrapper -->

<script>
function deleteQcode() {
	document.cookie = paperCode + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}
</script>

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

</body>
</html>
