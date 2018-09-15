<!--
		///////////////////////////////////////////////////////////////////////////////////////
		// Shopping website with shopping cart 
		// page : index.html 
		// page task : Sign up Form -> save in db 
		// Written by : Jieun Kwon
		// Written Date : Feb 26, 2018
		// updated Date : April 14, 2018
		// updated : database connection
		///////////////////////////////////////////////////////////////////////////////////////
-->
<?php 
@ob_start();
 
        $uid = $_REQUEST['userid'];
        $uname = $_REQUEST['uname'];
        $email = $_REQUEST['email'];
        $addr = $_REQUEST['addr'];
        $pass = $_REQUEST['userpw'];
        
        // Database Connection 
		include 'db.php';
		
        // query
        $result=mysqli_query($link, "select * from registration where userid='".$uid."'");
        
        if(($row=mysqli_num_rows($result))>0)
        {
            $msg = "Your name already exist, please try again.";
			
        }else{
            if(mysqli_query($link, "insert into registration values('".$uid."','".$uname."','".$email."','".$addr."','".$pass."')"))
            {
                $msg = "Your registeration is successfully completed";
                  
            }else{
                $msg = "Your signup attempt was unsuccessful";
            }
            
        }
        
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
		Sign Up
		</h1> 
		 
		 <form name="loginForm" method="post" >
		 <table border="0" align="center" class="tbl_signup">
			<tr>
				<td height="20">  
					 
				</td>
			</tr>
			<tr>
				<td height="50" class="txt_title"> 
					 <?php echo $msg;?>
				</td> 
			</tr>
			 
			<tr>
				<td height="20"> 
				</td>
			</tr>
			<!-- Buttons -->  
			<tr>
				<td align="center"> 
					 <input type = "button" value="Sign In" class="bt_general" onclick="document.location.href='index.html';">
					 <input type = "button" value="Signup Again" class="bt_general" onclick="document.location.href='signup.html';">
				</td>
			</tr>
		<!-- END: Buttons -->
		</table>
		</form>
		
		<!-- Extenal script -->
		<script src="scripts/shopping.js"></script> 
		
	</body>
</html>
