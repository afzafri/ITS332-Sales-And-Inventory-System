<?php
	require_once('./auth.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<script type="text/javascript" src="./js/mootools.js"></script>
	<script type="text/javascript" src="./js/datepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="./css/datepicker.css">
	<link rel="stylesheet" type="text/css" href="./css/notes.css">
	<script type="text/javascript">
	window.addEvent('load', function() {
		
		new DatePicker('.from', 
				{ 
				positionOffset: { x: 0, y: 5 },
				inputOutputFormat: 'Y-m-d'
				});
				
		new DatePicker('.to', { 
				positionOffset: { x: 0, y: 5 },
				inputOutputFormat: 'Y-m-d'
				});
				
	});
	</script>

    <title>Sales & Inventory System</title>
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="./images/favicon.ico" />

    <!-- Bootstrap Core CSS -->
    <link href="./templates/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="./templates/dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="./templates/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="./templates/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- Custom 2 -->
	<link rel="stylesheet" type="text/css" href="./css/design.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>


    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php">Sales & Inventory System</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
             
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="./employee/profile.php?id=<?php echo ($_SESSION['SESS_MEMBER_ID']) ?>"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
						<a href="logout.php" onclick="return confirm('Are you sure to logout?');"><i class="fa fa-sign-out fa-fw"></i>Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
			
			<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
			<?php 
			if(($_SESSION['SESS_MEMBER_LEVEL']) == 1 )
			{
				echo '
				
				
                        <li>
                            <a href="home.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
						<br>
						 <li>
                            <a href="./employee/"><i class="fa fa-user fa-fw"></i> Add Employee</a>
                        </li>
						 <li>
                            <a href="./employee/emplist.php"><i class="fa fa-table fa-fw"></i> List Employee</a>
                        </li>
						<li>
                            <a href="./employee/profile.php"><i class="fa fa-search"></i> Search Employee</a>
                        </li>
						<br>
						<li>
                            <a href="./product/"><i class="fa fa-edit fa-fw"></i> Add Products</a>
                        </li>
						<li>
                            <a href="./product/prodlist.php"><i class="fa fa-table fa-fw"></i> List Products</a>
                        </li>
						<li>
                            <a href="./stock/"><i class="fa fa-shopping-cart fa-fw"></i> Add New Stocks</a>
                        </li>
						<li>
                            <a href="./stock/upstock.php"><i class="fa fa-shopping-cart fa-fw"></i> Update Stocks</a>
                        </li>
						<br>
                        <li>
                            <a href="./record/"><i class="fa fa-edit fa-fw"></i> Record Sales</a>
                        </li>
						 <li>
                            <a href="./sales/"><i class="fa fa-table fa-fw"></i> Show Sales</a>
                        </li>
                 
				
				
				';
			}
			else
			{
				echo '
				
				
                        <li>
                            <a href="home.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
						<br>
						<li>
                            <a href="./product/prodlist.php"><i class="fa fa-table fa-fw"></i> List Products</a>
                        </li>
						<li>
                            <a href="./stock/"><i class="fa fa-shopping-cart fa-fw"></i> Add New Stocks</a>
                        </li>
						<li>
                            <a href="./stock/upstock.php"><i class="fa fa-shopping-cart fa-fw"></i> Update Stocks</a>
                        </li>
						<br>
                        <li>
                            <a href="./record/"><i class="fa fa-edit fa-fw"></i> Record Sales</a>
                        </li>
						 <li>
                            <a href="./sales/"><i class="fa fa-table fa-fw"></i> Show Sales</a>
                        </li>
                 
				
				
				';
			}
			
			?>
		
				<li>
				<div class="logo"></div>
				<center><b>Copyright &copy; 2014 - <?php echo date('Y') ?> </b></center><br>
				</li>
				
				</ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
			
			
			
			
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">