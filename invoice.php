<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type"
		content="text/html; charset=iso-8859-1" />
	<title>INVOICE</title>
</head>
<body>
	<h2>Week 7 Create Order</h2>
	<p>
	<table cellpadding="5">
	<?php
		
		$error_message = "System temporarily unavailable";
		
		// + Establish a connection to the database
		$server   = "localhost:3306";
		$username = "root";
		
		$link = mysqli_connect($server, $username);

		if ( !( mysqli_connect( $server, $username )))
		{
			die( $error_message );
		}
		
		// Select the schema in the database
		$database = "laurare2_student8";
		if ( !( mysqli_select_db( $link, $database )))
		{
			die( $error_message );
		}//end if

		// + Loop through each POST'ed parameter
		foreach( $_POST as $ParamName => $ParamValue )
		{
	        	//The name of the parameter
			$ParamName = urldecode( $ParamName );

			// The value of the parameter
			$ParamValue = urldecode( $ParamValue );

			// + We only want those parameters that are actually
			//   the quantities of products			
			if (( strpos( $ParamName, "productqty_" ) === 0 ) &&
			    	( $ParamValue > 0 ))
			    	
			{
		
	
			
				$parameterCount++;
				
				// + If we have at least one product, start the
				//   table.
				if ( $parameterCount == 1 )
				{
					echo "<table cellpadding=\"5\">";
					echo "<tr style=\"font-weight:bold;\">";
					echo "<td> </td>";
					echo "<td>Product Name</td>";
					echo "<td>Quantity Ordered</td>";
					echo "<td>Unit Price</td>";
					echo "<td>Unit Shipping</td>";
					echo "<td>Extended Price</td>";
					echo "</tr>";
				}//end if
				
				echo "<tr>";
				echo "<td>" . $parameterCount . "</td>";
	
				// + Remove the prefix from the parameter name
				//   and use this as the product ID.
				$ProductID = substr( $ParamName, 11 );
				
				// + Get information about the product from
				//   the database.
				$query  = "  SELECT PROD_NAME, ";
				$query .= "         PROD_DESCRIP, ";
				$query .= "         PROD_CATEGORY, ";
				$query .= "         PROD_COST, ";
				$query .= "         PROD_QTY_ON_HAND, ";
				$query .= "         PROD_SHIP_COST ";
				$query .= "    FROM product ";
				$query .= "   WHERE PROD_ID = '" . $PROD_ID . "' ";
				$query_result = mysqli_query( $link, $query );
				
				if ( $query_result == FALSE )
				{
					die( $error_message  );
				}//end if
				
				$returned_row = mysqli_fetch_row( $query_result );


				$PRODNAME  = $returned_row[ 0 ];
				$PRODCOST    = $returned_row[ 3 ];
				$PRODSHIPCOST = $returned_row[ 5 ];
	
				// + Display the product in the table.
				echo "<td>" . $PRODNAME  . "</td>";
				echo "<td>" . $ParamValue   . "</td>";
				echo "<td>" . $PRODCOST    . "</td>";
				echo "<td>" . $PRODSHIPCOST . "</td>";
				echo "<td>" . ( $PRODCOST + $PRODSHIPCOST ) * $ParamValue . "</td>";
				
				// + Increment the order total by the amount of
				//   this product.
				$OrderTotal += ( $PRODCOST + $PRODSHIPCOST ) * $ParamValue;
				
				// + Add a row to the OrderLine table for this
				//   product.
				$query  = "INSERT ";
				$query .= "  INTO orderLine( ";
				$query .= "          ORDER_ID, ";
				$query .= "          PROD_ID, ";
				$query .= "          QUANTITY_ORDERED, ";
				$query .= "          QUANTITY_SHIPPED, ";
				$query .= "          UNIT_PRICE, ";
				$query .= "          UNIT_SHIPPING_PRICE ";
				$query .= "          ) ";
				$query .= "VALUES ( ";
				$query .= "         $CurrentOrderNumber, ";
				$query .= "         '" . $PROD_ID . "', ";
				$query .= "         $ParamValue, ";
				$query .= "         $ParamValue, ";
				$query .= "         $PRODCOST, ";
				$query .= "         $PRODSHIPCOST ";
				$query .= "       ) ";
				$query_result = mysqli_query( $link, $query );
				
				if ( $query_result == FALSE )
				{
					die( $error_message );
				}//end if
			 }//END IF
			
			echo "</tr>";
		
		
			if ( $parameterCount == 0 )
			{
				echo "No parameters found.";
			}
			else
			{
				// + If at least one product was ordered, display a final row
				//   in the table with the order total.
				echo "<tr style=\"font-weight:bold;\">";
				echo "<td> </td>";
				echo "<td colspan=\"4\">Total for Order # $CurrentOrderNumber</td>";
				echo "<td style=\"background-color:#FFFFCC;\">" . $OrderTotal . "</td>";
				echo "</tr>";
				echo "</table>";
			
				// + Update the OrderHeader table with the actual order total
				//   now that we have looped through all of the products.
				$query  = "UPDATE orderheader ";
				$query .= "   SET ORDER_TOTAL = $OrderTotal ";
				$query .= " WHERE ORDER_ID = $CurrentOrderNumber ";
				$query_result = mysqli_query( $link, $query );
			
				if ( $query_result == FALSE )
				{
					die( $error_message );
				}//end if
			}//END ELSE
		}//END FOR	
	?>
	</table>
	</p>
</body>
</html>