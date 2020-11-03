<?php

//select_single_data.php
include("../auth.php");
include('../db/database_connection.php');

$message = '';
$form_data = json_decode(file_get_contents("php://input"));

$data = [
    'id'  => (int)($form_data->id)
];

$query = <<<SQL
 SELECT 
        routes.id, 
        routes.account_id,
        accounts.account,
        routes.dst_ip, 
        routes.dst_mask, 
        routes.descr, 
        routes.state, 
        routes.add_date, 
        routes.upd_date, 
        routes.change_by 
FROM routes JOIN accounts ON accounts.id=routes.account_id WHERE routes.account_id = :id
SQL;

$statement = $connect->prepare($query);
if($statement->execute($data)) {
    $output = $statement->fetchAll(PDO::FETCH_ASSOC);
}

echo json_encode($output);

