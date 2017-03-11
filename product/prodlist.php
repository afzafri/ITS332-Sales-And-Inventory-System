<?php
	require_once('../auth.php');
	include '../templates/headerfolder.php'; 
?>

<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Are you sure? This will also delete your stocks');
}
</script>

<center>
<h1 class='page-header'>Product List</h1>


<form action="prodlist.php" method="get">
		Search Product : <input type="text" name="pname" placeholder="Product Name"> &nbsp;
		<input type="submit" class="myButton"><br><br>
</form>



<?php

include '../config.php';

	try
	{
		//connect to database
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		//list all product if user not using search function
		if(empty($_GET['pname']))
		{
			//select data from
			$stmt = $conn->prepare("SELECT PRODUCTID, PRODUCTNAME, SIZEAVAILABLE, COLORSAVAILABLE, SLEEVEAVAILABLE, FLOWERSEMBAVAILABLE, GPRICE FROM PRODUCT");
		
			//execute sql query
			$stmt->execute();
		
			echo '<p>Note 1 : Click on the Product ID to list of available stocks.<br>Note 2 : Click the icon under Add New Stock column to navigate to add stock page.<br>
			Note 3 : Click the icon under Update Stock column to navigate to update stock page.<br>Note 4 : Click the "X" button under the Delete column to delete the product and stock.</p>';
			$i = 0;
		
			echo "<br><div class='table-responsive'>
			<table class='table table-bordered table-hover table-striped'>";
			echo "<tr>";
			echo "	<th>No.</th>";
			echo "	<th>ID</th>";
			echo "	<th>Name</th>";
			echo "	<th>Available Size</th>";
			echo "	<th>Available Colors</th>";
			echo "	<th>Available Sleeve</th>";
			echo "	<th>Available Design</th>";
			echo "	<th>Cost Price (RM)</th>";
			echo "	<th>Add New Stock</th>";
			echo "	<th>Update Stock</th>";
			
			//check only manager can see
			if(($_SESSION['SESS_MEMBER_LEVEL']) == 1 )
			{
				echo "	<th>Delete</th>";
			}
		
			echo "</tr>";
			
			//use php function fetch() to get the db column data
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				//use the fetched data to store into variable
				$ids = $row['PRODUCTID'];
				$names = $row['PRODUCTNAME'];
				$sizes = $row['SIZEAVAILABLE'];
				$colors = $row['COLORSAVAILABLE'];
				$sleeves = $row['SLEEVEAVAILABLE'];
				$flowers = $row['FLOWERSEMBAVAILABLE'];
				$cost = $row['GPRICE'];

				
				echo "<tr>";
				echo "	<td>".($i+1)."</td>";
				echo "	<td><a href='../stock/index.php?id=$ids'>$ids</a></td>";
				echo "	<td>$names</td>";
				echo "	<td>$sizes</td>";
				echo "	<td>$colors</td>";
				echo "	<td>$sleeves</td>";
				echo "	<td>$flowers</td>";
				echo "	<td>$cost</td>";
				echo " <td><a href='../stock/index.php?id=$ids'><img src='../images/add.png' width='25px' title='Add New Stock'/></a></td>";
				echo " <td><a href='../stock/upstock.php?id=$ids'><img src='../images/update.png' width='25px' title='Update Stock'/></a></td>";
				
				//check only manager can see
				if(($_SESSION['SESS_MEMBER_LEVEL']) == 1 )
				{
					echo "	<td><a href='./prodlist.php?id=$ids&delete=Delete' onclick='return checkDelete()'><img src='../images/del.png' width='25px' title='Delete Product'/></a></td>";
				}
				
				
				echo "</tr>";
				
				$i++;
			}
			
			
			echo "</tr></table></div>";
			
			if(isset($_GET['id']) && isset($_GET['delete']))
			{	
				$ids = $_GET["id"];
				$stmtdel = $conn->prepare("DELETE FROM PRODUCT WHERE PRODUCTID='{$ids}' ");
				$stmtdel->execute();
				
				$stmtdelstock = $conn->prepare("DELETE FROM PRODUCTDETAIL WHERE PRODUCTID='{$ids}' ");
				$stmtdelstock->execute();
				
				echo "<script>alert('Data Deleted')</script>";
			}
			
			
		}
		
		//list only the products that meets user searched 
		if(isset($_GET['pname']))
		{
			$pname = $_GET['pname'];
			
			//select data from
			$stmt = $conn->prepare("SELECT PRODUCTID, PRODUCTNAME, 
														SIZEAVAILABLE, COLORSAVAILABLE, 
														SLEEVEAVAILABLE, FLOWERSEMBAVAILABLE, 
														GPRICE FROM PRODUCT
														WHERE PRODUCTNAME LIKE '%{$pname}%'");
		
			//execute sql query
			$stmt->execute();
			
			echo '<p>Note 1 : Click on the Product ID to list of available stocks.<br>Note 2 : Click the "X" button under the Delete column to delete the product and stock.</p>';
			$i = 0;
		
			echo "<br><div class='table-responsive'>
			<table class='table table-bordered table-hover table-striped'>";
			echo "<tr>";
			echo "	<th>No.</th>";
			echo "	<th>ID</th>";
			echo "	<th>Name</th>";
			echo "	<th>Available Size</th>";
			echo "	<th>Available Colors</th>";
			echo "	<th>Available Sleeve</th>";
			echo "	<th>Available Design</th>";
			echo "	<th>Cost Price (RM)</th>";
			
			//check only manager can see
			if(($_SESSION['SESS_MEMBER_LEVEL']) == 1 )
			{
				echo "	<th>Delete</th>";
			}
		
			echo "</tr>";
			
			//use php function fetch() to get the db column data
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				//use the fetched data to store into variable
				$ids = $row['PRODUCTID'];
				$names = $row['PRODUCTNAME'];
				$sizes = $row['SIZEAVAILABLE'];
				$colors = $row['COLORSAVAILABLE'];
				$sleeves = $row['SLEEVEAVAILABLE'];
				$flowers = $row['FLOWERSEMBAVAILABLE'];
				$cost = $row['GPRICE'];

				
				echo "<tr>";
				echo "	<td>".($i+1)."</td>";
				echo "	<td><a href='../stock/index.php?id=$ids'>$ids</a></td>";
				echo "	<td>$names</td>";
				echo "	<td>$sizes</td>";
				echo "	<td>$colors</td>";
				echo "	<td>$sleeves</td>";
				echo "	<td>$flowers</td>";
				echo "	<td>$cost</td>";
				
				//check only manager can see
				if(($_SESSION['SESS_MEMBER_LEVEL']) == 1 )
				{
					echo "	<td><a href='./prodlist.php?pname=$pname&id=$ids&delete=Delete' onclick='return checkDelete()'><img src='../images/del.png' width='25px' title='Delete Product'/></a></td>";
				}
				
				
				echo "</tr>";
				
				$i++;
			}
			
			
			echo "</tr></table></div>";
			
			if(isset($_GET['id']) && isset($_GET['delete']))
			{	
				$ids = $_GET["id"];
				$stmtdel = $conn->prepare("DELETE FROM PRODUCT WHERE PRODUCTID='{$ids}' ");
				$stmtdel->execute();
				
				$stmtdelstock = $conn->prepare("DELETE FROM PRODUCTDETAIL WHERE PRODUCTID='{$ids}' ");
				$stmtdelstock->execute();
				
				echo "<script>alert('Data Deleted')</script>";
			}
			
		}
		
	}
	catch(PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
	}

	//close conection
	$conn = null;
	
?>


</center>
<?php include '../templates/footerfolder.php'; ?>