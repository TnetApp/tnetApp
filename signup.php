<?php 
require 'header.php';
require 'apis/dbconfig.php';
require_once 'apis/functions.php';
 //signup logics

if (!isset($_POST['signup'])) {
  $uname = $upass = $fname = $lname = $email = $idno = $inst = $mobile = $token = "";
}else{

  $uname = mysqli_real_escape_string($conn, $_POST['uname']);
  $upass = mysqli_real_escape_string($conn, $_POST['upass']);
  $fname = mysqli_real_escape_string($conn, $_POST['fname']);
  $lname = mysqli_real_escape_string($conn, $_POST['lname']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $idno = mysqli_real_escape_string($conn, $_POST['idno']);
  $inst = mysqli_real_escape_string($conn, $_POST['inst']);
  $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
  
  //check empty fields and errors
  
  if (!empty($uname) || !empty($upass) || !empty($fname) || !empty($lname) || !empty($email) || !empty($idno) || !empty($inst) || !empty($mobile)) {
    
    //validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo("$email is not a valid email address");
    }

    // Perform image upload
      $fileName = $_FILES['file']['name'];
      $fileTmpName = $_FILES['file']['tmp_name'];
      $fileSize = $_FILES['file']['size'];
      $fileType = $_FILES['file']['type'];
      $fileError = $_FILES['file']['error'];
      
      $fileExt = explode('.', $fileName);
      $fileActualExt = strtolower(end($fileExt));

      $allowedFileType = array('png','jpg','jpeg');

      if (in_array($fileActualExt, $allowedFileType)) {
        
        if ($fileError === 0) {
          
          if ($fileSize < 3000000) {
            
            # unique file name
            $newFileName = uniqid('', true).".".$fileActualExt;

            $fileDestination = 'uploads/'.$newFileName;

            // move file to server
            
            move_uploaded_file($fileTmpName, $fileDestination);

          }else{
            echo "<script>
                  alert('Photo could not be uploaded');
              </script>";
          }
          
        }else{
          echo "<script>
                  alert('Unexpected error occured while uploading your photo');
              </script>";
        }
      }else{
        echo "<script>
                  alert('Please select jpg,png,jpeg file formats');
              </script>";
      }
      
// end image upload


    //encrypt password
    $hashed_pass = password_hash($upass, PASSWORD_DEFAULT);

    tnetRegister($uname,$hashed_pass,$fname,$lname,$mobile,$email,$inst,$idno,$fileDestination,$inst);
  }else{

    echo "All fields required";
  }

}
unset($_POST['signup']);
 ?>

<!-- card signup -->
<div class="container">
 <div class="row">
    <div class="col s12 m6">
      <div class="card white-grey darken-1">
        <div class="card-content white-text">
          <span class="card-title text-center"><img src="images/logo.png"></span>
          <h3 class="text-center text-bold text-upper text-tnet-gradient tnet-text-sm">Sign Up</h3>
            <form class="col s12" method="POST" action="" enctype="multipart/form-data">
              <div class="row">
                <div class="input-field col s6">
                  <!-- <i class="material-icons prefix">account_circle</i> -->
                  <input id="icon_prefix" type="text" class="validate" name="fname"  value="<?php if(isset($fname)){
                    print ($fname);
                  }?>">
                  <label for="icon_prefix">First Name</label>
                </div>
                <div class="input-field col s6">
                 <!--  <i class="material-icons prefix">phone</i> -->
                  <input id="icon_second_name" type="text" class="validate" name="lname" value="<?php if(isset($lname)){
                    print ($lname);
                  }?>">
                  <label for="icon_second_name">Last Name</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s6">
                  <!-- <i class="material-icons prefix">account_circle</i> -->
                  <input id="icon_email" type="email" class="validate" name="email" value="<?php if(isset($email)){
                    print ($email);
                  }?>">
                  <label for="icon_email">Email (<small>Optional</small>)</label>
                </div>
                <div class="input-field col s6">
                 <!--  <i class="material-icons prefix">phone</i> -->
                  <input id="icon_telephone" type="tel" class="validate" name="mobile" value="<?php if(isset($mobile)){
                    print ($mobile);
                  }?>">
                  <label for="icon_telephone">Mobile</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s6">
                  <!-- <i class="material-icons prefix">account_circle</i> -->
                  <input id="icon_idno" type="number" class="validate" name="idno" value="<?php if(isset($idno)){
                    print ($idno);
                  }?>">
                  <label for="icon_idno">ID (<small>Optional</small>)</label>
                </div>
                <div class="input-field col s6">
                 <!--  <i class="material-icons prefix">phone</i> -->
                  <input id="icon_inst" type="tel" class="validate" name="inst" value="<?php if(isset($inst)){
                    print ($inst);
                  }?>">
                  <label for="icon_inst">Instition</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s6">
                  <!-- <i class="material-icons prefix">account_circle</i> -->
                  <input id="icon_username" type="text" class="validate" name="uname" value="<?php if(isset($uname)){
                    print ($uname);
                  }?>">
                  <label for="icon_username">Username</label>
                </div>
                <div class="input-field col s6">
                 <!--  <i class="material-icons prefix">phone</i> -->
                  <input id="icon_password" type="password" class="validate" name="upass">
                  <label for="icon_password">Password</label>
                </div>
              </div>
              <div class="file-field input-field">
              <div class="btn">
                <span>Pic</span>
                <input type="file" name="file" required="">
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text" placeholder="Set your profile pic" required="">
              </div>
              </div>
                        <!-- Switch -->
            <div class="switch pull-center">
            <label>
              <small>Agree</small>
              <input type="checkbox" name="terms" class="validate" required="" id="terms">
              <span class="lever"></span>
              
            </label>
          </div>
            <br>
            <button class="btn waves-effect waves-light green bt-sm width-100" type="submit" name="signup">sign up<i class="material-icons right"></i></button>
              <br>
            <div class="card-action">
              <a href="login.php" class="pull-left">Login</a>
              <a href="#" class="pull-right">Info</a>
            </div>
            </form> 
          </div>
        </div>
        
      </div>
    </div>
  </div>
     <style type="text/css">
       .width-100{
  width: 100%;
  height: auto;
}
     </style>
  
   <!-- end form elements -->

<?php require 'footer.php'; ?>

<script type="text/javascript">
  function terms(){
    var terms = document.getElementById('terms').val();
  if (terms == " ") {
    alert('Please agree to terms and conditions');
  }
  }
</script>