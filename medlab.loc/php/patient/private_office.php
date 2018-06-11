<?php
    include($_SERVER['DOCUMENT_ROOT'].'/php/lib/connect.php');

    $query_patient = "SELECT * FROM Patient WHERE ID_Patient = '".intval($_COOKIE['patient_id'])."' ";
    $result_patient = mysqli_query($link,$query_patient);
    $row_patient = mysqli_fetch_assoc($result_patient);

    $query_order = "SELECT * FROM Orders WHERE ID_Patient = '".intval($_COOKIE['patient_id'])."'";
    $result_order = mysqli_query($link,$query_order);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Личный кабинет</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <script type="text/javascript" src="../../lib/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="../../lib/bootstrap.min.css" />
    <link rel="stylesheet" href="../../lib/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="../../lib/bootstrap-select.min.css" />
    <link rel="stylesheet" href="../../css/patient/private_office.css" />

    <script type="text/javascript" src="../../lib/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../lib/bootstrap-dropdown.js"></script>
    <script type="text/javascript" src="../../lib/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="../../js/patient/private_office.js"></script>
    <script type="text/javascript" src="../../lib/defaults-ru_RU.js"></script>

    <script type="text/javascript" src="../../lib/jquery.maskedinput.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
          $(".phone").mask("+7(999)999-99-99");
        });
    </script>
</head>
<body>
    <div class="container-fluid">
        <a href="http://medlab.loc"><button type="button" class="btn btn-success btn-lg btn-block">Перейти на главную</button></a>
        <h1 align="center">Личный кабинет </h1>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#panel1">Личные данные</a></li>
            <li><a data-toggle="tab" href="#panel2">Заказы</a></li>
        </ul>
 
        <div class="tab-content">
          <div id="panel1" class="tab-pane fade in active">
            <?php
            echo 
            '
            <div class="col-xs-offset-3 col-xs-6">
                    <div class="row">
                        <div class="form-group">
                            <label class="control-label col-xs-3" for="lastname">Фамилия:</label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control lastname change" name="lastname" value = "'.$row_patient['Lastname'].'">
                            </div>
                            <div class = "col-xs-3">
                            <input name="lastnameC" type="submit" class="form-control btn btn-primary btnln" value="Изменить">
                            </div>
                        </div>
                    </div>
                </div>
            <div class="clearfix"></div>

            <div class="col-xs-offset-3 col-xs-6">
                    <div class="row">
                        <div class="form-group">
                            <label class="control-label col-xs-3" for="firstname">Имя:</label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control firstname change" name="firstname" value = "'.$row_patient['Firstname'].'">
                            </div>
                            <div class = "col-xs-3">
                            <input name="firtsnameC" type="submit" class="form-control btn btn-primary btnfn" value="Изменить">
                            </div>
                        </div>
                    </div>
                </div>
            <div class="clearfix"></div>

            <div class="col-xs-offset-3 col-xs-6">
                    <div class="row">
                        <div class="form-group">
                            <label class="control-label col-xs-3" for="fathername">Отчество:</label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control fathername change" name="fathername" value = "'.$row_patient['Fathername'].'">
                            </div>
                            <div class = "col-xs-3">
                            <input name="fathernameC" type="submit" class="form-control btn btn-primary btnftn" value="Изменить">
                            </div>
                        </div>
                    </div>
                </div>
            <div class="clearfix"></div>

            <div class="col-xs-offset-3 col-xs-6">
                    <div class="row">
                        <div class="form-group">
                            <label class="control-label col-xs-3" for="birthday" >Дата рождения:</label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control birthday change" name="birthday" value = "'.$row_patient['Birthday'].'">
                            </div>
                        </div>
                    </div>
                </div>
            <div class="clearfix"></div>

            <div class="col-xs-offset-3 col-xs-6">
                    <div class="row">
                        <div class="form-group">
                            <label class="control-label col-xs-3" for="address">Адрес:</label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control address change" name="address" value = "'.$row_patient['Address'].'">
                            </div>
                            <div class = "col-xs-3">
                            <input name="addressC" type="submit" class="form-control btn btn-primary btna" value="Изменить">
                            </div>
                        </div>
                    </div>
                </div>
            <div class="clearfix"></div>

            <div class="col-xs-offset-3 col-xs-6">
                    <div class="row">
                        <div class="form-group">
                            <label class="control-label col-xs-3" for="phone">Телефон:</label>
                            <div class="col-xs-6">
                                <input type="tel" class="form-control phone change" name="phone" value = "'.$row_patient['Phone'].'">
                            </div>
                            <div class = "col-xs-3">
                            <input name="phoneC" type="submit" class="form-control btn btn-primary btnp" value="Изменить">
                            </div>
                        </div>
                    </div>
                </div>
            <div class="clearfix"></div>
            '

            ?>
          </div>
          <div id="panel2" class="tab-pane fade">
            <?php
             while ($row_order = mysqli_fetch_assoc($result_order)) {
                $query_ListMS = "SELECT Medtest.Name_medtest, Medtest.Price_medtest FROM
                                 Medtest, List_medtests_in_order WHERE 
                                 Medtest.ID_Medtest = List_medtests_in_order.ID_Medtest AND 
                                 List_medtests_in_order.ID_Order = ".$row_order['ID_Order']." ";
                $result_ListMS = mysqli_query($link, $query_ListMS);
                $idOrder = intval($row_order['ID_Order']);

                echo
                "<h3>Номер заказа: $idOrder</h3>";
                echo '<p>Дата оформления: '.$row_order['Date_order'].'</p>';

                echo '<h4>Анализы заказа</h4>';
                while ($row_ListMS = mysqli_fetch_assoc($result_ListMS)) {
                    echo '<p>'.$row_ListMS['Name_medtest'].': '.$row_ListMS['Price_medtest'].' руб.</p>';
                }
                echo '<p>Общая сумма '.$row_order['Price_order'].' руб.</p>';
             }
            ?>
          </div>
        </div>
    </div>
</body>
</html>