<?php

	if (!empty($_FILES) && isset($_FILES['filetest']) && $_FILES['filetest']['error'] === 0) {

		$arrFiles = scandir('tests');
		$nextnum = count($arrFiles) - 1;

		if ($_FILES['filetest']['type'] === 'application/json') {

			move_uploaded_file($_FILES['filetest']['tmp_name'], __DIR__ . '/tests/' . $nextnum . '.json');
			echo 'Был загружен файл с тестом ' . $_FILES['filetest']['name'];

		}
		else {

			echo 'Был выбран неправильный формат файла';

		}

	}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<title>загрузка тестового файла</title>
	<meta charset="utf-8">
</head>
<body>
	<form action="admin.php" method="POST" enctype="multipart/form-data">
		<div>
			Файл
		</div>
		<div>
			<input type="file" name="filetest">
		</div>
		<input type="submit" name="load" value="Загрузить">
	</form>
	<a href="list.php">Список тестов</a>
</body>
</html>

