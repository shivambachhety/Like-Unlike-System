<?php
	include ('connect.php');
	session_start();
		
	if (isset($_POST['like'])){		
		
		$id = $_POST['id'];
		$query=mysqli_query($conn,"select * from `like` where postid='$id' and userid='".$_SESSION['userid']."'") or die(mysqli_error());
		
		if(mysqli_num_rows($query)>0){
			mysqli_query($conn,"delete from `like` where userid='".$_SESSION['userid']."' and postid='$id'");
		}
		else{
			mysqli_query($conn,"insert into `like` (userid,postid) values ('".$_SESSION['userid']."', '$id')");
		}
	}		
?>


