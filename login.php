<?php 
require 'header.php' ;
require 'apis/dbconfig.php';
require_once 'apis/functions.php';
//handle sessions

if (isset($_SESSION['utoken'])) {
  header('Location:home.php');
}
// login logics
if (!isset($_POST['login'])) {
  $sent_username = '';
  $sent_pass ='';
}else{
  $sent_username = mysqli_real_escape_string($conn, $_POST['username']);
  $sent_pass = mysqli_real_escape_string($conn, $_POST['pass']);

  tnetLogin($sent_username,$sent_pass);
}
?>
<div class="container">
 <div class="row">
    <div class="col s12 m6">
      <div class="card green-white darken-1">
        <div class="card-content white-text">
          <span class="card-title text-center"><img src="images/logo.png"></span>
          <h3 class="text-center text-bold text-upper text-tnet-gradient tnet-text-sm">Sign In</h3>
          <div class="clear"></div>
          <div class="card-body">
            <form action="" class="loginForm" id="loginForm" method="POST">
              
              <div class="input-field">
                <input id="icon_prefix" type="text" class="validate" name="username" required="">
                <label for="icon_prefix">Username</label>
              
              <div class="input-field">
                <input id="icon_password" type="password" class="validate" name="pass" required="">
                <label for="icon_password">Password</label>
              </div>
            </div>
              <div class="clear"></div>
              <!-- remember me -->
             <div class="switch">
              <label style="color: green" class="text-bold">
                Remember me
                <input type="checkbox" >
                <span class="lever"></span>
              </label>
            </div>
            <div class="clear"></div>
            <br>
            <!-- submit -->
            <!-- NOTE: Add send in submit button -->
            <button class="btn waves-effect waves-light green btn-sm width-100" type="submit" name="login">sign in<i class="material-icons right">send</i></button>
          </form>
          </div>
        </div>
        <div class="card-action">
          <p><span class="pull-left"><a href="#">Reset</a></span>
            <span class="pull-right"><a href="signup.php" >Register</a></span>
          </p> 
        </div>
      </div>
    </div>
  </div>
  </div>
<?php require 'footer.php'; ?>

<style type="text/css">
  .tnet-response-back{
text-align: center;
border: 1px solid blue;
padding: 10px;
background-color: transparent;
width: 95%;
margin-left:2%;
color: red;
}
</style>