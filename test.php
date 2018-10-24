<?php

	if (!empty($_GET)) {
		if (array_key_exists('ID', $_GET)) {

			$testnum = filter_input(INPUT_GET, 'ID', FILTER_VALIDATE_INT);
			if ($testnum === false) {
				echo "Передан неправильный номер теста";
			}
			else {
				
				$jstring = file_get_contents(__DIR__ . '/tests/' . $testnum . '.json');
				$jdata = json_decode($jstring, true);
				$testname = $jdata['testname'];
				$answers = $jdata['answers'];
?>

				<!DOCTYPE html>
				<html lang="ru">
				<head>
					<title>Тест</title>
					<meta charset="utf-8">
				</head>
				<body>
					<form action="test.php" method="GET">
						<?php echo '<input type="hidden" name="ID" value="' . $testnum . '">'?>
						<fieldset>
						    <legend><?php echo $testname; ?></legend>
						    <?php
							foreach ($answers as $choise) {
								echo '<label><input type="radio" name="choise" value="' . $choise[0] . '">' . $choise[0] . '</label>';
								if ($choise[1]) {
									$true_answers[] = $choise[0];
								}
							}
							?>
						</fieldset>
						<input type="submit" name="send">
					</form>
					<?php
						if (array_key_exists('choise', $_GET)) {

							$your_choise = $_GET['choise'];
							echo "<p>Вы выбрали: $your_choise<p>";

							$true_choise = array_search($your_choise, $true_answers);
							if ($true_choise === false) {
								echo "<p>Вы ошиблись<p>";
							}
							else {
								echo "<p>Это правильный ответ<p>";
							}
						}

					?>
				</body>
				</html>
<?php

			}
		}
	}

?>

