<?php

//Start session
session_start();	
//Unset the variables stored in session
unset($_SESSION['SESS_MEMBER_ID']);
unset($_SESSION['SESS_MEMBER_PASS']);
unset($_SESSION['SESS_MEMBER_LEVEL']);

?>

<html>
<head>
<title>Sales & Inventory System</title>
<link rel="shortcut icon" href="./images/favicon.ico" />
<link rel="stylesheet" type="text/css" href="./css/login.css">
</head>

<body>

<div class="logo"></div>

<div class="login-block">

<form action="index.php" method="post">
	<h1>Login</h1>
	<input type="text" value="" placeholder="Employee ID" id="username" name="id" required="required"/>
    <input type="password" value="" placeholder="Password" id="password" name="pass" required="required"/>
    <button>Login</button>

                   

<?php

include 'config.php';

if(isset($_POST["id"]) && isset($_POST["pass"]))
{
		
	$id = $_POST["id"];
	$pass = $_POST["pass"];	
		
	try
	{
		//connect to db
		$conn = new PDO("mysql:host=$servername;dbname=$dbname" , $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		//sql query
		$stmt = $conn->prepare("SELECT ID, PASSWORD, LEVEL FROM EMPLOYEE");

		//execute query
		$stmt->execute();
		
		//fetch
		while($result = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			//store fetched data into variable
			$i = $result['ID'];
			$p = $result['PASSWORD'];
			$l = $result['LEVEL'];
			
			if($id == $i && $pass == $p)
			{
				session_regenerate_id();
				$_SESSION['SESS_MEMBER_ID'] = $i;
				$_SESSION['SESS_MEMBER_PASS'] = $p;
				$_SESSION['SESS_MEMBER_LEVEL'] = $l;
				session_write_close();
				header("location: home.php");
				exit();
			}
			else
			{
				$err = "Wrong username/password!";
			}
		}
		
		
		if(isset($err))
		{
			echo "<center><font color='red'><p>$err</p></font></center>";
		}
		
	}
	catch(PDOException $e)
	{
		echo "Connection failed : " . $e->getMessage();
	}

	$conn = null;
}

?>

</form>
</div>
<br><center><b>Copyright &copy; 2014 - <?php echo date('Y') ?> </b></center><br>
</body>
</html>