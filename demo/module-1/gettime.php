<?php
/*
** Сценарий возвращает текущее время
*/

// Установка типа данных и кодировки
header("Content-type", "text/plain; charset=utf-8");

// Чтение параметра задержки и задержка в коде
if (isset($_GET["delay"])){
	$delay = abs((int) $_GET["delay"]);
	$currTime = time();
	while (time() < $currTime + $delay) {}
}

// Текущее время
echo date("H:i:s");
?>