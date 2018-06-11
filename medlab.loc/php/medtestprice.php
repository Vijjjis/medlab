<!DOCTYPE html>
<html>
<head>
	<title>Список анализов и их стоимость</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <script src="../lib/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="../lib/bootstrap.min.css" />
    <link rel="stylesheet" href="../lib/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="../css/medtestprice.css" />
    <script src="../lib/bootstrap.min.js"></script>
    <script type="text/javascript" src="../lib/bootstrap-dropdown.js"></script>
</head>
<body>
  <div class="container-fluid">
  	<table class="table table-bordered">
    		<thead class="thead-medtest">
          <h1 align="center">Анализы и цены</h1>
      		<tr>
        			<th>Название анализа</th>
        			<th>Цена</th>
      		</tr>
    		</thead>
    		<tbody>
          <?php
            include($_SERVER['DOCUMENT_ROOT'].'/php/lib/connect.php');

            $query = mysqli_query($link, "SELECT * FROM MedTest");

            while( $row = mysqli_fetch_assoc($query) )
            {
              echo "<tr>";
                  echo "<td>".$row['Name_medtest']."</td>";
                  echo "<td class = \"price\">".$row['Price_medtest']." р."."</td>";
              echo "</tr>";
            } 
          ?>
        </tbody>
    </table>
    <div class="col-xs-12">
      <a href="http://medlab.loc/"><button type="button" class="btn btn-success btn-lg btn-block">Перейти на главную</button></a>
    </div>
  </div>
</body>
</html>