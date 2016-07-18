<!DOCTYPE html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <title>Billing Page</title>  

 <script language="javascript">
 <!--

		function isChecked (checkboxObj)
		{
		    checkBool = false;
		    var check = document.getElementsByName("card");
		    for (var i =0; i<check.length; i++){
                     if(check[i].checked)
			checkBool = true;
                    }
		    return checkBool;
		} //isChecked function



  function isBlankField (textObj)
  {
    if (textObj.value == "")
      return true;
    else
      return false;
  }//end isBlankField

  function validate (formObj)
  {
    sErrText = '';     //Build error message - present all errors
    bRetCode = false;  //Set to true if pass all validations
	
    //Validate text fields
    if (isBlankField (formObj.first_name))
	sErrText += "\nFirst Name is required";
    if (isBlankField (formObj.last_name))
	sErrText += "\nLast name is required";
    if (isBlankField (formObj.address_1))
	sErrText += "\nAddress 1 is required";
    if (isBlankField (formObj.address_2))
	sErrText += "\nAddress 2 is required";
    if (isBlankField (formObj.address_3))
	sErrText += "\nAddress 3 is required";
    if (isBlankField (formObj.town_city))
	sErrText += "\nTown_City is required";
    if (isBlankField (formObj.state_province))
	sErrText += "\nState_Province is required";
    if (isBlankField (formObj.postcode_zip))
	sErrText += "\nPostcode is required";
    if (isBlankField (formObj.country))
	sErrText += "\nCountry is required";

    //Validate if a Credit Card Company is checked
    checkBool = isChecked(formObj);
    if (checkBool == false)
    {
        sErrText += "\nCard Selection is required";
    }	
    if (isBlankField (formObj.cardNumber))
	sErrText += "\nCard Number is required";
    if (isBlankField (formObj.ccv2))
	sErrText += "\nCCV2 is required";

	
    //If there are validation errors, sErrText holds them.
    if (sErrText.length > 0)
	alert ("Sorry, missing data:" + sErrText);
    else
    {
	str = "\nHere is your input:";
	str += "\nFirst Name: " + formObj.first_name.value;
	str += "\nLast Name: " + formObj.last_name.value;
	str += "\nAddress 1: " + formObj.address_1.value;
	str += "\nAddress 2: " + formObj.address_2.value;
	str += "\nAddress 3: " + formObj.address_3.value;
	str += "\nCity: " + formObj.town_city.value;
	str += "\nState or Province: " + formObj.state_province.value;
	str += "\nZip Code: " + formObj.postcode_zip.value;
	str += "\nCountry: " + formObj.country.value;
        str += "\nCredit Card: " + formObj.card.value;
	str += "\nCard Number: " + formObj.cardNumber.value;
	str += "\nCCV2: " + formObj.ccv2.value;
			
	alert (str);
	bRetCode = true;  //Set true enables submitting form!!
    }
		
    return bRetCode;
		
  } //validate

//-->  
</script>

<?php
	$shipping = $_POST['shipping'];
	$expDelivDate = $_POST['expDelivDate'];
	$error_message = "System error";

	//connect to database
	$server   = "localhost:3306";
	$username = "root";

	$link = mysqli_connect($server, $username);

	if ( !( mysqli_connect( $server, $username )))
	{
		die( $error_message );
	}

	$link = mysqli_connect($server, $username);
	// Select the schema in the database
	$database = "laurare2_student8";
	mysqli_select_db($link, $database);
	$custID = "987654";
	$query = "INSERT INTO orderheader(CUSTOMER_ID, ORDER_DATE, SHIPPING_METHOD, ESTIMATED_DELIVERY_DATE)
		  VALUES ('$custID', 'CURRENT_TIMESTAMP()', '$shipping', '$expDelivDate')";

	//I have no idea why the code below doesn't work but the above code works!!!!!

	//$query  = "INSERT ";
	//$query .= "  INTO orderHeader( ";
	//$query .= "         CUSTOMER_ID,";
	//$query .= "         ORDER_DATE, ";
	//$query .= "         SHIPPING_METHOD, ";	
	//$query .= "         ESTIMATED_DELIVERY_DATE ";
	//$query .= "         ) ";
	//$query .= "VALUES ( ";
	//$query .= "         $custID ";
	//$query .= "         CURRENT_TIMESTAMP() ";
	//$query .= "         $shipping, ";
	//$query .= "         $expDelivDate ";
	
	//$query .= "       ) ";

	$query_result = mysqli_query( $link, $query );
	if ( $query_result == FALSE )
        {
		die( $error_message );
	}

