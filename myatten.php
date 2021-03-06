<html>
<head>
<meta charset="utf-8">
<title>My Attendance || Attendance Management System</title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Raleway" />
<style type="text/css">
	.back_logout_div{
		width:90%;
		padding-left:40px;
		padding-top:40px;
	}
	tr{
		height:35px;
		border:none;
	}
	.student_table{
		margin-left:50px;
		margin-top:30px;
	}
	* {
		font-family: Raleway;
	}
</style>
</head>
  <?php
session_start();
if(!isset($_SESSION['s_username'])){
	header("location: index.php");
	}
else {
?>
<?php
include("header-all.php");
?>
<div class="content_main">

	<div class="back_logout_div" style="height:30px;">
		<div class="back_div" style="float:left; height:100%;"><p align="left"><a href="student.php" style="text-decoration:underline; color:#2E9AFE;">Back</a></P></div>
		<div class="back_div" style="float:right; height:100%;"><p align="right"><a href="logout.php"style="text-decoration:underline; color:#2E9AFE;">Log Out</a></P></div>
	</div>
<?php

	$Code=$_GET['Co'];
	$CurrentYear=$_GET['Cu'];
	$S_Id=$_GET['I'];
	$T_Id=$_GET['TI'];
	$Class=$_GET['Cl'];
	$Batch=$_GET['B'];
	$Semester=$_GET['Se'];
	$Section=$_GET['Sc'];
	
	$table_name=$T_Id."-".$CurrentYear."-".$Class."-".$Batch."-".$Semester."-".$Code."-".$Section;
	$my_attendance=0;
	$my_atten_per=0;
	$class_held=0;
	
	
	//Finding Current Student's Attendance
	include("connect.php");
	$query= "SELECT SUM(`$S_Id`) AS maxid FROM `$table_name`";
	$result = mysql_query($query);
	$count = mysql_num_rows($result);
		if ($count==0)
		{
			//echo "You have not been assigned any class.";
		}
		else
		{
			while($row = mysql_fetch_array($result)) 
			{
				$my_attendance= $row['maxid'];
			}
		}
		mysql_close($con);
		
	//Finding Total Class Held
	include("connect.php");
	$query= "SELECT COUNT(*) AS class FROM `$table_name`";
	$result = mysql_query($query);
	$count = mysql_num_rows($result);
		if ($count==0)
		{
			//echo "You have not been assigned any class.";
		}
		else
		{
			while($row = mysql_fetch_array($result)) 
			{
				$class_held= $row['class'];
			}
		}
		mysql_close($con);
	
	//Attendance percentage Claculation

	$my_atten_per=($my_attendance/$class_held)*100;
?>
<table class="student_table" align="center" border="1px">
	<tr>
		<td><strong>Student Id</strong></td>
		<td><strong>Subject Code</strong></td>
		<td><strong>Class/Dep</strong></td>
		<td><strong>Batch</strong></td>
		<td><strong>Semester</strong></td>
		<td><strong>Section</strong></td>
		<td><strong>My Attendance</strong></td>
		<td><strong>Total Class Held</strong></td>
		<td><strong>Percentage(%)</strong></td>
	</tr>
	<tr>
		<td><?php echo $S_Id;?></td>
		<td><?php echo $Code;?></td>
		<td><?php echo $Class;?></td>
		<td><?php echo $Batch;?></td>
		<td><?php echo $Semester;?></td>
		<td><?php echo $Section;?></td>
		<td><?php echo $my_attendance;?></td>
		<td><?php echo $class_held;?></td>
		<td><?php echo number_format((float)$my_atten_per, 2, '.', '')."%";?></td>
		
	</tr>
</table>

</div>
<?php
include("footer.php");
?>
<?php
}//closing of isset
?>
</html>