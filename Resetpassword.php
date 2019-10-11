<?php
require_once '../inc/dbconfig.php';
include_once 'header.php';

//LOCATE USER SUBMITED DEATAILS
if (isset($_POST['submit'])) {
	
	$user = mysqli_real_escape_string($conn,$_POST['user_name']);

$sql = "SELECT id,fname,lname,user_name,email,phone FROM users WHERE user_name = '$user' OR email = '$user' OR phone = '$user' LIMIT 1";
$query = mysqli_query($conn,$sql);

//GET NUMBER OF USERS FOUND
$count = mysqli_num_rows($query);
if ($count > 1) {
	echo "ERRORS";
	exit();

}elseif ($count < 1) {
	echo '
<script> 
<!--  
   alert ("Oops ! Request Failed ,Try Again Later...!"); 
   window.location.href="Resetpassword.php"; 
//--> 
</script> 
';
	exit();

}elseif ($count = 1) {
	$result = mysqli_fetch_array($query,MYSQLI_ASSOC);
	$found_username = $result['fname']." ".$result['lname'];
	echo "</br>";
	echo '
  <div class="container" style=" width:96%;margin-left: 2%;margin-right: 2%;" >
  <img src="../img/logo.jpg" style="width:35%;">
		<div class="card">
			<div class="card-header"><h6 align="center"><p>'.$found_username.'</p><br>Reset Password <br><small style="color: red;">STEP TWO</small></h6></div>
				<div class="card-body" >
				
				<form action="Resetpassword_.php" method="POST">
				<div class="form-group">
 				<label for="password_new" class="sr-only">New Password</label>
 				<input type="password" name="password_new" id="password_new" class="form-control" placeholder="Enter New Password" required="">
 				</div>
 				<br>
 				<div class="form-group" >
 				<label for="password_new_again" class="sr-only">Confirm New Password</label>
 				<input type="password" name="password_new_again" id="password_new_again" class="form-control" placeholder="Confirm New Password" required="">	
 				</div>
 				<input type ="hidden" name="userid" value="'.$result['id'].'">
 				<input type="submit" name="send" value="Request New Password" class="btn btn-warning">
 				</form>
 		</div>
 </div>';
	}

}else{
	echo '
	<img src="../img/logo.jpg" style="width:35%;">
	<div class="container" style=" width:100%;margin-left: 0%;">
  		<div class="row" >
			<div class="card bg-light" style=" width:100%;margin-left: 2%;margin-right: 2%;">
				<div class="card-header"><h6 align="center"> Reset Password <br><small style="color: red;">STEP ONE</small></h6></div>
					<div class="card-body" >
					<form action="?" method="POST">
					<div class="form-group">
 					<label for="password_current" class="lr-only">Enter Recovery Details</label>
 					<input type="text" name="user_name" id=" user_name" class="form-control" placeholder="Username Or Email" autocomplete="off" required="">
 					</div>
 					<input type="submit" name="submit" value="Submit" class="btn btn-warning">
 				</form>
		 </div>
 </div>';
}


?>


 <?php include_once 'footer.php'; ?>