<?php
/*
login page
*/
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
	require('./db/db.php');
	session_start();
    // If form submitted, insert values into the database.
    if (isset($_POST['username'])){
		
		$username = stripslashes($_REQUEST['username']); // removes backslashes
		$username = mysqli_real_escape_string($con,$username); //escapes special characters in a string
		$password = stripslashes($_REQUEST['password']);
		$password = mysqli_real_escape_string($con,$password);
		
	//Checking is user existing in the database or not
        //$query = "SELECT * FROM `users` WHERE username='$username' and password='".md5($password)."'";
	$query = "SELECT * FROM `users` WHERE username='$username' and password='".md5($password)."' and state = 'enable' ";
		$result = mysqli_query($con,$query) or die(mysqli_error());
		$rows = mysqli_num_rows($result);
        if($rows==1){
			$_SESSION['username'] = $username;
			header("Location: index_accounts.php"); // Redirect user to index.php
            }else{
				echo "<div class='form'><h3>Username/password is incorrect or disable.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
				}
    }else{
?>
<div class="form">
<h1>Log In</h1>
<form action="" method="post" name="login">
<input type="text" name="username" placeholder="Username" required />
<input type="password" name="password" placeholder="Password" required />
<input name="submit" type="submit" value="Login" />
</form>
<!-- <p>Develope for <a href='https://iam'> iam</a></p> -->
</div>
<?php } ?>


</body>
</html>
