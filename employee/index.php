<?php
	require_once('../auth.php');
	if(($_SESSION['SESS_MEMBER_LEVEL']) != 1 )
	{
		header("location: ../home.php");
	}
	include '../templates/headerfolder.php'; 
	
	//required fields handling	
	$errID = $errName = $errGender = $errDOB = $errAdd = $errPhone = $errIC = $errPos = $errPass = $errLev = "";
	$id = $name = $gender = $day = $month = $year = $address = $phone = $ic = $position = $pass = $level = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(empty($_POST['id'])) {$errID = "*Employee ID is required.";} else { $id = $_POST["id"];}
		if(empty($_POST['name'])) {$errName = "*Name is required.";} else { $name = $_POST["name"];}
		if(empty($_POST['gender'])) {$errGender = "*Gender is required.";} else { $gender = $_POST["gender"];}
		if(empty($_POST['day']) && empty($_POST['month']) && empty($_POST['year'])) {$errDOB = "*Date of Birth is required.";} else { $year = $_POST["year"]; $month = $_POST["month"]; $day = $_POST["day"];}
		if(empty($_POST['address'])) {$errAdd = "*Address is required.";} else { $address = $_POST["address"];}
		if(empty($_POST['phone'])) {$errPhone = "*Phone Number is required.";} else { $phone = $_POST["phone"];}
		if(empty($_POST['ic'])) {$errIC = "*Identification Card is required.";} else { $ic = $_POST["ic"];}
		if(empty($_POST['position'])) {$errPos = "*Job Position is required.";} else { $position = $_POST["position"];}
		if(empty($_POST['pass'])) {$errPass = "*Password is required.";} else { $pass = $_POST["pass"];}
		if(empty($_POST['level'])) {$errLev = "*System Access Level is required.";} else { $level = $_POST["level"];}
	}
	
	
?>

<center>
<h1 class='page-header'>Add Employee</h1>

<div class="design-block">
<form action="index.php" method="post" enctype="multipart/form-data" >

<?php echo "<font color='red'>" . $errID . "</font>"; ?>
<input type="text" name="id" placeholder="ID" value="<?php echo (isset($_POST['id']) ? $_POST['id'] : null); ?>"><br>

<?php echo "<font color='red'>" . $errName . "</font>"; ?>
<input type="text" name="name" placeholder="Name" value="<?php echo (isset($_POST['name']) ? $_POST['name'] : null); ?>"><br>

<?php echo "<font color='red'>" . $errGender . "</font>"; ?>
<h4>Gender : <label><select name="gender">
				
				<option value="">Select Gender</option>
				<?php 
				if(($_POST['gender']) == "MALE")
				{
					echo '<option value="MALE" selected>MALE</option>
				<option value="FEMALE">FEMALE</option>';
				}
				else if(($_POST['gender']) == "FEMALE")
				{
					echo '<option value="MALE">MALE</option>
				<option value="FEMALE" selected>FEMALE</option>';
				}
				else
				{
					echo '<option value="MALE">MALE</option>
				<option value="FEMALE">FEMALE</option>';
				}
				?>
				</select></label></h4>

<?php echo "<font color='red'>" . $errDOB . "</font>"; ?>				
<h4>Date of Birth :

<!-- Start dob-->
<?php

$days = range(1, 31);
$months = range(1, 12);
$years = range(1930, date('Y'));

//days	
echo '
<label><select name="day">
<option value="">Day</option>
';				
foreach($days as $days)
{
	if(($_POST['day']) == $days)
	{
		echo "<option value='$days' selected>$days</option> ";
	}
	else
	{
		echo "<option value='$days'>$days</option> ";
	}
} 
echo '</select></label>';

//months
echo '
<label><select name="month">
<option value="">Month</option>
';				
foreach($months as $months)
{
	if(($_POST['month']) == $months)
	{
		echo "<option value='$months' selected>$months</option> ";
	}
	else
	{
		echo "<option value='$months'>$months</option> ";
	}
	
} 
echo '</select></label>';

//months
echo '
<label><select name="year">
<option value="">Year</option>
';				
foreach($years as $years)
{
	if(($_POST['year']) == $years)
	{
		echo "<option value='$years' selected>$years</option> ";
	}
	else
	{
		echo "<option value='$years'>$years</option> ";
	}
	
} 
echo '</select></label>';


