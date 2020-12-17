<?php

//Generate ACCESSLIST confuration

//include('database_connection.php');
$connect = new PDO("mysql:host=localhost;dbname=iam", "iamuser", "iampass");

// generate  files:
$query = "SELECT * FROM accounts WHERE state='enable' ORDER BY id";

$statement = $connect->prepare($query);
if($statement->execute())
{
    $accesslist = fopen('/opt/bin/fw/rulus.conf', 'w');   // generate  users
    fwrite($accesslist, "# Auto generate by IAM for FW\n" );
    while($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
        // add accounts to accesslist
     fwrite($accesslist,     "\n#" . $row['account'] ."   ". $row['ip'] . "   ". $row['fullname'] . "   " . $row['descr'] ."\n" );
        // add rules to accesslist
        $query1 = "SELECT accesslist.proto, accounts.ip, accesslist.dst_ip, accesslist.dst_port, accesslist.descr FROM accesslist JOIN accounts ON accounts.id=accesslist.account_id  WHERE accounts.account=:account AND accesslist.state='enable' ORDER BY accounts.id";
        $statement1 = $connect->prepare($query1);
        if($statement1->execute(['account' => $row['account']]))
        {
            while($row1 = $statement1->fetch(PDO::FETCH_ASSOC))
            {
                fwrite($accesslist, $row1['proto'] . ", " . $row1['ip'] .", " . $row1['dst_ip'] .  ", " . $row1['dst_port'] .  "     " . $row1['descr'] ."\n");
            }
        }
    }
    fclose($accesslist);
}

?>