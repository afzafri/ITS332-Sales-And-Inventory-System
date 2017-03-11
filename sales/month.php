<?php
	require_once('../auth.php');
?>

<html>
<head>
<title>Monthly Sales</title>
</head>
<body>
<center>
<h2>Monthly Sales (<?php echo date("F") ?>)</h2>


<?php

include '../config.php';

	
try
{
	
	//connect to database
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	//select data from db
	$stmt = $conn->prepare("SELECT EMPID,PRODUCTID,NAME,COLORS,SIZE,SLEEVE, FLOWERSEMB,QUANTITY,
												PRICE,REVENUE,DATE_FORMAT(DATE(DATE_TIME),'%d-%m-%Y') AS DISDATE, 
												MONTH(DATE_TIME) 
												FROM SALES 
												WHERE MONTH(DATE_TIME)=MONTH(CURDATE())");
	
	//execute the sql query
	$stmt->execute();
	
	echo "
	<div class='table-responsive'>
		<table class='table table-bordered table-hover table-striped'>
		<tr>
		<th>No.</th>
		<th>Emp. ID</th>
		<th>Date</th>
		<th>Product ID</th>
		<th>Product</th>
		<th>Colors</th>
		<th>Size</th>
		<th>Sleeve</th>
		<th>Flowers</th>
		<th>Quantity</th>
		<th>Price (RM)</th>
		<th>Profits (RM)</th>
		</tr>
	
	";
	
	$i=0;	
	//use php function fetch() to get the db column data
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
        //use the fetched data to store into variable
		$name = $row['NAME'];
		$colors = $row['COLORS'];
		$size = $row['SIZE'];
		$sleeve = $row['SLEEVE'];
		$flowers = $row['FLOWERSEMB'];
		$quantity = $row['QUANTITY'];
		$price = $row['PRICE'];
		$revenue = $row['REVENUE'];
		$datetime = $row['DISDATE'];
		$empid = $row['EMPID'];
		$prodid = $row['PRODUCTID'];
		
		$no = $i+1;
		
			echo " 
		
		<tr>
		<td>$no</td>
		<td>$empid</td>
		<td>$datetime</td>
		<td>$prodid</td>
		<td>$name</td>
		<td>$colors</td>
		<td>$size</td>
		<td>$sleeve</td>
		<td>$flowers</td>
		<td>$quantity</td>
		<td>$price</td>
		<td>$revenue</td>
		</tr>
			
		
	
		";
		
		$i++;
	}
	
	$total = $conn->prepare("SELECT SUM(PRICE) AS TOTALSALES, 
												SUM(REVENUE) AS TOTALREV,
												SUM(QUANTITY) AS TOTALQUANTITY  
												FROM SALES 
												WHERE MONTH(DATE_TIME)=MONTH(CURDATE())");
	
	$total->execute();
	
	$result = $total->fetch(PDO::FETCH_ASSOC);
	$totalprice = $result['TOTALSALES'];
	$totalrevenue = $result['TOTALREV'];
	$totalquantity = $result['TOTALQUANTITY'];
	
	//total
	echo "
	<tr>
	<td  colspan='8'></td>
	<th>Total</th>
	<th>$totalquantity</th>
	<th>$totalprice</th>
	<th>$totalrevenue</th>
	</tr>
	
	</table>
	</div>

	";
	
}	
catch (PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}

//close conection
$conn = null;


?>

</form>
</center>
</body>
</html>