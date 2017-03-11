<?php

include '../config.php';

	
try
{
	$productid = $_POST['get_flowers'];
	
	//connect to database
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	//select data from db
	$stmt = $conn->prepare("SELECT FLOWERSEMBAVAILABLE
												FROM PRODUCT
												WHERE PRODUCTID = '{$productid}' "
	);
	
	//execute the sql query
	$stmt->execute();
	
	echo "<option value=''>Design</option>";
	//use php function fetch() to get the db column data
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
        //use the fetched data to store into variable
		$flowers = $row['FLOWERSEMBAVAILABLE'];
		//use function explode() to insert value into array delimiter by comma
		$arrflowers = explode(',' , $flowers);	
		
		foreach($arrflowers as $arrflowers)
		{
			echo "<option value='$arrflowers'>$arrflowers</option>";
		}
	}
	
	exit;
	
	
}	
catch (PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}

//close conection
$conn = null;


?>