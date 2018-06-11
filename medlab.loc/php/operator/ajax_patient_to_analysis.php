<?php
	include($_SERVER['DOCUMENT_ROOT'].'/php/lib/connect.php');

	if(!empty($_POST['id_patient'])) {

	    $query_dataPatient = "SELECT * FROM Patient WHERE ID_Patient = '".$_POST['id_patient']."' ";
	    
	    if ($result_dataPatient = mysqli_query($link, $query_dataPatient)) {

	    	$row_dataPatient = mysqli_fetch_assoc($result_dataPatient);

	    	if ($row_dataPatient['Gender'] == 'Женский')
	    		$query_medtest = "SELECT * FROM Medtest WHERE NOT Type_biomaterial = 'Эякулят' and isdelete = 0";
	    	else if ($row_dataPatient['Gender'] == 'Мужской')
	    		$query_medtest = "SELECT * FROM Medtest WHERE isdelete = 0";
	    	else
	    		echo "<option>Произошла ошибка</option>";

    		if ($result_medtest = mysqli_query($link,$query_medtest)) {
    			while ($row_medtest = mysqli_fetch_assoc($result_medtest)) {
    				echo 
        				'<option 
        				data-medtest_price = '.$row_medtest["Price_medtest"].' 
        				data-medtest_id = '.$row_medtest["ID_Medtest"].' 
        				data-medtest_name = "'.$row_medtest["Name_medtest"].'"
        				>'.$row_medtest["Name_medtest"].' - '.$row_medtest["Price_medtest"].' руб.
        				</option>'; 
    			}
    			mysqli_free_result($result_dataPatient);
    			mysqli_free_result($result_medtest);
    		}
	    }
	    mysqli_close($link);
	}
?>