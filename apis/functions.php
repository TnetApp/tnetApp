<?php 
session_start();
#========================================================================
/*Function to handle login logics*/

function tnetLogin($uname,$upass)
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
			}
			//verify passwords
			if (!password_verify($upass, $u_db_pass)) {
				
				echo "<script>alert('Invalid login credentials');</script>";

			}else{
			// initialize session handler
			$_SESSION['utoken'] = $u_db_token;

			echo "<script>
			alert('Login was successful ');
			window.open('home.php?user=".$_SESSION['utoken']."','_self');
			</script>";
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

	$sql = "INSERT INTO `users`(`uname`, `upass`, `ufname`, `ulname`, `umobile`, `umail`, `uinstname`, `uidno`, `uprofile`, `regdate`, `ustatus`, `uvcode`, `utoken`)
	VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);";


			$stmt = mysqli_stmt_init($conn); //initialize 
			if (mysqli_stmt_prepare($stmt, $sql)) {

				// define constant variables
				$regdate = date('j M Y H:i:s');
				$status ='0';
				$vcode  = tnetGenerateKey();
				$token = hash('sha256',uniqid('T', microtime()));

				// get the MAC address of Client 
				$mac_address = exec('getmac'); 
				// Storing 'getmac' value in $mac_address 
				$mac_address = strtok($mac_address, ' '); 
				 

				mysqli_stmt_bind_param($stmt,"ssssissississs", $uname,$upas,$fname,$lname,$mobile,$email,$inst,$idno,$fileDestination,$regdate,$status,$vcode,$token,$mac_address);
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
					echo $count;
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

		/*Function to handle cookie logics*/
		/*Function to handle page redirect logics*/
		/*Function to handle subscriptions logics*/
		/*Function to handle reset password*/
		/*Function to handle notifications*/
		/*Function to handle network traffic*/
		?>

