<?php

//Generate AUTHORIZE confuration

//include('database_connection.php');
$connect = new PDO("mysql:host=localhost;dbname=iam", "iamuser", "iampass");

// generate  files:
$query = "SELECT * FROM accounts WHERE state='enable' ORDER BY id";

$statement = $connect->prepare($query);
if($statement->execute())
{
    $authorize = fopen('/opt/bin/user/authorize', 'w');   // generate  users
    fwrite($authorize, "# Auto generate by IAM for RADIUS\n\n" );
    while($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
        // add accounts to authorize
    fwrite($authorize,     $row['account'] ."\tAuth-Type := Accept\n\tTunnel-Type = \"VLAN\",\n\tTunnel-Medium-Type = \"IEEE-802\",\n\tTunnel-Private-Group-Id = \"". $row['vlan'] . "\",\n\tFramed-IP-Address = ". $row['ip'] . "\n\n" .           "net1001.". $row['vlan'] ."\tAuth-Type := Accept\n\tFramed-IP-Address = ". $row['ip'] .",\n\tFramed-IP-Netmask = ". $row['netmask'] .",\n\tPPPD-Upstream-Speed-Limit = 102400,\n\tPPPD-Downstream-Speed-Limit = 102400,\n\tReply-Message := \"Accept for, %{User-Name}\"\n\n" );
    }
    fclose($authorize);
}

?>