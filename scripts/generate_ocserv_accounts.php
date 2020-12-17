<?php

//Generate OCSERV confuration


// delete all file
array_map('unlink', glob("/opt/bin/user/ocs/*"));

//include('database_connection.php');
$connect = new PDO("mysql:host=localhost;dbname=iam", "iamuser", "iampass");

// generate  files:
$query = "SELECT * FROM accounts WHERE state='enable' ORDER BY id";

$statement = $connect->prepare($query);
if($statement->execute())
{
    while($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
        // generate account file
        $output = fopen('/opt/bin/user/ocs/'.$row['account'], 'w');

        if($row['dns1'] === 'no' && $row['dns2'] === 'no')
        {
            fwrite($output, "# Auto generate by IAM for OCSERV\nexplicit-ipv4 = " . $row['ip'] . "\nipv4-network = " . $row['network'] . "\nipv4-netmask = " . $row['netmask'] . "\n");
        }
        elseif($row['dns1'] === 'no')
        {
            fwrite($output, "# Auto generate by IAM for OCSERV\nexplicit-ipv4 = " . $row['ip'] . "\nipv4-network = " . $row['network'] . "\nipv4-netmask = " . $row['netmask'] ."\ndns = " . $row['dns2'] ."\n");
        }
        elseif($row['dns2'] === 'no')
        {
            fwrite($output, "# Auto generate by IAM for OCSERV\nexplicit-ipv4 = " . $row['ip'] . "\nipv4-network = " . $row['network'] . "\nipv4-netmask = " . $row['netmask'] ."\ndns = " . $row['dns1'] ."\n");
        }
        else
        {
            fwrite($output, "# Auto generate by IAM for OCSERV\nexplicit-ipv4 = " . $row['ip'] . "\nipv4-network = " . $row['network'] . "\nipv4-netmask = " . $row['netmask'] . "\ndns = " . $row['dns1'] . "\ndns = " . $row['dns2'] . "\n");
        }

        // add routes to account file
        $query1 = "SELECT routes.dst_ip, routes.dst_mask, routes.state  FROM routes JOIN accounts ON accounts.id=routes.account_id WHERE accounts.account=:account AND (routes.state='enable' OR routes.state='norout') ORDER BY routes.id";
        $statement1 = $connect->prepare($query1);
        if($statement1->execute(['account' => $row['account']]))
        {
            while($row1 = $statement1->fetch(PDO::FETCH_ASSOC))
            {
                if($row1['state'] === 'enable' && $row1['dst_ip'] === '0.0.0.0' && $row1['dst_mask'] === '0.0.0.0')
                {
                    fwrite($output, "route = default" . "\n");
                }
                elseif($row1['state'] === 'enable')
                {
                    fwrite($output, "route = " . $row1['dst_ip'] . "/" . $row1['dst_mask'] . "\n");
                }
                else
                {
                    fwrite($output, "no-route = " . $row1['dst_ip'] . "/" . $row1['dst_mask'] . "\n");
                }
            }
        }
        fclose($output);
    }
}

?>