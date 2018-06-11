<!DOCTYPE html>
<html>
<head>
	<title>Оформление заказа</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <script type="text/javascript" src="../../lib/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="../../lib/bootstrap.min.css" />
    <link rel="stylesheet" href="../../lib/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="../../lib/bootstrap-select.min.css" />
    <link rel="stylesheet" href="../../css/laborant/laborant.css" />

    <script type="text/javascript" src="../../lib/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../lib/bootstrap-dropdown.js"></script>
    <script type="text/javascript" src="../../lib/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="../../js/laborant/ajax_add_result.js"></script>
    <script type="text/javascript" src="../../lib/defaults-ru_RU.js"></script>
</head>
<body>
    <div class="container-fluid">

        <h1 align="center">Добавить результат</h1>

        <form method="POST" action="complete_result.php">
            <h2 align="center">ФИО клиента</h2>
            <div class="row">
                <div class="col-xs-offset-4 col-xs-4">
                    <div class="form-group">
                        <select class="selectpicker selectpicker_patient form-control" name="patient" title="Выберите пациента" data-live-search="true" data-size="7">
                            <?php  
                                include($_SERVER['DOCUMENT_ROOT'].'/php/lib/connect.php');

                                $query = "SELECT * FROM Patient ORDER BY Lastname ASC";
                                if ($result = mysqli_query($link,$query)) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                         echo '<option value= '.$row['ID_Patient'].'>'
                                              .$row['Lastname'].' '.$row['Firstname'].' '.$row['Fathername'].'
                                              </option>';
                                    }
                                    mysqli_free_result($result);
                                }
                                mysqli_close($link);
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <h2 align="center">Заказы клиента</h2>
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10">
                    <div class="form-group">
                        <select class="selectpicker selectpicker_order_id form-control" name="order" title="Пациент не выбран" data-live-search="true" data-size="7" disabled="true">
                        </select>
                    </div>
                </div>
            </div>

            <h2 align="center">Анализы заказа по пробам</h2>
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10">
                    <div class="form-group">
                        <select class="selectpicker selectpicker_medtest_of_specimen form-control" name="medtest" title="Заказ не выбран" data-live-search="true" data-size="7" disabled="true">
                        </select>
                    </div>
                </div>
            </div>
            
            <h2 align="center" class="H1_Indicators">Показатели анализа</h2>

            <input type="hidden" class="specimen" name="specimen" value="">
            <input type="hidden" class="arr_id_ind" name="str_id_ind" value="">
             <input type="hidden" class="result_date" name="result_date" value="">
            
            <div class="row indicators">
            </div>

            <div class="form-group">
                <input name="submit" type="submit" class="btn btn-primary form-control result-button" value="Добавить результат">
            </div>   

        </form>
    </div>
</body>
</html>