<?php
	function generateCode($length=6) {

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";

    $code = "";

    $clen = strlen($chars) - 1;  
    while (strlen($code) < $length) {

         $code .= $chars[mt_rand(0,$clen)];  
    }

    return $code;

}

include($_SERVER['DOCUMENT_ROOT'].'/php/lib/connect.php');

if(isset($_POST['submit'])) 
{

	if(empty($_POST['inputLogin']) or empty($_POST['inputPassword']))
	{
		print 'Заполните все поля';
	}

	else
	{
		$query = "SELECT service_id, service_password FROM Service WHERE service_login = '".mysqli_real_escape_string($link, $_POST['inputLogin'])."' LIMIT 1";
		if ($result = mysqli_query($link, $query))
            $data = mysqli_fetch_assoc($result);

		if($data['service_password'] === md5(md5($_POST['inputPassword'])))

        {

            # Генерируем случайное число и шифруем его
            $hash = md5(generateCode(10));

            # Записываем в БД новый хеш авторизации
            mysqli_query($link,"UPDATE Service SET service_hash='".$hash."' WHERE service_id='".$data['service_id']."'");

            # Ставим куки
            setcookie("service_id", $data['service_id'], time()+60*60*24*30,'/');
            setcookie("service_hash", $hash, time()+60*60*24*30, '/');

            # Переадресовываем браузер на страницу проверки нашего скрипта
            header("Location: http://medlab.loc/"); exit();

        }

        else
        {
            print "Вы ввели неправильный логин/пароль";
        }

	}
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content=" nameth=device-nameth, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="../../lib/bootstrap.min.css" />
    <link rel="stylesheet" href="css/aut/aut.css" />
</head>
<body>
    <div class="container-fluid name">
      <h2 align="center">Вход для сотрудников</h2>

    <form class="form-horizontal" method="POST">

        <div class="form-group">
            <label class="control-label col-xs-3" for="inputLogin">Логин:</label>
            <div class="col-xs-6 text-center">
                <input type="login" class="form-control" name="inputLogin" placeholder="Введите логин">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-3" for="inputPassword">Пароль:</label>
            <div class="col-xs-6">
                <input type="password" class="form-control" name="inputPassword" placeholder="Введите пароль">
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-offset-3 col-xs-6">
                <input name="submit" type="submit" class="btn btn-primary" value="Вход">
            </div>
        </div> 

    </form>

</body>
</html>