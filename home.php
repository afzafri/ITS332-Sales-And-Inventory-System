<?php
	require_once('auth.php');
	include './templates/header.php'; 
	$alevel = ($_SESSION['SESS_MEMBER_LEVEL']);
?>

<h1 class='page-header'>Dashboard</h1>
<h3>
<?php echo "ID : <b>".($_SESSION['SESS_MEMBER_ID']) . "</b><br>Access Level : <b>". (($alevel == 1) ? "Manager" : "Employee") . "</b>" ; ?>
</h3>

<br>
<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Notifications Panel
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                 <a href="./sales/index.php?today=Daily+Sales&from=&to=" class="list-group-item">
								 
<?php

include 'config.php';
	
try
{
	//connect db
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	//get total sales today
	$salesnum = $conn->prepare("SELECT COUNT(*) AS TOTAL,SUM(QUANTITY) AS SOLD 
														FROM SALES 
														WHERE DATE_TIME=CURDATE()");
	$salesnum->execute();
	$result = $salesnum->fetch(PDO::FETCH_ASSOC);
	$sales = $result['TOTAL'];
	$sold = $result['SOLD'];
	
	//get total low stock
	$countstmt = $conn->prepare(" SELECT COUNT(*) AS COUNTLOW
														FROM PRODUCTDETAIL
														WHERE QUANTITY < 5");
	$countstmt->execute();
	$resultlow = $countstmt->fetch(PDO::FETCH_ASSOC);
	$countlow = $resultlow['COUNTLOW'];
	
	echo "
	 <i class='fa fa-money fa-fw'></i> Today's Sales :<br> 
	 <i>
	 <b>$sales</b> total sales <br>
	 <b>$sold</b> total items sold    
	 </i>
	</a>
	<a href='./stock/' class='list-group-item'>
	";
	
	echo "<i class='fa fa-shopping-cart fa-fw'></i> <b>$countlow</b> Stock Is Running Low (Stock below 5 pcs) : <br>";
	 
	 //get list of low stock
	$getlow = $conn->prepare(" SELECT P.PRODUCTNAME, PD.SIZE , PD.COLORS, 
														PD.SLEEVE, PD.FLOWERSEMB, PD.QUANTITY
														FROM PRODUCT P, PRODUCTDETAIL PD
														WHERE P.PRODUCTID = PD.PRODUCTID
														AND PD.QUANTITY <5");
	$getlow->execute();
	
	while ($row = $getlow->fetch(PDO::FETCH_ASSOC))
	{
		$name = $row['PRODUCTNAME'];
		$size = $row['SIZE'];
		$colors = $row['COLORS'];
		$sleeve = $row['SLEEVE'];
		$flowers = $row['FLOWERSEMB'];
		$quantity = $row['QUANTITY'];
		
		echo "
			<i>$name $colors $sleeve $flowers $size : <b>$quantity left</b></i> <br>
		";
	}
	
	echo "
	</a>
	</div>
	<!-- /.list-group -->
	</div>
	<!-- /.panel-body -->
	</div>
	
	
	<h1 class='page-header'>Sticky Notes</h1> 
	
	<div class='panel panel-default'>
	<div class='panel-heading'>
                            <i class='fa fa-edit fa-fw'></i> "; ?><a href="./notes/" onclick="centeredPopup(this.href,'Add Notes','470','540','no');return false"><button class="myButton">Add Notes</button></a><?php
                        
						echo "</div>
	
	";
	
	echo '
	<div class="notes">
	<ul>';
		
	 //get notes
	$getnotes = $conn->prepare(" SELECT * FROM NOTES ORDER BY ID DESC");
	$getnotes->execute();
	
	while ($row = $getnotes->fetch(PDO::FETCH_ASSOC))
	{
		$id = $row['ID'];
		$title = $row['TITLE'];
		$texts = $row['TEXT'];
		$empid = $row['EMPID'];
		
		echo "
			<li>";
				?><a href="./notes/edit.php?notesid=<?php echo $id ?>" onclick="centeredPopup(this.href,'Add Notes','470','590','no');return false"><?php
				echo "
					<h2>".htmlentities($title)."</h2>
					<p>".htmlentities($texts)."
					<br><br><h4>By : {$empid}</h4>
					</p>
				</a>
			</li>
		";
	}	
	
	
}	
catch (PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}

//close conection
$conn = null;

?>

  </ul>
</div>
</div>

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

<?php include './templates/footer.php'; ?>