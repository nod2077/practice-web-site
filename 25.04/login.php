<?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbbase = 'practice_web-site';

    $link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbbase);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "SELECT * FROM `users` WHERE BINARY username = '$username' OR BINARY email = '$username'";
        $result = mysqli_query($link, $query);

        $message = '';
        if (empty($username) || empty($password)) {
            $message = 'Пожалуйста, заполните все поля!';
        } else if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            $dbpassword = $user['password'];
            if (password_verify($password, $dbpassword) == true) {
                    header('Location: profile.php');
                    $message = 'Успешная авторизация!';
                    session_start();
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['user'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                } else {
                    $message = 'Неверный пароль.';
                }
            } else {
                $message = 'Неверный логин/электронная почта или пароль.';
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
        <a href="register.php">Регистрация</a>
        <h3>Авторизация пользователя</h3>
        <div class="card">
            <form action="" method="POST">
                <div class="form-decoration">
                    <label>Логин или email:</label>
                    <input class="input-text" name="username" type="text" minlength="1" maxlength="100">
                </div>
                <div class="form-decoration">
                    <label>Пароль:</label>
                    <input class="" name="password" type="text" minlength="8" maxlength="255">
                </div>
                <input type="submit">
            </form>
        </div>
        <?php if(!empty($message)): ?>
            <p class="card"><?php echo $message; ?></p>
        <?php endif; ?>
    </body>
</html>