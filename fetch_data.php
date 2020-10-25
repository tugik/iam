<?php

//fetch_data.php

include('database_connection.php');

     $query = "SELECT records.id, records.zone_id, zones.zone, records.name, records.ttl, records.class, records.type, records.priority, records.weight, records.port, records.data, records.descr, records.state, records.add_date, records.upd_date, records.change_by FROM records JOIN zones ON zones.id=records.zone_id ORDER BY id";
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