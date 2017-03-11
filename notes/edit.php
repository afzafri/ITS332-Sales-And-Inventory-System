<?php
	require_once('../auth.php');
	$empid = ($_SESSION['SESS_MEMBER_ID']);
?>

<html>
<head>
<title>Edit Sticky Note</title>
<link href="../templates/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
 <link href="../templates/dist/css/sb-admin-2.css" rel="stylesheet">
 <link rel="stylesheet" type="text/css" href="../css/design.css">
 <script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Are you sure?');
}
</script>
</head>
<body>
<center>
<h1 class='page-header'>Edit Sticky Note</h1>

<div class="design-block">


<?php

include '../config.php';

if(isset($_GET['notesid']))
{
	$notesid = $_GET['notesid'];
	
	echo "<form action='edit.php?notesid={$notesid}' method='post'>";
	
	try
	{
		//connect to database
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		//insert data into db
		$getnotes = $conn->prepare("SELECT * FROM NOTES WHERE ID = '{$notesid}' ");
		
		//execute sql query
		$getnotes->execute();
		$row = $getnotes->fetch(PDO::FETCH_ASSOC);
		$id = $row['ID'];
		$title = $row['TITLE'];
		$texts = $row['TEXT'];
		$empid = $row['EMPID'];
		
		echo "
		<input type='text' name='title' placeholder='Title' value='".htmlentities($title)."'><br>
		<textarea  name='notes' placeholder='Enter your notes here...'style='width: 410px; height: 200px;'>".htmlentities($texts)."</textarea><br>
		<br>				
		<button>Save</button>
		</form>
		
		
		<a href='./edit.php?notesid={$notesid}&delete=Delete' onclick='return checkDelete()'><button>Delete Note</button></a>
		
		</div>
		";
		
		if(isset($_POST['title']) && isset($_POST['notes']))
		{
			$title = $_POST['title'];
			$notes = $_POST['notes'];
	
			//insert data into db
			$stmt = $conn->prepare("UPDATE NOTES SET TITLE='{$title}', TEXT='{$notes}', EMPID='{$empid}' WHERE ID='{$id}' ");
			
			//execute sql query
			$stmt->execute();
		
			echo "Success! Note Saved";
		}
		if(isset($_GET['delete']))
		{	
			$stmtdel = $conn->prepare("DELETE FROM NOTES WHERE ID='{$id}' ");
			$stmtdel->execute();
			
			echo "Success! Note Deleted";
		}
		
	}
	catch(PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
	}

	//close conection
	$conn = null;
	
}