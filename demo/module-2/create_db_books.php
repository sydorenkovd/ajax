<?php
$db = new SQLite3("books.db");


$db->query(
		"CREATE TABLE book
		(
			id INTEGER PRIMARY KEY AUTOINCREMENT,
			author TEXT,
			title TEXT, 
			image TEXT,
			category NUMERIC
		)"
	);

$db->query(
		"CREATE INDEX book_category ON book(category ASC)"
	);


$db->query(
		"CREATE TABLE category
		(
			id INTEGER PRIMARY KEY AUTOINCREMENT,
			title TEXT,
			parent NUMERIC
		)"
	);

$db->query(
		"CREATE INDEX category_parent ON category(parent ASC)"
	);

?>