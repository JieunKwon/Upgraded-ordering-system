<?php  
@ob_start();
session_start();

	///////////////////////////////////////////////////////////////////////////////////////
	// Shopping website with Database
	// page : product.php 
	// page task : Show the product list from product table 
	// Written by : Jieun Kwon
	// Written Date : April 13, 2018
	// updated Date :  
	///////////////////////////////////////////////////////////////////////////////////////
		 
	// Login Session check 
    if(isset($_SESSION['login'])){
 
		// Database Connection 
		include 'db.php';

		// query
		$result=mysqli_query($link, "select * from product where Av_qty > 0 order by pid");
           
 
?>
<!DOCTYPE html>
<html>
	<head>
		<title> Jieun Kwon</title> 

		<!-- style sheet -->
		<link href = "css/main.css" type = "text/css" rel = "stylesheet"/> 
	</head>
	<body >
	<!-- Heading -->
		<h1>
		Item List
		</h1> 
		<form name="shoppingCart" method="post" >
		<!-- hidden value for adding cart -->
		<input type="hidden" value="" name="addPid">
		 <table border="0" align="center" class="tbl_prod_main">	
			<tr>
				<td colspan="2" height="20" class="txt_small" width="250"> 
				 Items
				</td>
				<td class="txt_small" width="100">	 
				Price 
				</td>
				<td class="txt_small" width="100">
				Quantity 
				</td> 
				<td class="txt_small" width="150">
				Add to Cart 
				</td> 
			</tr>
			<tr>
				<td height="1px" colspan="5" bgcolor="#2BA5BA"> 
				</td>
			</tr>	
<?php 
			// when items are availe to sell
			if(($row=mysqli_num_rows($result))>0)
            {
                while($arr=mysqli_fetch_array($result, MYSQLI_ASSOC))
                {
               
?>					
					
			<tr>
				<td width="100"> 
				<!-- item Image -->
				<img src="images/<?php echo $arr['pid']?>.jpg" width="100" >
				</td>
				<td class="txt_pname">
					 <?php echo $arr['pname']?>
				</td>
				<td>	 
					$<?php echo number_format($arr['unit_price'], 2, '.', '')?> 
				</td>
				<td> 
					<select class="txt_prod" name="qty<?php echo $arr['pid']; ?>" >
					<?php 
					for($i=1;$i<=$arr['Av_qty'];$i++)
					{
						 echo "<option value='". $i ."'> ". $i ." </option>";
					}
					?> 
					</select>
				</td> 
				<td>
					<input type="button" class="bt_cart" id="qty1" value="Add to Cart" width="20" onclick="javascript:addCart('<?php echo $arr['pid']; ?>', '<?php echo $arr['pname']; ?>')"> 
				</td> 
			</tr> 
			<tr>
				<td height="1px" colspan="5" bgcolor="#2BA5BA"> 
				</td>
			</tr>
			
<?php			
				// end of while
                }
   
			// no product items 
            }else{
?>
				<tr>
					<td colspan="5" height="50" > 
						Sorry, no items
					</td>
				</tr>
				<tr>
					<td height="1px" colspan="5" bgcolor="#2BA5BA"> 
					</td>
				</tr>

<?php
			// end of query
			 }
        
		 
?> 
 
			</table>
			 
		<!-- Table for Buttons --> 
			<table border="0" align="center"> 
			<tr>
				<td  height="40" width="600" align="center">  
					 <input type = "button" value="Home" class="bt_general" onclick="location.href='index.html';"> 
				       <input type = "button" value="Go Shopping Cart" class="bt_general" onclick="location.href='cart.php';"> 
				</td>
			</tr>
		<!-- END: Buttons --> 
		</table>
		</form>
		<!-- Extenal script -->
		<script src="scripts/shopping.js"></script> 
		
		<!-- Link to my web page --> 
		<footer> 
		<div align = "center" height="100">
			. April 2018 . Created by Jieun<br>
		</div>
		</footer>
	 
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