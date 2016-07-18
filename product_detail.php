<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type"
		content="text/html; charset=iso-8859-1" />
	<title>Week 6 | PHP Dynamic Web Page</title>
</head>
<body>



	<?php
		
		
		if ( isset( $_GET['PROD_ID']) && $_GET['PROD_ID'] != NULL )
		{
			
			$server   = "localhost:3306";
			$username = "root";
				
			$link = mysqli_connect( $server, $username );

			# Select the schema in the database
			$database = "laurare2_student8";
			mysqli_select_db( $link, $database );

			# Create the query
			$query  = "  SELECT PROD_ID, PROD_NAME, PROD_DESCRIP, PROD_CATEGORY, ";
			$query .= "         PROD_COST, PROD_QTY_ON_HAND, PROD_SHIP_COST, PROD_SHIP_WEIGHT, PROD_FILENAME ";
			$query .= "    FROM product ";
			$query .= "   WHERE PROD_ID = \"" . $_GET['PROD_ID'] . "\"";
			$query .= "ORDER BY PROD_NAME ";
			$bool_result = mysqli_query( $link, $query );
			
			if ( $bool_result == TRUE )
			{
				unset( $returned_row );

				$returned_row = mysqli_fetch_row( $bool_result );
				if ( $returned_row[0] != NULL )
				{ #echo '<img src="$returned_row[8]">';
					$pic = $returned_row[8];
					#echo '<img src="'.$pic.'">';
					echo '<img src="pictures/'.$pic.'">';
					echo "<p> </p>";
					echo "<hr align=\"left\" width=\"75%\"/>";
					echo "<table border=\"0\" cellpadding=\"5\" cellspacing=\"2\" >";
					echo "<tr>";
					echo "<td colspan=\"2\"><h3>Information for the item:</h3></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><strong>Item description</strong></td><td>" . $returned_row[2] . "</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><strong>Item ID</strong></td><td>" . $returned_row[0] . "</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><strong>Purchase price</strong></td><td>$" . $returned_row[4] . "</td>";
					echo "</tr>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><strong>Shipping Weight</strong></td><td>" . $returned_row[7] . "</td>";
					echo "</tr>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><strong>Shipping Cost</strong></td><td>$" . $returned_row[6] . "</td>";
					echo "</tr>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><strong>Category</strong></td><td>" . $returned_row[3] . "</td>";
					echo "</tr>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><strong>Quantity in stock</strong></td><td>" . $returned_row[5] . "</td>";
					echo "</tr>";
					echo "</table>";

				}
			}
			else
			{
				echo "<p>No information was found for item ID \"";
				echo $_GET['PROD_ID'] . "\"";
			}
		}
	?>	
	</p>
	<form method="get" action="orderPage.php">
	<p> <input type="submit" value="Order Page"/></p>
	</form>

	<form method="get" action="product_by_category.php">
	<p> <input type="submit" value="List furniture by category"/></p>
	</form>

</body>
</html>