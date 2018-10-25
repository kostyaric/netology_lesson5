<?php

	$result_string = '';

	if (!empty($_GET)) {
		if (array_key_exists('ID', $_GET)) {

			$testnum = filter_input(INPUT_GET, 'ID', FILTER_VALIDATE_INT);
			if ($testnum === false) {
				echo 'Передан неправильный номер теста';
			}
			else {
				
				$jstring = file_get_contents(__DIR__ . '/tests/' . $testnum . '.json');
				$jdata = json_decode($jstring, true);
				$testname = $jdata['testname'];
				$questionset = $jdata['questionset'];

				$field_string = '';
				foreach ($questionset as $i => $single_question) {

					$question_num = $i + 1;
					$question = $single_question['question'];
					$answers = $single_question['answers'];

					$answer_string = '';
					foreach ($answers as $choise) {
						
						$choise = $choise[0];
						$answer_string .= '
						<label><input type="radio" name="choise' . $i . '" value="' . $choise . '">' . $choise . '</label>';
					}

					$field_string .= "
					<fieldset>
					    <legend>Вопрос № $question_num. $question</legend>" .
						    $answer_string .
					'</fieldset>';

				}
			}
		}
	}
	if (!empty($_POST)) {
		
		foreach ($questionset as $i => $single_question) {
			
			$answer_num = $i + 1;
			
			if (array_key_exists('choise' . $i, $_POST)) {

				$user_answer = $_POST['choise' . $i];
				
				$answers = $single_question['answers'];				
				foreach ($answers as $file_answer) {
					
					$value = $file_answer[0];

					if ($user_answer == $value) {
						$true_value = $file_answer[1];
					}
				}

				$result_string .= '<p>Ваш ответ на вопрос № ' . $answer_num . ': ' . $user_answer . '. Это ' . ($true_value ? 'Правильный' : 'Ошибочный') . ' ответ </p>';
			}
			else {
				
				$result_string .= '<p>Вы не ответили на вопрос №' . $answer_num . '</p>';

			}

		}
	}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<title>Тест</title>
	<meta charset="utf-8">
</head>
<body>
	<h1><?php echo $testname?></h1>
	<form action="" method="POST">
		<?php
		echo '<input type="hidden" name="ID" value="' . $testnum . '">';
		echo $field_string;
		?>
		<input type="submit" name="send">
	</form>
	<?php echo $result_string; ?>
</body>
</html>

