<?php 
session_start();
#========================================================================
/*Function to handle login logics*/

function tnetLogin($uname,$upass,$ip)
{
	require 'dbconfig.php';

	$sql = "SELECT * FROM users WHERE uname = ? ";

	$stmt = mysqli_stmt_init($conn);

	if (mysqli_stmt_prepare($stmt, $sql)) {
		mysqli_stmt_bind_param($stmt, "s" ,$uname);
		mysqli_execute($stmt);

		$result = mysqli_stmt_get_result($stmt);
		$count = mysqli_num_rows($result);

		if ($count > 0) {
			foreach ($result as $key => $userDetails) {
				$u_db_pass = $userDetails['upass']; 
				$u_db_fname = $userDetails['ufname'];
				$u_db_token = $userDetails['utoken']; 
				$u_db_ip = $userDetails['udevice'];
				$u_db_mobile = $userDetails['umobile'];
				$vcode = $userDetails['uvcode'];  
			}
			//verify passwords
			if (!password_verify($upass, $u_db_pass)) {
				
				echo "<script>alert('Invalid login credentials');</script>";

			}else{
				if ($ip === $u_db_ip) {
					// initialize session handler
					$_SESSION['utoken'] = $u_db_token;

					echo "<script>
					alert('Login was successful ');
					window.open('home.php?user=".$_SESSION['utoken']."','_self');
					</script>";
				}else{
					require 'apis/sms/code_sms/sms.php';
					
				}
			
			}

		} else {
			//user exist ,abort login process with process
			echo "<script>
			alert('Oops! no user found');
			</script>";	
			
		}
		

	}
	return $count;
}
#===============================================================================

/*Function to handle session logics*/

// function tnetSession($u_db_token, $u_db_fname)
// {
// 	session_start();
// 	$_SESSION['utoken'] = $u_db_token;
// 	$_SESSION['uname'] = $u_db_fname;
	
// }

#==============================================================================


/*Function to handle register logics*/
function tnetRegister($uname,$upas,$fname,$lname,$mobile,$email,$instname,$idno,$fileDestination,$inst)
{
	require 'dbconfig.php';

	//check user existence
	$sql = "SELECT * FROM users WHERE uname =? OR umail =? OR umobile =? OR uidno =?";

			$stmt = mysqli_stmt_init($conn);

			if (mysqli_stmt_prepare($stmt, $sql)) {
				mysqli_stmt_bind_param($stmt, "ssss" ,$uname, $email ,$mobile ,$idno);
				mysqli_execute($stmt);

				$result = mysqli_stmt_get_result($stmt);
				$count = mysqli_num_rows($result);
				if ($count > 0) {
					
			//abort registration and call the form
					echo "<script>alert('Ooops! user exist ...');</script>";
		
				} else {
			//call register user function to continue with process
				$sql = "INSERT INTO `users`(`uname`, `upass`, `ufname`, `ulname`, `umobile`, `umail`, `uinstname`, `uidno`, `uprofile`, `regdate`, `ustatus`, `uvcode`, `utoken`,`udevice`)VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?);";


			$stmt = mysqli_stmt_init($conn); //initialize 
			if (mysqli_stmt_prepare($stmt, $sql)) {

				// define constant variables
				$regdate = date('j M Y H:i:s');
				$status ='1';
				$vcode  = tnetGenerateKey();
				$token = hash('sha256',uniqid('T', microtime()));

				// get the IP address of Client 
				$ip = $_SERVER['REMOTE_ADDR']; 


				mysqli_stmt_bind_param($stmt,"ssssissississs", $uname,$upas,$fname,$lname,$mobile,$email,$inst,$idno,$fileDestination,$regdate,$status,$vcode,$token,$ip);
				$execute = mysqli_stmt_execute($stmt);



				if($execute == true){

					echo "<script>
					alert('Congralutions...!');
					window.open('login.php','_self');

					</script>";
					unset($stmt);
				}
				else{
					echo "<script>alert('Ooops! signup failed ...');</script>";
				}

			} else {
				echo "<script>alert('Ooops! Something went wrong...');</script>";

			}
				}
			} 

	
		}


#==============================================================================
// Function to handle user existance
		function tnetCheckUser($uname,$umail,$umobile,$uidno){
			require 'dbconfig.php';

			$sql = "SELECT * FROM users WHERE uname =? OR umail =? OR umobile =? OR uidno =?";

			$stmt = mysqli_stmt_init($conn);

			if (mysqli_stmt_prepare($stmt, $sql)) {
				mysqli_stmt_bind_param($stmt, "s" ,$uname);
				mysqli_execute($stmt);

				$result = mysqli_stmt_get_result($stmt);
				$count = mysqli_num_rows($result);
				if ($count > 0) {
					//echo $count;
			//abort registration and call the form
					exit('There is vaild user with such credentials ....!');
				} else {
			//call register user function to continue with process
			//file_get_contents('index.php');
			//
				}
			} 
		}

		/*Function to handle key generation*/

		function tnetGenerateKey()
		{
			$keyLength = "5";
			$keyString = "ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
			$keyRand = substr(str_shuffle($keyString), 0, $keyLength);
			return $keyRand;
		}

		/*Function to handle authentication logics*/

		function tnetVerifyAccount($ip)
		{
			require 'dbconfig.php';
			$query = "SELECT * FROM users WHERE udevice = ?";

			$stmt = mysqli_stmt_init($conn);
			if (mysqli_stmt_prepare($stmt, $query)) {
				
				mysqli_stmt_bind_param($stmt, 's', $ip);
				mysqli_stmt_execute($stmt);

				$result = mysqli_stmt_get_result($stmt);
				$count = mysqli_num_rows($result);
				if ($count > 0) {
					
					foreach ($result as $key => $user_account) {
						$u_db_mobile = $user_account['umobile'];
						$u_db_ip = $user_account['udevice'];
						$vcode = $user_account['uvcode'];
					}
					if ($ip !== $u_db_ip) {
						//send verification code to user
					require 'apis/sms/code_sms/sms.php';
					}else{

					}
					
				}
			}
			return  $u_db_mobile;
		}
		/*Function to handle code matching  logics*/
		function tnetConfirmCode($ip,$user_sent_vcode)
		{
			require 'dbconfig.php';
			$query = "SELECT * FROM users WHERE udevice !=? AND uvcode =?";
			$stmt = mysqli_stmt_init($conn);
			if (mysqli_stmt_prepare($stmt, $query)) {
				
				mysqli_stmt_bind_param($stmt, 'ss', $ip,$user_sent_vcode);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);

				while ($row = mysqli_fetch_assoc($result)) {
				$db_vcode = $row['uvcode'];
				$u_db_token = $row['utoken'];
				break;
				}

				if ($db_vcode === $user_sent_vcode) {
					// initialize session handler
					$_SESSION['utoken'] = $u_db_token;

					echo "<script>
					alert('Verification was successful ');
					window.open('home.php?user=".$_SESSION['utoken']."','_self');
					</script>";
				}else{
					echo "Validation failed";
				}

			}
		}

		/*Function to handle subscriptions logics*/
		function tnetSubscribe()
		{
			$plan = array('silver','bronze','gold');

			$expiry = date('d m y H:i:s');

			$packages = array('unliminet','max_users_10','e-learn');
		}

		/*Function to handle reset password*/
		/*Function to handle notifications*/
		/*Function to handle network traffic*/
		?>

