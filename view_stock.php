<?php
session_start();
$i = 0;
$total_val = 0;
$total_valT = 0;
$total_prdtM = 0;
$total_prdtS = 0;

include_once 'dbconnect.php';

if(!isset($_SESSION['usr_id'])) {
	header("Location:index.php");
}

if($_SESSION['usr_type'] == 'S') {
	header("Location:index.php");
}

$error = false;
$email_address = "admin@priyamdeyphysics.org";

//check if form is submitted 
if (isset($_POST['register'])) {
	
	$main = mysqli_real_escape_string($con, $_POST['main']);
	$sub1 = mysqli_real_escape_string($con, $_POST['sub1']);
	$sub2 = mysqli_real_escape_string($con, $_POST['sub2']);

	

	if (!$error) {
		if(mysqli_query($con, "INSERT INTO category(main,sub1,sub2) VALUES('" . $main . "', '" . $sub1 . "', '" . $sub2 . "')" )) {
		


			$successmsg = "Successfully Added!!!";

		} else {
			$errormsg = "Error in Adding...Please try again later! (Quote: Form Error)";
		}
	}
}

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Power Solution | Admin Dashboard</title>
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
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>P</b>S</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Power </b>Solution</span>
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
          <a href="category.php">
            <i class="fa fa-th"></i>
            <span>CATEGORIES</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
          <a href="add_stock.php">
            <i class="fa fa-plus"></i> <span>ADD STOCK</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-edit"></i>
            <span>SALES</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li class="active">
          <a href="#">
            <i class="fa fa-bar-chart-o"></i>
            <span>VIEW STOCK</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-pie-chart"></i> <span>VIEW SALES</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <!--
        <li>
          <a href="notices.php">
            <i class="fa fa-table"></i> <span>NOTICES</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        -->
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
        <li class="active"><a href="#"><i class="ion ion-person"></i>Home</a></li>
        <li>Categories</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Main row -->
      <div class="row">
      	<a name="register"></a>
        <section class="col-lg-12 connectedSortable">

          <!-- Link box -->

          <div class="box box-success">
            <div class="box-header">            

              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">
                Stock Status
              </h3>
            </div>
            <div class="box-body">
            
            	<div class="row">
                <div class="col-lg-12">
				
                <?php 
				$resultT = mysqli_query($con, "Select * FROM stock");
				if($resultT->num_rows >0) {
					while($rowT = $resultT->fetch_assoc()) {
						$price = $rowT['price'];
						$quantity = $rowT['quantity'];
						$sold = $rowT['sold'];
						$left = $quantity - $sold;
						$add_charge = $rowT['add_charge'];
						$current = $rowT['quantity'] - $rowT['sold'];
						$valuationT = ($price + $add_charge) * $current;
						$total_valT += $valuationT;
						$c_id_temp = $rowT['c_id'];
						$resultT2 = mysqli_query($con, "SELECT * from category WHERE id = '".$c_id_temp."' ");
						while($rowT2 = $resultT2->fetch_assoc()) {
							if(($rowT2['main'] == "Filter Fitting") || ($rowT2['main'] == "Chimney Fitting")){
								$total_prdtS += $left ;
							} else {
								$total_prdtM += $left ;
							}
						}
						
							
					}
				}
				?>
				<h4>Total Valuation of All Products : <strong><?php echo $total_valT; ?></strong></h4>
                <h4>Total Number of Products : <br> </h4>
                <p>Main Parts : <strong><?php echo $total_prdtM; ?></strong>&nbsp;&nbsp;
                Spare Parts : <strong><?php echo $total_prdtS; ?></strong></p>
                </div>
            	</div>
                
            </div>

          </div>

          <!-- /.box -->

        </section>
      	<!-- Left col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-12 connectedSortable">

          <!-- Link box -->

          <div class="box box-primary">
            <div class="box-header">            

              <i class="fa fa-minus"></i>

              <h3 class="box-title">
                Instant Sale (Stock Removal)
              </h3>
            </div>
            <div class="box-body">
            
            	<div class="row">
                <div class="col-lg-12">
                <form role="form" name="instSaleForm" action="scripts/insSale.php" method="post">
					<div class="col-lg-12 col-xs-12 text-center">
                    <div class="input-group">

                        <label>Item Name : </label> &nbsp;
                        <select name="p_id">
                        	<option selected disabled value="">Select Product</option>
                    <?php
                    $resultR = mysqli_query($con, "Select * FROM stock ORDER BY id");
					if($resultR->num_rows >0) {
					while($rowR = $resultR->fetch_assoc()) {
						$idR = $rowR['id'];
						$nameR = $rowR['name'];
						$quanR = $rowR['quantity'];
						$soldR = $rowR['sold'];
						$remainR = $quanR - $soldR ;
						if($remainR > 0) {
						?>
                        
  							<option value="<?php echo $idR ; ?>"><?php echo $idR.") ".$nameR; ?></option>
                    <?php	} 
                    }
					}
					?>
                        </select>
                    </div>
                    </div>
                    <br>
                    <div class="col-lg-3 col-xs-8 text-center">
                    <div class="input-group">
                		<span class="input-group-addon"><i class="fa fa-arrow-circle-right"></i></span>
                		<input type="text" name="rquantity" class="form-control" placeholder="Removal Quantity" maxlength="5">
              		</div>
                    </div> 

                    <div class="col-lg-3 col-xs-4 text-center">
                		<button type="submit" name="removeS" class="btn btn-success">Remove Stock</button>
                    </div>

              		</div>
                </form>

                </div>
            	</div>
                
            </div>

          </div>

          <!-- /.box -->

        </section>
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
        	
           <div class="box box-warning">
            <div class="box-header">
              <h3 class="box-title">Detailed Stock</h3>
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Category</th>
                  <th>Name</th>
                  <th>Seller</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>GST</th>
                  <th>Add Charges</th>
                  <th>Expected Value</th>
                  <th>Total Valuation</th>
                </tr>
                </thead>
                <tbody>
            <?php
			$result = mysqli_query($con, "Select * FROM stock");
			if($result->num_rows >0) {
				while($row = $result->fetch_assoc()) {
					$c_id = $row['c_id'];
					
					$result2 = mysqli_query($con, "SELECT * from category WHERE id = '".$c_id."' ");
					while($row2 = $result2->fetch_assoc()) {
						$c_id_value = "<strong>(".$c_id.")</strong> ".$row2['main'];
					}
					
					$name = $row['name'];
					$seller = $row['seller'];
					$price = $row['price'];
					$quantity = $row['quantity'];
					$date_entry = $row['date'];
					$gst = $row['gst'];
					$add_charge = $row['add_charge'];
					$exp_value = $row['exp_value'];
					$current = $row['quantity'] - $row['sold'];
					$valuation = ($price + $add_charge) * $current;
					$total_val += $valuation;
					$i = $row['id'];
					if($current > 0) {
					?>
                
                <tr>
                  <td><?php echo $i ; ?></td>
                  <td><?php echo $c_id_value ; ?></td>
                  <td><?php echo $name ; ?></td>
                  <td><?php echo $seller ; ?></td>
                  <td><?php echo $price ; ?></td>
                  <td><?php echo $current ; ?></td>
                  <td><?php echo $gst." %" ; ?></td>
                  <td><?php echo $add_charge ; ?></td>
                  <td><?php echo $exp_value ; ?></td>
                  <td><?php echo $valuation ; ?></td>
                </tr>
                
            <?php 
					}
				}
			}
			
			?>
                </tbody>
                <tfoot>
                <tr>
                  <th>ID</th>
                  <th>Category</th>
                  <th>Name</th>
                  <th>Seller</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>GST</th>
                  <th>Add Charges</th>
                  <th>Expected Value</th>
                  <th>Total Valuation</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
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
    <strong>Copyright &copy; 2018-19 <a href="http://powersolutionmmg.com" >Power Solution </a>| Created by <a href="http://mindwebs.org">MinD Webs Team</a></strong>
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


<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>
