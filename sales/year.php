<?php
	require_once('../auth.php');
?>

<html>
<head>
<title>Yearly Sales</title>
<link rel="stylesheet" href="./morris/morris.css">
<!--<script src="./morris/jquery.min.js"></script>-->
<script src="./morris/raphael-min.js"></script>
<script src="./morris/morris.min.js"></script>
</head>
<body>
<center>
<h2>Yearly Sales (<?php echo date("Y") ?>)</h2>


<?php

include '../config.php';

	
try
{
	
	//connect to database
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	//select data from db
	$stmt = $conn->prepare("SELECT EMPID,PRODUCTID,NAME,COLORS,SIZE,SLEEVE,
										FLOWERSEMB,QUANTITY,
										PRICE,REVENUE,DATE_FORMAT(DATE(DATE_TIME),'%d-%m-%Y') AS DISDATE, 
										YEAR(DATE_TIME) 
										FROM SALES 
										WHERE YEAR(DATE_TIME)=YEAR(CURDATE())");
	
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
												WHERE YEAR(DATE_TIME)=YEAR(CURDATE())");
	
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
	<br><br><br>
	";
	
	
	//generate bar graph function
	
	$graph = $conn->prepare("SELECT MONTH(DATE_TIME) AS MONTHZ, SUM(QUANTITY) AS TQ FROM SALES WHERE YEAR(DATE_TIME)=YEAR(CURDATE()) GROUP BY MONTH(DATE_TIME)");
	
	$graph->execute();
	
	
	$jan = 0;
	$feb = 0;
	$mar = 0;
	$apr = 0;
	$may = 0;
	$jun = 0;
	$jul = 0;
	$aug = 0;
	$sep = 0;
	$oct = 0;
	$nov = 0;
	$dec = 0;
	
	while($result = $graph->fetch(PDO::FETCH_ASSOC))
	{
		$month = $result['MONTHZ'];
		$totalquantity = $result['TQ'];
		
		if($month == 1)
		{
			$jan = $totalquantity;
		}
		if($month == 2)
		{
			$feb = $totalquantity;
		}
		if($month == 3)
		{
			$mar = $totalquantity;
		}
		if($month == 4)
		{
			$apr = $totalquantity;
		}
		if($month == 5)
		{
			$may = $totalquantity;
		}
		if($month == 6)
		{
			$jun = $totalquantity;
		}
		if($month == 7)
		{
			$jul = $totalquantity;
		}
		if($month == 8)
		{
			$aug = $totalquantity;
		}
		if($month == 9)
		{
			$sep = $totalquantity;
		}
		if($month == 10)
		{
			$oct = $totalquantity;
		}
		if($month == 11)
		{
			$nov = $totalquantity;
		}
		if($month == 12)
		{
			$dec = $totalquantity;
		}
	}
	
	echo "
	
	
	<h2>Bar Graph of Quantity Sold</h2>
 
	 <div id='graph' style='height: 400px;width: 100%;'></div>
	 
	 <script>
	 Morris.Bar({
	  element: 'graph',
	  data: [
		{x: 'January', y: $jan},
		{x: 'February', y: $feb},
		{x: 'March', y: $mar},
		{x: 'April', y: $apr},
		{x: 'May', y: $may},
		{x: 'Jun', y: $jun},
		{x: 'July', y: $jul},
		{x: 'August', y: $aug},
		{x: 'September', y: $sep},
		{x: 'October', y: $oct},
		{x: 'November', y: $nov},
		{x: 'December', y: $dec}
	  ],
	  xkey: 'x',
	  ykeys: ['y'],
	  labels: ['Quantity Sold'],
	  
	});
	 </script>
	
	
	
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