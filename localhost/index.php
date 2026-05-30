<?php
$number1 = '';
$number2 = '';
$operation = '';
$result = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$number1 = $_POST['number1'];
    $number2 = $_POST['number2'];
	$operation = $_POST['calc_list'];

	if ($number1 === '' || $number2 === '') {
		$error = "Пожалуйста, заполните поля с числами";
	} 
	else {
		$number1 = (float)$number1;
		$number2 = (float)$number2;
		switch ($operation) {
            case '+':
                $result = $number1 + $number2;
                break;
            case '-':
                $result = $number1 - $number2;
                break;
            case '*':
                $result = $number1 * $number2;
                break;
            case '/':
                // Защита от деления на ноль
                if ($number2 == 0) {
                    $error = "Делить на ноль нельзя!";
                } else {
                    $result = $number1 / $number2;
                }
				break;
			case '%':
				$result = $number1 % $number2;
				break;
			case '^':
				$result = pow($number1, $number2);
                break;
            default:
                $error = "Неверная операция!";
        }
	}
}
?>


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css">
	<title>Веб-калькулятор</title>
	<meta charset="utf-8">
	<style>
		* {
			background-color: lightgray;
		}
		div {
			display: flex;
			border: solid black 2px;
			border-radius: 15px;
			background-color: white;
		}
	</style>
</head>
<body>	
	<div>
		<form action="" method="POST">
			<input type="number" name="number1"></input>
			<input type="number" name="number2"></input>
			<label>Выберите операцию</label>
			<select id="calc" name="calc_list">
				<option value="+">+</option>
				<option value="-">-</option>
				<option value="*">*</option>
				<option value="/">/</option>
				<option value="%">%</option>
				<option value="^">^</option>
			</select>
			<button type="submit">Посчитать</button>
		</form>
	</div>
	<?php if (!empty($error)): ?>
        <p style="color: red;"><strong>Ошибка:</strong> <?= $error ?></p>
    <?php endif; ?>

    <!-- Вывод результата -->
    <?php if ($result !== ''): ?>
        <p style="color: green; font-size: 1.2em;">
            <strong>Результат:</strong> <?= $result ?>
        </p>
    <?php endif; ?>
</body>
</html>