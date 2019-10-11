<?php 
require 'header.php';
require 'topnav.php';
require 'apis/dbconfig.php';

?>

<!-- card basic -->
<div class="container-fluid ">
 <div class="row tent-main-container ">
    <div class="col s12 m6 tent-main-container">
      <div class="card white darken-1 tnet-main-container">
        <div class="card-content white-black text-bold">
          <span class="card-title"><i class="fa fa-user green-text"></i>&nbsp;Profile</span>
          <hr>
          <?php


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

                echo'<p class="profile-p">
                    <img src="'.$profilePic.'" class="profile-img img-circle">
                    <br>
                    '. ucfirst($user_details['ufname'])."&nbsp;". ucfirst($user_details['ulname']).'<br>
                    Mobile : +254'. $user_details['umobile'].'<br>
                    Email : '. strtolower($user_details['umail']).'<br>
                    National ID: '. $user_details['uidno'].'<br>
                    Account Type: Subscriber<br>
                    Registration : '. $user_details['regdate'].'<br>
                    Organization : '.ucwords( $user_details['uinstname']).'<br>
                    Package: Gold (3months)<br>
                    Expiry: 5th Dec 2019 <br><br>
                    <a href="#" class=" btn btn-success btn-small profile-update-btn text-upper tnet-text-xs">update</a>

                  </p>';
              }
            }
          ?>
          
        </div>
      </div>
    </div>
  </div>
</div>   
<!-- footer elements -->
<script src="plugins/tnet.js"></script>
<?php 
require 'bfooter.php';
require 'footer.php';
?>
