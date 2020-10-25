<?php

//fetch_data.php

include('database_connection.php');
$query = "SELECT * FROM zones ORDER BY id";

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