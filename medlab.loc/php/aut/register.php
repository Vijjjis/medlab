<?php

// Страница регситрации нового пользователя


# Соединямся с БД
include($_SERVER['DOCUMENT_ROOT'].'/php/lib/connect.php');

if(isset($_POST['submit']))

{

    $err = array();

    # проверям ФИО
    if(strlen($_POST['lastName']) < 2)
    {
        $err[] = "Фамилия должна быть не менее 2-х символом";
    }

    if(strlen($_POST['firstName']) < 2)
    {
        $err[] = "Имя должно быть не менее 2-х символом";
    }

    if(strlen($_POST['fatherName']) > 0 and strlen($_POST['fatherName']) < 2)
    {
        $err[] = "Отчество не может быть меньше 2-х символом";
    }

    # провееряем Email
    if(!preg_match("/^((\"[^\"\f\n\r\t\v\b]+\")|([\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+(\.[\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+)*))@((\[(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))\])|(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))|((([A-Za-z0-9\-])+\.)+[A-Za-z\-]+))$/D", $_POST['inputEmail'])) 
    {       
        $err[] = "Email введён неверно";
    }

    # проверяем пароль
    if(strlen($_POST['inputPassword']) < 8) 
    {
        $err[] = "Пароль не должен быть меньше 8 символов";
    }

    if($_POST['inputPassword'] != $_POST['confirmPassword'])
    {
      $err[] = "Пароли не совпадают";
    }

    # Проверяем, нет ли пользователя с таким E-mail

    $query = "SELECT COUNT(ID_Patient) as count FROM Patient WHERE E_mail='".mysqli_real_escape_string($link,$_POST['inputEmail'])."' ";
    if ($result = mysqli_query($link,$query)) {
        $row = mysqli_fetch_assoc($result);
        if (intval($row['count']) > 0) {
          $err[] = "Пользователь с таким E-mail уже существует в базе данных";
        }
    }

    
    # Если нет ошибок, то добавляем в БД нового пользователя

    if(count($err) == 0)

    {

        $E_mail = $_POST['inputEmail'];

        # Убераем лишние пробелы и делаем двойное шифрование для пароля
        $password = md5(md5(trim($_POST['inputPassword'])));

        $lastName = $_POST['lastName'];
        $firstName = $_POST['firstName'];
        $fatherName = $_POST['fatherName'];
        $Gender = $_POST['genderRadios'];
        $Phone = $_POST['phoneNumber'];
        $Address = $_POST['postalAddress'];

        mysqli_query($link,"INSERT INTO Patient SET E_mail ='".$E_mail."', Password='".$password."', LastName='".$lastName."', 
                                           FirstName = '".$firstName."', FatherName = '".$fatherName."', Gender = '".$Gender."',
                                           Phone = '".$Phone."', Address = '".$Address."'");

        header("Location: login.php"); exit();

    }

    else

    {
        echo "<b>При регистрации произошли следующие ошибки:</b><br>";

        foreach($err AS $error)

        {

            print $error."<br>";

        }
    }

}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content=" nameth=device-nameth, initial-scale=1, shrink-to-fit=no" />
    <script type="text/javascript" src="../../lib/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="../../lib/bootstrap.min.css" />
    <link rel="stylesheet" href="../../lib/datepicker.css" />
    <link rel="stylesheet" href="../../css/aut/aut.css" />
    <script type="text/javascript" src="../../lib/jquery.maskedinput.js"></script>
    <script type="text/javascript" src="../../lib/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="../../lib/bootstrap-datepicker.ru.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
          $(".phone").mask("+7(999)999-99-99");
          $(".birthday").datepicker({
            format: 'yyyy-mm-dd',
            language: 'ru'
          });
        });
      </script>
</head>
<body>
    <div class="container-fluid name">
      <h2 align="center">Регистрация</h2>
    <form class="form-horizontal" method="POST">
      <div class="form-group">
        <label class="control-label col-xs-3 required" for="lastName">Фамилия:</label>
        <div class="col-xs-6">
          <input type="text" class="form-control" name="lastName" placeholder="Введите фамилию">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-xs-3 required" for="firstName">Имя:</label>
        <div class="col-xs-6">
          <input type="text" class="form-control" name="firstName" placeholder="Введите имя">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-xs-3" for="fatherName">Отчество:</label>
        <div class="col-xs-6">
          <input type="text" class="form-control" name="fatherName" placeholder="Введите отчество">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-xs-3 required" for="inputEmail">E-mail:</label>
        <div class="col-xs-6">
          <input type="email" class="form-control" name="inputEmail" placeholder="E-mail">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-xs-3 required" for="inputPassword">Пароль:</label>
        <div class="col-xs-6">
          <input type="password" class="form-control" name="inputPassword" placeholder="Введите пароль">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-xs-3 required" for="confirmPassword">Подтвердите пароль:</label>
        <div class="col-xs-6">
          <input type="password" class="form-control" name="confirmPassword" placeholder="Введите пароль ещё раз">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-xs-3" for="inputBirthday">Дата рождения:</label>
        <div class="col-xs-6">
          <input type="text" class="form-control birthday" name="inputBirthday" placeholder="Нажмите для выбора даты">
        </div>
      </div>
      <div class="col-xs-offset-3">
        <p class="s">Для корректного добавления номера телефона необходимо ввести его полностью</p>
      </div>
      <div class="form-group">
        <label class="control-label col-xs-3" for="phoneNumber">Телефон:</label>
        <div class="col-xs-6">
          <input type="tel" class="form-control phone" name="phoneNumber" placeholder="Введите номер телефона">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-xs-3" for="postalAddress">Адрес:</label>
        <div class="col-xs-6">
          <textarea rows="3" class="form-control" name="postalAddress" placeholder="Введите адрес"></textarea>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-xs-3 required">Пол:</label>
        <div class="col-xs-3">
          <label class="radio-inline">
            <input type="radio" name="genderRadios" value="Мужской"> Мужской
          </label>
        </div>
        <div class="col-xs-3">
          <label class="radio-inline">
            <input type="radio" name="genderRadios" value="Женский"> Женский
          </label>
        </div>
      </div>
      <br />
      <div class="form-group">
        <div class="col-xs-offset-3 col-xs-6">
          <input name="submit" type="submit" class="btn btn-primary" value="Регистрация">
          <input type="reset" class="btn btn-default" value="Очистить форму">
        </div>
      </div>
    </form>
</body>
</html>