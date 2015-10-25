<?php
$db = new SQLite3("books.db");


$db->exec(
		"CREATE TABLE book
		(
			id INTEGER PRIMARY KEY,
			author TEXT,
			title TEXT, 
			image TEXT,
			category NUMERIC
		)"
	);

$db->exec(
		"CREATE INDEX book_category ON book(category ASC)"
	);


$db->exec(
		"CREATE TABLE category
		(
			id INTEGER PRIMARY KEY,
			title TEXT,
			parent NUMERIC
		)"
	);

$db->exec(
		"CREATE INDEX category_parent ON category(parent ASC)"
	);

?>