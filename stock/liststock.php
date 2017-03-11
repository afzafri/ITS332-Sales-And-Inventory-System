<?php
	require_once('../auth.php');
?>

<html>
<head>
<title>List Of All Available Stock</title>

</head>
<body>
<center>
<h2>List Of All Available Stock</h2>


<?php

include '../config.php';

	
try
{
	
	//connect to database
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	//select data from db
	$stmt = $conn->prepare("SELECT PD.DETAILID, P.PRODUCTID, P.PRODUCTNAME, 
												PD.SIZE, PD.COLORS, PD.SLEEVE, 
												PD.FLOWERSEMB, PD.QUANTITY
												FROM PRODUCT P, PRODUCTDETAIL PD
												WHERE P.PRODUCTID = PD.PRODUCTID ");
	
	//execute the sql query
	$stmt->execute();
	
	echo "
		
		
		 <div class='table-responsive'>
		<table class='table table-bordered table-hover table-striped'>
		<tr>
		<th>Product ID</th>
		<th>Name</th>
		<th>Size</th>
		<th>Colors</th>
		<th>Sleeve</th>
		<th>Flowers</th>
		<th>Quantity</th>
		<th>Delete</th>
		</tr>
	
	";
	
	//use php function fetch() to get the db column data
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
        //use the fetched data to store into variable
		$did = $row['DETAILID'];
		$pid = $row['PRODUCTID'];
		$name = $row['PRODUCTNAME'];
		$size = $row['SIZE'];
		$colors = $row['COLORS'];
		$sleeve = $row['SLEEVE'];
		$flowers = $row['FLOWERSEMB'];
		$quantity = $row['QUANTITY'];
		
		
		echo " 
		
		<tr>
		<td>$pid</td>
		<td>$name</td>
		<td>$size</td>
		<td>$colors</td>
		<td>$sleeve</td>
		<td>$flowers</td>
		<td>$quantity</td>
		<td><a href='./index.php?did=$did&delete=Delete' onclick='return checkDelete()'><img src='../images/del.png' width='25px' title='Delete Product'/></a></td>
		</tr>
	
		";
		
	}
	
	$total = $conn->prepare("SELECT SUM(QUANTITY) AS TOTALQUANTITY
											    FROM PRODUCT P, PRODUCTDETAIL PD
												WHERE P.PRODUCTID = PD.PRODUCTID");
	
	$total->execute();
	
	$result = $total->fetch(PDO::FETCH_ASSOC);
	$totalquantity = $result['TOTALQUANTITY'];
	
	//total
	echo "
	<tr>
	<td  colspan='6'></td>
	<th>Total</th>
	<th>$totalquantity</th>
	</tr>
	
	</table>
	</div>

	";
	
	if(isset($_GET['did']) && isset($_GET['delete']))
	{	
		$ids = $_GET["did"];
		
		$stmtdelstock = $conn->prepare("DELETE FROM PRODUCTDETAIL WHERE DETAILID='{$ids}' ");
		$stmtdelstock->execute();
		
		echo "<script>alert('Data Deleted')</script>";
	}
	
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