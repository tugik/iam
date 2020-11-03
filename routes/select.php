<?php

//select.php
include("../auth.php");
include('../db/database_connection.php');

$query = "SELECT routes.id, routes.account_id, routes.dst_ip, routes.dst_mask, routes.descr, routes.state, routes.add_date, routes.upd_date, routes.change_by FROM routes JOIN accounts ON accounts.id=routes.account_id  ORDER BY routes.id DESC";
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