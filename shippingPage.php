<!DOCTYPE html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <title>Shipping Page</title>

  <script language="javascript">
  <!--
   function delivDate(form){
     var today = new Date();
     var expectDate = form.shipping.selectedIndex;
     if(expectDate === 0){
     var newRegular = new Date(new Date(today).setDate(today.getDate() + 4));}
     else if(expectDate === 1){
     var newRegular = new Date(new Date(today).setDate(today.getDate() + 42));}
     else {
     var newRegular = new Date(new Date(today).setDate(today.getDate() + 1));}
     var expDelivDate;
     document.getElementById('expDelivDate').value = newRegular;
    // document.write(regular);

   }//end delivDate

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
			
	alert (str);
	bRetCode = true;  //Set true enables submitting form!!
    }
		
    return bRetCode;
		
  } //validate

//-->  
</script>

</head>

<body>



  <h1>Shipping</h1>
  <p><em>*</em> = required field </p>

  <h2>User's Information</h2>
  <form name="shipForm" method="post" onSubmit="return validate(shipForm);" action="billingPage.php">
    <?php	
	$error_message = "<td colspan=\"5\">The system is currently unavailable.</td>";
	$error_message2 = "here";
	// + Let us go look up the username and password.
	// + Establish a connection to the database
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

	// + Query the table

	$query  = "  SELECT FIRST_NAME, ";
	$query .= "         LAST_NAME, ";
	$query .= "         SHIPPING_ADDR_1, ";
	$query .= "         SHIPPING_ADDR_2, ";
	$query .= "         SHIPPING_CITY, ";
	$query .= "         SHIPPING_REGION, ";
	$query .= "         SHIPPING_POSTAL_CODE ";
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
				$SHIPPING_ADDR_1 = $returned_row[2];
				$SHIPPING_ADDR_2 = $returned_row[3];
				$SHIPPING_CITY = $returned_row[4];
				$SHIPPING_REGION = $returned_row[5];
				$SHIPPING_POSTAL_CODE = $returned_row[6];
			}//end else

		}//end while

	}//end else
    ?>
		


	
    <div class="row">
        <div class="large-9 small-centered columns">
            
                <div class="row">
                    <div class="small-2 columns">
                        <label class="inline right" for="first_name">*First name</label>
                    </div>
                    <div class="small-10 columns">
                        <input type="text" name="first_name" value ="<?php echo $FIRST_NAME; ?>" > </input>
                    </div>
                </div>    
                <div class="row">
                    <div class="small-2 columns">
                        <label class="inline right" for="last_name">*Last name</label>
                    </div>
                    <div class="small-10 columns">
                        <input type="text" name="last_name" value ="<?php echo $LAST_NAME; ?>" ></input>
                    </div>
                </div>    
                <div class="row">
                    <div class="small-2 columns">
                        <label class="inline right" for="address_1">*Address 1</label>
                    </div>
                    <div class="small-10 columns">
                        <input type="text" name="address_1" value ="<?php echo $SHIPPING_ADDR_1; ?>" ></input>
                    </div>
                </div>    
                <div class="row">
                    <div class="small-2 columns">
                        <label class="inline right" for="address_2">*Address 2</label>
                    </div>
                    <div class="small-10 columns">
                        <input type="text" name="address_2" value ="<?php echo $SHIPPING_ADDR_2; ?>" ></input>
                    </div>
                </div>    
 
                <div class="row">
                    <div class="small-2 columns">
                        <label class="inline right" for="town_city">*Town/city</label>
                    </div>
                    <div class="small-10 columns">
                        <input type="text" name="town_city" value ="<?php echo $SHIPPING_CITY; ?>" ></input>
                    </div>
                </div>    
                <div class="row">
                    <div class="small-2 columns">
                        <label class="inline right" for="state_province">*State/province</label>
                    </div>
                    <div class="small-5 columns">
                        <input type="text" name="state_province" value ="<?php echo $SHIPPING_REGION; ?>" ></input>
                    </div>
                    <div class="small-2 columns">
                        <label class="inline right" for="postcode_zip">*Postcode/zip</label>
                    </div>
                    <div class="small-3 columns">
                        <input type="text" name="postcode_zip" value ="<?php echo $SHIPPING_POSTAL_CODE; ?>" ></input>
                    </div>
                </div>    
                <div class="row">
                    <div class="small-2 columns">
                        <label class="inline right" for="country">*Country</label>
                    </div>
                    <div class="small-10 columns">
                        <input type="text" name="country"></input>
                    </div>
                </div> 
              
        </div>
    </div>



		<p>*Shipping Option:
      		<select name="shipping">
        	<option value="Regular">Regular</option>
        	<option value="Parcel">Parcel</option>
        	<option value="Express">Express</option>
      		</select>
 
    		</p>
  		<p><input type="button" name="button" value="Expected Delivery Date" onClick="delivDate(this.form)">
     		<input type="text" name="expDelivDate" id="expDelivDate" size="50" />
  		</p> 


  <p>
    <input type="submit" value="Submit" />
</form>



</body>

</html>