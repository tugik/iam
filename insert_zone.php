<?php

//insert.php

include("auth.php");
include('database_connection.php');


$form_data = json_decode(file_get_contents("php://input"));

$error = '';
$message = '';
$validation_error = '';
$zone = '';
$type_zone = '';
$file = '';
$masters = '';
$forwarders = '';
$notify = '';
$allow_query = '';
$allow_transfer = '';
$allow_update = '';
$allow_notify = '';
$name = '';
$ttl = '';
$class = '';
$type = '';
$primary_ns = '';
$resp_person = '';
$serial = '';
$refresh = '';
$retry = '';
$expire = '';
$minimum = '';
$descr = '';
$state = '';
$add_date = '';
$upd_date = '';
$change_by = $_SESSION["username"];


if($form_data->action == 'fetch_single_data')
{
	$query = "SELECT * FROM zones WHERE id='".$form_data->id."'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output['zone'] = $row['zone'];
		$output['type_zone'] = $row['type_zone'];

		$output['file'] = $row['file'];
		$output['masters'] = $row['masters'];
		$output['forwarders'] = $row['forwarders'];
		$output['notify'] = $row['notify'];
		$output['allow_query'] = $row['allow_query'];
		$output['allow_transfer'] = $row['allow_transfer'];
		$output['allow_update'] = $row['allow_update'];
		$output['allow_notify'] = $row['allow_notify'];

		$output['name'] = $row['name'];
		$output['ttl'] = $row['ttl'];
		$output['class'] = $row['class'];
		$output['type'] = $row['type'];
		$output['primary_ns'] = $row['primary_ns'];
		$output['resp_person'] = $row['resp_person'];
		$output['serial'] = $row['serial'];
		$output['refresh'] = $row['refresh'];
		$output['retry'] = $row['retry'];
		$output['expire'] = $row['expire'];
		$output['minimum'] = $row['minimum'];
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
	DELETE FROM zones WHERE id='".$form_data->id."'
	";
	$statement = $connect->prepare($query);
	if($statement->execute())
	{
		$output['message'] = 'Zone Deleted';
	}
}
else
{
	if(empty($form_data->zone))
	{
		$error = 'Zone is Required';
	}
	else
	{
		$zone = $form_data->zone;
	}
	if(empty($form_data->type_zone))
	{
		$error = 'Zone Type is Required';
	}
	else
	{
		$type_zone = $form_data->type_zone;
	}
	if(empty($form_data->file))
	{
		$error = 'File Type is Required';
	}
	else
	{
		$file = $form_data->file;
	}
	if(empty($form_data->masters))
	{
		//$error = 'Masters Type is Required';
		$masters = $form_data->masters;
	}
	else
	{
		$masters = $form_data->masters;
	}
	if(empty($form_data->forwarders))
	{
		//$error = 'Forwarders Type is Required';
		$forwarders = $form_data->forwarders;
	}
	else
	{
		$forwarders = $form_data->forwarders;
	}
	if(empty($form_data->notify))
	{
		$error = 'Notify Type is Required';
		//$notify = $form_data->notify;
	}
	else
	{
		$notify = $form_data->notify;
	}
	if(empty($form_data->allow_query))
	{
		//$error = 'Query Type is Required';
		$allow_query = $form_data->allow_query;
	}
	else
	{
		$allow_query = $form_data->allow_query;
	}
	if(empty($form_data->allow_transfer))
	{
		//$error = 'Transfer Type is Required';
		$allow_transfer = $form_data->allow_transfer;
	}
	else
	{
		$allow_transfer = $form_data->allow_transfer;
	}
	if(empty($form_data->allow_update))
	{
		//$error = 'Update Type is Required';
		$allow_update = $form_data->allow_update;
	}
	else
	{
		$allow_update = $form_data->allow_update;
	}
	if(empty($form_data->allow_notify))
	{
		//$error = 'Notify Type is Required';
		$allow_notify = $form_data->allow_notify;
	}
	else
	{
		$allow_notify = $form_data->allow_notify;
	}
	if(empty($form_data->name))
	{
		$error = 'Name is Required';
	}
	else
	{
		$name = $form_data->name;
	}
	if(empty($form_data->ttl))
	{
		$error = 'TTL is Required';
	}
	else
	{
		$ttl = $form_data->ttl;
	}
	if(empty($form_data->class))
	{
		$error = 'Class is Required';
	}
	else
	{
		$class = $form_data->class;
	}
	if(empty($form_data->type))
	{
		$error = 'Type is Required';
	}
	else
	{
		$type = $form_data->type;
	}
	if(empty($form_data->primary_ns))
	{
		$error = 'Primary NS is Required';
	}
	else
	{
		$primary_ns = $form_data->primary_ns;
	}
	if(empty($form_data->resp_person))
	{
		$error = 'Person NS is Required';
	}
	else
	{
		$resp_person = $form_data->resp_person;
	}
	if(empty($form_data->serial))
	{
		$serial = time();
		//$error = 'Serial is Required';
	}
	else
	{
		$serial = time();
		//$form_data->serial;
	}
	if(empty($form_data->refresh))
	{
		$error = 'Refresh is Required';
	}
	else
	{
		$refresh = $form_data->refresh;
	}
	if(empty($form_data->retry))
	{
		$error = 'Retry is Required';
	}
	else
	{
		$retry = $form_data->retry;
	}
	if(empty($form_data->expire))
	{
		$error = 'Expire is Required';
	}
	else
	{
		$expire = $form_data->expire;
	}
	if(empty($form_data->minimum))
	{
		$error = 'Minimum is Required';
	}
	else
	{
		$minimum = $form_data->minimum;
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
				':zone'		=>	$zone,
				':type_zone'	=>	$type_zone,

				':file'		=>	$file,
				':masters'	=>	$masters,
				':forwarders'	=>	$forwarders,
				':notify'	=>	$notify,
				':allow_query'	=>	$allow_query,
				':allow_transfer'	=>	$allow_transfer,
				':allow_update'	=>	$allow_update,
				':allow_notify'	=>	$allow_notify,

				':name'		=>	$name,
				':ttl'		=>	$ttl,
				':class'	=>	$class,
				':type'		=>	$type,
				':primary_ns'	=>	$primary_ns,
				':resp_person'	=>	$resp_person,
				':serial'	=>	$serial,
				':refresh'	=>	$refresh,
				':retry'	=>	$retry,
				':expire'	=>	$expire,
				':minimum'	=>	$minimum,
				':descr'	=>	$descr,
				':state'	=>	$state,
				':change_by'	=>	$change_by
			);
			$query = "
			INSERT INTO zones
				(zone, type_zone, file, masters, forwarders, notify, allow_query, allow_transfer, allow_update, allow_notify, name, ttl, class, type, primary_ns, resp_person, serial, refresh, retry, expire, minimum, descr, state, change_by) VALUES 
				(:zone, :type_zone, :file, :masters, :forwarders, :notify, :allow_query, :allow_transfer, :allow_update, :allow_notify, :name, :ttl, :class, :type, :primary_ns, :resp_person, :serial, :refresh, :retry, :expire, :minimum, :descr, :state, :change_by )
			";
			$statement = $connect->prepare($query);
			if($statement->execute($data))
			{
				$message = 'Zone Inserted';
			}
		}
		if($form_data->action == 'Edit')
		{
			$data = array(
				':zone'		=>	$zone,
				':type_zone'	=>	$type_zone,

				':file'		=>	$file,
				':masters'	=>	$masters,
				':forwarders'	=>	$forwarders,
				':notify'	=>	$notify,
				':allow_query'	=>	$allow_query,
				':allow_transfer'	=>	$allow_transfer,
				':allow_update'	=>	$allow_update,
				':allow_notify'	=>	$allow_notify,

				':name'		=>	$name,
				':ttl'		=>	$ttl,
				':class'	=>	$class,
				':type'		=>	$type,
				':primary_ns'	=>	$primary_ns,
				':resp_person'	=>	$resp_person,
				':serial'	=>	$serial,
				':refresh'	=>	$refresh,
				':retry'	=>	$retry,
				':expire'	=>	$expire,
				':minimum'	=>	$minimum,
				':descr'	=>	$descr,
				':state'	=>	$state,
				':change_by'	=>	$change_by,
				':id'		=>	$form_data->id
			);
			$query = "
			UPDATE zones 
			SET zone = :zone,  type_zone = :type_zone,  file = :file, masters = :masters, forwarders = :forwarders, notify = :notify, allow_query = :allow_query, allow_transfer = :allow_transfer, allow_update = :allow_update, allow_notify = :allow_notify, name = :name, ttl = :ttl, class = :class, type = :type, primary_ns = :primary_ns, resp_person = :resp_person, serial= :serial, refresh = :refresh, retry = :retry, expire = :expire, minimum = :minimum, descr = :descr, state = :state, change_by = :change_by 
			WHERE id = :id
			";

			$statement = $connect->prepare($query);
			if($statement->execute($data))
			{
				$message = 'Zone Edited';
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
