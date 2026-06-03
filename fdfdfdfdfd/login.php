<?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbbase = 'practice_site';

    $link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbbase);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "SELECT * FROM `users` WHERE username ='$username' OR email = '$username'";
        $result = mysqli_query($link, $query);
        if (empty($username) || empty($password)) {
            echo 'Пожалуйста, заполните все поля!';
        } else if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            $dbpassword = $user['password'];
            if (password_verify($password, $dbpassword) == true) {
                header('Refresh: 2 profile.php');
                echo 'Успешная авторизация!';
            } else {
                echo 'Неверный пароль.';
            }
        }
         else {
            echo 'Неверный логин/электронная почта или пароль.';
        }
    }
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>Регистрация</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div id="register-theme">
            <a href="register.php">Регистрация</a>
            <h3>Авторизация пользователя</h3>
            <form action="" method="POST">
                <label>Логин или email:<input name="username" type="text" minlength="1" maxlength="100"></label>
                <label>Пароль:<input name="password" type="text" minlength="8" maxlength="255"></label>
                <input type="submit">
            </form>
        </div>
    </body>
</html>