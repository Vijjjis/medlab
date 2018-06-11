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
	// Все анализы выбранного заказа
	$query = "SELECT Medtest.ID_Medtest, Medtest.Name_medtest, Medtest.Type_biomaterial 
			  FROM Medtest, List_medtests_in_order, Orders WHERE
			  Medtest.ID_Medtest = List_medtests_in_order.ID_Medtest AND
              List_medtests_in_order.ID_Order = Orders.ID_Order AND
			  Orders.ID_Order = '".$_POST['order_id']."' ";	  
	$result = mysqli_query($link, $query);

	while ($row = mysqli_fetch_assoc($result)) {
		// Для каждого анализа проверяет, существует ли для него проба
		$query_IsSpecimen = "SELECT ID_Specimen FROM List_medtests_for_specimen WHERE 
							 ID_Medtest = '".$row['ID_Medtest']."' AND ID_Order = '".$_POST['order_id']."' ";
		$result_IsSpecimen = mysqli_query($link, $query_IsSpecimen);
		$count_row = mysqli_num_rows($result_IsSpecimen);
		$row_IsResult = mysqli_fetch_assoc($result_IsSpecimen);

		// Если проба отсутствует
		if ($count_row == 0) {
			echo 
			'<option data-typebio = '.$row['Type_biomaterial'].' value = '.$row['ID_Medtest'].'>
			'.$row['Name_medtest'].'
			</option>';
		}
		else {
			echo 
			'<option disabled style="background: #5cb85c; color: #fff;">
			Проба № '.$row_IsResult['ID_Specimen'].' | '.$row['Name_medtest'].' | Проба добавлена
			</option>';
		}
	}
}

?>