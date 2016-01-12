<?php

class courierManager {
	
	private $connection;
	
	function __construct($mysqli){
		
		$this->connection = $mysqli;
	
	}


	function addNewOrder($description) {
		
		$stmt = $this->connection->prepare("INSERT INTO courier_service(package_description) VALUES(?)");
		$stmt->bind_param("s", $description);
		
		$message = "";
		
		if($stmt->execute()){
			$message = "*** Edukalt andmebaasi salvestatud ***";
		}
		
		$stmt->close();
		
		return $message;

	}
	
	function getAllData(){
		
		$stmt = $this->connection->prepare("SELECT id, package_description, package_yes_no, package_en_route, package_received FROM courier_service");
		
		$stmt->bind_result($id_from_db, $description_from_db, $yes_no_from_db, $en_route_from_db, $received_from_db);
		$stmt->execute();
		
		$array = array();
		
		while($stmt->fetch()){
			
			$order = new Stdclass();
			
			$order->id = $id_from_db;
			$order->description = $description_from_db;
			$order->existance = $yes_no_from_db;
			$order->en_route = $en_route_from_db;
			$order->received = $received_from_db;
			
			array_push($array, $order);
		}
		
		return $array;
		
		$stmt->close();
	}
	
	function packageExists($existance){
		
		$stmt = $this->connection->prepare("UPDATE courier_service SET package_yes_no=1 WHERE id=?");
		$stmt->bind_param("i", $existance);
		$stmt->execute();
		
		header("Location:data.php");
		
		$stmt->close();
	
	}
	
	function packageEnRoute($en_route){
		
		$stmt = $this->connection->prepare("UPDATE courier_service SET package_en_route=1 WHERE id=?");
		$stmt->bind_param("i", $en_route);
		$stmt->execute();
		
		header("Location:table.php");
		
		$stmt->close();
	
	}
	
	function packageReceived($received){
		
		$stmt = $this->connection->prepare("UPDATE courier_service SET package_received=1 WHERE id=?");
		$stmt->bind_param("i", $received);
		$stmt->execute();
		
		header("Location:table.php");
		
		$stmt->close();
	
	}
	
	
}
	
	
?>