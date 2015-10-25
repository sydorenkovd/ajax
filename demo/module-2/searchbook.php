<?php
/*
** Скрипт возварщает список книг указанной категории
**    cat - параметр - код категории
*/

// Передаем заголовки
header('Content-type: text/plain; charset=utf-8');
header('Cache-Control: no-store, no-cache');
header('Expires: ' . date('r'));

// Каким образом запрашивались данные? 
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	// Переменные параметы
	$title = ''; $author = '';
	
	if (!empty($_POST['title'])) 
		$title = trim(strip_tags($_POST['title']));
	if (!empty($_POST['author'])) 
		$author = trim(strip_tags($_POST['author']));
	
	// Открытие БД
	$db = new SQLite3("books.db");
	
	// Создание и выполнение запроса
	$sql = 'SELECT * FROM book ' .
						"WHERE title LIKE '%" . $db->escapeString($title) . "%' " . 
						"AND author LIKE '%" . $db->escapeString($author) . "%'";
	$result = $db->query($sql);

	// Вывод результата запроса
	while ($row = $result->fetchArray(SQLITE3_ASSOC))
		echo $row['author'], '. ', $row['title'],  "\n";
	
	// Закрытие БД
	unset($db);
}else{
	// Параметр не указан
	echo 'Запрос должен быть передан методом POST';
}
?>