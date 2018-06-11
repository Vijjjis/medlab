<?php
	include($_SERVER['DOCUMENT_ROOT'].'/php/lib/connect.php');
	if (isset($_COOKIE['service_id']) and isset($_COOKIE['service_hash'])) {
		if (isset($_POST['submit_specimen'])) {

			$query = "SELECT COUNT(ID_Specimen) as count FROM Specimen WHERE Date_get = '".$_POST['specimen_date']."' ";
			$result = mysqli_query($link,$query);
        	$row = mysqli_fetch_assoc($result);

        	if (intval($row['count']) > 0) {

            	header( 'Location: http://medlab.loc/php/laborant/add_specimen.php' ); exit();
        	}

        	else {

        		$order = $_POST['order'];
				$arr_medtest = [];
				$arr_medtest = $_POST['medtest'];
				$date = $_POST['specimen_date'];

				$query_insertSPEC = "INSERT INTO Specimen 
									 SET Date_get = '".$date."', ID_Patient = '".$_POST['patient']."' ";

				if ($result = mysqli_query($link, $query_insertSPEC)) {

					$ID_Specimen = mysqli_insert_id($link);

					foreach ($arr_medtest as $id_medtest) {
					/*echo "ID order = $order   ";
					echo "ID Specimem = $ID_Specimen   ";
					echo "ID Medtest = $id_medtest   ";*/
					$query_insertListMFS = "INSERT INTO List_medtests_for_specimen SET
											ID_Specimen = '".intval($ID_Specimen)."', 
											ID_Medtest = '".intval($id_medtest)."', 
											ID_Order = '".intval($order)."'
											";
					mysqli_query($link, $query_insertListMFS);
					$right = mysqli_insert_id($link);
					echo '<h1 align = "center">Проба успешно добавлена</h1>';
					}
				}
				else {
					mysqli_error($link);
				}

        	}
			
			//$arr_notSpecimen = [];

			//Цикл для каждого анализа добавляемой пробы
			/*foreach ($arr_medtest as $id_medtest) {
				$query_isSpecimen =  "SELECT List_medtests_in_order.ID_Medtest 
									  FROM List_medtests_in_order, Medtest, Orders, List_medtests_for_specimen 
									  WHERE
									  Medtest.ID_Medtest = List_medtests_in_order.ID_Medtest AND
									  Medtest.ID_Medtest = List_medtests_for_specimen.ID_Medtest AND
									  List_medtests_in_order.ID_Order = Orders.ID_Order AND
									  Orders.ID_Order = List_medtests_for_specimen.ID_Order AND 
									  Orders.ID_Order = '".$_POST['order']."' AND
									  List_medtests_in_order.ID_Medtest = '".$id_medtest."' ";

				$result_isSpecimen = mysqli_query($link, $query_isSpecimen);
				$count_rows = mysqli_num_rows($result_isSpecimen);
				if ($count_rows  == 0) {
					array_push($arr_notSpecimen, $id_medtest);
				}
				else {
					echo "<h1 align = \"center\">Проба для анализа $id_medtest уже существуют</h1>";
				}
			}*/
				
		}

		else {
			header("Location: http://medlab.loc/php/laborant/add_specimen.php"); exit();
		}
	}

	else {
		header("Location: http://medlab.loc/"); exit();
	}
?>