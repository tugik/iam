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

if($form_data->action == 'fetch_single_data')
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

	if(empty($form_data->username))
	{
		$error[] = 'UserName is Required';
	}
	else
	{
		$username = $form_data->username;
	}

	if(empty($form_data->fullname))
	{
		$error[] = 'FullName is Required';
	}
	else
	{
		$fullname = $form_data->fullname;
	}
	if(empty($form_data->password))
	{
		$error[] = 'Password is Required';
	}
	else
	{
		$password = $form_data->password;
	}
	if(empty($form_data->permission))
	{
		$error[] = 'Permission is Required';
	}
	else
	{
		$permission = $form_data->permission;
	}

	if(empty($form_data->state))
	{
		$error[] = 'State is Required';
	}
	else
	{
		$state = $form_data->state;
	}

	if(empty($error))
	{
		if($form_data->action == 'Insert')
		{
			$data = array(
				':username'		=>	$username,
				':fullname'		=>	$fullname,
				':password'		=>	$password,
				':permission'		=>	$permission,
				':state'		=>	$state,
				':change_by'		=>	$change_by
			);
			$query = "
			INSERT INTO users 
				(username, fullname, password, permission, state, change_by) VALUES 
				(:username, :fullname, md5(:password), :permission, :state, :change_by )
			";
			$statement = $connect->prepare($query);
			if($statement->execute($data))
			{
				$message = 'User Inserted';
			}
		}
		if($form_data->action == 'Edit')
		{
			$data = array(
				':username'		=>	$username,
				':fullname'		=>	$fullname,
				':password'		=>	$password,
				':permission'		=>	$permission,
				':state'		=>	$state,
				':change_by'		=>	$change_by,
				':id'			=>	$form_data->id
			);
			$query = "
			UPDATE users 
			SET username = :username, fullname = :fullname, permission = :permission, state = :state, change_by = :change_by 
			WHERE id = :id
			";

			$statement = $connect->prepare($query);
			if($statement->execute($data))
			{
				$message = 'User Edited';
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