?>



<?php
        $query  = "  SELECT FIRST_NAME, ";
	$query .= "         LAST_NAME, ";
	$query .= "         BILL_ADDR_1, ";
	$query .= "         BILL_ADDR_2, ";
	$query .= "         BILL_CITY, ";
	$query .= "         BILL_REGION, ";
	$query .= "         BILL_POSTAL_CODE ";
	$query .= "    FROM customerData ";
	$query .= "ORDER BY CUSTOMER_ID";
	$query_result = mysqli_query( $link, $query );
				
	if ( $query_result == FALSE )
	{
		die ( $error_message2 );
	}

	else{
		while ($returned_row = mysqli_fetch_row( $query_result))
		{
			if ( $query_result == FALSE )
			{
				die ( $error_message2 );
			}//end if

			else
			{

				$FIRST_NAME = $returned_row[0];
				$LAST_NAME = $returned_row[1];
				$BILL_ADDR_1 = $returned_row[2];
				$BILL_ADDR_2 = $returned_row[3];
				$BILL_CITY = $returned_row[4];
				$BILL_REGION = $returned_row[5];
				$BILL_POSTAL_CODE = $returned_row[6];
			}//end else

		}//end while

	}//end else
?>



<?php
	
	$error_message = "System error";
	$error_message2 = "still not working";

	//connect to database
	$server   = "localhost:3306";
	$username = "root";

	$link = mysqli_connect($server, $username);

	if ( !( mysqli_connect( $server, $username )))
	{
		die( $error_message );
	}

	$link = mysqli_connect($server, $username);
	// Select the schema in the database
	$database = "cs482";
	mysqli_select_db($link, $database);
	
	//$CUSTOMER_ID = "987654";
	$BILL_TO_FIRST_NAME = $FIRST_NAME;
	$BILL_TO_LAST_NAME = $LAST_NAME ;
	$BILL_TO_ADDRESS1 = $BILL_ADDR_1 ;
	$BILL_TO_ADDRESS2 = $BILL_ADDR_2 ;
	$BILL_TO_CITY = $BILL_CITY ;
	$BILL_TO_REGION = $BILL_REGION ;
	$BILL_TO_POSTAL_CODE = $BILL_POSTAL_CODE ;

	//echo "$FIRST_NAME"; value works!!


	
	//practice program works perfectly, but this refuses to run!!!!
	$sql = "UPDATE orderHeader SET BILL_TO_FIRST_NAME='$BILL_TO_FIRST_NAME', BILL_TO_LAST_NAME='$BILL_TO_LAST_NAME', BILL_TO_ADDRESS#1 ='$BILL_TO_ADDRESS1', BILL_TO_ADDRESS#2 ='$BILL_TO_ADDRESS2', BILL_TO_CITY = '$BILL_TO_CITY', BILL_TO_REGION = '$BILL_TO_REGION', BILL_TO_POSTAL_CODE = '$BILL_TO_POSTAL_CODE'	  
		WHERE CUSTOMER_ID = '$custID'";
	

	
	$query_result = mysqli_query( $link, $sql );
	if ( $query_result == FALSE )
        {
		die( $error_message2 );
	}
	
?>


</head>

