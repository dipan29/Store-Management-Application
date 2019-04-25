<?php
session_start();
$i = 0;
include_once 'dbconnect.php';

if(!isset($_SESSION['usr_id'])) {
	header("Location:index.php");
}

if($_SESSION['usr_type'] == 'S') {
	header("Location:index.php");
}

$total_val = 0;


function randomKey() {
    $alphabet = '0123456789';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 3; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

$bill_id = 0;
$idResult = mysqli_query($con, "SELECT * FROM ids");
while($idRow = $idResult->fetch_assoc()) {
	$bill_curr_id = $idRow['bill_id'];
	$bill_id = $bill_curr_id + 1;
}
$bill_id = str_pad($bill_id, 5, '0', STR_PAD_LEFT);

$five_id = $bill_id;
$d_id = date("dmy");
$invoice_id = "PSM_".$d_id."_".$five_id;


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
  <!-- Select2 -->
  <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  

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
        <li class="active">
          <a href="#">
            <i class="fa fa-edit"></i>
            <span>SALES</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
          <a href="view_stock.php">
            <i class="fa fa-bar-chart-o"></i>
            <span>VIEW STOCK</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
          <a href="view_sales.php">
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
        <li>Sales</li>
        <li>New Bill</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Main row -->
      <div class="row">
      	<a name="register"></a>
      	<!-- Left col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-12 connectedSortable">

          <!-- Link box -->

          <div class="box box-primary">
            <div class="box-header">            

              <i class="fa fa-dollar"></i>

              <h3 class="box-title">
                Create New Invoice
              </h3>
            </div>
            <div class="box-body">
            
            	<div class="row">
                <div class="col-lg-12">
                <form role="form" name="billForm" action="scripts/generateBill.php" method="post">
					<div class="row">
                    	<div class="col-lg-4 col-xs-12">
                            <div class="input-group">
                                <label>Type of Bill : </label> &nbsp;
                                <select name="type" id="type">
                                    <option value="Plain">Plain Bill</option>
                                    <option value="Sales">Sales Bill</option>                                    
                                        
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-xs-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                                <input type="text" id="invoice_number" name="invoice_number" class="form-control" placeholder="Invoice Number" value="<?php echo $invoice_id ; ?>">
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-xs-6">
                            <div class="input-group">
                                <p class="center-block">Date :  <strong><?php echo date("F j, Y");//substr($timeNow,0,10); ?></strong></p>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="input-group">
                		<span class="input-group-addon"><i class="ion-person"></i></span>
                		<input type="text" name="name" id="name" class="form-control" placeholder="Customer's Name" maxlength="40" required>
              		</div>  
                    <br>
                    <div class="row">
                        <div class="col-lg-6 col-xs-12">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Customer's Phone Number" maxlength="12" required>
                        </div>
                        </div>
                        <div class="col-lg-6 col-xs-12">
                        <div class="input-group">
                        	<span class="input-group-addon"><i class="fa fa-link"></i></span>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Customer's Email Address" maxlength="50">
                        </div>
                        </div>
                    </div>    
                    <br>
                    <div class="input-group">
                		<span class="input-group-addon"><i class="fa fa-address-book"></i></span>
                		<!--<input type="text" name="address" class="form-control" placeholder="Address" maxlength="150">-->
                        <textarea class="form-control" name="address" id="address" placeholder="Customer's Address" rows="4" cols="100" required></textarea>
              		</div> 
                    <br>
                    <center><br><h3>Items Section</h3><br></center>
                    <!--Items Entering part-->
                    <div class="row">
                    	<div class="col-lg-4 col-xs-12">
                          <div class="input-group">
                            
                            <select class="form-control select2" name="productAdd" id="productAdd" >
                            
                              <option selected="selected" disabled>Search and Select Product</option>
                              <?php 
							  $result = mysqli_query($con, "SELECT * FROM category ORDER BY ID");
							  if($result->num_rows > 0) {
								  while($row = $result->fetch_assoc() ) {									  
									  $c_id = $row['id'];
									  $category = $row['main']." > ".$row['sub1']." > ".$row['sub2'];
									  $result2 = mysqli_query($con, "SELECT * FROM stock WHERE c_id = '".$c_id."' ");
									  
									  
									  if($result2->num_rows > 0) {
										  while($row2 = $result2->fetch_assoc()){
											  $name = $row2['name'];
									  		  $quantity = $row2['quantity'] - $row2['sold'];
											  $p_id = $row2['id'];
											  
											  $temptitle = "Primary Category : ".$row['main']." &#013;&#010;Price : ".$row2['price']." | Additional Charge : ".($row2['gst'] + $row2['add_charge'])." &#013;&#010;Expected Value : ".$row2['exp_value']." | Pieces Left : ".$quantity ;
											  $title = addslashes($temptitle);
											  
											  if($quantity >0) {
											  ?>
                                              <option value="<?php echo $p_id ; ?>" title="<?php echo $title ; ?>"><?php echo $name ; ?></option>
											  <?php }
										  }
									  }
									  
								  }
							  }
							  ?>
                              
                            </select>
                          </div>
                      	</div>
                        <div class="col-lg-3 col-xs-6">
                        	<div class="input-group">
                        		<span class="input-group-addon">Quantity : </span>
                                <input type="number" name="quantityAdd" id="quantityAdd" min="1" max="5000" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                        	<div class="input-group">
                            	<span class="input-group-addon">Price : <strong>Rs</strong></span>
                                <input type="text" name="rateMRPAdd" id="rateMRPAdd" class="form-control" placeholder="MRP">
                                <input type="text" name="rateGSTAdd" id="rateGSTAdd" class="form-control" placeholder="GST" value="0" maxlength="2" onFocus="this.value = '' ">
                                
                            </div>
                        </div>
                        <div class="col-lg-2 col-xs-12">
                        	<a id="addProduct" class="btn btn-success" onClick="addProduct()">Add Item</a>
                        </div>
                    </div>
                    
                    <!--Script for Above Part-->
                    <script>
						var i = 0;
						var deleted = 0;
						function findProduct(id)
						{
							alert(id.value);
						}
						
						function addProduct() {
							//Calculation Part
							var productID = productAdd.value;
							var quantity = quantityAdd.value;
							var MRP = rateMRPAdd.value;
							var GSTpercent = rateGSTAdd.value;
							var GST = GSTpercent/100;
							var GSTvalue = GST*MRP;
							
							var finalRate = parseFloat(MRP,10) + parseFloat(GSTvalue,10);
							var finalPrice = finalRate * quantity ;
							
							var name = productAdd.options[productAdd.selectedIndex].text;
							
							var exTotal = parseFloat(document.getElementById('totalAmount').innerHTML, 10);
							var Total = parseFloat(finalPrice, 10) + parseFloat(exTotal, 10);
														
							document.getElementById('totalAmount').innerHTML = Total;
							
							//var encode = "Product ID : " + productID + " Final Price " + finalPrice;
							
							//Set Part
							i++;
							
							//Append Part
							$("#dynamicProducts").find('tbody')
								.append($('<tr id="row'+i+'"><td>'+i+'</td><td><input type="text" style="width:50px" name="productID[]" value="'+productID+'"/></td><td>'+name+'</td><td><input type="text" name="MRP[]" value="'+MRP+'"/></td><td><input type="text" name="GST[]" value="'+GSTvalue+'"/></td><td><input type="text" name="quantity[]" value="'+quantity+'"/></td><td>'+finalPrice+'</td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger" onClick="removeProduct('+i+')">Remove</button></td></tr>')
									//.append($('<td>')
										//.append('<tr id="row'+i+'"><td><input type="text" name="name[]" placeholder="Enter Your Name"/></td><td><button type="button" name="remove" id="'+i+'" class="btn_remove">Remove</button></td></tr>');
// })
									//)
    							);
							
						}
						
						function removeProduct(id) {							
							var rowSet = "row"+id;
								
							var tempI = parseInt(id, 10) - parseInt(deleted, 10);
							
							var exTotal = parseFloat(document.getElementById('totalAmount').innerHTML, 10);
							var delPrice = parseFloat(document.getElementById("dynamicProducts").rows[id].cells[6].innerHTML, 10);
							
							var Total = parseFloat(exTotal, 10) - parseFloat(delPrice, 10);
							
							document.getElementById('totalAmount').innerHTML = Total;
							if(confirm("Are You Sure You Want To Delete This Product?")){
								$('#dynamicProducts tr#'+rowSet+'').remove();
								//var table = document.getElementById("dynamicProducts");
								//deleted = parseFloat(deleted, 10) + 1;
								//document.getElementById('dynamicProducts').deleteRow(tempI);
							}
						}
						
						
					</script>      
                    
                    <!-- Add Dynamic Table here to add upto the custom billing section -->
                    <br><br>
                    <div class="row">
                    <div class="col-lg-12">
                    <table id="dynamicProducts" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                          <th>Sl No.</th>
                          <th style="width:50px">Product ID</th>
                          <th>Product Name</th>
                          <th>Rate</th>
                          <th>GST Value</th>
                          <th>Quantity</th>
                          <th>Price</th>
                          <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                    <!--
                    <tfoot>
                        <tr>
                          <th>Product ID</th>
                          <th>Product Name</th>
                          <th>Rate</th>
                          <th>GST</th>
                          <th>Quantity</th>
                          <th>Price</th>
                          <th></th>
                        </tr>
                    </tfoot>
                    -->
                    </table>
                    </div>
                    </div>
                    

                                                 
                    <br>  
                    <div class="row">
                    <hr>
                    	<h3><center>Total Amount : <span id="totalAmount">0</span></center></h3>
                    </div>
                    <div class="box-footer">
                    <div class="col-lg-6 col-xs-6 text-center">
                		<button type="submit" name="bill" class="btn btn-success">Create Bill</button>
                    </div>
                    <div class="col-lg-6 col-xs-6 text-center">
                		<a href="sales.php" class="btn btn-primary">Reset</a>
                    </div>
              		</div>
                </form>
                
                <script>
				
				</script>            
               
                </div>
            	</div>
                
            </div>

          

          <!-- /.box -->

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
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
	
	
    $('#example1').DataTable()
    /* $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    }) */
 

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
</body>
</html>
