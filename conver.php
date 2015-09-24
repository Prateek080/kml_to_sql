<?php

include ('connect.php');
$connection = new createConnection(); //i created a new object
$connection=$connection->connectToDatabase(); // connected to the database     
$file = 'xx.kml';
$contents = file_get_contents($file); // filename
$xml      = new SimpleXMLElement($contents);  //getting the contents
set_time_limit(100000);
foreach($xml->Document->Folder as $city)
{       
         
        $city_name    = (string)$city->name;
		$sql = "INSERT INTO city_info (city_name) VALUES (?)";
		$sql =$connection->prepare($sql);
		$sql->bindParam(1,$city_name);
		$sql->execute();
		
		$nesql ="select id from city_info where city_name=?";
		$nesql =$connection->prepare($nesql);
		$nesql->bindParam(1,$city_name);
		$nesql->execute();
		$nesql->setFetchMode(PDO::FETCH_ASSOC);
		$result = $nesql->fetch();
		$city_id=$result['id'];
		
		 foreach($city->Placemark as $city_details)
		 {
					$city_location_name=$city_details->name;
					$raw=(string)$city_details->Polygon->outerBoundaryIs->LinearRing->coordinates;
					$values   = explode(" ", trim($raw));
					$coords   = array();
					foreach($values as $value) { 
						array_push($coords, $value);
					}
					$coords_string = serialize($coords);
					$sql = "INSERT INTO locations(name,coordinates,city_id) VALUES (?,?,?)";
					
					$sql =$connection->prepare($sql);
					$sql->bindParam(1,$city_location_name);
					$sql->bindParam(2,$coords_string);
					$sql->bindParam(3,$city_id);
					$sql->execute();
				 }
		echo "Data inserted";
}
 ?>