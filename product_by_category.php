<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Eclectic Collectible Furniture</title>
  <link rel="stylesheet" type="text/css" href="style.css" media="screen">
</head>

<body>
<form method="GET" action="product_detail.php">
<?php
  # Establish a connection to the database
  $server   = "localhost:3306";
  $username = "root";
				
  $link = mysqli_connect( $server, $username );

  # Select the schema in the database
  $database = "laurare2_student8";
  mysqli_select_db( $link, $database );
				
  # Create the query
  $query  = "  SELECT PROD_ID, PROD_NAME,PROD_DESCRIP, PROD_CATEGORY,";
  $query .= "         PROD_COST, PROD_QTY_ON_HAND, PROD_SHIP_COST, PROD_SHIP_WEIGHT, PROD_FILENAME";
  $query .= "    FROM product ";
  $query .= "ORDER BY PROD_CATEGORY ";
  $bool_result = mysqli_query( $link, $query );


  if ( $bool_result == TRUE )
  {	$count = 0;
	$res = mysqli_query($link, $query);
	$lastCategory = '';
	
	while ($returned_row = mysqli_fetch_assoc($res))
	{
	  if($returned_row['PROD_CATEGORY'] != $lastCategory)
    	  {
            $lastCategory = $returned_row['PROD_CATEGORY'];
            echo "<br /><strong>$lastCategory</strong><br/>";
          }      

	  echo '<a href= "product_detail.php?" onClick= "PROD_ID(' . $returned_row['PROD_ID'] .')"> '.$returned_row['PROD_NAME'].'</a><br/>';

        }
        
  }

  else
  {
    echo "<option value=\"No items available\">No items available</option>";
  }
?>
</form>

</body>
</html>