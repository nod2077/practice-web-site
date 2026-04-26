<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="style.css">
	<title></title>
</head>
<body>
	<?php
	echo '<p class="title">Список пользователей';
		$users = [
			["name" => "Виктор", "age" => 18, "email" => "viktor@gmail.com", "city" => "Стерлитамак"],
			["name" => "Андрей", "age" => 22, "email" => "andrey-ufa@mail.ru", "city" => "Уфа"],
			["name" => "Сергей", "age" => 21, "email" => "sergey05@gmail.com", "city" => "Санкт-Петербург"],
			["name" => "Антон", "age" => 17, "email" => "anton349@mail.yandex.ru", "city" => "Новосибирск"],
			["name" => "Вильдан", "age" => 17, "email" => "vildan@gmail.com", "city" => "Стерлитамак"],
		];
		foreach($users as $user) {
			echo '<div class="user-card">' . 
            '<p class="bold-text">' . $user['name'] . ', ' . $user['age'] . '</p>' .
            '<p>Email: <a href="mailto:' . $user['email'] . '">' . $user['email'] . '</a></p>' .
            '<p>Город: ' . $user['city'] . '</p>' .
         '</div>';
		}
	?>
</body>
</html>