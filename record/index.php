<?php
	require_once('../auth.php');
?>


<?php include '../templates/headerfolder.php'; ?>

<html>
<head>


<!-- function ajax for dropdown*/ -->
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript">
function fetch_name(val)
{
   $.ajax({
     type: 'post',
     url: 'fetch_data.php',
     data: {
       get_option:val
     },
     success: function (response) {
       document.getElementById("new_select").innerHTML=response; 
     }
   });
   
   $.ajax({
     type: 'post',
     url: 'fetch_size.php',
     data: {
       get_size:val
     },
     success: function (response) {
       document.getElementById("select_size").innerHTML=response; 
     }
   });
   
   $.ajax({
     type: 'post',
     url: 'fetch_sleeve.php',
     data: {
       get_sleeve:val
     },
     success: function (response) {
       document.getElementById("select_sleeve").innerHTML=response; 
     }
   });
   
   $.ajax({
     type: 'post',
     url: 'fetch_flowers.php',
     data: {
       get_flowers:val
     },
     success: function (response) {
       document.getElementById("select_flowers").innerHTML=response; 
     }
   });
}


</script>


</head>
<body>

<center>

<h1 class='page-header'>Record Sales</h1>

<form action="index.php" method="post">

<label><select name='pilih' onchange="fetch_name(this.value);">
<option value=''>Choose Product</option>


<?php

include '../config.php';

	
try
{
	
	//connect to database
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	//select data from db
	$stmt = $conn->prepare("SELECT DISTINCT PRODUCTNAME,PRODUCTID FROM PRODUCT");
	
	//execute the sql query
	$stmt->execute();
	
	$empid = $_SESSION['SESS_MEMBER_ID'];
	
	//use php function fetch() to get the db column data
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
        //use the fetched data to store into variable
		$name = $row['PRODUCTNAME'];
		$productid = $row['PRODUCTID'];
		
		echo "
			<option value='$productid'>$name</option>
		";
	}
	echo "</select></label>&nbsp;";
	
	echo "<label><select id='new_select' name='new_select'>
	</select></label>&nbsp;";
	
	echo "<label><select id='select_sleeve' name='select_sleeve'>
	</select></label>&nbsp;";
	
	echo "<label><select id='select_flowers' name='select_flowers'>
	</select></label>&nbsp;";
	
	echo "<label><select id='select_size' name='select_size'>
	</select></label>&nbsp;";
	
	
	$q = range(1,10);
	
	echo "Quantity : <label><select name='quantity'>";
	foreach($q as $q)
	{
		echo "<option value='$q'>$q</option>";
	}
	echo "</select></label>&nbsp;
	Sales Price/pcs : <input type='text' size='1' name='salesprice'>&nbsp;
	<input type='submit' name='submit' class='myButton'>
	
	</form>
	";
	
	

	if(isset($_POST['submit']))
	{
		$idproduk = $_POST['pilih'];
		
		$getproductname = $conn->prepare("SELECT DISTINCT PRODUCTNAME,PRODUCTID FROM PRODUCT WHERE PRODUCTID = '{$idproduk}' ");
		$getproductname->execute();
		$rowname = $getproductname->fetch(PDO::FETCH_ASSOC);
		
		$namaproduk = $rowname['PRODUCTNAME'];
		$warna =  (isset($_POST['new_select']) ? $_POST['new_select'] : null);
		$saiz = (isset($_POST['select_size']) ? $_POST['select_size'] : null);
		$sleeve = (isset($_POST['select_sleeve']) ? $_POST['select_sleeve'] : null);
		$flowers = (isset($_POST['select_flowers']) ? $_POST['select_flowers'] : null);
		$bilangan = (isset($_POST['quantity']) ? $_POST['quantity'] : null);
		$salesprice = (isset($_POST['salesprice']) ? $_POST['salesprice'] : null); 
		
		//get price
		$getprice = $conn->prepare("SELECT DISTINCT GPRICE FROM PRODUCT WHERE PRODUCTID = '{$idproduk}' ");
	
		//execute the sql query
		$getprice->execute();
		$resultprice = $getprice->fetch(PDO::FETCH_ASSOC);
		$gp = $resultprice['GPRICE'];
		 
		$totalprice = $bilangan*$salesprice;
		$totalgprice = $bilangan*$gp;
		$revenue = $totalprice - $totalgprice;
		$today = date("d-m-Y"); 
		
		//get current purchased size quantity
		$stock = $conn->prepare("SELECT QUANTITY FROM PRODUCTDETAIL WHERE PRODUCTID='{$idproduk}' AND SIZE='{$saiz}' AND COLORS='{$warna}' AND SLEEVE='{$sleeve}' AND FLOWERSEMB='{$flowers}'");
		$stock->execute();
		
		$result = $stock->fetch(PDO::FETCH_ASSOC);
		$quantitysize = $result['QUANTITY'];
		
		if($quantitysize >= $bilangan && $salesprice >= $gp)
		{
			echo " 
			
			<br><br>
			<div class='table-responsive'>
			<table class='table table-bordered table-hover table-striped'>
			<tr>
			<th>Date</th>
			<th>Seller ID</th>
			<th>Product ID</th>
			<th>Product</th>
			<th>Colors</th>
			<th>Size</th>
			<th>Sleeve</th>
			<th>Flowers</th>
			<th>Quantity</th>
			<th>Price (RM)</th>
			</tr>
			
			<tr>
			<td>$today</td>
			<td>$empid</td>
			<td>$idproduk</td>
			<td>$namaproduk</td>
			<td>$warna</td>
			<td>$saiz</td>
			<td>$sleeve</td>
			<td>$flowers</td>
			<td>$bilangan</td>
			<td>$totalprice</td>
			</tr> 
			
			</table></div>
			";
			
			//insert sales into sales table
			$stmt = $conn->prepare("INSERT INTO SALES (EMPID,PRODUCTID,NAME,COLORS,SIZE,SLEEVE,FLOWERSEMB,QUANTITY,PRICE,REVENUE,DATE_TIME) 
													VALUES ('$empid','$idproduk','$namaproduk','$warna','$saiz','$sleeve','$flowers','$bilangan','$totalprice','$revenue',CURDATE() )"
													);
		
			//execute the sql query
			$stmt->execute();
			
			$latestq = $quantitysize - $bilangan;
			echo "<br><h4>Current Stock for $namaproduk $warna $sleeve sleeve $flowers design $saiz size  is : <b>$latestq</b></h4><br>";
			
			$lateststock = $conn->prepare("UPDATE PRODUCTDETAIL SET QUANTITY={$latestq} WHERE PRODUCTID='{$idproduk}' AND SIZE='{$saiz}' AND COLORS='{$warna}' AND SLEEVE='{$sleeve}' AND FLOWERSEMB='{$flowers}'");
			$lateststock->execute();
		}
		if($quantitysize < $bilangan && $quantitysize != null)
		{
			echo "<font color='red'><h3>Available stock is not enough. <br>Current Stock in inventory for $namaproduk $warna $sleeve $flowers $saiz : $quantitysize pcs</h3></font>";
		}
		if($quantitysize == null)
		{
			echo "<font color='red'><h3>Stock not available. Please restock </h3></font>";
		}
		if($salesprice < $gp)
		{
			echo "<font color='red'><h3>Invalid price.</h3></font>";
		}
		
		
	
	}
	
}	
catch (PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}

//close conection
$conn = null;


?>

</center>
<?php include '../templates/footerfolder.php'; ?>