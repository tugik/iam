<?php

//Generate IPSEC.USERS confuration

//include('database_connection.php');
$connect = new PDO("mysql:host=localhost;dbname=iam", "iamuser", "iampass");

// generate  files:
$query = "SELECT * FROM accounts WHERE state='enable' ORDER BY id";

$statement = $connect->prepare($query);
if($statement->execute())
{
    $ipsec = fopen('/opt/bin/user/ipsec.users', 'w');   // generate  users
    fwrite($ipsec, "# Auto generate by IAM for IPSEC\n\n" );
    while($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
        // add accounts to ipsec.users
        if($row['device'] === 'mac' &&  $row['dns1'] === 'no' && $row['dns2'] === 'no')
        {
            fwrite($ipsec, "conn " . $row['account'] . "\n\trightid=\"" . $row['account'] . "\"\n\trightsourceip=" . $row['ip'] . "\n\tleftid=" . $row['server'] . "\n\n");
        }
        elseif($row['device'] === 'mac'  &&  $row['dns1'] === 'no')
        {
            fwrite($ipsec, "conn " . $row['account'] . "\n\trightid=\"" . $row['account'] . "\"\n\trightsourceip=" . $row['ip'] . "\n\tleftid=" . $row['server'] . "\n\trightdns=" . $row['dns2'] . "\n\n");
        }
        elseif($row['device'] === 'mac'  &&  $row['dns2'] === 'no')
        {
            fwrite($ipsec, "conn " . $row['account'] . "\n\trightid=\"" . $row['account'] . "\"\n\trightsourceip=" . $row['ip'] . "\n\tleftid=" . $row['server'] . "\n\trightdns=" . $row['dns1'] . "\n\n");
        }
        elseif($row['device'] === 'mac')
        {
            fwrite($ipsec, "conn " . $row['account'] . "\n\trightid=\"" . $row['account'] . "\"\n\trightsourceip=" . $row['ip'] . "\n\tleftid=" . $row['server'] . "\n\trightdns=" . $row['dns1'] . "," . $row['dns2'] . "\n\n");
        }
        elseif($row['device'] === 'win' && $row['dns1'] === 'no' && $row['dns2'] === 'no')
        {
            fwrite($ipsec, "conn " . $row['account'] . "\n\trightid=\"CN=" . $row['account'] . ", O=*, OU=*\"\n\trightauth=pubkey" . "\n\trightsourceip=" . $row['ip'] . "\n\tleftid=" . $row['server'] . "\n\n");
        }
        elseif($row['device'] === 'win' && $row['dns1'] === 'no')
        {
            fwrite($ipsec, "conn " . $row['account'] . "\n\trightid=\"CN=" . $row['account'] . ", O=*, OU=*\"\n\trightauth=pubkey" . "\n\trightsourceip=" . $row['ip'] . "\n\tleftid=" . $row['server'] . "\n\trightdns=" . $row['dns2'] . "\n\n");
        }
        elseif($row['device'] === 'win' && $row['dns2'] === 'no')
        {
            fwrite($ipsec, "conn " . $row['account'] . "\n\trightid=\"CN=" . $row['account'] . ", O=*, OU=*\"\n\trightauth=pubkey" . "\n\trightsourceip=" . $row['ip'] . "\n\tleftid=" . $row['server'] . "\n\trightdns=" . $row['dns1'] . "\n\n");
        }
        else
        {
            fwrite($ipsec, "conn " . $row['account'] . "\n\trightid=\"CN=" . $row['account'] . ", O=*, OU=*\"\n\trightauth=pubkey" . "\n\trightsourceip=" . $row['ip'] . "\n\tleftid=" . $row['server'] . "\n\trightdns=" . $row['dns1'] .  "," . $row['dns2'] . "\n\n");
        }
    }
    fclose($ipsec);
}

?>