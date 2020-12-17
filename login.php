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
<link rel="stylesheet" href="style.css"   />
</head>
<body style="background-color:#f5f7fa;">
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
    <br><br><br>
 <!--   <img alt="IAM" src="main-logo.png" width="322" height="90"> -->
    <br>
<h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Log In to IAM</h1>
    <h5><p style="margin-left: 60px;">Identity and Access Management</p></h5>
<form action="" method="post" name="login">
<input type="text" name="username" placeholder="Username" required />
<input type="password" name="password" placeholder="Password" required />
<input name="submit" type="submit" value="Login" />
</form>
<!--    <h6><p style="margin-left: 100px;">Develope for companyname</a> 2020</p></h6>-->
    <h6><p style="margin-left: 100px;">IT department 2020</p></h6>
</div>
<?php } ?>


</body>
</html>
