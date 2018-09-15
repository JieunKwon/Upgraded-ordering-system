<?php

//////////////////////////////////
//	DATABASE CONNECTION LINK 
//	Jieun Kwon
//	
//	April, 14 2018
//////////////////////////////////

// $link=mysqli_connect("dev.fast.sheridanc.on.ca","kwonjie_adm","shanghai7812!@","kwonjie_shopcart");
$link = mysqli_connect('localhost:3306', 'root', '', 'kwonjie_shopcart');
if(!$link){
	die('Could not connect: '.mysqli_error());
}

//  need to close every page after db connection
//	mysql_close($link);


			
			

?>