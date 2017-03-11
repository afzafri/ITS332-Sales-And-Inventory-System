<?php
	require_once('../auth.php');
?>

<?php include '../templates/headerfolder.php'; ?>


<center>

<?php
	if(($_SESSION['SESS_MEMBER_LEVEL']) == 1 )
	{
		echo ' 
		
		<h1 class="page-header">Search/View Employee</h1>
		<form action="profile.php" method="get">
		Employee ID : <input type="text" name="id"><br><br>
		<input type="submit" class="myButton"><br><br>
		</form>

		
		';
	}	
	else
	{
		echo '
		
		<h1 class="page-header">Profile</h1>
		
		';
	}

?>
<?php

include '../config.php';

//declare variable. use 'isset' to determine if variable is set and not null. if null, not execute
if(isset($_GET["id"]))
{
	$id = (isset($_GET["id"]) ? $_GET["id"] : null);
	$idlogin = ($_SESSION['SESS_MEMBER_ID']);
	$levellogin = ($_SESSION['SESS_MEMBER_LEVEL']);
	
	//check if user is allow to view profile, return true if allowed
	if( ($id == $idlogin) && ($levellogin == 1)) 
	{
		$status = true;
	}
	else if( ($id != $idlogin) && ($levellogin == 1)) 
	{
		$status = true;
	}
	else if( ($id == $idlogin) && ($levellogin == 2))
	{
		$status = true;
	}
	else if( ($id != $idlogin) && ($levellogin == 2))
	{
		$status = false;
	}
	
	//check if status true, allow user to view
	if($status == true)
	{
		try
		{
			
			//connect to database
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			

			//select data from db
			$stmt = $conn->prepare("SELECT ID, NAME, GENDER, DATE_FORMAT(DOB,'%d-%m-%Y') AS DATE, 
											 (YEAR(CURDATE()) - YEAR(DOB)) AS AGE, ADDRESS, PHONE, IC, POSITION, LEVEL FROM EMPLOYEE WHERE ID='$id'  ");

			//execute the sql query
			$stmt->execute();
			
			//function fetcht() used to get the column data
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			
			//fetch data in db and store into variable
			$id = $row['ID'];
			$name = $row['NAME'];
			$gender = $row['GENDER'];
			$dob = $row['DATE'];
			$age = $row['AGE'];
			$address = $row['ADDRESS'];
			$phone = $row['PHONE'];
			$ic = $row['IC'];
			$position = $row['POSITION'];
			$level = $row['LEVEL'];
			
			
			if($id != null)
			{
				
				echo "<br><div class='imgBorder'>";
				if(file_exists("../images/userimg/".$id.".jpg"))
				{
					echo "<img width=150px height=150px src='../images/userimg/".$id.".jpg'></img>";
				}
				else
				{
					echo "<img width=150px height=150px src='../images/userimg/noimage.jpg'></img>";
				}
				
				echo "</div>";
				
				echo "<div class='table-responsive'>
				<table class='table table-bordered table-hover table-striped'>";
				echo "<br>";
				echo "<tr>";
				echo "	<th>ID</th><td>".htmlentities(strtoupper($id))."</td>";
				echo "</tr>";
				echo "<tr>";
				echo "	<th>Name</th><td>".htmlentities(strtoupper($name))."</td>";
				echo "</tr>";
				echo "<tr>";
				echo "	<th>Gender</th><td>".htmlentities(strtoupper($gender))."</td>";
				echo "</tr>";
				echo "<tr>";
				echo "	<th>DOB</th><td>".htmlentities(strtoupper($dob))."</td>";
				echo "</tr>";
				echo "<tr>";
				echo "	<th>Age</th><td>".htmlentities($age)."</td>";
				echo "</tr>";
				echo "<tr>";
				echo "	<th>Address</th><td>".htmlentities(strtoupper($address))."</td>";
				echo "</tr>";
				echo "<tr>";
				echo "	<th>Phone</th><td>".htmlentities($phone)."</td>";
				echo "</tr>";
				echo "<tr>";
				echo "	<th>IC</th><td>".htmlentities($ic)."</td>";
				echo "</tr>";
				echo "<tr>";
				echo "	<th>Position</th><td>".htmlentities(strtoupper($position))."</td>";
				echo "</tr>";
				echo "<tr>";
				echo "	<th>Access Level</th><td>".(($level == 1) ? "Manager" : "Employee")."</td>";
				echo "</tr>";
				
				echo "</table></div>";
				
			}	
			else
			{
				echo "<h2><font color='red'>No data available.</font></h2>";
			}
			
		}	
		catch (PDOException $e)
		{
			if((strpos($id, "'") == true))
			{
				echo "<font color='red'><h1>WOW! HACKER!</h1></font>";
			}
			else
				echo "Connection failed: " . $e->getMessage();
		}

			//close conection
			$conn = null;
		
	}
	else
	{
		echo "<font color='red'><h2>You have no privileged to view this page!</h2></font>";
	}
	


	if(($_SESSION['SESS_MEMBER_LEVEL']) == 1 )
	{
		echo "<br>";
		?>
		<a href="empupdate.php?id=<?php echo $id ?>" onclick="centeredPopup(this.href,'Add Notes','470','550','no');return false"><button class="myButton">Update Info</button></a>
		<?php
		echo "<br><br>";
	}
}		

?>


<script language="javascript">
var popupWindow = null;
function centeredPopup(url,winName,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings ='height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
popupWindow = window.open(url,winName,settings)
}
</script>


</center>
<?php include '../templates/footerfolder.php'; ?>