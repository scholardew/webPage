<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Eclectic Collectible Furniture</title>
  <link rel="stylesheet" type="text/css" href="style.css" media="screen">
</head>
<body link="white" class="indexBckGrnd">

<header>

 
  <hgroup>
    <h1>Regis Eclectic Collectible Store</h1>
    <h2>Quality hand built metal furniture</h2>
  </hgroup>

  <nav>
    <ul>
      <li><a href="#bottom">Contact</a></li>
      <li><a href="#middle">About</a></li>         
    </ul>
  </nav>

</header>

<h3>747 Reception Desk</h3>
<p>
<img class="imgAlignMiddle" src="pictures/Boeing_Reception_Desk.jpg" alt="A picture of a 747 desk">
</p>

<h3>Oil Drum Chair</h3>
<p>
<img class="imgAlignMiddle" src="pictures/Oil_Drum_Chair.jpg" alt="A picture of an oil drum chair">
</p>

<a name="middle">

<p class ="block">
The Regis Eclectic Collectible Store is a company that specialiazes in selling 
furniture made from metal.  Furniture listed on this site is hand-made and is created 
from everything from automobiles to machine guns.  
</p>



<p class ="item">Purchase<p/>

	<form method="get" action="product_detail.php">

		<p>
		<select name="PROD_ID">
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
				$query .= "ORDER BY PROD_NAME ";
				$bool_result = mysqli_query( $link, $query );

				if ( $bool_result == TRUE )
				{
					while( $returned_row = mysqli_fetch_row( $bool_result ))
					{
						echo "<option value=\"";
						echo $returned_row[0] . "\"";
						if ( isset( $_GET['PROD_ID']) && $_GET['PROD_ID'] == $returned_row[0] )
						{
							echo " selected=\"selected\"";
						}
						echo ">";
						echo $returned_row[1];
						echo "</option>";
					}
				}
				else
				{
					echo "<option value=\"No items available\">No items available</option>";
				}
			?>
		</select>
		</p>
		<!-- Button to press -->
		<p>
		<input type="submit" value="submit" />
		</p>
	</form>



<footer>
  Phone: (555)555-5555; email: dgreear@regis.edu
</footer>

<a name="bottom">

</body>

</html>
