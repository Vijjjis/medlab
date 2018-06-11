<?php
include($_SERVER['DOCUMENT_ROOT'].'/php/lib/connect.php');

if (!empty($_POST['id_patient'])) {
	$query = "SELECT * FROM Orders WHERE ID_Patient = '".$_POST['id_patient']."' ";
	if ($result = mysqli_query($link, $query)) {
		while ($row = mysqli_fetch_assoc($result)) {
			echo '<option value = '.$row['ID_Order'].'>Номер заказа - '.$row['ID_Order'].'</option>';
		}

	}
}

if (!empty($_POST['order_id'])) {

	// запрос на выборку тех анализов заказа, для которых есть проба
	$query_specimenOfOrder = "SELECT List_medtests_for_specimen.ID_Specimen, Medtest.Name_medtest, Medtest.ID_Medtest  FROM 
							  Specimen, Patient, Orders, List_medtests_in_order, Medtest, List_medtests_for_specimen
							  WHERE
							  Specimen.ID_Patient = Patient.ID_Patient AND
							  Patient.ID_Patient = Orders.ID_Patient AND
							  Orders.ID_Order = List_medtests_in_order.ID_Order AND
							  List_medtests_in_order.ID_Medtest = Medtest.ID_Medtest AND
							  Medtest.ID_Medtest = List_medtests_for_specimen.ID_Medtest AND
						 	  List_medtests_for_specimen.ID_Specimen = Specimen.ID_Specimen AND
						 	  List_medtests_for_specimen.ID_Order = Orders.ID_Order AND
						 	  Orders.ID_Order = '".$_POST['order_id']."' ";


	$result_specimenOfOrder = mysqli_query($link, $query_specimenOfOrder);

	// для каждого анализа каждой пробы
	while ($data_specimen = mysqli_fetch_assoc($result_specimenOfOrder)) {

		// проверяем, существует ли результат
		$query_IsResult = "SELECT ID_Result FROM Specimen_result WHERE 
				  ID_Medtest = '".$data_specimen['ID_Medtest']."' AND ID_Specimen = '".$data_specimen['ID_Specimen']."' ";

		$result_IsResult = mysqli_query($link, $query_IsResult);
		$count_rows = mysqli_num_rows($result_IsResult);

		// если результата нет, то выводим их в список как доступные для добавления результат
		if ($count_rows == 0) {

			/*cl_var_dump(intval($data_specimen['ID_Specimen']), 'ID_Specimen');
			cl_var_dump(intval($data_specimen['ID_Medtest']), 'ID_Medtest');
			cl_var_dump($data_specimen['Name_medtest'], 'Name_medtest');*/

			echo '<option 
				    data-idspecimen = '.$data_specimen['ID_Specimen'].' 
				    value = '.$data_specimen['ID_Medtest'].' 
				    >
				    Проба № - '.$data_specimen['ID_Specimen'].' | '.$data_specimen['Name_medtest'].'
				  </option>';
		}
		else {
			echo '<option disabled style="background: #5cb85c; color: #fff;"> 
				  Проба № - '.$data_specimen['ID_Specimen'].' | '.$data_specimen['Name_medtest'].' | Проверено
				  </option>';
		}
	}
}

if (!empty($_POST['idSpecimen'])) {
	$query_allIndicators = "SELECT * FROM Indicator_of_Medtest WHERE ID_Medtest = '".$_POST['idMedtest']."' ";
	$result_allIndicators = mysqli_query($link, $query_allIndicators);

	/*cl_var_dump($_POST['idSpecimen'], '$mas log cl_print_r');
	cl_var_dump($_POST['idMedtest'], '$mas log cl_print_r');*/

	while ($row_Indicator = mysqli_fetch_assoc($result_allIndicators)) {
		echo '<div class="form-group">
				<div class="col-xs-6 form-indicator">
        			<label for="'.$row_Indicator['Name_indicator'].'">'.$row_Indicator['Name_indicator'].':</label>
          			<input type="text" class="form-control form_ind" name="val_ind[]" data-id_ind = "'.$row_Indicator['ID_Indicator'].'">
	          		<select name="norm_ind[]">
	    	  			<option disabled>Норма анализа</option>
	      				<option value = "1">Норма</option>
	      				<option value = "2">Выше нормы</option>
	      				<option value = "0">Ниже нормы</option>
	          		</select>
        	  	</div>
      		  </div>';
	}

}

?>