<?php
/*
** Класс работы с базой данных
*/
class ServerDatabase{
	private $db;		// База данных
	private $params;	// Массив параметров
	private $sql;		// Текст запроса

	// Констуктор класса
	public function __construct($databaseFile='books.db'){
		$this->db = new SQLite3($databaseFile);
	}
	
	// Подготовка нового запроса к выполнению
	public function newQuery($sql){
		$this->sql = $sql;
		$this->params = array();
	}
	
	// Добавление параметра в запрос
	public function addParameter($parameter){
		$this->params[] = $this->db->escapeString($parameter);
	}
	
	// Добавление нескольких параметров
	public function addParameters($parameters){
		foreach ($parameters as $parameter)
			$this->addParameter($parameter);
	}
	
	// Выполняет запрос
	public function execute($select=false){
		// Подготовка запроса
		for ($i = 0; $i < count($this->params); $i++)
		{
			$patten = '%' . ($i + 1);
			$this->sql = str_replace($patten, $this->params[$i], $this->sql);
		}
		if($select)
			$result = $this->dbToArray($this->db->query($this->sql));
		else
			$result = $this->db->exec($this->sql);
		return $result;
		
	}
	// Метод конвертирует SQLIte3Result в массив
	private function dbToArray($data){
		$arr = array();
		while($row = $data->fetchArray(SQLITE3_ASSOC))
			$arr[] = $row;
		return $arr;
	}
	// Последний добавленный ID
	public function getLastInsertId(){
		return $this->db->lastInsertRowID();
	}
	
	// Число обработанных записей
	public function getRowsAffected(){
		return $this->db->changes();
	}
}
?>