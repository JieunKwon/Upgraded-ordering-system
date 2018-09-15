<?php

//-------------------------------------------------------
//	Assignment 6 
//	addCart.php
//	Task : Update item's qty user want to change
//	Database : kwonjie_shopcart
//	Table	 : cart, product
//	created by : Jieun Kwon
//	created date: April 14, 2018
//
//-------------------------------------------------------
@ob_start();
 
		// request item's infomation : item id, item qty, userid from session
        $cno = $_REQUEST['upCno'];			// cno of Cart table
        $upqty = $_REQUEST['upqty'.$cno];	// new qty
		$qty = $_REQUEST['qty'];			// current qty
		$del = $_REQUEST['del'];			// delete mode = 1
        //$uid = $_SESSION['login'];
		
		$uid = "kwon";
		   
        // Database Connection 
		include 'db.php';
   
		//----------------------------
		// Delete item from cart 
		if($del == "1"){
			
			// update Av_qty of product table
			if(mysqli_query($link, "update product set Av_qty = Av_qty +".$qty." where pid = (select pid from cart where cno=".$cno.")"))
			{			 		
					// delete item of cart table
					if(mysqli_query($link, "delete from cart where cno=".$cno))					
					{ 
						header("location:cart.php");
					}else{
						
						echo "Some problem occured when your item was deleted.\nPlease contact the system administrator";
					}
			}else{
				echo "Some problem occured when your item was deleted.\nPlease contact the system administrator";
			}
			
		//----------------------------
		// Update qty of cart 
		}else{
			
			// query to insert cart table
			if(mysqli_query($link, "update cart set qty = ".$upqty." where cno=".$cno))
			{			  
					// qty calculate
					if($qty > $upqty)	// when new qty is bigger	
						$plusQuery = "Av_qty = Av_qty +". ($qty - $upqty);
					else				// when new qty is small
						$plusQuery = "Av_qty = Av_qty -". ($upqty - $qty);
									
					// query to update product table
					if(mysqli_query($link, "update product set ".$plusQuery." where pid = (select pid from cart where cno=".$cno.")"))
					{ 
						header("location:cart.php");
						
					}else{
						
						echo "Some problem occured when your item was updated.\nPlease contact the system administrator";
					}
			}else{
	 
				echo "Some problem occured when your item was updated.\nPlease contact the system administrator";
			}	
			
		}
	    mysqli_close($link);
 ?>