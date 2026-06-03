<?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbbase = 'practice_site';

    $link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbbase);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $query = "SELECT * FROM `users` WHERE username = '$username'";
        $insert = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        $result = mysqli_query($link, $query);
        if (empty($username) || empty($email) || empty($password)) {
            echo 'Пожалуйста, заполните все поля!';
        } else if (mysqli_num_rows($result) > 0) {
            echo 'Данный логин уже занят.';
        } else {
            mysqli_query($link, $insert);
            echo 'Успешная регистрация!';
            header('Refresh: 5 login.php');
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
            <a href="login.php">Авторизация</a>
            <h3>Регистрация пользователя</h3>
            <form action="" method="POST">
                <label>Логин:<input name="username" type="text" minlength="1" maxlength="50"></label>
                <label>Электронная почта:<input name="email" type="text" minlength="7" maxlength="100"></label>
                <label>Пароль:<input name="password" type="text" minlength="8" maxlength="255"></label>
                <input type="submit">
            </form>
        </div>
    </body>
</html>