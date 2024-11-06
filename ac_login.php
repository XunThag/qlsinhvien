<?php 

if (isset($_POST['login'])) {

	require 'connectDB.php';

	$Usermail = $_POST['email']; 
	$Userpass = $_POST['pwd']; 

	if (empty($Usermail) || empty($Userpass) ) {
		header("location: index.html?error=emptyfields");
  		exit();
	}
	else if (!filter_var($Usermail,FILTER_VALIDATE_EMAIL)) {
          header("location: index.html?error=invalidEmail");
          exit();
    }
	else{
		$sql = "SELECT * FROM admin WHERE admin_email=?";
		$result = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($result, $sql)) {
			header("location: index.html?error=sqlerror");
  			exit();
		}
		else{
			mysqli_stmt_bind_param($result, "s", $Usermail);
			mysqli_stmt_execute($result);
			$resultl = mysqli_stmt_get_result($result);

			if ($row = mysqli_fetch_assoc($resultl)) {
				$pwdCheck = password_verify($Userpass, $row['admin_pwd']);
				if ($pwdCheck == false) {
					header("location: index.html?error=wrongpassword");
  					exit();
				}
				else if ($pwdCheck == true) {
	                session_start();
					$_SESSION['Admin-name'] = $row['admin_name'];
					$_SESSION['Admin-email'] = $row['admin_email'];
					header("location: index.php?login=success");
					exit();
				}
			}
			else{
				header("location: index.html?error=nouser");
  				exit();
			}
		}
	}
mysqli_stmt_close($result);    
mysqli_close($conn);
}
else{
  header("location: index.html");
  exit();
}
?>