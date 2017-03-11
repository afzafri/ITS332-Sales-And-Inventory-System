<?php
	require_once('../auth.php');
?>

<?php include '../templates/headerfolder.php'; ?>


<center>

<div class="noprint">

<h1 class='page-header'>Show Sales</h1>

<form action="index.php" method="get">

<input type="submit" name="today" value="Daily Sales" class="myButton">&nbsp;
<input type="submit" name="month" value="Monthly Sales" class="myButton">&nbsp;
<input type="submit" name="year" value="Yearly Sales" class="myButton">&nbsp;

From <input type="text" size='5' name="from" id="datepicker-start">&nbsp;
To <input type="text" size='5' name="to" id="datepicker-end">&nbsp; 

<input type="submit" name="range" value="Show" class="myButton">

</form>


</div>

<div class="printonly">
<h1>Gerobok Kalsom</h1>
</div>
<?php

if(isset($_GET['today']))
{
	include 'today.php';
}
if(isset($_GET['month']))
{
	include 'month.php';
}
if(isset($_GET['year']))
{
	include 'year.php';
}
if(isset($_GET['from']) && isset($_GET['to']) && isset($_GET['range']))
{
	$from = $_GET['from'];
	$to = $_GET['to'];
	
	//echo "from : $from <br> to : $to";
	include 'range.php';
}

?>

<div class="noprint">
<br><br>

<a href='javascript:window.print()'><button class="myButton">Print</button></a><br><br>


</center>
</div>


<?php include '../templates/footerfolder.php'; ?>

