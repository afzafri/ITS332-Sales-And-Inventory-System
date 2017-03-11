<?php
	require_once('../auth.php');
?>

<html>
<head>
<title>Update Info</title>
<link href="../templates/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
 <link href="../templates/dist/css/sb-admin-2.css" rel="stylesheet">
 <link rel="stylesheet" type="text/css" href="../css/design.css">
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Are you sure?');
}
</script>
</head>


<center>

<?php

include '../config.php';

//declare variable. use 'isset' to determine if variable is set and not null. if null, not execute
if(isset($_GET["id"]))
{
	$id = (isset($_GET["id"]) ? $_GET["id"] : null);
	
	try
	{
		
		//connect to database
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		//select data from db
		$stmt = $conn->prepare("SELECT ID, NAME, GENDER, DAY(DOB) AS DAY, MONTH(DOB) AS MONTH, YEAR(DOB) AS YEAR, 
											   ADDRESS, PHONE, IC, POSITION, PASSWORD, LEVEL FROM EMPLOYEE WHERE ID='$id'  ");
		
		//execute the sql query
		$stmt->execute();
		
		//function fetcht() used to get the column data
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		//fetch data in db and store into variable
		$id = $row['ID'];
		$name = strtoupper($row['NAME']);
		$gender = strtoupper($row['GENDER']);
		$day = $row['DAY'];
		$month = $row['MONTH'];
		$year = $row['YEAR'];
		$address = strtoupper($row['ADDRESS']);
		$phone = $row['PHONE'];
		$ic = $row['IC'];
		$position = strtoupper($row['POSITION']);
		$password = $row['PASSWORD'];
		$level = $row['LEVEL'];
	
		$arrgen = array("MALE","FEMALE");
		$arrlev = array("1","2");
		$days = range(1, 31);
		$months = range(1, 12);
		$years = range(1930, date('Y'));
		
		echo "
		<h1 class='page-header'>Update Info</h1>
		
		<div class='design-block'>
		
		<form action='empupdate.php?id={$id}' method='post' >
		<h4>ID : {$id}</h4>
		Name : <input type='text' name='names' value='{$name}'><br>
		
		<h4>Gender : <label><select name='genders'>
		
							<option value=''>Select Gender</option>
							";
						
						foreach($arrgen as $arrgen)
						{
							if($arrgen == $gender)
							{
								echo "<option value='{$arrgen}' selected>{$arrgen}</option>";
							}
							else
							{
								echo "<option value='{$arrgen}'>{$arrgen}</option>";
							}
						}
		
		//Date of Birth : <input type='text' name='dobs' value='{$dob}'><br>		
		echo "</select></label></h4>";
						
		
		//days	
		echo '
		<h4>Date Of Birth : <label><select name="hari">
		<option value="">Day</option>
		';				
		foreach($days as $days)
		{
			if($days == $day)
			{
				echo "<option value='{$days}' selected>{$days}</option> ";
			}
			else
			{
			echo "<option value='{$days}'>{$days}</option> ";
			}
		} 
		echo '</select>';

		//months
		echo '
		<select name="bulan">
		<option value="">Month</option>
		';				
		foreach($months as $months)
		{
			if($months == $month)
			{
				echo "<option value='{$months}' selected>{$months}</option> ";
			}
			else
			{
				echo "<option value='{$months}'>{$months}</option> ";
			}
		} 
		echo '</select>';

		//months
		echo '
		<select name="tahun">
		<option value="">Year</option>
		';				
		foreach($years as $years)
		{
			if($years == $year)
			{
				echo "<option value='{$years}' selected>{$years}</option> ";
			}
			else
			{
				echo "<option value='{$years}'>{$years}</option> ";
			}
		} 
		echo '</select>';


		echo '</label></h4><br>';
		
		echo "
		Address : <input type='text' name='addresss' value='{$address}'><br>
		Phone : <input type='text' name='phones' value='{$phone}'><br>
		IC : <input type='text'  name='ics' value='{$ic}'><br>
		Position : <input type='text' name='positions' value='{$position}'><br>
		Password : <input type='text' name='passs' value='{$password}'><br>
		
		<h4>Level : <label><select name='levels' value='{$level}'>
						<option value=''>Select Access Level</option>";
						
						foreach($arrlev as $arrlev)
						{
							$showlev = (($arrlev == 1) ? "Manager" : "Employee");
							if($arrlev == $level)
							{
								echo "<option value='{$arrlev}' selected>{$showlev}</option>";
							}
							else
							{
								echo "<option value='{$arrlev}'>{$showlev}</option>";
							}
						}
						
						
						echo "</select></label></h4><br>
											
		<input type='submit' name='update' value='Update' >
		</form>
		
		<form action='empupdate.php?id={$id}' method='post' enctype='multipart/form-data'>
    <h4>Upload new photo :</h4>
    <input type='file' name='fileToUpload' id='fileToUpload'>
    <input type='submit' value='Upload Image' name='upimg'><br>
  </form>
		
				
		<a href='./empupdate.php?id={$id}&delete=Delete' onclick='return checkDelete()'><button class='myButton'>Delete Data</button></a>
		
		</div>
		
		";
		
		if(isset($_POST['update']))
		{
			$names = strtoupper($_POST['names']);
			$genders = $_POST['genders'];
			$dobs = $_POST['tahun']."-".$_POST['bulan']."-".$_POST['hari'];
			$addresss = strtoupper($_POST['addresss']);
			$phones = $_POST['phones'];
			$ics = $_POST['ics'];
			$positions = strtoupper($_POST['positions']);
			$passs = $_POST['passs'];
			$levels = $_POST['levels'];
			
			$stmtupdate = $conn->prepare("UPDATE EMPLOYEE SET NAME=?, GENDER=?, DOB=?, 
																 ADDRESS=?, PHONE=?, IC=?, POSITION=?, PASSWORD=?, LEVEL=? WHERE ID=? ");
																 
			$stmtupdate->execute(array($names,$genders,$dobs,$addresss,$phones,$ics,$positions,$passs,$levels,$id));
			
			echo "<script>alert('Success! Data Updated.')</script>";
		}
		if(isset($_GET['delete']))
		{	
			$stmtdel = $conn->prepare("DELETE FROM EMPLOYEE WHERE ID='{$id}' ");
			$stmtdel->execute();
			
			unlink("../images/userimg/".$id.".jpg");
			
			echo "<script>alert('Data Deleted')</script>";
		}
		if(isset($_POST['upimg']))
		{
		  include 'imgupd.php';
		}
		
	}	
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
	}

	//close conection
	$conn = null;
	
}


 
?>

</center>
</body>
</html>

