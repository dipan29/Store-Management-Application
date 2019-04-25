<?php

include_once 'dbconnect.php';
session_start();

if(isset($_POST['removeS'])) {
	
	$p_id = $_POST['p_id'];
	$rquantity = $_POST['rquantity'];
		$resultT = mysqli_query($con, "Select * FROM stock ORDER BY id");
		if($resultT->num_rows >0) {
					while($rowT = $resultT->fetch_assoc()) {
						if($rowT['id'] == $p_id) {
							$currentSold = $rowT['sold'];
						}
					}
				}
	$newQuan = $currentSold + $rquantity;
	
	if(mysqli_query($con, "INSERT INTO temp_sale(p_id,date,quantity) VALUES('" . $p_id . "', '" . $timeNow . "', '" . $rquantity . "')" )) {
		if(mysqli_query($con, "UPDATE stock SET sold = '".$newQuan."' WHERE id = '".$p_id."' "))  {
			?>
            <script>
				window.history.go(-1);
			</script>
            <?php
		}
	} else {
		echo "SOME ERROR OCCURED!!!!";
	}
	
}

?>