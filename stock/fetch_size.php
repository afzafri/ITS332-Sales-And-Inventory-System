<?php

include '../config.php';

	
try
{
	$productid = $_POST['get_size'];
	
	//connect to database
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	//select data from db
	$stmt = $conn->prepare("SELECT SIZEAVAILABLE
												FROM PRODUCT
												WHERE PRODUCTID = '{$productid}' "
	);
	
	//execute the sql query
	$stmt->execute();
	
	echo "<option value=''>Sizes</option>";
	//use php function fetch() to get the db column data
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
        //use the fetched data to store into variable
		$size = $row['SIZEAVAILABLE'];
		//use function explode() to insert value into array delimiter by comma
		$arrsize = explode(',' , $size);	
		
		foreach($arrsize as $arrsize)
		{
			echo "<option value='$arrsize'>$arrsize</option>";
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