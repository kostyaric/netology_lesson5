<!DOCTYPE html>
<html lang="ru">
<head>
	<title>Список файлов</title>
	<meta charset="utf-8">
</head>
<body>

<h1>Список тестов</h1>
<?php

	$arrFiles = scandir('tests');

	foreach ($arrFiles as $fullname) {

		if (substr($fullname, -5) === '.json') {

			$jstring = file_get_contents(__DIR__ . '/tests/' . $fullname);
			$jdata = json_decode($jstring, true);
			$testname = $jdata['testname'];

			$dotpos = strrpos($fullname, '.');
			$name = substr($fullname, 0, $dotpos);
			echo '<div><a href="test.php?ID=' . $name .'" target="_blank">' . $testname . '</a></div>';

		}

	}

?>

</body>
</html>
