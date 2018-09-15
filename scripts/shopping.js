/*
		///////////////////////////////////////////////////////////////////////////////////////
		// SYST10199 - Web Programmimg 
		// Instructor: Amandeep Kaur
		// Assignment 6 : Shopping website with shopping cart 
		// page : shopping.js 
		// page task : login validations, calculate total order price,  
		// Written by : Jieun Kwon
		// Written Date : Feb 26, 2018
		// updated Date : April 14, 2018
		// 
		// updated: total price  = items + insurance(10% of item) - discount(5% of item) + Shipping + Gift + 13% tax
		// updated: saperate variables of prices due to print details 
		///////////////////////////////////////////////////////////////////////////////////////
--*/	
 
		// global vars
		// form name for product;
		var form_cart = document.shoppingCart;
		
		// index.html -> Login button onclick
		// validations check : User Id = abc and User Password = 123
		function login()
		{  
			// null check
			if((document.getElementById("userid").value == "") || (document.getElementById("userpw").value == ""))
			{
				alert("Please enter user id and user password.");
				document.getElementById("userid").focus();
			}
			else  
			{	
				
				document.loginForm.action = "login.php"; 
				document.loginForm.submit();
				// 
				// window.location.href = "product.php";  // move to product page
			}
		  
		}	

		// signup.html -> Sign up button onclick
		// validations check : User Id and User Password  are not null 
		function signup()
		{ 
			if((document.getElementById("userid").value == "") || (document.getElementById("userpw").value == ""))
			{
				alert("Please enter user id and user password.");
				document.getElementById("userid").focus();
			}
			else 
			{	
				
				document.register.action = "registerdb.php";
				document.register.submit();
			}
			
		}	
		
		/****************************************/
		// 
		// START for <Product> page
		//  
		/****************************************/
		
		// add cart by one item selected
		function addCart(pid, pname)
		{
			
			if(confirm("Do you want to add to cart?\nSelected Item : " + pname )){
				
				form_cart.addPid.value = pid;	 
				form_cart.action = "addCart.php"; 
				form_cart.submit();
			}
		}
		
		
		// update qty of cart
		function updateQty(cno, pname, qty){
			
			 
			if(confirm("Do you want to change the quantity?\nSelected Item : " + pname )){
				
				form_cart.upCno.value = cno;	 
				form_cart.qty.value = qty;	
				form_cart.action = "updateQty.php"; 
				form_cart.submit();
			}
		
		}
		
		// delete item from cart 
		function delQty(cno, pname, qty){
			
			if(confirm("Do you want to delete the item?\nSelected Item : " + pname )){
				
				form_cart.upCno.value = cno;	 
				form_cart.qty.value = qty;	
				form_cart.del.value = "1";
				form_cart.action = "updateQty.php"; 
				form_cart.submit();
			}
			
			
		}
		
		/****************************************/
		// 
		// START for <Shopping Cart> page
		//  
		/****************************************/
		
		// give a promo code randomly
		function get_promo_code()
		{
			document.getElementById("promo_code").value = "CP" + Math.ceil(Math.random() * 100000000);
		 
		}
		
		
		// calculate items' cost : when shopping cart page is onloaded, can call 
		function prod_init()
		{
			  
			var prod_price = (form_cart.price1.value * form_cart.qty1.value) + (form_cart.price2.value * form_cart.qty2.value);
			return prod_price;
		}
		
		// make reset form 
		function prod_reset()
		{
			document.shoppingCart.reset();
			//document.getElementById("cal_result").innerHTML = "CAD$" + prod_init().toFixed(2);
			prod_recal();
		}
		
		/****************************************/
		// prod_recal()
		// calculate total costs
		// 1. calculate for all options
		// 2. print price information to product.html
		// 3. add all price
		// 4. print total price
		/****************************************/
		function prod_recal()
		{
				
			// items' price
			var tot_price = 0;
			var items_price = 0;;
			var insurance_price = 0;
			var promo_price = 0;
			var delivery_price = 0;
			
			// items price
			items_price = form_cart.pre_price.value;
			
			//document.getElementById("rst_items").innerHTML = "$" + items_price.toFixed(2);
			
			// calculate total price 
			tot_price = parseFloat(items_price);
			
			
			// !! insurance fee should be calculate first,
			// items' price * 1.1 
			if(form_cart.insurance.checked == true)	
			{ 
				insurance_price = items_price * 0.1; 
				tot_price += insurance_price;
				document.getElementById("rst_insu").innerHTML = "$" + insurance_price.toFixed(2);		
			
			}else{
				document.getElementById("rst_insu").innerHTML = "$0.00";
			}
			 
			// * 0.95 for promotional code
			// and then, according to promotion, print discount price
			if(form_cart.promo_code.value != "")
			{
				promo_price = items_price * 0.05;  
				document.getElementById("rst_promo").innerHTML = "-$" + promo_price.toFixed(2);
				tot_price -= promo_price; 
				
			}else{
				document.getElementById("rst_promo").innerHTML = "$0.00";
			} 
			
			// + delivery cost
			if(form_cart.delivery[0].checked)
			{ 
				delivery_price = parseFloat(form_cart.delivery[0].value); 
				
			}else if(form_cart.delivery[1].checked){
				
				delivery_price = parseFloat(form_cart.delivery[1].value); 
			}
			
			tot_price += delivery_price
			document.getElementById("rst_ship").innerHTML = "$" + delivery_price.toFixed(2);
	  	 
			// + 9.99 for gift wrapping 
			if(form_cart.gift.checked == true)	
			{  
				document.getElementById("rst_gift").innerHTML = "$" + parseFloat(form_cart.gift.value).toFixed(2);
				tot_price += parseFloat(form_cart.gift.value);
				 
			}else{
				document.getElementById("rst_gift").innerHTML = "$0.00";
			}
	 	
			// Total before tax: 
			document.getElementById("rst_price_all").innerHTML = "CAD $" + tot_price.toFixed(2);
		 	
			// * 1.13 for tax
			document.getElementById("rst_tax").innerHTML = "CAD $" + (tot_price * 0.13).toFixed(2);
			
			// TOTAL with tax
			tot_price *= 1.13;
			 
	 
			// addition insurance
			tot_price += insurance_price;
			
			// print result
			document.getElementById("rst_total").innerHTML = "CAD $" + tot_price.toFixed(2);
		 
		}
		
		// validations and submit form
		function prod_submit()
		{ 
			 
			// submit order
			if(confirm("Do you want to order?"))
			{ 
				form_cart.action = "result.html";
				form_cart.submit();
			}
			 
		}
		
		/***********************************************
		// Confirm form : reset & submit
		// validations for fields
		************************************************/
		
		// form clear
		function confirm_reset(){
			document.orderConfirm.reset();
		}
		
		// submit
		function confirm_submit()
		{
			var formname = document.orderConfirm;  // form name
			var chkstr = ""; 					// temporary variable for checking string 
			
			// name checck
			if(formname.name.value == ""){
					
				document.getElementById("rst_total").innerHTML = "Please enter your name to order items";
				formname.name.focus();
				return;
			}
			
			// phone number check 
			if(formname.phone.value == ""){
					
				document.getElementById("rst_total").innerHTML = "Please enter your phone number for delivery items";
				formname.phone.focus();
				return;
				
			}else{
			
				chkstr = formname.phone.value;
				// if one character is not number value. "-" is available
				for(var i = 0; i < chkstr.length; i++)
				{
					if(isNaN(chkstr.charAt(i)))
					{
						if((chkstr.charAt(i) != "-") && chkstr.charAt(i) != ".")
						{
							document.getElementById("rst_total").innerHTML = "Please enter your phone number correctly";
							formname.phone.focus();
							return;
						}
					}
					
				}
			}
			
			// Email check
			chkstr = formname.email.value;
			if(chkstr == ""){
					
				document.getElementById("rst_total").innerHTML = "Please enter your email address for getting order details";
				formname.email.focus();
				return;
				
			}else{
				 
				if(chkstr.indexOf("@") < 0 || chkstr.indexOf(".") < 0)
				{
					document.getElementById("rst_total").innerHTML = "Please enter your email address correctly";
					formname.email.focus();
					return;
				}
			}
			
			// address check
			if(formname.address.value == ""){
					
				document.getElementById("rst_total").innerHTML = "Please enter your address for order";
				formname.address.focus();
				return;
			}
			
			if(confirm("Are you sure you want to submit this order?"))
			{
				formname.action = "result.html";
				formname.submit();
			}
		}
		
		
		 