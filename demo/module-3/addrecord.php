<?php
/*
** Скрипт возвращает последние записи в гостевой книге
*/

// Читаем данные, переданные в POST
$rawPost = file_get_contents('php://input');

// Заголовки ответа
header('Content-type: text/plain; charset=utf-8');
header('Cache-Control: no-store, no-cache');
header('Expires: ' . date('r'));

// Если данные были переданы...
if ($rawPost) {
	// Разбор пакета JSON
	$record = json_decode($rawPost);

	// Открытие БД
	$db = new SQLite3('gbook.db');

	// Подготовка данных
	$author  = $db->escapeString($record->author);
	$email   = $db->escapeString($record->email);
	$message = $db->escapeString($record->message);
	$date    = time();

	// Запрос
	$sql = "INSERT INTO gbook (author, email, message, date)
		VALUES ('$author', '$email', '$message', $date)";
	$db->query($sql);

	// Возврат результата
	echo json_encode(
		array
		(
			'result'          => 'OK',
			'lastInsertRowId' => $db->lastInsertRowID()
		)
	);
} else {
	// Данные не переданы
	echo json_encode(
		array
		(
			'result' => 'No data'
		)
	);
}
?>