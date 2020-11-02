<?php

//select.php

include('database_connection.php');

//$query = "SELECT * FROM accesslist JOIN accounts ON accounts.id=accesslist.account_id ORDER BY accounts.id DESC";
//$query = "SELECT accesslist.id, accesslist.account_id, accesslist.proto, accesslist.dst_ip, accesslist.dst_port, accesslist.descr, accesslist.state, accesslist.add_date, accesslist.upd_date, accesslist.change_by FROM accesslist JOIN accounts ON accounts.id=accesslist.account_id ORDER BY accesslist.id DESC";
$query = "SELECT accesslist.id, accesslist.account_id, accesslist.proto, accesslist.dst_ip, accesslist.dst_port, accesslist.descr, accesslist.state, accesslist.add_date, accesslist.upd_date, accesslist.change_by FROM accesslist JOIN accounts ON accounts.id=accesslist.account_id  ORDER BY accesslist.id DESC";
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