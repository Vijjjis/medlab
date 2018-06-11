<?php
// Страница авторизации



# Функция для генерации случайной строки

function generateCode($length=6) {

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";

    $code = "";

    $clen = strlen($chars) - 1;  
    while (strlen($code) < $length) {

         $code .= $chars[mt_rand(0,$clen)];  
    }

    return $code;

}



# Соединямся с БД
include($_SERVER['DOCUMENT_ROOT'].'/php/lib/connect.php');

if(isset($_POST['submit']))

{

    if(empty($_POST['inputEmail']) or empty($_POST['inputPassword']))        
    {
        print "Pusto"; 
    }

    else
    {

        # Вытаскиваем из БД запись, у которой логин равняется введенному
        $query = "SELECT ID_Patient, Password FROM Patient WHERE E_mail ='".mysqli_real_escape_string($link, $_POST['inputEmail'])."' LIMIT 1";
        if ($result = mysqli_query($link, $query))
            $data = mysqli_fetch_assoc($result);

        # Сравниваем пароли
        if($data['Password'] === md5(md5($_POST['inputPassword'])))

        {

            # Генерируем случайное число и шифруем его
            $hash = md5(generateCode(10));

            # Записываем в БД новый хеш авторизации
            mysqli_query($link, "UPDATE Patient SET Hash='".$hash."' WHERE ID_Patient='".$data['ID_Patient']."'");

            # Ставим куки
            setcookie("patient_id", $data['ID_Patient'], time()+60*60*24*30,'/');
            setcookie("patient_hash", $hash, time()+60*60*24*30, '/');

            # Переадресовываем браузер на страницу проверки нашего скрипта
            header("Location: check.php"); exit();

        }

        else
        {
            print "Вы ввели неправильный Email/пароль";
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
    <div class="container-fluid ">

        <form class="form-horizontal" method="POST">
            <h2 align="center">vhod</h2>

            <div class="row">

                <div class="col-xs-offset-3 col-xs-6">
                    <div class="row">
                        <div class="form-group">
                            <label class="control-label col-xs-3" for="inputEmail">Email:</label>
                            <div class="col-xs-6">
                                <input type="email" class="form-control" name="inputEmail" placeholder="Email">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="col-xs-offset-3 col-xs-6">
                    <div class="row">
                        <div class="form-group">
                            <label class="control-label col-xs-3" for="inputPassword">Пароль:</label>
                            <div class="col-xs-6">
                                <input type="password" class="form-control" name="inputPassword" placeholder="Введите пароль">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="col-xs-offset-3 col-xs-6">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-xs-offset-3 col-xs-6">
                                <input name="submit" type="submit" class="form-control btn btn-primary" value="Вход">
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="clearfix"></div>
                <p class="text-center"><a href="register.php">Регистрация</a></p>
            </div>

        </form>

    </div>
</body>
</html>