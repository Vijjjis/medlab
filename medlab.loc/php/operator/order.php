<!DOCTYPE html>
<html>
<head>
	<title>Оформление заказа</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <script type="text/javascript" src="../../lib/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="../../lib/bootstrap.min.css" />
    <link rel="stylesheet" href="../../lib/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="../../lib/bootstrap-select.min.css" />
    <link rel="stylesheet" href="../../css/operator/order.css" />

    <script type="text/javascript" src="../../lib/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../lib/bootstrap-dropdown.js"></script>
    <script type="text/javascript" src="../../lib/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="../../js/operator/ajax_patient_to_analysis.js"></script>
    <script type="text/javascript" src="../../lib/defaults-ru_RU.js"></script>
</head>
<body>
    <div class="container-fluid">

        <h1 align="center">Оформление заказа</h1>

        <form method="POST" action="reg_pat.html">
            <input type="hidden" name="order" value="">
            <div class="row">
                <div class="col-xs-offset-4 col-xs-4">
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary form-control" name="submit" value="Зарегистрировать пациента">
                    </div>
                </div>
            </div>
        </form>

        <form method="POST" action="complete_order.php">
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

            <h2 align="center">Список анализов</h2>
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10">
                    <div class="form-group">
                        <select class="selectpicker selectpicker_analysis form-control" name="analysis[]" multiple title="Пациент не выбран" data-live-search="true" data-size="7" disabled="true" data-actions-box="true">
                        </select>
                    </div>
                </div>
            </div>

            <input type="hidden" class="sum_price" name="sum_price" value="">
            <input type="hidden" class="medtest_id" name="medtest_id" value="">
            <input type="hidden" class="medtest_name" name="medtest_name" value="">
            <input type="hidden" class="order_date" name="order_date" value="">

            <div class="form-group">
                <input name="submit" type="submit" class="btn btn-primary form-control order-button" value="Выберите пациента и анализы" disabled="true">
            </div> 
            
        </form>

    </div>
</body>
</html>