<?php

//insert.php

include("auth.php");
include('database_connection.php');


$form_data = json_decode(file_get_contents("php://input"));

$error = '';
$message = '';
$validation_error = '';
$account = '';
$fullname = '';
$department = '';
$ip = '';
$vlan = '';
$server = '';
$device = '';
$dns = '';
$net = '';
$subnet = '';
$descr = '';
$state = '';
$add_date = '';
$upd_date = '';
$change_by = $_SESSION["username"];


if($form_data->action == 'fetch_single_data')
{
	$query = "SELECT * FROM accounts WHERE id='".$form_data->id."'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output['account'] = $row['account'];
		$output['fullname'] = $row['fullname'];
		$output['department'] = $row['department'];
		$output['ip'] = $row['ip'];
		$output['vlan'] = $row['vlan'];
		$output['server'] = $row['server'];
		$output['device'] = $row['device'];
		$output['dns'] = $row['dns'];
		$output['net'] = $row['net'];
		$output['subnet'] = $row['subnet'];
		$output['descr'] = $row['descr'];
		$output['state'] = $row['state'];
		$output['add_date'] = $row['add_date'];
		$output['upd_date'] = $row['upd_date'];
		$output['change_by'] = $row['change_by'];
	}
}


elseif($form_data->action == "Delete")
{
	$query = "
	DELETE FROM accounts WHERE id='".$form_data->id."'
	";
	$statement = $connect->prepare($query);
	if($statement->execute())
	{
		$output['message'] = 'Account Deleted';
	}
}
else
{
	if(empty($form_data->account))
	{
		$error = 'Account is Required';
	}
	else
	{
		$account = $form_data->account;
	}
	if(empty($form_data->fullname))
	{
		$error = 'Full Name is Required';
	}
	else
	{
		$fullname = $form_data->fullname;
	}
	if(empty($form_data->department))
	{
		//$error = 'Department is Required';
		$department = $form_data->department;
	}
	else
	{
		$department = $form_data->department;
	}
	if(empty($form_data->ip))
	{
		$error = 'IP is Required';
	}
	else
	{
		$ip = $form_data->ip;
	}
	if(empty($form_data->vlan))
	{
		$error = 'Vlan is Required';
	}
	else
	{
		$vlan = $form_data->vlan;
	}
	if(empty($form_data->server))
	{
		$error = 'Server is Required';
	}
	else
	{
		$server = $form_data->server;
	}
	if(empty($form_data->device))
	{
		$error = 'Device is Required';
	}
	else
	{
		$device = $form_data->device;
	}
	if(empty($form_data->dns))
	{
		//$error = 'DNS is Required';
		$dns = $form_data->dns;
	}
	else
	{
		$dns = $form_data->dns;
	}
	if(empty($form_data->net))
	{
		//$error = 'NET is Required';
		$net = $form_data->net;
	}
	else
	{
		$net = $form_data->net;
	}
	if(empty($form_data->subnet))
	{
		//$error = 'SubNET is Required';
		$subnet = $form_data->subnet;
	}
	else
	{
		$subnet = $form_data->subnet;
	}
	if(empty($form_data->descr))
	{
		$error = 'Description is Required';
	}
	else
	{
		$descr = $form_data->descr;
	}
	if(empty($form_data->state))
	{
		$error = 'State is Required';
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
				':account'	=>	$account,
				':fullname'	=>	$fullname,
				':department'	=>	$department,
				':ip'	=>	$ip,
				':vlan'	=>	$vlan,
				':server'	=>	$server,
				':device'	=>	$device,
				':dns'	=>	$dns,
				':net'	=>	$net,
				':subnet'	=>	$subnet,
				':descr'	=>	$descr,
				':state'	=>	$state,
				':change_by'	=>	$change_by
			);
			$query = "
			INSERT INTO accounts
				(account, fullname, department, ip, vlan, server, device, dns, net, subnet, descr, state, change_by) VALUES 
				(:account, :fullname, :department, :ip, :vlan, :server, :device, :dns, :net, :subnet, :descr, :state, :change_by )
			";
			$statement = $connect->prepare($query);
			if($statement->execute($data))
			{
				$message = 'Account Inserted';
			}
		}
		if($form_data->action == 'Edit')
		{
			$data = array(
				':account'	=>	$account,
				':fullname'	=>	$fullname,
				':department'	=>	$department,
				':ip'	=>	$ip,
				':vlan'	=>	$vlan,
				':server'	=>	$server,
				':device'	=>	$device,
				':dns'	=>	$dns,
				':net'	=>	$net,
				':subnet'	=>	$subnet,
				':descr'	=>	$descr,
				':state'	=>	$state,
				':change_by'	=>	$change_by,
				':id'		=>	$form_data->id
			);
			$query = "
			UPDATE accounts 
			SET account = :account, fullname = :fullname, department = :department, ip = :ip, vlan = :vlan, server = :server, device = :device, dns = :dns, net = :net, subnet = :subnet, descr = :descr, state = :state, change_by = :change_by 
			WHERE id = :id
			";

			$statement = $connect->prepare($query);
			if($statement->execute($data))
			{
				$message = 'Account Edited';
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
