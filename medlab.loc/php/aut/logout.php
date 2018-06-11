<?php
    include '../lib/connect.php';

    if (isset($_COOKIE['service_id']) and isset($_COOKIE['service_hash']))
    {
    	mysqli_query($link,"UPDATE Service SET service_hash = '' WHERE service_id = '".$_COOKIE['service_id']."' ");
    	setcookie("service_id", "", time() - 3600*24*30*12, "/");
    	setcookie("service_hash", "", time() - 3600*24*30*12, "/");
    	header("Location: http://medlab.loc/"); exit();
    }
    else if (isset($_COOKIE['patient_id']) and isset($_COOKIE['patient_hash']))
    {
    	mysqli_query($link, "UPDATE Patient SET Hash = '' WHERE ID_Patient = '".$_COOKIE['patient_id']."' ");
    	setcookie("patient_id", "", time() - 3600*24*30*12, "/");
    	setcookie("patient_hash", "", time() - 3600*24*30*12, "/");
    	header("Location: http://medlab.loc/"); exit();
    }
?>