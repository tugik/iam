<?php

//select.php
include("../auth.php");
include('../db/database_connection.php');

//$query = "SELECT accounts.account, routes.id, routes.account_id, routes.dst_ip, routes.dst_mask, routes.descr, routes.state, routes.add_date, routes.upd_date, routes.change_by FROM routes JOIN accounts ON accounts.id=routes.account_id  ORDER BY routes.id DESC";
$query = "SELECT accounts.account, routes.id, routes.account_id, routes.dst_ip, routes.dst_mask, routes.descr, routes.state, routes.add_date, routes.upd_date, routes.change_by, (@row_number:=@row_number + 1) AS number FROM routes JOIN accounts ON accounts.id=routes.account_id, (SELECT @row_number:=0) AS n ORDER BY routes.id";
$statement = $connect->prepare($query);
if($statement->execute())
{
    while($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
        $data[] = $row;
    }
    echo json_encode($data);
}

?>