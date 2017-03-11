<?php
	require_once('../auth.php');
	if(($_SESSION['SESS_MEMBER_LEVEL']) != 1 )
	{
		header("location: ../home.php");
	}
	include '../templates/headerfolder.php'; 
	
	//required fields handling	
	$errID = $errName = $errSize = $errColor = $errCost = "";
	$id = $name = $size = $color = $cost = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(empty($_POST['id'])) {$errID = "*Product ID is required.";} else { $id = $_POST["id"];}
		if(empty($_POST['name'])) {$errName = "*Product Name is required.";} else { $name = $_POST["name"];}
		if(empty($_POST['size'])) {$errSize = "*Product Size is required.";} else { $size = $_POST["size"];}
		if(empty($_POST['colors'])) {$errColor = "*Product Color is required.";} else { $color = $_POST["colors"];}
		if(empty($_POST['cost'])) {$errCost = "*Product Cost is required.";} else { $cost = $_POST["cost"];}
	}
	
?>

<center>
<h1 class='page-header'>Add Product</h1>
<p>Note 1 : Size, Colors, Sleeve and Flowers/Embroidery MUST be separated by comma if there's more than one option.<br>Note 2 : Sleeve and Flowers/Embroidery are OPTIONAL. Leave BLANK if there is no option</p>
<div class="design-block">
<form action="index.php" method="post">

<?php echo "<font color='red'>" . $errID . "</font>"; ?>
<input type="text" name="id" placeholder="ID" value="<?php echo (isset($_POST['id']) ? $_POST['id'] : null); ?>"><br>

<?php echo "<font color='red'>" . $errName . "</font>"; ?>
<input type="text" name="name" placeholder="Name" value="<?php echo (isset($_POST['name']) ? $_POST['name'] : null); ?>"><br>

<?php echo "<font color='red'>" . $errSize . "</font>"; ?>
<input type="text" name="size" placeholder="Available Size (Seperated by coma. ex : M.L,XL)" value="<?php echo (isset($_POST['size']) ? $_POST['size'] : null); ?>"><br>

<?php echo "<font color='red'>" . $errColor . "</font>"; ?>
<input type="text" name="colors" placeholder="Available Colors (Seperated by coma. ex : Red.Blue)" value="<?php echo (isset($_POST['colors']) ? $_POST['colors'] : null); ?>"><br>

<input type="text" name="sleeves" placeholder="Available Sleeve (Seperated by coma. ex : Long.Short)" value="<?php echo (isset($_POST['sleeves']) ? $_POST['sleeves'] : null); ?>"><br>
<input type="text" name="flowers" placeholder="Available Flowers/Embroidery (Seperated by coma. ex : Rose,Daisy)" value="<?php echo (isset($_POST['flowers']) ? $_POST['flowers'] : null); ?>"><br>

<?php echo "<font color='red'>" . $errCost . "</font>"; ?>
<input type="text" name="cost" placeholder="Cost Price" value="<?php echo (isset($_POST['cost']) ? $_POST['cost'] : null); ?>"><br>

<button>Submit</button>
</form>
</div>

<?php

include '../config.php';

//declare variable. use 'isset' to determine if variable is set and not null. if null, not execute
if(isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["size"]) && 
isset($_POST["colors"]) && isset($_POST["sleeves"]) && isset($_POST["flowers"]) && 
isset($_POST["cost"]) )
{
	$id = strtoupper($_POST['id']);
	$name = strtoupper($_POST['name']);
	$size = strtoupper($_POST['size']);
	$colors = strtoupper($_POST['colors']);
	$sleeves = strtoupper($_POST['sleeves']);
	$flowers = strtoupper($_POST['flowers']);
	$cost = $_POST['cost'];
	

	if($id != "" && $name != "" && $size !="" && $colors != "" &&
	$cost != "")
	{
		try
		{
			//connect to database
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			//insert data into db
			$stmt = $conn->prepare("INSERT INTO PRODUCT (PRODUCTID,PRODUCTNAME,SIZEAVAILABLE,
														COLORSAVAILABLE,SLEEVEAVAILABLE,FLOWERSEMBAVAILABLE,GPRICE)
														VALUES(?,?,?,?,?,?,?);");
			
			//execute sql query
			$stmt->execute(array($id , $name , $size , $colors , $sleeves , $flowers , $cost));
			
			
			echo "<script>alert('Success! Data Inserted.')</script>";
			
			
		}
		catch(PDOException $e)
		{
			echo "Connection failed: " . $e->getMessage();
		}

		//close conection
		$conn = null;
	}
	else
	{
		echo "<script>alert('Please complete the form!')</script>";
	}
	
}


?>

</center>
<?php include '../templates/footerfolder.php'; ?>