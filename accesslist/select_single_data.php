<?php

//select_single_data.php

include('database_connection.php');

$message = '';
$form_data = json_decode(file_get_contents("php://input"));

$data = [
    'id'  => (int)($form_data->id)
];

//$query = <<<SQL
// SELECT
//        accesslist.id,
//        accesslist.account_id,
//        accesslist.proto,
//        accesslist.dst_ip,
//        accesslist.dst_port,
//        accesslist.descr,
//        accesslist.state,
//        accesslist.add_date,
//        accesslist.upd_date,
//        accesslist.change_by
// FROM accesslist WHERE accesslist.account_id = :id
//SQL;

$query = <<<SQL
 SELECT 
        accesslist.id, 
        accesslist.account_id,
        accounts.account,
        accesslist.proto,
        accounts.ip,
        accesslist.dst_ip, 
        accesslist.dst_port, 
        accesslist.descr, 
        accesslist.state, 
        accesslist.add_date, 
        accesslist.upd_date, 
        accesslist.change_by 
FROM accesslist JOIN accounts ON accounts.id=accesslist.account_id WHERE accesslist.account_id = :id
SQL;

$statement = $connect->prepare($query);
if($statement->execute($data)) {
    $output = $statement->fetchAll(PDO::FETCH_ASSOC);
}

echo json_encode($output);

