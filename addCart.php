<?php 
@ob_start();
 session_start();
 
//-------------------------------------------------------
// 
//	addCart.php
//	Task : Add to cart when user select item
//	Database : kwonjie_shopcart
//	Table	 : cart
//	created by : Jieun Kwon
//	created date: April 13, 2018
//
//-------------------------------------------------------

		// request item's infomation : item id, item qty, userid from session
        $pid = $_REQUEST['addPid'];
        $qty = $_REQUEST['qty'.$pid];
        $uid = $_SESSION['login'];
	 
        // Database Connection 
		include 'db.php';
   
		// query to update product table
		if(mysqli_query($link, "update product set Av_qty = Av_qty -".$qty." where pid =".$pid))
		{   
			// check whether the item already is in the cart or not
			$result = mysqli_query($link, "select * from cart where userid = '".$uid."' and pid = ".$pid);
			  
			if(($row=mysqli_num_rows($result))>0)
			{		
				// query to update qty to cart table
				$cart_query = "update cart set qty = qty + ".$qty." where userid = '".$uid."' and pid = ".$pid;
			 		
			}else{
				// query to insert cart table
				$cart_query = "insert into cart (userid, pid, qty) values ('".$uid."',".$pid.",".$qty.")";
				 
			}
		   
			// execute query
			if(mysqli_query($link, $cart_query))
			{	 
				header("location:product.php");
			}else{
				echo "Some problem occured when items was added to cart, please contact the system administrator";
			}
		 
		}else{
			echo "Some problem occured, please contact the system administrator";
		}
		 
	    mysqli_close($link);
 ?>