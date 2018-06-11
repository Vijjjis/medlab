<?php
	if (isset($_POST['main']))
        {
        	header("Location: http://medlab.loc/"); exit();
        }

    if (isset($_POST['new_order']))
        {
        	header("Location: http://medlab.loc/php/operator/order.php"); exit();
        }  
?>