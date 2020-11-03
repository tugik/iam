<?php

//insert.php
include("../auth.php");
include('../db/database_connection.php');

$message = '';

$form_data = json_decode(file_get_contents("php://input"));

$data = array(
    'account_id'    => $form_data->account_id,
    'dst_ip'  => $form_data->dst_ip,
    'dst_mask'  => $form_data->dst_mask,
    'descr'  => $form_data->descr,
    'state'  => $form_data->state,
    'change_by' => $_SESSION["username"]
);

$query = "
 INSERT INTO routes
 (account_id, dst_ip, dst_mask, descr, state, change_by) VALUES
 (:account_id, :dst_ip, :dst_mask, :descr, :state, :change_by)
";



$statement = $connect->prepare($query);

if($statement->execute($data))
{
    $message = 'Route Inserted';
}

$output = array(
    'message' => $message
);

echo json_encode($output);

?>