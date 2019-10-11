<?php 

// create database connection function
	$server ='127.0.0.1'; $username ='root'; $password = ''; $dbname = 'tnet'; $port ='3306'; 
	$conn = mysqli_connect($server, $username,$password,$dbname, $port);

	if ($conn == true) {
		//echo "Database connected successfully";
	} else {
		echo "Database connection failed";
	}

?>

<?php //if (condition): ?>

<!-- html code to run if condition is true
 -->
<?php //else: ?>

<!-- html code to run if condition is false -->

<?php //endif ?>