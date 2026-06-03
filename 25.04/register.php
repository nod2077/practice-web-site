<?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbbase = 'practice_web-site';

    $link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbbase);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        $query = "SELECT * FROM `users` WHERE username = '$username'";
        $insert = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password_hashed')";
        $result = mysqli_query($link, $query);

        $message = '';
        if (empty($username) || empty($email) || empty($password)) {
            $message = 'Пожалуйста, заполните все поля!';
        } else if (mysqli_num_rows($result) > 0) {
            $message = 'Данный логин уже занят.';
        } else {
            mysqli_query($link, $insert);
            $message = 'Вы зарегистрированы. Переход будет выполнен через 3 секунды..';
            header('Refresh: 3 login.php');
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
        <a href="login.php">Авторизация</a>
        <h3>Регистрация пользователя</h3>
        <div class="card">
            <form action="" method="POST">
                <div class="form-decoration">
                    <label>Логин:</label>
                    <input name="username" type="text" minlength="1" maxlength="50">
                </div>
                <div class="form-decoration">
                    <label>Электронная почта:</label>
                    <input name="email" type="text" minlength="7" maxlength="100">
                </div>
                <div class="form-decoration">
                    <label>Пароль:</label>
                    <input name="password" type="text" minlength="8" maxlength="255">
                </div>
                <input type="submit">
            </form>
            <?php if(!empty($message)): ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>
        </div>
    </body>
</html>