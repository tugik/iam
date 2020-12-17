<?php

//select.php
include("../auth.php");
include('../db/database_connection.php');

//$query = "SELECT accounts.account, accesslist.id, accesslist.account_id, accesslist.proto, accesslist.dst_ip, accesslist.dst_port, accesslist.descr, accesslist.state, accesslist.add_date, accesslist.upd_date, accesslist.change_by FROM accesslist JOIN accounts ON accounts.id=accesslist.account_id  ORDER BY accesslist.id DESC";
$query = "SELECT accounts.account, accesslist.id, accesslist.account_id, accesslist.proto, accounts.ip, accesslist.dst_ip, accesslist.dst_port, accesslist.descr, accesslist.state, accesslist.add_date, accesslist.upd_date, accesslist.change_by, (@row_number:=@row_number + 1) AS number FROM accesslist JOIN accounts ON accounts.id=accesslist.account_id, (SELECT @row_number:=0) AS n ORDER BY accounts.id";
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