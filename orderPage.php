<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type"
		content="text/html; charset=iso-8859-1" />
	<title>Week 7 | Product Picking</title>
	
	<script type="text/javascript">
		function ValidateQty( in_qtyentry )
		{
			if ( parseInt( in_qtyentry.value ) >= 0 &&
				 parseInt( in_qtyentry.value ) <= 99
			    )
			{
				in_qtyentry.style.backgroundColor = "#FFFFCC";				
			}
			else
			{
				in_qtyentry.style.backgroundColor = "#FFCC00";
			}
		}
		
		function UpdateExtPrice( in_qtyentry, in_unitprice, in_shipping, out_extprice )
		{
			if ( parseInt( in_qtyentry.value ) > 0 &&
			     parseInt( in_qtyentry.value ) <= 99
			   )
			{
				out_extprice.value = in_qtyentry.value * ( in_unitprice + in_shipping );
			}
			else
			{
				out_extprice.value = "";
			}
		}
		
		function MoveExtPriceFocus( in_qtyentry, in_updatebutton )
		{
			if ( parseInt( in_qtyentry.value ) >= 0 &&
				 parseInt( in_qtyentry.value ) <= 99
			    )
			{
				in_updatebutton.focus();
			}
			else
			{
				in_qtyentry.focus();
			}
		}
		
	</script>
</head>
<body onload="SetInitialFocus()">
	<h2>Week 7 Product Picking</h2>
	<p>
	<form name="theForm" action="" method="POST">
		<table border="0" width="100%" cellpadding="5">
			<tr>
				<td>Quantity</td>
				<td>Product Description</td>
				<td>Unit Price</td>
				<td>Shipping</td>
				<td>Extended Price</td>
				<td> </td>
			</tr>
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
				}//end if

		
				// Select the schema in the database
				$database = "laurare2_student8";
				mysqli_select_db($link, $database);
				
	
				// + Query the table
				// + Because we are querying on the primary key, we are
				//   guaranteed to return at most one row
				$query  = "  SELECT PROD_ID, ";
				$query .= "         PROD_NAME, ";
				$query .= "         PROD_DESCRIP, ";
				$query .= "         PROD_CATEGORY, ";
				$query .= "         PROD_COST, ";
				$query .= "         PROD_QTY_ON_HAND, ";
				$query .= "         PROD_SHIP_COST ";
				$query .= "    FROM product ";
				$query .= "ORDER BY PROD_NAME";
				$query_result = mysqli_query( $link, $query );
				
				if ( $query_result == FALSE )
				{
					die ( $error_message );
				}
				else
				{
					$rowCounter = 1;
					while ( $returned_row = mysqli_fetch_row( $query_result ))
					{
						if ( $query_result == FALSE )
						{
							die( $error_message );
						}
						else
						{
							$PROD_ID           = $returned_row[ 0 ];
							$PROD_NAME         = $returned_row[ 1 ];
							$PROD_COST         = $returned_row[ 4 ];
							$PROD_SHIP_COST    = $returned_row[ 6 ];
							
							if ( $rowCounter == 1 )
							{
								echo "<script type=\"text/javascript\">";
								echo "	function SetInitialFocus() ";
								echo "	{ ";
								echo "		document.forms[0].productqty_$PROD_ID.focus();";
								echo "		document.forms[0].productqty_$PROD_ID.select();";
								echo "	} ";
								echo "</script>";
							}
							$rowCounter ++;
							
							echo "<tr>";
							echo "	<td width=\"25\">";
							echo "		<input style=\"background-color:#FFFFCC;\"" ;
							echo "			type=\"text\" name=\"productqty_$PROD_ID\" width=\"3\" value=\"0\" size=\"3\"";
							echo "				onchange=\"ValidateQty( this )\""; 
							//echo "				onblur=\"UpdateExtPrice( this, 4.99, 1.50, extprice_$PROD_ID )\" />";
							echo "	</td>";
							echo "	<td>";
							echo "		<span style=\"font-weight:bold\">";
							echo 			$PROD_NAME;
							echo "		</span>";
							echo "	</td>";
							echo "	<td align=\"center\">$PROD_COST</td>";
							echo "	<td align=\"center\">$PROD_SHIP_COST</td>";
							echo "	<td>";
							echo "		<input name=\"extprice_$PROD_ID\"  type=\"text\" readonly=\"yes\"";
							echo "			style=\"background-color:transparent; border:0; font-weight:bold; text-align:center;\"";
							echo "			onfocus=\"MoveExtPriceFocus( productqty_$PROD_ID, update_$PROD_ID )\"/>";
							echo "	</td>";
							echo "	<td>";
							echo "		<input name=\"update_$PROD_ID\" type=\"button\" value=\"Update\"";
							echo "			onclick=\"UpdateExtPrice( productqty_$PROD_ID, $PROD_COST, $PROD_SHIP_COST, extprice_$PROD_ID )\"/>";
							echo "	</td>";
							echo "</tr>";

						}//end else

					}//end while

				}//end else

				// + Get the current order number and increment it by one
				$query  = "  SELECT ReferenceValue ";
				$query .= "    FROM Reference ";
				$query .= "   WHERE ReferenceName = 'Current Order Number' ";
				$query_result = mysqli_query( $link, $query );
		
				if ( $query_result == TRUE )
				{
					$returned_row = mysqli_fetch_row( $query_result );
					$CurrentOrderNumber = $returned_row[0];
					$CurrentOrderNumber++;
				}
				else
				{
					die( $error_message );
				}
		
				// + Save the new current order number back to the database
				$query  = "UPDATE Reference ";
				$query .= "   SET ReferenceValue = " . $CurrentOrderNumber . " ";
				$query .= " WHERE ReferenceName = 'Current Order Number' ";
		
				$query_result = mysqli_query( $link, $query );

				if ( $query_result == FALSE )
				{
					die( $error_message );
				}

				// + Create a row in the OrderHeader table.
				// + Notice that we use the MySQL function
				//   CURRENT_TIMESTAMP() to automatically put
				//   the current date and time onto the order.
				$num = "98765";
				$query  = "INSERT ";
				$query .= "  INTO orderHeader( ";
				$query .= "	    CUSTOMER_ID ";

				$query .= "         ORDER_DATE ";
				$query .= "         ) ";
				$query .= "VALUES ( ";
				$query .= "         $num";
				$query .= "         CURRENT_TIMESTAMP() ";
				$query .= "       ) ";
				$query_result = mysqli_query( $link, $query );





				// + Keep track of how many distinct products are ordered
				$parameterCount = 0;
		
				// + Keep track of the total value of the order
				$OrderTotal = 0.0;
		
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
						$parameterCount ++;

						// + Remove the prefix from the parameter name
						//   and use this as the product ID.
						$PROD_ID = substr( $ParamName, 11 );
				
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
						}
					}//end if



						if ( $parameterCount == 0 )
						{
							echo "No parameters found.";
						}//end if
				
						else
						{
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

						}//end else
				}//end for


			?>
			<tr>
				<td align="center" colspan="5">
					<input type="submit" name="submit" value="Submit" />
				</td>
			</tr>
		</table>
	</form>

	</p>
</body>
</html>