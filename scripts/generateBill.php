<?php
include_once 'dbconnect.php';
session_start();

$errors = '';
$totalMRP = 0;
$totalGST = 0;
$totalQuan = 0;

$bill_id = 0;
$idResult = mysqli_query($con, "SELECT * FROM ids");
while($idRow = $idResult->fetch_assoc()) {
	$bill_curr_id = $idRow['bill_id'];
	$bill_id = $bill_curr_id + 1;
}
$bill_id = str_pad($bill_id, 5, '0', STR_PAD_LEFT);

function randomKey() {
    $alphabet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOQRSTUVWXYZ';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 4; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

$hash_key = randomKey();

if(isset($_POST['bill'])) {
	
	$number = count($_POST["productID"]);
	
	$bill_type = mysqli_real_escape_string($con, $_POST['type']);
	$invoice_number = mysqli_real_escape_string($con,$_POST['invoice_number']);
	$inv_date = date("F j, Y");
	$cust_name = mysqli_real_escape_string($con, $_POST['name']);
	$cust_phone = mysqli_real_escape_string($con, $_POST['phone']);
	$cust_address = mysqli_real_escape_string($con, $_POST['address']);
	$cust_email = mysqli_real_escape_string($con, $_POST['email']);
	
	if($number > 0) {
		for($i=0; $i<$number; $i++) {
			
 			if(trim($_POST["productID"][$i] != '')) {
				$p_id = mysqli_real_escape_string($con,  $_POST["productID"][$i]);
			}
			if(trim($_POST["MRP"][$i] != '')) {
				$mrp = mysqli_real_escape_string($con,  $_POST["MRP"][$i]);
			}
			if(trim($_POST["GST"][$i] != '')) {
				$gst = mysqli_real_escape_string($con,  $_POST["GST"][$i]);
			}
			if(trim($_POST["quantity"][$i] != '')) {
				$quantity = mysqli_real_escape_string($con,  $_POST["quantity"][$i]);
			}
			
			$sell_price = $mrp + $gst ;
			
			if(mysqli_query($con,"INSERT INTO sales(p_id,piece,sell_price,sell_mrp,sell_gst, invoice_id,cust_name,cust_address,cust_phone,cust_email,sell_date) VALUES('" .$p_id. "' , '" .$quantity. "' , '" .$sell_price. "' , '" .$mrp. "', '" .$gst. "' , '" .$invoice_number. "' , '" .$cust_name. "' , '" .$cust_address. "' , '" .$cust_phone. "' , '" .$cust_email. "' , '" .$inv_date. "')")) {
				if(mysqli_query($con, "UPDATE stock SET sold = sold + $quantity WHERE id = '".$p_id."' ")) {
					$errors = '';
					
					$totalMRP += $mrp * $quantity;
					$totalGST += $gst * $quantity;
					$totalQuan += $quantity;		
				} else {
					$errors .= "Stock Error";
				}
			} else {
				$errors .= "Sales Error";
			}
			
			
		}
	}
	
	if(!$errors) {
				if(mysqli_query($con, "INSERT INTO invoice(invoice_id,type,name,phone,address,email,total_mrp,total_gst,items,sell_date,admin, keyHash) VALUES('" .$invoice_number. "' , '".$bill_type."' , '" .$cust_name. "' , '" .$cust_phone. "' , '" .$cust_address. "' , '" .$cust_email. "' , '" .$totalMRP. "' , '" .$totalGST. "' , '" .$totalQuan. "' , '" .$inv_date. "' , '" .$_SESSION['usr_name']. "' , '" .$hash_key. "' ) ")) {
				
				$update_rec = mysqli_query($con, "UPDATE ids SET bill_id = bill_id + 1");
				
				$url = "../invoice.php?id=".$invoice_number;
				header("Location:$url");
				} else {
					echo "INVOICE ERROR";
				}
			} else {
				echo $errors;
			}
	
}

?>