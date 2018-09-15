<?php
@ob_start();
session_destroy();
session_start();
 
        $uid = $_REQUEST['uid'];
        $pass = $_REQUEST['upw'];
        
        // Database Connection 
		include 'db.php';
		
        // query
        $result=mysqli_query($link, "select * from registration where userid='".$uid."' and password='".$pass."'");
        
		// find userid
        if(($row=mysqli_num_rows($result))>0)
        { 
            $_SESSION['login'] = $uid;
            header("location:product.php");
			
		// no userid
        }else{
           
		   // go back to index page
            header("location:index.html");
        
        }
        
?>
     