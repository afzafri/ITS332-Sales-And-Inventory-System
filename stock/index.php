<?php
	require_once('../auth.php');
?>


<?php include '../templates/headerfolder.php'; ?>

<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Are you sure to delete?');
}
</script>

<html>
<head>


<!-- function ajax for dropdown*/ -->
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript">
function fetch_data(val)
{
   
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
     url: 'fetch_colors.php',
     data: {
       get_colors:val
     },
     success: function (response) {
       document.getElementById("select_colors").innerHTML=response; 
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
   
  
}


</script>


</head>
<body>

<center>

<h1 class='page-header'>Add New Stocks</h1>

<form action="index.php" method="post">

Select : <label><select name='pilih' onchange="fetch_data(this.value);">
<option value=''>Choose Product</option>


<?php

include '../config.php';

	
try
{
	
	//connect to database
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	//select data from db
	$stmt = $conn->prepare("SELECT PRODUCTNAME,PRODUCTID FROM PRODUCT");
	
	//execute the sql query
	$stmt->execute();
	
	
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
	
	echo "<label><select id='select_size' name='select_size'>
	</select></label>&nbsp;";
	
	echo "<label><select id='select_colors' name='select_colors'>
	</select></label>&nbsp;";
	
	echo "<label><select id='select_sleeve' name='select_sleeve'>
	</select></label>&nbsp;";
	
	echo "<label><select id='select_flowers' name='select_flowers'>
	</select></label>&nbsp;";
	
	
	echo "Quantity : <input type='text' size='1' name='quantity'>&nbsp; 
	<input type='submit' name='submit' class='myButton' value='Add New Stock'>

	
	</form>
	";
	//<input type='submit' name='liststock' class='myButton' value='List All Stock'>

	if(isset($_POST['submit']))
	{
		$idproduk = (isset($_POST['pilih']) ? $_POST['pilih'] : null);
		$saiz = (isset($_POST['select_size']) ? $_POST['select_size'] : null);
		$warna = (isset($_POST['select_colors']) ? $_POST['select_colors'] : null);
		$bunga = (isset($_POST['select_flowers']) ? $_POST['select_flowers'] : null);
		$lengan = (isset($_POST['select_sleeve']) ? $_POST['select_sleeve'] : null);
		$bilangan = (isset($_POST['quantity']) ? $_POST['quantity'] : null);
		
		
		//connect to database
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		//do checking before kick in data
		if($bilangan > 0 && $idproduk != null && $saiz != null && $warna != null)
		{
			//insert data into db
			$stmt = $conn->prepare("INSERT INTO PRODUCTDETAIL (PRODUCTID,SIZE,COLORS,SLEEVE,FLOWERSEMB,QUANTITY)
														VALUES('$idproduk' , '$saiz' , '$warna' , '$lengan' , '$bunga' , '$bilangan') ");
			
			//execute the sql query
			$stmt->execute();
			
			echo "<script>alert('Success! Data Inserted.')</script>";
		}
		if($bilangan <= 0 && $idproduk != null && $saiz != null && $warna != null)
		{
			echo "<script>alert('Invalid Quantity!')</script>";
		}
		if($bilangan <= 0  && $idproduk == null && $saiz == null && $warna == null)
		{
			echo "<script>alert('Invalid Quantity and Please select all required field!')</script>";
		}
		if($bilangan > 0  && $idproduk == null && $saiz == null && $warna == null)
		{
			echo "<script>alert('Please select all required field!')</script>";
		}
		if($bilangan > 0  && $idproduk != null && $saiz != null && $warna == null)
		{
			echo "<script>alert('Please select all required field!')</script>";
		}
		if($bilangan > 0  && $idproduk != null && $saiz == null && $warna != null)
		{
			echo "<script>alert('Please select all required field!')</script>";
		}
		if($bilangan > 0  && $idproduk == null && $saiz != null && $warna != null)
		{
			echo "<script>alert('Please select all required field!')</script>";
		}
		
	}
	if(empty($_GET['id']))
	{
		include 'liststock.php';
	}
	if(isset($_GET['id']))
	{
		$ids = $_GET['id'];
		include 'liststockid.php';
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