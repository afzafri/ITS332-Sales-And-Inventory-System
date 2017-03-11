<?php
	require_once('../auth.php');
?>

<?php include '../templates/headerfolder.php'; ?>
<center>

<?php

include '../config.php';

	try
	{
		//connect to database
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		//insert data into db
		$stmt = $conn->prepare("SELECT ID,NAME,POSITION FROM EMPLOYEE");
		
		//execute sql query
		$stmt->execute();
		
		$i = 0;
		
		echo "<h1 class='page-header'>Employee List</h1>";
		echo '<p>Note : Click on the Employee ID to view detailed information of the employee.</p>';
		echo "<br><div class='table-responsive'>
		<table class='table table-bordered table-hover table-striped'>";
		echo "<tr>";
		echo "	<th>No.</th>";
		echo "	<th>ID</th>";
		echo "	<th>Name</th>";
		echo "	<th>Position</th>";
		echo "</tr>";
		
		//use php function fetch() to get the db column data
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			//use the fetched data to store into variable
			$ids = $row['ID'];
			$names = $row['NAME'];
			$jawatan = $row['POSITION'];
			
			echo "<tr>";
			echo "	<td>".($i+1)."</td>";
			echo "	<td><a href='profile.php?id=$ids'>$ids</a></td>";
			echo "	<td>".strtoupper($names)."</td>";
			echo "	<td>".strtoupper($jawatan)."</td>";
			echo "</tr>";
			
			$i++;
		}
		
		
		echo "</tr></table></div>";
		
		
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