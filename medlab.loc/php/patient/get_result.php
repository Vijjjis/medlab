<?php 
include($_SERVER['DOCUMENT_ROOT'].'/php/lib/connect.php');

if (isset($_COOKIE['patient_id']) and isset($_COOKIE['patient_hash'])) {
	if (isset($_POST['submit'])) {
		

		$err = [];

		if (!empty($_POST['orderID'])) {
			
			$query_IsOrder = "SELECT Patient.ID_Patient 
							  FROM Orders, Patient WHERE
							  Orders.ID_Patient = Patient.ID_Patient AND 
							  Orders.ID_Order = '".$_POST['orderID']."' ";
			$result_IsOrder = mysqli_query($link, $query_IsOrder);
			$row_IsOrder = mysqli_fetch_assoc($result_IsOrder);

			if ($_COOKIE['patient_id'] != $row_IsOrder['ID_Patient']) {
				$err[] = "Такого заказа не существует!";
			}

		}
		else {
			$err[] = "Введите номер заказа";
		}
		// если количество ошибок равно 0
		if (count($err) == 0) {
			

			$query_MedtestResult = "SELECT DISTINCT Specimen_result.ID_Specimen, Medtest.Name_medtest, Medtest.ID_Medtest FROM
				Medtest, Indicator_of_Medtest, List_indicators_of_result, Specimen_result, List_medtests_for_specimen 
				WHERE
				Medtest.ID_Medtest = Indicator_of_Medtest.ID_Medtest AND
				Indicator_of_Medtest.ID_Indicator = List_indicators_of_result.ID_Indicator AND
				List_indicators_of_result.ID_Result = Specimen_result.ID_Result AND
				Specimen_result.ID_Medtest = List_medtests_for_specimen.ID_Medtest AND
				Specimen_result.ID_Specimen = List_medtests_for_specimen.ID_Specimen AND
				List_medtests_for_specimen.ID_Order = '".$_POST['orderID']."' ";

			$result_MedtestResult = mysqli_query($link, $query_MedtestResult);
			$count = mysqli_num_rows($result_MedtestResult);

			if ($count != 0) {

				echo 
				"<!DOCTYPE html>
					<html lang=\"ru\">
					<head>
    					<meta charset=\"utf-8\">
    					<meta name=\"viewport\" content=\"nameth=device-nameth, initial-scale=1, shrink-to-fit=no\" />
    					<link rel=\"stylesheet\" href=\"../../css/bootstrap.min.css\" />
    					<link rel=\"stylesheet\" href=\"../../css/patient/get_result.css\" />
					</head>
					<body>
						<div class = \"container-fluid\">
						<h1>Результаты анализов заказа № ".$_POST['orderID']."</h1>";

				while ($row_MedtestResult = mysqli_fetch_assoc($result_MedtestResult) ) {

					$query_MedtestIndicator = "SELECT Indicator_of_Medtest.Name_indicator, Indicator_of_Medtest.Unit, List_indicators_of_result.Value_indicator, List_indicators_of_result.Is_normally FROM
					Medtest, Indicator_of_Medtest, List_indicators_of_result, Specimen_result, List_medtests_for_specimen 
					WHERE
					Medtest.ID_Medtest = Indicator_of_Medtest.ID_Medtest AND
					Indicator_of_Medtest.ID_Indicator = List_indicators_of_result.ID_Indicator AND
					List_indicators_of_result.ID_Result = Specimen_result.ID_Result AND
					Specimen_result.ID_Medtest = List_medtests_for_specimen.ID_Medtest AND
					Specimen_result.ID_Specimen = List_medtests_for_specimen.ID_Specimen AND
					List_medtests_for_specimen.ID_Order = '".$_POST['orderID']."' AND 
					List_medtests_for_specimen.ID_Specimen = '".intval($row_MedtestResult['ID_Specimen'])."' AND 
					List_medtests_for_specimen.ID_Medtest = '".intval($row_MedtestResult['ID_Medtest'])."' ";

					$result_MedtestIndicator = mysqli_query($link, $query_MedtestIndicator);
					echo "<div class = \"resultMedtest\">
							<h1>".$row_MedtestResult['Name_medtest']."</h1>";
					while ($row_MedtestIndicator = mysqli_fetch_assoc($result_MedtestIndicator)) {
						if ($row_MedtestIndicator['Is_normally'] == 1) {
							echo 
							"<p>
							".$row_MedtestIndicator['Name_indicator'].": 
							<span class = \"norm\">".$row_MedtestIndicator['Value_indicator']." ".$row_MedtestIndicator['Unit']."</span>
							</p>";
						}
						else if ($row_MedtestIndicator['Is_normally'] == 2) {
							echo 
							"<p>
							".$row_MedtestIndicator['Name_indicator'].": 
							<span class = \"norm_high\">".$row_MedtestIndicator['Value_indicator']." ".$row_MedtestIndicator['Unit']."</span>
							</p>";
						}
						else if ($row_MedtestIndicator['Is_normally'] == 0) {
							echo 
							"<p>
							".$row_MedtestIndicator['Name_indicator'].": 
							<span class = \"norm_low\">".$row_MedtestIndicator['Value_indicator']." ".$row_MedtestIndicator['Unit']."</span>
							</p>";
						}
					}
					echo "</div>";
				}
				echo 
					"	</div>
					</body>
					</html>";

			}

			else {
				echo "<p>К сожалению, результаты анализов ещё не готовы</p>";
			}

		}
		else {

        	foreach($err AS $error)

        	{

            	print $error."<br>";

        	}
		}

	}
	else {
		header("Location: http://medlab.loc/"); exit();
	}
}
else {
		header("Location: http://medlab.loc/"); exit();
}

?>