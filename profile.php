<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="card">
            <p>Айди аккаунта: <?php echo $_SESSION['id'] ?></p>
            <p>Логин: <?php echo $_SESSION['user']; ?></p>
            <p>Электронная почта: <?php echo $_SESSION['email']; ?></p>
            <form action="logout.php"><button type="submit" name="button">Выйти</button></form>
        </div>
    </body>
</html>