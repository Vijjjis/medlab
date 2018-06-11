<?php
include($_SERVER['DOCUMENT_ROOT'].'/php/lib/connect.php');

if (!empty($_POST['phone'])) {
	$query = "UPDATE Patient SET Phone = '".$_POST['phone']."' WHERE ID_Patient = '".intval($_COOKIE['patient_id'])."' ";
	$result = mysqli_query($link, $query);
}

if (!empty($_POST['address'])) {
	$query = "UPDATE Patient SET Address = '".$_POST['address']."' WHERE ID_Patient = '".intval($_COOKIE['patient_id'])."' ";
	$result = mysqli_query($link, $query);
}

if (!empty($_POST['firstname'])) {
	$query = "UPDATE Patient SET Firstname = '".$_POST['firstname']."' WHERE ID_Patient = '".intval($_COOKIE['patient_id'])."' ";
	$result = mysqli_query($link, $query);
}

if (!empty($_POST['lastname'])) {
	$query = "UPDATE Patient SET Lastname = '".$_POST['lastname']."' WHERE ID_Patient = '".intval($_COOKIE['patient_id'])."' ";
	$result = mysqli_query($link, $query);
}

if (!empty($_POST['fathername'])) {
	$query = "UPDATE Patient SET Fathername = '".$_POST['fathername']."' WHERE ID_Patient = '".intval($_COOKIE['patient_id'])."' ";
	$result = mysqli_query($link, $query);
}