<body>

  <h1>Checkout</h1>
  <p><em>*</em> = required field </p>

  <h2>Billing Information</h2>





  <form name="billForm" method="get" onSubmit="return validate(billForm);" action="index.php">




    <div class="row">
        <div class="large-9 small-centered columns">
            
                <div class="row">
                    <div class="small-2 columns">
                        <label class="inline right" for="first_name">First name*</label>
                    </div>
                    <div class="small-10 columns">
                        <input type="text" name="first_name" value = "<?php echo $FIRST_NAME;?>" ></input>
                    </div>
                </div>    
                <div class="row">
                    <div class="small-2 columns">
                        <label class="inline right" for="last_name">Last name*</label>
                    </div>
                    <div class="small-10 columns">
                        <input type="text" name="last_name" value = "<?php echo $LAST_NAME;?>"></input>
                    </div>
                </div>    
                <div class="row">
                    <div class="small-2 columns">
                        <label class="inline right" for="address_1">Address 1*</label>
                    </div>
                    <div class="small-10 columns">
                        <input type="text" name="address_1" value = "<?php echo $BILL_ADDR_1;?>"></input>
                    </div>
                </div>    
                <div class="row">
                    <div class="small-2 columns">
                        <label class="inline right" for="address_2">Address 2*</label>
                    </div>
                    <div class="small-10 columns">
                        <input type="text" name="address_2" value = "<?php echo $BILL_ADDR_2;?>"></input>
                    </div>
                </div>    
                
                <div class="row">
                    <div class="small-2 columns">
                        <label class="inline right" for="town_city">Town/City*</label>
                    </div>
                    <div class="small-10 columns">
                        <input type="text" name="town_city" value = "<?php echo $BILL_CITY;?>"></input>
                    </div>
                </div>    
                <div class="row">
                    <div class="small-2 columns">
                        <label class="inline right" for="state_province">State/Province*</label>
                    </div>
                    <div class="small-5 columns">
                        <input type="text" name="state_province" value = "<?php echo $BILL_REGION;?>"></input>
                    </div>
                    <div class="small-2 columns">
                        <label class="inline right" for="postcode_zip">Postcode/zip*</label>
                    </div>
                    <div class="small-3 columns">
                        <input type="text" name="postcode_zip" value = "<?php echo $BILL_POSTAL_CODE;?>"></input>
                    </div>
                </div>    
                <div class="row">
                    <div class="small-2 columns">
                        <label class="inline right" for="country">Country*</label>
                    </div>
                    <div class="small-10 columns">
                        <input type="text" name="country"></input>
                    </div>
                </div> 
              
        </div>
    </div>
  <h2>Payment Information</h2>

  <p>
    <input name="card" type="radio" value="Mastercard"/>
    Mastercard
  </p>
  <p>
    <input name="card" type="radio" value="VISA"/>
    VISA
  </p>
  <p>
    <input name="card" type="radio" value="AmericanExpress"/>
    American Express
  </p>
  <p>
    <input name="card" type="radio" value="Discover"/>
    Discover
  </p>
<div class="row">
  <div class="small-2 columns">
    <label class="inline right" for="cardNumber">Card Number*</label>
  </div>
  <div class="small-16 columns">
    <input type="text" name="cardNumber" maxlength="16"></input>
  </div>

  <div class="small-2 columns">
    <label class="inline right" for="ccv2">Security Code (CCV2)*</label>
  </div>
  <div class="small-16 columns">
    <input type="text" name="ccv2" maxlength="4"></input>
  </div>
</div>

  <p>Expiration Date <em>*</em> 
     <select name="ExpirationDate">
        <option value="January">January</option>
        <option value="February">February</option>
        <option value="March">March</option>
        <option value="April">April</option>
        <option value="May">May</option>
        <option value="June">June</option>
        <option value="July">July</option>
        <option value="August">August</option>
        <option value="September">September</option>
        <option value="October">October</option>
        <option value="November">November</option>
        <option value="December">December</option>
    </select>
    <select name="Year">
        <option value="2005">2005</option>
        <option value="2006">2006</option>
        <option value="2007">2007</option>
        <option value="2008">2008</option>
        <option value="2009">2009</option>
        <option value="2010">2010</option>
        <option value="2011">2011</option>
        <option value="2012">2012</option>
        <option value="2013">2013</option>
        <option value="2014">2014</option>
        <option value="2015">2015</option>
    </select>
  </p>







  <p>
  <input type="submit" value="Submit" />
  </p>
  

</form>
</body>
</html>