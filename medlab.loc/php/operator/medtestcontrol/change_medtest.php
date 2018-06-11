<?php  

include($_SERVER['DOCUMENT_ROOT'].'/php/lib/connect.php');
if (isset($_POST['submit'])) {

	$query = mysqli_query($link, "UPDATE Medtest SET Name_medtest = '".$_POST['name']."', Price_medtest = '".$_POST['price']."', Type_biomaterial = '".$_POST['typebio']."' WHERE ID_Medtest = '".intval($_POST['id_medtest'])."' ");
	header("Location: http://medlab.loc/php/operator/medtestcontrol/mc.php"); exit();
}

if (isset($_POST['delete'])) {
	$query = mysqli_query($link, "UPDATE Medtest SET isdelete = 1 WHERE ID_Medtest = '".intval($_POST['id_medtest'])."' ");
	header("Location: http://medlab.loc/php/operator/medtestcontrol/mc.php"); exit();
}

if (isset($_POST['add'])) {
	if (!empty($_POST['name']) and !empty($_POST['price']) and !empty($_POST['typebio'])) {
		$query = mysqli_query($link, "INSERT INTO Medtest SET Name_medtest = '".$_POST['name']."', Price_medtest = '".$_POST['price']."', Type_biomaterial = '".$_POST['typebio']."' ");
		header("Location: http://medlab.loc/php/operator/medtestcontrol/mc.php"); exit();
	}
	header("Location: http://medlab.loc/php/operator/medtestcontrol/mc.php"); exit();
}
?>