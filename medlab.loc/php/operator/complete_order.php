<?php

include($_SERVER['DOCUMENT_ROOT'].'/php/lib/connect.php');

function calculate_age($birthday) {
  $birthday_timestamp = strtotime($birthday);
  $age = date('Y') - date('Y', $birthday_timestamp);
  if (date('md', $birthday_timestamp) > date('md')) {
    $age--;
  }
  return $age;
}

if (isset($_COOKIE['service_id']) and isset($_COOKIE['service_hash'])) {
    if (isset($_POST['submit'])) {

        $query = "SELECT COUNT(ID_Order) as count FROM Orders WHERE Date_order = '".$_POST['order_date']."' ";
        $result = mysqli_query($link,$query);
        $row = mysqli_fetch_assoc($result);

        if (intval($row['count']) > 0) {

            header( 'Location: http://medlab.loc/php/operator/order.php' ); exit();

        }

        else {
            $price = $_POST['sum_price'];

            $medtest_name = $_POST['medtest_name'];
            $array_medtest_name = explode(",", $medtest_name);

            $id_medtest = $_POST['medtest_id'];
            $array_id_medtest = explode(",", $id_medtest);

            $date_pdf = date('d-m-Y');
            $date = $_POST['order_date'];

            $id_patient = $_POST['patient'];
            $row_dataPatient = '';
            $query_dataPatient = "SELECT * FROM Patient WHERE ID_Patient = '".$id_patient."' ";
            if ($result_dataPatient = mysqli_query($link, $query_dataPatient))
                $row_dataPatient = mysqli_fetch_assoc($result_dataPatient);

            $query_insertOrder = "INSERT INTO Orders SET Date_order ='".$date."', Price_order = $price, ID_Patient = '".$id_patient."' ";
            mysqli_query($link, $query_insertOrder);

            $id_order = mysqli_insert_id($link);
            foreach ($array_id_medtest AS $id) {
                $query_insertLMIO = "INSERT INTO List_medtests_in_order SET ID_Order = '".$id_order."', ID_Medtest = '".$id."' ";
                mysqli_query($link, $query_insertLMIO);
            }
            $age = calculate_age($row_dataPatient['Birthday']);
        }
    }
}
else {

    header("Location: http://medlab.loc/"); exit();

} 
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <script type="text/javascript" src="../../lib/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="../../lib/bootstrap.min.css" />
    <link rel="stylesheet" href="../../lib/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="../../css/operator/check_napr.css" />

    <script type="text/javascript" src="../../lib/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../lib/bootstrap-dropdown.js"></script>

</head>
<body>
    <div class="container-fluid">

        <div class="hidden-print">
            <a href="http://medlab.loc/">
                <button type="button" class="btn btn-success btn-lg btn-block">Перейти на главную</button>
            </a>
        </div>
        <div class="hidden-print">
            <a href="http://medlab.loc/php/operator/order.php">
                <button type="button" class="btn btn-success btn-lg btn-block">Оформить следующий заказ</button>
            </a>
        </div>

        <div class="col-xs-offset-3 col-xs-6 alert alert-success">
            <p><b>Сохраняйте номер заказа!</b></p>
            <h3 class="alert-heading">Заказ номер <?php echo $id_order;?></h3>
            <hr>
            <h4>Личные данные пациента</h4>
                <p><b>ФИО</b>: 
                    <?php 
                    echo $row_dataPatient["Lastname"].' '.$row_dataPatient["Firstname"].' '.$row_dataPatient['Fathername']; 
                    ?>
                </p>
                <p><b>Пол</b>: 
                    <?php 
                    echo $row_dataPatient["Gender"] 
                    ?>
                </p>
                <?php
                    if (!empty($row_dataPatient["Phone"])) {
                        echo '<p><b>Телефон</b>: +'.$row_dataPatient["Phone"].'</p>';
                    }
                    if (!empty($row_dataPatient["Address"])) {
                        echo '<p><b>Адрес</b>: '.$row_dataPatient["Address"].'</p>';
                    }
                    if (!empty($row_dataPatient["E_mail"])) {
                        echo '<p><b>E_mail</b>: '.$row_dataPatient["E_mail"].'</p>';
                    }
                ?>
            <hr>    
            <h4>Список анализов</h4>
                <div class = 'medtest-price'>
                <?php
                    foreach ($array_medtest_name AS $medtest_name) {
                        $query_dataMedtest = "SELECT * FROM Medtest WHERE Name_medtest = '".$medtest_name."' ";
                        if ($result_dataMedtest = mysqli_query($link,$query_dataMedtest)) {
                            $row_dataMedtest = mysqli_fetch_assoc($result_dataMedtest);
                            echo 
                                '<div class = "left-col">'.$medtest_name.'</div>
                                <div class = "right-col">'.$row_dataMedtest["Price_medtest"].' руб.</div>
                                <div class = "clear"></div>';
                        }
                    }
                ?>
                </div>
            <hr>
            <p align="right">Итого: <?php echo $price;?> руб.</p>
            <p align="right"><b>Дата оформления</b>: <?php echo $date_pdf;?></p>
            <hr class="hr_napr">
            <h3>Направление</h3>
                <div class = 'napravlenie'>
                <?php
                   foreach ($array_medtest_name AS $medtest_name) {
                        $query_dataMedtest = "SELECT * FROM Medtest WHERE Name_medtest = '".$medtest_name."' ";
                        if ($result_dataMedtest = mysqli_query($link,$query_dataMedtest)) {

                            $row_dataMedtest = mysqli_fetch_assoc($result_dataMedtest);
                            echo "<hr class = \"hr_napr\">";
                            echo '<h5 align = "center">'.$medtest_name.'</h5>
                                    <p>ФИО: 
                                    '.$row_dataPatient["Lastname"].' 
                                    '.$row_dataPatient["Firstname"].' 
                                    '.$row_dataPatient['Fathername'].'
                                    </p>
                                    <p>Возраст: '.$age.'</p>';

                            if ($row_dataMedtest['Type_biomaterial'] == "Кровь") {
                                echo
                                '<p>Кабинет для сдачи крови: 314 </p>
                                <p>Дата выдачи направления: '.$date_pdf.'<p>
                                <p>Подпись выдавшего направление:';
                            }
                            else if ($row_dataMedtest['Type_biomaterial'] == "Эякулят") {
                                echo
                                '<p>Место сдачи: Отделение 2, "Пункт приёма биоматериала №2"</p>
                                <p>Дата выдачи направления: '.$date_pdf.'<p>
                                <p><b>Направление самостоятельно прикрепить к контейнеру с биоматериалом</b></p>
                                <p>Подпись выдавшего направление:';
                            }
                            else if ($row_dataMedtest['Type_biomaterial'] == "Кал" 
                                or $row_dataMedtest['Type_biomaterial'] == 'Моча') {
                                echo
                                '<p>Место сдачи: Отделение 2, "Пункт приёма биоматериала №1"</p>
                                <p>Дата выдачи направления: '.$date_pdf.'<p>
                                <p><b>Направление самостоятельно прикрепить к контейнеру с биоматериалом</b></p>
                                <p>Подпись выдавшего направление:';
                            }
                        }
                    }   
                ?>
                </div>
        </div>

    </div>
</body>

</html>