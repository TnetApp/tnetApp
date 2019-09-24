<?php
require 'apis/dbconfig.php';
require 'apis/functions.php';
if (isset($_SESSION['utoken'])) {
  $utoken = $_SESSION['utoken'];
}else{
  header('Location:login.php');
}


$query = "SELECT * FROM users WHERE utoken = ?";
$stmt = mysqli_stmt_init($conn);
if (mysqli_stmt_prepare($stmt, $query)) {
  mysqli_stmt_bind_param($stmt, 's', $utoken);
  mysqli_stmt_execute($stmt);

  $result = mysqli_stmt_get_result($stmt);
  foreach ($result as $key => $user_details) {
    $logged_user = $user_details['ufname'];
    $profilePic = $user_details['uprofile'];
  }
}


 ?>
<nav class="nav-extended">
    <div class="nav-wrapper tnet-bg">
      <a href="#" class="pull-left tnet-logo"><img src="images/logo.png"></a>
      <!-- chips -->
  <div class="chip pull-right">
    <img src="<?php print($profilePic); ?>" alt="">
    <?php print(ucfirst($logged_user)); ?>
  </div>
    </div>
  </nav>
<style type="text/css">
  .tnet-bg{
    background-color: white;
    color: darkgreen;
    width: 100%;
  }
  .tnet-theme{
    color: green;
  }
  .tnet-logo{
    margin-left: 10px;
    height: 35px;
  }
  .chip{
    margin-top: 8px;
    box-shadow:-2px -1px 4px 4px black;
    background-color: white;
  }
</style>