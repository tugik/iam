<?php

//fetch_data.php

include('./db/database_connection.php');
$query = "SELECT * FROM accounts ORDER BY id";

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