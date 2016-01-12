<?php
	
	require_once("functions.php");
	require_once("courierManager.class.php");
	require_once("header.php");
	
	$courierManager = new courierManager($mysqli);
	
	$orders_array = $courierManager->getAllData();
	
?>

<table border="1">
	<tr>
		<th>Tellimuste arv kokku</th>
		<th>Lõpetatud tellimuste arv</th>
	</tr>
	
<?php
	
	$count = 0;
	for($i = 0; $i < count($orders_array); $i++){
		if($orders_array[$i]->received == "1"){
			$count++;
		}	
	}
	
	echo "<td>".count($orders_array)."</td>";
	echo "<td>".$count."</td>";

?>

</table><br>

<?php require_once("footer.php"); ?>