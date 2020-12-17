<?php

//edit.php
include("../auth.php");
include('../db/database_connection.php');

$message = '';

$form_data = json_decode(file_get_contents("php://input"));

$change_by = $_SESSION["username"];

$data = array(
    ':proto'  => $form_data->proto,
    ':dst_ip'  => $form_data->dst_ip,
    ':dst_port'  => $form_data->dst_port,
    ':descr'  => $form_data->descr,
    ':state'  => $form_data->state,
    ':change_by'	=>	$change_by,
    ':id'  => $form_data->id
);

$query = "
 UPDATE accesslist 
 SET proto = :proto, dst_ip = :dst_ip, dst_port = :dst_port, descr = :descr, state = :state, change_by = :change_by
 WHERE accesslist.id = :id
";

$statement = $connect->prepare($query);
if($statement->execute($data))
{
    $message = 'Access rule Edited';
}

$output = array(
    'message' => $message
);

echo json_encode($output);

?>