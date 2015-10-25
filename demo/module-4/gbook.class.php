<?php
require_once('message.class.php');

// Класс гостевой книги
class GBook
{
	// Свойства
	private $db;		// База данных
	
	// Констуктор
	public function __construct($fileName='gbook.db')
	{
		// Открытие базы данных
		$this->db = new SQLite3($fileName);
		if (!filesize($fileName))
		{
			// Таблица записей гостевой книги
			$this->db->exec('CREATE TABLE message 
					(
						id TEXT PRIMARY KEY,	-- ID записи
						author TEXT,			-- Автор записи
						email TEXT,				-- Е-mail автора
						body TEXT,				-- Тело ообщения
						timestamp INT			-- Штамп времени
					)
				');
			$this->db->exec('CREATE INDEX message_id ON message(id)');
			$this->db->exec('CREATE INDEX message_timestamp ON message(timestamp DESC)');
		}
	}
	
	// Возвращает запись по указанному ID
	public function getMessage($id)
	{
		$res = $this->db->query('SELECT * FROM message WHERE id = \'' . 
		$this->db->escapeString($id) . '\'');
		if($row = $res->fetchArray(SQLITE3_ASSOC))
			return new Message($row['id'], $row['author'], $row['email'], $row['body']);
		else
			return null;
	}
	
	// Возвращает сколько-то последних записей
	public function getLastMessages($count=10)
	{
		$count = (int) $count;
		$res = $this->db->query('SELECT id FROM message ORDER BY timestamp DESC LIMIT ' . $count);
		$messages = array();
		while ($row = $res->fetchArray(SQLITE3_NUM))
			$messages[] = $this->getMessage($row[0]);
		return $messages;
	}
	
	// Добавляет новое сообщение
	public function addMessage($message)
	{
		$this->db->exec('INSERT INTO message (id, author, email, body, timestamp) VALUES (' .
			'\'' . $this->db->escapeString($message->id)  . '\', ' .
			'\'' . $this->db->escapeString($message->author)  . '\', ' .
			'\'' . $this->db->escapeString($message->email)  . '\', ' .
			'\'' . $this->db->escapeString($message->body)  . '\', ' .
			time() . ')');
	}	
	
	// Заменяет существующее сообщение
	public function replaceMessage($message)
	{
		$this->db->exec('UPDATE message SET ' .
			'author = \'' . $this->db->escapeString($message->author)  . '\', ' .
			'email = \'' . $this->db->escapeString($message->email)  . '\', ' .
			'body = \'' . $this->db->escapeString($message->body)  . '\' ' .
			'WHERE id = \'' . $this->db->escapeString($message->id)  . '\'');
	}
	
	// Удаляет существующее сообщение
	public function deleteMessage($message)
	{
		$this->db->exec('DELETE FROM message ' .
			'WHERE id = \'' . $this->db->escapeString($message->id)  . '\'');
	}	
}
?>