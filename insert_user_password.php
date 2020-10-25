<?php

//insert.php

include("auth.php");
include('database_connection.php');


$form_data = json_decode(file_get_contents("php://input"));

$error = '';
$message = '';
$validation_error = '';
$username = '';
$fullname = '';
$password = '';
$permission = '';
$state = '';
$add_date = '';
$upd_date = '';
$change_by = $_SESSION["username"];

if($form_data->action == 'fetch_password_data')
{
	$query = "SELECT * FROM users WHERE id='".$form_data->id."'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output['username'] = $row['username'];
		$output['fullname'] = $row['fullname'];
		$output['password'] = $row['password'];
		$output['permission'] = $row['permission'];
		$output['state'] = $row['state'];
		$output['add_date'] = $row['add_date'];
		$output['upd_date'] = $row['upd_date'];
		$output['change_by'] = $row['change_by'];
	}
}
elseif($form_data->action == "Delete")
{
	$query = "
	DELETE FROM users WHERE id='".$form_data->id."'
	";
	$statement = $connect->prepare($query);
	if($statement->execute())
	{
		$output['message'] = 'User Deleted';
	}
}
else
{

	if(empty($form_data->password))
	{
		$error[] = 'Password is Required';
	}
	else
	{
		$password = $form_data->password;
	}


	if(empty($error))
	{

		if($form_data->action == 'Change')

		{

			$data = array(
				':password'		=>	$password,
				':change_by'		=>	$change_by,
				':id'			=>	$form_data->id
			);

			$query = "
			UPDATE users 
			SET password = md5(:password),  change_by = :change_by 
			WHERE id = :id
			";

			$statement = $connect->prepare($query);
			if($statement->execute($data))
			{
				$message = 'Password changed';
			}
		}
	}
	else
	{
		$validation_error = implode(", ", $error);
	}

	$output = array(
		'error'		=>	$validation_error,
		'message'	=>	$message
	);

}



echo json_encode($output);

?>
