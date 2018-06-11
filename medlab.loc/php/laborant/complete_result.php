<?php
include($_SERVER['DOCUMENT_ROOT'].'/php/lib/connect.php');
if (isset($_COOKIE['service_id']) and isset($_COOKIE['service_hash'])) {
	if (isset($_POST['submit'])) {

		$query = "SELECT COUNT(ID_Result) as count FROM Specimen_result WHERE Date_complete = '".$_POST['result_date']."' ";
		$result = mysqli_query($link,$query);
        $row = mysqli_fetch_assoc($result);

        if (intval($row['count']) > 0) {

            header( 'Location: http://medlab.loc/php/laborant/add_specimen.php' ); exit();
        }
        else {

        	$medtest_id = $_POST['medtest'];
			$specimen_id = $_POST['specimen'];
			$date = date('Y-m-d H:i:s');

			$arr_id_ind = explode(",", $_POST['str_id_ind']);
			$arr_val_ind = $_POST['val_ind'];
			// массив, где key = id показателя, а value - значение показателя 
			$arr_ind = array_combine($arr_id_ind, $arr_val_ind);
			$arr_norm = $_POST['norm_ind'];
			$result = [];

			$i = 0;

			array_walk($arr_ind, function ($value, $key) use (&$result, &$arr_norm, &$i) {
			    $result[$key] = [$value, $arr_norm[$i]];
			    $i++;
			});

			$query_insertResult = "INSERT INTO Specimen_result SET 
					 Date_complete = '".$date."', ID_Medtest = '".$medtest_id."', ID_Specimen = '".$specimen_id."' ";

			mysqli_query($link, $query_insertResult);
			$id_result = mysqli_insert_id($link);

			foreach ($result as $key => $value) {
				$query_insertValuesResult = "INSERT INTO List_indicators_of_result SET 
						ID_Result = '".intval($id_result)."', 
						ID_Indicator = '".$key."', 
						Value_indicator = '".$value[0]."', 
						Is_normally = '".$value[1]."' ";
				mysqli_query($link, $query_insertValuesResult);
			}
			echo '<h2 align = "center">Результат успешно добавлен<h2>';
			echo "<a href = \"http://medlab.loc/php/laborant/add_specimen.php\">Добавить пробу</a>";
			echo '<a href = "http://medlab.loc/>На главную</a>';
        }	
		// print_r($arr_ind);
		// print_r($_POST['norm_ind']);
		//print_r($result[$key]);

	}
	else {
		header("Location: http://medlab.loc/php/laborant/add_specimen.php"); exit();
	}
}
else {
	header("Location: http://medlab.loc/php/laborant/add_specimen.php"); exit();
}
?>