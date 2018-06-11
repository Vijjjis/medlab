<?php
// Скрипт проверки

include($_SERVER['DOCUMENT_ROOT'].'/php/lib/connect.php');

if ( isset($_COOKIE['patient_id']) and isset($_COOKIE['patient_hash']) )

{   

    $query = "SELECT * FROM Patient WHERE ID_Patient = '".intval($_COOKIE['patient_id'])."' LIMIT 1";
    if ($result = mysqli_query($link, $query));
        $userdata = mysqli_fetch_assoc($result);

    if(($userdata['Hash'] !== $_COOKIE['patient_hash']) or ($userdata['ID_Patient'] !== $_COOKIE['patient_id']))

    {
        setcookie("patient_id", "", time() - 3600*24*30*12, "/");
        setcookie("patient_hash", "", time() - 3600*24*30*12, "/");
        
        echo "<h1 align = \"center\">Упс, походу что-то пошло не так.</h1>";
        echo "<center><a  href=\"login.php\">Нажмите, чтобы повторить вход</a><center>";
    }

    else 
    {
        header("Location: http://medlab.loc/"); exit();
    }

}

else if ( isset($_COOKIE['service_id']) and isset($_COOKIE['service_hash']) )

{
    $query = "SELECT * FROM Service WHERE service_id = '".intval($_COOKIE['service_id'])."' LIMIT 1";

    if ($result = mysqli_query($link, $query));
        $userdata = mysqli_fetch_assoc($result);

    if(($userdata['service_hash'] !== $_COOKIE['service_hash']) or ($userdata['service_id'] !== $_COOKIE['service_id']))

    {

        setcookie("service_id", "", time() - 3600*24*30*12, "/");

        setcookie("service_hash", "", time() - 3600*24*30*12, "/");

        echo "<h1 align = \"center\">Упс, походу что-то пошло не так.</h1>";
        echo "<center><a  href=\"login_service.php\">Нажмите, чтобы повторить вход</a><center>";

    }

    else 
    {
        header("Location: http://medlab.loc/"); exit(); 
    }

}
?>