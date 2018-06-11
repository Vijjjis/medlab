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

        header("Location: order.php"); exit();

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