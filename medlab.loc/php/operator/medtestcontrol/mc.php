<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <script type="text/javascript" src="../../../lib/jquery-3.3.1.min.js"></script>

    <link rel="stylesheet" href="../../../lib/bootstrap.min.css" />
    <link rel="stylesheet" href="../../../lib/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="../../../lib/bootstrap-select.min.css" />

    <script type="text/javascript" src="../../../lib/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../../lib/bootstrap-dropdown.js"></script>
    <script type="text/javascript" src="../../../lib/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="../../../js/operator/ajax.js"></script>

</head>
<body>
  <div class="container-fluid">
    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#change_delete-Medtest">Изменить/Удалить анализ</a></li>
      <li><a data-toggle="tab" href="#addmedtest">Добавить исследование</a></li>
    </ul>

    <div class="col-xs-12" style="padding-top: 10px;">
      <a href="http://medlab.loc/"><button type="button" class="btn btn-success btn-lg btn-block">Перейти на главную</button></a>
    </div>

    <div class="tab-content">
      <div id="change_delete-Medtest" class="tab-pane fade in active">
        <div class="row table-medtest">
          <table id="m" class="table table-bordered">
            <thead class="thead-medtest">
              <h1 align="center">Добавить анализ</h1>
              <tr>
                <th>Название анализа</th>
                <th>Цена (в руб.)</th>
                <th>Тип биоматериала</th>
              </tr>
            </thead>
              <?php
                include($_SERVER['DOCUMENT_ROOT'].'/php/lib/connect.php');

                $query = mysqli_query($link, "SELECT * FROM MedTest WHERE isdelete = 0");

                while( $row = mysqli_fetch_assoc($query) )
                {
                  echo 
                  '
                  <form method="POST" action="change_medtest.php">
                    <tbody>
                      <tr>  
                          <td>
                            <input type="text" class="form-control input-medtest" name="name" value = "'.$row['Name_medtest'].'">
                          </td>
                           
                          <td>
                            <input type="text" class="form-control input-medtest" name="price" value = "'.$row['Price_medtest'].'">
                          </td>
                          
                          <td>
                            <input type="text" class="form-control input-medtest" name="typebio" value = "'.$row['Type_biomaterial'].'">
                          </td>
                           
                          <td>
                            <input type="submit" class="form-control" name="submit" value = "Изменить">
                          </td>

                          <td>
                            <input type="submit" class="form-control" name="delete" value = "Удалить">
                          </td>
                      </tr>
                      <input type="hidden" name="id_medtest" value = "'.$row['ID_Medtest'].'"
                    </tbody>
                    </form>
                   ';
                } 
              ?>
          </table>
        </div>
      </div>
      <div id="addmedtest" class="tab-pane fade">
        <div class="row table-add">
          <table class="table table-bordered">
            <thead class="thead-add">
              <h1 align="center">Анализы и цены</h1>
              <tr>
                <th>Название анализа</th>
                <th>Цена (в руб.)</th>
                <th>Тип биоматериала</th>
              </tr>
            </thead>
            <form method="POST" action="change_medtest.php">
              <tbody>
                <tr>
                  
                  <td>
                    <input type="text" class="form-control input-medtest" name="name" value = "">
                  </td>
                   
                  <td>
                    <input type="text" class="form-control input-medtest" name="price" value = "">
                  </td>
                  
                  <td>
                    <input type="text" class="form-control input-medtest" name="typebio" value = "">
                  </td>

                  <td>
                    <input type="submit" class="form-control" name="add" value = "Добавить">
                  </td>

                </tr>
              </tbody>
            </form>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>