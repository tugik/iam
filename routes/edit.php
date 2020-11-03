
<?php

//edit.php
include("../auth.php");
include('../db/database_connection.php');

$message = '';

$form_data = json_decode(file_get_contents("php://input"));

$data = array(
    ':dst_ip'  => $form_data->dst_ip,
    ':dst_mask'  => $form_data->dst_mask,
    ':descr'  => $form_data->descr,
    ':state'  => $form_data->state,
    ':id'  => $form_data->id
);

$query = "
 UPDATE routes 
 SET dst_ip = :dst_ip, dst_mask = :dst_mask, descr = :descr, state = :state
 WHERE routes.id = :id
";

$statement = $connect->prepare($query);
if($statement->execute($data))
{
    $message = 'Route Edited';
}

$output = array(
    'message' => $message
);

echo json_encode($output);

?>