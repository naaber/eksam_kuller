<?php
	
	require_once("functions.php");
	require_once("courierManager.class.php");
	require_once("header.php");
	
	$courierManager = new courierManager($mysqli);
	
	$orders_array = $courierManager->getAllData();
	
	if(isset($_GET["update_2"])){
		$courierManager->packageEnRoute($_GET["update_2"]);
	}
	
	if(isset($_GET["update_3"])){
		$courierManager->packageReceived($_GET["update_3"]);
	}

?>

<h3>Tellimused</h3>

<table border="1">
	<tr>
		<th>Kirjeldus</th>
		<th>Teel</th>
		<th>Kättesaadud</th>
		<th></th>
		<th></th>
	</tr>

<?php

	for($i = 0; $i < count($orders_array); $i++){
		
		if($orders_array[$i]->existance == "1"){
		
			echo "<tr>";
			echo "<td>".$orders_array[$i]->description."</td>";
			if($orders_array[$i]->en_route == ""){
				echo "<td>0</td>";
			} else {
				echo "<td>".$orders_array[$i]->en_route."</td>";
			}
			if($orders_array[$i]->received == ""){
				echo "<td>0</td>";
			} else {
				echo "<td>".$orders_array[$i]->received."</td>";
			}
			if($orders_array[$i]->en_route == "1"){
				echo "<td></td>";
			} else {
				echo "<td><a href='?update_2=".$orders_array[$i]->id."'>Pakk teel</a></td>";
			}
			if($orders_array[$i]->received == "1"){
				echo "<td></td>";
			} else {
				echo "<td><a href='?update_3=".$orders_array[$i]->id."'>Pakk kättesaadud</a></td>";
			}
			echo "</tr>";
			
		}
	}
	
?>

</table><br>

<?php require_once("footer.php"); ?>