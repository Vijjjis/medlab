<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <script type="text/javascript" src="lib/jquery-3.3.1.min.js"></script>

    <link rel="stylesheet" href="lib/bootstrap.min.css" />
    <link rel="stylesheet" href="lib/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="lib/flickity.min.css">
	<link rel="stylesheet" href="css/index.css" />

    <script type="text/javascript" src="lib/bootstrap.min.js"></script>
    <script type="text/javascript" src="lib/bootstrap-dropdown.js"></script>
	<script type="text/javascript" src="lib/flickity.pkgd.min.js"></script>
	<script type="text/javascript" src="js/index.js"></script>

</head>
<body>
	<div class="container">
		<div>Hello</div>
    	<nav class="navbar navbar-default">
        	<div class="container-fluid">

            	<div class="navbar-header">
                	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-main">
                    	<span class="icon-bar"></span>
                    	<span class="icon-bar"></span>
                    	<span class="icon-bar"></span>
                	</button>
                	<a class="navbar-brand" href="#"><img src="images/logo.png"></a>
            	</div>

            	<div class="collapse navbar-collapse" id="navbar-main">
                	<ul class="nav navbar-nav">
                    	<li><a class="ss" href="php/medtestprice.php">Анализы и цены</a></li>

				    
				    <?php
					    include('php/lib/connect.php');

					    if (empty($_COOKIE))
					    {
					 
					    	echo "</ul>";
                			echo "<ul class=\"nav navbar-nav navbar-right\">";
					    	echo "<li><a title=\"Вход для сотрудников\" class=\"service\" href=\"php/aut/login_service.php\"> </a></li>";
					    	echo "<li><a title=\"Регистрация\" class=\"register\" href=\"php/aut/register.php\"> </a></li>";
        					echo "<li><a title=\"Вход для пациентов\" class=\"patient\" href=\"php/aut/login.php\"> </a></li>";
        					echo "</ul></div></div></nav>";
        					echo "<div class=\"main-carousel\">
  									<div class=\"carousel-cell\"><img class=\"img-carousel\" src=\"images/1.jpg\"></div>
  									<div class=\"carousel-cell\"><img class=\"img-carousel\" src=\"images/2.jpg\"></div>
  									<div class=\"carousel-cell\"><img class=\"img-carousel\" src=\"images/3.jpg\"></div>
								  </div>;";
					    }

	    				else if (isset($_COOKIE['patient_id']) and isset($_COOKIE['patient_hash'])) 
	    				{

	        				$query = "SELECT * FROM Patient WHERE ID_Patient = '".intval($_COOKIE['patient_id'])."' LIMIT 1";
	        				if ($result = mysqli_query($link, $query));
	        					$userdata = mysqli_fetch_assoc($result);

	        				echo "<li><a href=\"#myModal\" data-toggle=\"modal\">Получить результаты</a></li>";
	        				echo "<li><a id = \"s\" href=\"php/patient/private_office.php\">Личный кабинет</a></li>";
	        				echo "</ul>";
                			echo "<ul class=\"nav navbar-nav navbar-right\">";
                			echo "<li><a href=\"php/patient/private_office.php\"> ".$userdata['E_mail']."</a></li>";
	        				echo "<li><a href=\"php/aut/logout.php\"><span class=\"glyphicon glyphicon-user\"></span> Выход</a></li>";
	        				echo "</ul></div></div></nav>";

	        				echo "<div class=\"main-carousel\">
  									<div class=\"carousel-cell\"><img class=\"img-carousel\" src=\"images/1.jpg\"></div>
  									<div class=\"carousel-cell\"><img class=\"img-carousel\" src=\"images/2.jpg\"></div>
  									<div class=\"carousel-cell\"><img class=\"img-carousel\" src=\"images/3.jpg\"></div>
								  </div>;";

							echo 
							"<div id=\"myModal\" class=\"modal fade\">
							  <div class=\"modal-dialog\">
							    <div class=\"modal-content\">

							      <div class=\"modal-header\">
							        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>
							        <h4 class=\"modal-title\">Получить результаты анализов</h4>
							      </div>

							      <form class=\"form-horizontal\" method=\"POST\" action = \"php/patient/get_result.php\">

								      <div class=\"modal-body\">
									    <div class=\"form-group\">
									        <label class=\"control-label col-xs-3\" for=\"orderID\">Номер заказа:</label>
									        <div class=\"col-xs-6\">
									          <input type=\"text\" class=\"form-control\" name=\"orderID\" placeholder=\"Введите номер заказа\">
									        </div>
									    </div>
								      </div>

								      <div class=\"modal-footer\">
								        <button type=\"submit\" name = \"submit\" class=\"btn btn-primary\">Получить результаты</button>
								      </div>

								  </form>
							    </div>
							  </div>
							</div>";
	   					}

					    else if (isset($_COOKIE['service_id']) and isset($_COOKIE['service_hash']))
					    {

					        $query = "SELECT service_status FROM Service WHERE service_id = '".intval($_COOKIE['service_id'])."' LIMIT 1";
					        if ($result = mysqli_query($link, $query))
					        	$userdata = mysqli_fetch_assoc($result);

					        if ($userdata['service_status'] == 3)
					        {
					        	echo "<li class \"s\"><a href=\"php/operator/order.php\">Оформить заказ</a></li>";
					        	echo "<li><a href=\"php/operator/medtestcontrol/mc.php\">Управление исследованиями</a></li>";
					        	echo "</ul>";
                				echo "<ul class=\"nav navbar-nav navbar-right\">";
                				echo "<li><a href=\"php/aut/logout.php\"><span class=\"glyphicon glyphicon-user\"></span> Выход</a></li>";
                				echo "</ul></div></div></nav>";
					        }

					        if ($userdata['service_status'] == 13)
					        {

					        	echo "<li><a href=\"php/laborant/add_result.php\">Добавить результаты</a></li>";
					        	echo "<li><a href=\"php/laborant/add_specimen.php\">Добавить пробы</a></li>";
					        	echo "</ul>";
                				echo "<ul class=\"nav navbar-nav navbar-right\">";
                				echo "<li><a href=\"php/aut/logout.php\"><span class=\"glyphicon glyphicon-user\"></span> Выход</a></li>";
                				echo "</ul></div></div></nav>";

					        }

	    				}
    				?>
	</div>
</body>
</html>