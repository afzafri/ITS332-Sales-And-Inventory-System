<?php
	require_once('../auth.php');
	$empid = ($_SESSION['SESS_MEMBER_ID']);
?>

<html>
<head>
<title>Add Sticky Note</title>
<link href="../templates/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
 <link href="../templates/dist/css/sb-admin-2.css" rel="stylesheet">
 <link rel="stylesheet" type="text/css" href="../css/design.css">
</head>
<body>
<center>
<h1 class='page-header'>Add Sticky Note</h1>
<p>Tips : Type in "&lt;br&gt;" without quote to enter a new line</p>

<div class="design-block">
<form action="index.php" method="post">
<input type="text" name="title" placeholder="Title"><br>
<textarea  name="notes" placeholder="Enter your notes here..."style="width: 410px; height: 200px;"></textarea><br>
<br>				
<button>Submit</button>
</form>
</div>

<?php

include '../config.php';

if(isset($_POST['title']) && isset($_POST['notes']))
{
	$title = $_POST['title'];
	$notes = $_POST['notes'];
	
	try
	{
		//connect to database
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		//insert data into db
		$stmt = $conn->prepare("INSERT INTO NOTES (TITLE,TEXT,EMPID) VALUES(? , ? , ?) ;");
		
		//execute sql query
		$stmt->execute(array($title,$notes,$empid));
		
		
		echo "Success! Note Inserted";
		
		
		
	}
	catch(PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
	}

	//close conection
	$conn = null;
	
}