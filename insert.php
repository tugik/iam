<?php

//insert.php

include("auth.php");
include('database_connection.php');


$form_data = json_decode(file_get_contents("php://input"));

$error = '';
$message = '';
$validation_error = '';
$zone = '';
$zone_id = '';
$name = '';
$ttl = '';
$class = '';
$type = '';
$priority = '';
$weight = '';
$port = '';
$data = '';
$descr = '';
$state = '';
$add_date = '';
$upd_date = '';
$change_by = $_SESSION["username"];

if($form_data->action == 'fetch_single_data')
{
	$query = "SELECT
		zones.zone,
		records.id,
		records.zone_id,
		records.name,
		records.ttl,
		records.class,
		records.type,
		records.priority,
		records.weight,
		records.port,
		records.data,
		records.descr,
		records.state,
		records.add_date,
		records.upd_date,
		records.change_by
		FROM records JOIN zones ON zones.id=records.zone_id WHERE records.id='".$form_data->id."'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output['zone'] = $row['zone'];
		$output['id'] = $row['id'];
		$output['zone_id'] = $row['zone_id'];
		$output['name'] = $row['name'];
		$output['ttl'] = $row['ttl'];
		$output['class'] = $row['class'];
		$output['type'] = $row['type'];
		$output['priority'] = $row['priority'];
		$output['weight'] = $row['weight'];
		$output['port'] = $row['port'];
		$output['data'] = $row['data'];
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
	DELETE FROM records WHERE id='".$form_data->id."'
	";
	$statement = $connect->prepare($query);
	if($statement->execute())
	{
		$output['message'] = 'Record Deleted';
	}
}
else
{

	if(empty($form_data->zone_id))
	{
		$error[] = 'Zone is Required';
	}
	else
	{
		$zone_id = $form_data->zone_id;
	}

	if(empty($form_data->name))
	{
		$error[] = 'Name is Required';
	}
	else
	{
		$name = $form_data->name;
	}

	if(empty($form_data->ttl))
	{
		$error[] = 'TTL is Required';
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

	if(empty($form_data->priority))
	{
		$priority = NULL;
		//$error = 'Priority is Required';
	}
	else
	{
		$priority = $form_data->priority;
	}

	if(empty($form_data->weight))
	{
		$weight = NULL;
		//$error = 'Weight is Required';
	}
	else
	{
		$weight = $form_data->weight;
	}

	if(empty($form_data->port))
	{
		$port = NULL;
		//$error = 'Port is Required';
	}
	else
	{
		$port = $form_data->port;
	}

	if(empty($form_data->data))
	{
		$error = 'Data is Required';
	}
	else
	{
		$data = $form_data->data;
	}

	if(empty($form_data->descr))
	{
		$error[] = 'Description is Required';
	}
	else
	{
		$descr = $form_data->descr;
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
				':zone_id'		=>	$zone_id,
				':name'			=>	$name,
				':ttl'			=>	$ttl,
				':class'		=>	$class,
				':type'			=>	$type,
				':priority'		=>	$priority,
				':weight'		=>	$weight,
				':port'			=>	$port,
				':data'			=>	$data,
				':descr'		=>	$descr,
				':state'		=>	$state,
				':change_by'		=>	$change_by
			);
			$query = "
			INSERT INTO records
				( zone_id, name, ttl, class, type, priority, weight, port, data, descr, state, change_by ) VALUES
				( :zone_id, :name, :ttl, :class, :type, :priority, :weight, :port, :data, :descr, :state, :change_by )
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
				':zone_id'	=>	$zone_id,
				':name'		=>	$name,
				':ttl'		=>	$ttl,
				':class'	=>	$class,
				':type'		=>	$type,
				':priority'	=>	$priority,
				':weight'	=>	$weight,
				':port'		=>	$port,
				':data'		=>	$data,
				':descr'	=>	$descr,
				':state'	=>	$state,
				':change_by'	=>	$change_by,
				':id'		=>	$form_data->id
			);
			$query = "
			UPDATE records 
			SET zone_id = :zone_id, name = :name, ttl = :ttl, class = :class, type = :type, priority = :priority, weight = :weight, port = :port, data = :data, descr = :descr, state = :state, change_by = :change_by 
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