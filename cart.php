<?php 
@ob_start();
session_start();
 
	///////////////////////////////////////////////////////////////////////////////////////
	// Shopping website with Database
	// page : cart.php 
	// page task : shopping cart shows the selected items, other options for choosing, and total price
	// Written by : Jieun Kwon
	// Written Date : April 13, 2018
	// updated Date :  
	///////////////////////////////////////////////////////////////////////////////////////
 
	// session check
   if(isset($_SESSION['login'])){
    
		// Database Connection 
		include 'db.php';
		
		//id
		$uid = $_SESSION['login'];
		
		// query
		$result=mysqli_query($link, "SELECT cart.cno, cart.pid, cart.qty, product.Av_qty, product.pname, product.unit_price FROM cart, product WHERE userid ='".$uid."' and cart.pid = product.pid");

?>
<html>
	<head>
		<title> Jieun Kwon</title> 

		<!-- style sheet -->
		<link href = "css/main.css" type = "text/css" rel = "stylesheet"/> 
	</head>
	<body >
	<!-- Heading -->
		<h1>
		Shopping Cart
		</h1> 
		<!-- Form (shoppingCart) Start -->
		 <form name="shoppingCart" method="post" >
		<!-- hidden value for adding cart -->
		<input type="hidden" value="" name="upCno">
		<input type="hidden" value="" name="qty">
		<!-- delete mode -->
		<input type="hidden" value="" name="del">
		
		 <table border="0" align="center" class="tbl_cart_main">	
			<tr>
				<td height="20" class="txt_small" colspan="2" width="320"> 
				 Items
				</td>
				<td class="txt_small" width="80">	 
				Price  
				</td> 
				<td class="txt_small" width="200">	  
				Quantity 
				</td> 
			</tr>
			<tr>
				<td height="1px" colspan="4" bgcolor="#2BA5BA"> 
				</td>
			</tr>	
<?php
			// cart have items
			if(($row=mysqli_num_rows($result))>0)
            {
				// items' total price 
				$total_price = 0;
				while($arr=mysqli_fetch_array($result, MYSQLI_ASSOC))
                { 
				  // items' total price 
				  $total_price += $arr['unit_price']*$arr['qty']; 
				 
?>			
					<tr>
						<td height="30">  
						<!-- item's image -->
							<img src="images/<?php echo $arr['pid']?>.jpg" width="40" >
						</td>
						<td>
						<!-- item's name -->
							<b><?php echo $arr['pname']?></b>
						</td>
						<td>	 
						<!-- item's unit price -->
							$<?php echo number_format($arr['unit_price'], 2, '.', '');?>
						 
							<input type="hidden" id="price1" name="" value="<?php echo $arr['unit_price']?>" > 
						</td>
						<td> 
						
						<!-- item's qty -->
							<select class="txt_prod" name="upqty<?php echo $arr['cno']; ?>" size="1" width="70px">
							<?php 
							// qty check : select box can open by the available item qty 
							for($i=1;$i<=$arr['Av_qty'] + $arr['qty'];$i++)
							{
								echo "<option value='". $i ."'";
								if($arr['qty'] == $i) 
									echo " selected";
								echo "> ". $i ." </option>";
							}
							?> 
							</select>
					 
							<!-- buttons for update and delete -->
							<input type="button" class="bt_small" id="qty1" value="Update" width="10" onclick="javascript:updateQty('<?php echo $arr['cno']; ?>', '<?php echo $arr['pname']; ?>', '<?php echo $arr['qty']?>')"> 
							<input type="button" class="bt_small" id="qty1" value="Delete" width="10" onclick="javascript:delQty('<?php echo $arr['cno']; ?>', '<?php echo $arr['pname']; ?>', '<?php echo $arr['qty']?>')"> 
						
						</td> 
					</tr>
<?php
				// end of while
				}
?>			 
		 <tr>
		 <td colspan = "4"> 
		<table width="600">	
			<tr>
				<td height="20" colspan="3"> 
				</td>
			</tr>
			<tr>
				<td height="20" class="txt_small" width="150"> 
				 Other options
				</td>
				<td class="txt_small" colspan="2">	  
				</td> 
			</tr>
			<tr>
				<td height="1px" colspan="3" bgcolor="#2BA5BA"> 
				</td>
			</tr>	
			<tr>
				<td height="40"> 
				<!-- promotional code -->
				# Promotional code
				</td>
				<td colspan="2">	 
				 <input type="text" class="txt_prod" id="promo_code" value="" size="15" >
				 <input type = "button" value="Get code" class="bt_small" onclick="get_promo_code();">
			       <br>5% of discounts of original items price 
				</td> 
			</tr> 
			<tr>
				<td height="40" >  
				<!-- Delivery options -->
				# Delivery options
				</td>
				<td colspan="2">
					<input type="radio" name="delivery" value="4.99" checked> $4.99 (standard) 
					<input type="radio" name="delivery" value="19.99" > $19.99 (expedited)
				</td> 
			</tr>
			<tr>
				<td height="40" >  
				<!-- Gift wrap -->
				# Gift wrapping
				</td>
				<td colspan="2"> 
					<input type="checkbox" name="gift"  value="9.99" > $9.99  
				</td> 
			</tr>
			<tr>
				<td height="40" >  
				<!-- Insurance -->
				# Insurance
				</td>
				<td colspan="2">
					<input type="checkbox" id="insurance" value="1" > 10% of the purchase price before tax and discounts
			</tr>
			<tr>
				<td height="40" >  
				<!-- rewards membership  -->
				# Rewards membership 
				</td>
				<td colspan="2">
					<input type="checkbox" id="rewards" value="1" > 1 point per $10
			</tr>
			<tr>
				<td height="20" colspan="3"> 
				</td>
			</tr>
			<tr>
				<td height="20" class="txt_small" width="150"> 
				# Order Summary
				</td>
				<td class="txt_small" colspan="2">	  
				</td> 
			</tr>
			<tr>
				<td height="1px" colspan="3" bgcolor="#2BA5BA"> 
				</td>
			</tr>
			<tr>
				<td colspan="3" align="center"> 
					<p class="txt_small" align="center">If you change options, click Recalculate button.</p>
													
					<!-- print the result for calculating total cost -->
					<table width="260" class="tbl_result" border=0>
						<tr height="15"> 
							<td align="left" width="130"> 
								Items: 
							</td>
							<td align="right" width="130">
							<input type="hidden" value="<?php echo $total_price;?>" id="pre_price">
							<div id="rst_items">$<?php echo number_format($total_price, 2, '.', '');?> </div>
							</td>
						</tr>
						<tr>
							<td align="left"> 
								Insurance: 
							</td>
							<td align="right">
							<div id="rst_insu">$0.00</div>
							</td>
						</tr>
						<tr>
							<td align="left"> 
								Discount: 
							</td>
							<td align="right">
							<div id="rst_promo">$0.00</div>
							</td>
						</tr>
					      <tr>
							<td align="left"> 
								Shipping: 
							</td>
							<td align="right">
							<div id="rst_ship">$4.99</div>
							</td>
						</tr>
						<tr>
							<td align="left"> 
								Gift Wrapping: 
							</td>
							<td align="right">
							<div id="rst_gift">$0.00</div>
							</td>
						</tr>
						<tr height="1"> 
							<td align="center" colspan="2">
							----------------------------------------------
							</td>
						</tr>
						<tr height="15"> 
							<td align="left" width="160"> 
								Total before tax: 
							</td>
							<td align="right"> 
								<div id="rst_price_all">CAD $<?php echo number_format($total_price + 4.99, 2, '.', '')?> </div>
							</td>
						</tr>
						 <tr>
							<td align="left"> 
								 GST/HST(13%): 
							</td>
							<td align="right">
							<div id="rst_tax">CAD $<?php echo number_format(($total_price + 4.99)*0.13, 2, '.', '')?></div>
							</td>
						</tr>
						 <tr>
							<td align="left" class="rst_total"> 
								Order Total  : 
							</td>
							<td align="right">
							<p id="rst_total" class="rst_total">CAD $<?php echo number_format(($total_price + 4.99)*1.13, 2, '.', '')?></p>
							</td>
						</tr> 
					</table>
					<!-- END :  total cost -->
				</td>
			</tr> 
		</table>
		</td>
		</tr>
		</table>
			 
		<!-- Table for Buttons --> 
			<table border="0" align="center"> 
			<tr>
				<td  height="40" width="700">  
					<input type = "button" value="Go shopping" class="bt_general" onclick="location.href='product.php';"> 
					 <input type = "button" value="Reset" class="bt_general" onclick="prod_reset();">
					 <input type = "button" value="Recalculate" class="bt_general" onclick="prod_recal();">
				       <input type = "button" value="Checkout" class="bt_general" onclick="prod_submit();"> 
				</td>
			</tr>
		<!-- END: Buttons -->
<?php
			// else of cart result
			}else{ 
?>                     
				<tr><td height='40' colspan='4' align='center'>
						<br>Your cart is empty
						<br><br>
						<input type = 'button' value='Go shopping' class='bt_general' onclick="location.href='product.php';">
						<br>
					</td>
					</tr>
				</table>
<?php			}
			
			mysqli_close($link);
	
?>
			
		</form>
		</table>
		
		<!-- Extenal javascript -->
		<script src="scripts/shopping.js"></script> 

	</body>
</html>

<?php

// session check - not login 
}else{
	echo "some problem occured";
?>
	<input type = "button" value="Home" class="bt_general" onclick="location.href='index.html';"> 
<?php
}
?>
