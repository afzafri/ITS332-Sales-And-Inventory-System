<?php

include '../config.php';

	
try
{
	$productid = $_POST['get_sleeve'];
	
	//connect to database
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	//select data from db
	$stmt = $conn->prepare("SELECT SLEEVEAVAILABLE
												FROM PRODUCT
												WHERE PRODUCTID = '{$productid}' "
	);
	
	//execute the sql query
	$stmt->execute();
	
	echo "<option value=''>Sleeves</option>";
	//use php function fetch() to get the db column data
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
        //use the fetched data to store into variable
		$sleeve = $row['SLEEVEAVAILABLE'];
		//use function explode() to insert value into array delimiter by comma
		$arrsleeve = explode(',' , $sleeve);	
		
		foreach($arrsleeve as $arrsleeve)
		{
			echo "<option value='$arrsleeve'>$arrsleeve</option>";
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