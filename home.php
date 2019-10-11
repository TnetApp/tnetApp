<?php 
require 'header.php';
require 'topnav.php';
require 'keepsession.php';
include 'apis/dbconfig.php';



  if (isset($_SESSION['utoken'])) {
    //find logged in user
    $loggedin = $_SESSION['utoken'];
    
    $sql="SELECT * FROM plan WHERE account = '$loggedin' LIMIT 1";
    $query = mysqli_query($conn,$sql);
    foreach ($query as $users) {
      $account = $users['account'];
      $package = $users['package'];
      $account_status = $users['account_status'];
    }
  }
?>
<!-- card basic -->
<div class="container-fluid ">
 <div class="row tent-main-container ">
    <div class="col s12 m6 tent-main-container">
      <div class="card white darken-1 tnet-main-container">
        <div class="card-content white-black text-bold">
          
            <?php 
        /*SWITCH BETWEEN FORM AND PLAN*/
        if ($account_status === '0') {
         echo '
        <span class="card-title"><i class="fa fa-cog green-text"></i> Packages</span>
          
      <div class="card-body">
        <form class="form" action="plan" method ="POST">
           <div class="row">
        <div class="col-md-12">
            <div class="col-md-8">
                <div class="radio" >
                    <label>
                        <input type="radio" name="plan" value="bronze"/>
                        <span class="cr"></span>
                        <br>
                        <p><b>BRONZE</b><br>
                          <li>Valid for 24 hours usage.</li>
                          <li>Unlimited Internet.</li>
                          <li>Charges: Kshs 50.</li>
                        </p>
                    </label>
                </div>
            </div>  
            <hr>
              <div class="col-md-8">
                <div class="radio" >
                    <label>
                        <input type="radio" name="plan" value="silver"/>
                        <span class="cr"></span>
                        <br>
                        <p><b>SILVER</b><br>
                          <li>Valid for 6 months usage.</li>
                          <li>Unlimited Internt</li>
                          <li>Charges: Kshs 200 .</li>
                        </p>
                    </label>
                </div>
            </div>  
            <hr>
              <div class="col-md-8">
                <div class="radio" >
                    <label>
                        <input type="radio" name="plan" value="gold"/>
                        <span class="cr"></span>
                        <br>
                        <p><b>GOLD</b><br>
                          <li>Valid for 12 months.</li>
                          <li>Unlimited Internet .</li>
                          <li>Charges: Kshs 500.</li>
                        </p>
                    </label>
                </div>
            </div> 
        </div>
    </div>
    <button type="submit" name="setplan" class="btn btn-success btn-small"> Continue <i class="fas fa-arrow-right"></i></button>
  </form>
        
      </div>';
        }elseif ($account_status === '1') {
          echo '
          <span class="card-title"><i class="fa fa-home green-text"></i> Home</span>

          <p style="text-align:center;">
          <h3>Package: Gold.</h3><br>
          <h5><i class="fas fa-arrow-right"></i>Unlimited Internet Access</h5><br>
          <h5><i class="fas fa-arrow-right"></i>High Speed Connectivity.</h5><br>
          <h5><i class="fas fa-arrow-right"></i>12 Months Guarantee.</h5><br>
          <h5><i class="fas fa-arrow-right"></i>Unlimited Number of Connected Clinets.</h5><br>
          <h5><i class="fas fa-arrow-right"></i>Subscription Date : 12th Oct 2020.</h5><br>
          <h5 class="red-text"><i class="fas fa-arrow-right"></i>Expiry Date : 12th Oct 2020.</h5><br>
       
           <small class="pull-center">***** EXPERIENCE THE DIFFERNCE *****</small>.
          </p>
          ';
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