echo '</h4><br>';

?>
<!--End dob-->

<?php echo "<font color='red'>" . $errAdd . "</font>"; ?>
<input type="text" name="address" placeholder="Address" value="<?php echo (isset($_POST['address']) ? $_POST['address'] : null); ?>"><br>

<?php echo "<font color='red'>" . $errPhone . "</font>"; ?>
<input type="text" name="phone" placeholder="Phone" value="<?php echo (isset($_POST['phone']) ? $_POST['phone'] : null); ?>"><br>

<?php echo "<font color='red'>" . $errIC . "</font>"; ?>
<input type="text" name="ic" placeholder="Identification Card. (No dash. Ex : 960521025077)" value="<?php echo (isset($_POST['ic']) ? $_POST['ic'] : null); ?>"><br>

<?php echo "<font color='red'>" . $errPos . "</font>"; ?>
<input type="text" name="position" placeholder="Job Position" value="<?php echo (isset($_POST['position']) ? $_POST['position'] : null); ?>"><br>

<?php echo "<font color='red'>" . $errPass . "</font>"; ?>
<input type="text" name="pass" placeholder="Password" value="<?php echo (isset($_POST['pass']) ? $_POST['pass'] : null); ?>"><br>

<?php echo "<font color='red'>" . $errLev . "</font>"; ?>
<h4>Access Level : <label><select name="level">
				<option value="">Select Access Level</option>

				<?php
				if(($_POST['level']) == 1)
				{
					echo '<option value="1" selected>Manager</option>
				<option value="2">Employee</option>';
				}
				else if(($_POST['level']) == 2)
				{
					echo '<option value="1">Manager</option>
				<option value="2" selected>Employee</option>';
				}
				else
				{
					echo '<option value="1">Manager</option>
				<option value="2">Employee</option>';
				}
				?>
				</select></label></h4><br>
				
<h4>Choose an image to upload : </h4><input type="file" name="fileToUpload" id="fileToUpload"><br><br>
<button>Submit</button>
</form>
</div>

<?php

include '../config.php';

//declare variable. use 'isset' to determine if variable is set and not null. if null, not execute
if(isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["gender"]) && 
isset($_POST["address"]) && isset($_POST["phone"]) && isset($_POST["ic"]) && 
isset($_POST["position"]) && isset($_POST["pass"]) && isset($_POST["level"]) && 
isset($_POST['day']) && isset($_POST['month']) && isset($_POST['year']) )
{
	$id = strtoupper($_POST['id']);
	$name = strtoupper($_POST['name']);
	$gender = $_POST['gender'];
	$day = $_POST['day'];
	$month = $_POST['month'];
	$year = $_POST['year'];
	$dob = $year."-".$month."-".$day;
	$address = strtoupper($_POST['address']);
	$phone = $_POST['phone'];
	$ic = $_POST['ic'];
	$position = strtoupper($_POST['position']);
	$pass = $_POST['pass'];
	$level = $_POST['level'];
	

	if($id != "" && $name != "" && $gender !="" && $day != "" &&
	$month != "" && $year != "" && $address != "" && $phone != "" &&
	$ic != "" && $position != "" && $pass != "" && $level != "")
	{
		try
		{
			//connect to database
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			//check id
			$checkid = $conn->prepare("SELECT ID FROM EMPLOYEE WHERE ID='{$id}';");
			$checkid->execute();
			$row = $checkid->fetch(PDO::FETCH_ASSOC);
			if($row['ID'] == null)
			{
				
				//insert data into db
				$stmt = $conn->prepare("INSERT INTO EMPLOYEE VALUES(?,?,?,?,?,?,?,?,?,?);");
				
				//execute sql query
				$stmt->execute(array($id , $name , $gender , $dob , $address , $phone , $ic , $position , $pass , $level));
				
				echo "<script>alert('Success! Data Inserted.')</script>";
			}
			else
			{
				echo "<script>alert('Employee ID already exist in database!')</script>";
			}
			
			
			
		}
		catch(PDOException $e)
		{
			echo "Connection failed: " . $e->getMessage();
		}

		//close conection
		$conn = null;
		
		//use image upload script
		include 'imgup.php';
		
	}
	else
	{
		echo "<script>alert('Please complete the form!')</script>";
	}
}


?>

</center>
<?php include '../templates/footerfolder.php'; ?>