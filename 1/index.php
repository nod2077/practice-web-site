<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css">
	<title>Веб-калькулятор</title>
	<meta charset="utf-8">
	<title></title>
</head>
<body>	
	<?php
		echo '<div>
				<textarea></textarea>
				<label>Выберите операцию</label>
				<select id="calc" name="calc_list">
					<option value="plus">+</option>
					<option value="minus">-</option>
					<option value="multiplication">*</option>
					<option value="divide">/</option>
					<option value="POS">%</option>
					<option value="exponentiation">^</option>
				</select>
				<form action="/button-action">
					<button type="submit" formation="/button-action">Вычислить</button>
				</form>
			</div>';
		$_POST['variable']
		?>
</body>
</html>