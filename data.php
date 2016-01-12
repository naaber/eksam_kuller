<?php
	
	require_once("functions.php");
	require_once("courierManager.class.php");
	require_once("header.php");

	$courierManager = new courierManager($mysqli);
	
	$message = "";
	$description = "";
	$description_error = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		if(isset($_POST["add_new_order"])){
			
			if(empty($_POST["description"])){
				$description_error = "*** Kirjeldus on kohustuslik ***";
			} else {
				$description = cleanInput($_POST["description"]);
				$message = $courierManager->addNewOrder($description);
			}
		}
	}
	
	$orders_array = $courierManager->getAllData();
	
	if(isset($_GET["update_1"])){
		$courierManager->packageExists($_GET["update_1"]);
	}

	function cleanInput($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
	}
	
?>

<h3>Lisa uus tellimus</h3>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	<textarea style="resize:none" id ="description" name="description" type="text" rows="10" cols="28" placeholder="Kirjeldus"></textarea><br><br> 
	<input name="add_new_order" type="submit" value="Lisa uus tellimus">
</form>

<?=$description_error;?>

<?=$message;?>

<h3>Sisestatud pakid</h3>

<table border="1">
	<tr>
		<th>Kirjeldus</th>
		<th>Olemasolu</th>
		<th></th>
	</tr>

<?php

	for($i = 0; $i < count($orders_array); $i++){
		
		echo "<tr>";
		echo "<td>".$orders_array[$i]->description."</td>";
		if($orders_array[$i]->existance == "1"){
			echo "<td>Olemas</td>";
			echo "<td></td>";
		} else {
			echo "<td>Ei ole olemas</td>";
			echo "<td><a href='?update_1=".$orders_array[$i]->id."'>Pakk olemas</a></td>";
		}
		
	}

?>

</table><br>

<?php require_once("footer.php"); ?>