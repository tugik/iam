<?php

//insert.php
include("../auth.php");
include('database_connection.php');

$message = '';

$form_data = json_decode(file_get_contents("php://input"));

$data = array(
    'account_id'    => $form_data->account_id,
    'proto'  => $form_data->proto,
    'dst_ip'  => $form_data->dst_ip,
    'dst_port'  => $form_data->dst_port,
    'descr'  => $form_data->descr,
    'state'  => $form_data->state,
    //'change_by'	=>	$change_by
    'change_by' => $_SESSION["username"]
);

$query = "
 INSERT INTO accesslist
 (account_id, proto, dst_ip, dst_port, descr, state, change_by) VALUES
 (:account_id, :proto, :dst_ip, :dst_port, :descr, :state, :change_by)
";



$statement = $connect->prepare($query);

if($statement->execute($data))
{
    $message = 'Data Inserted';
}

$output = array(
    'message' => $message
);

echo json_encode($output);

?>