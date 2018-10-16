<?php

class DB{
    private $dsn = 'mysql:dbname=sphere;host=127.0.0.1';
    private $user = 'root';
    private $password = '2501';
    public $db;

    private $query = '';
    private $table;
    private $list_columns = [];
    private $prepare = [];

    /**
     * [__construct description]
     * @param [type] $table [description]
     */
    public function __construct($table){

        $this->db = new PDO($this->dsn, $this->user, $this->password);
        $this->table = $table;

        $this->getColumnName();

    }

    /**
     * [Вибирає назви всіх стовпчиків в вибраній таблиці]
     * @return [null] [description]
     */
    private function getColumnName(){
    	$query = "SHOW COLUMNS FROM ".$this->table;
    	$res = $this->db->query($query);

    	foreach ($res as $value) {

    		if($value['Field'] == 'id') continue;
    		$this->list_columns[] = $value['Field'];
    	}
    }

    /**
     * [Створює запит для вибору з таблиці]
     * @param  array  $columns [['name_column', 'name_column']]
     * @return [DB object]          [description]
     */
    public function select(array $columns = []){
    	
    	$query = "SELECT * FROM ".$this->table;
    	
    	if(!empty($columns)){
    		$str = implode(', ', $columns);
    		$query = "SELECT $str FROM ".$this->table;
    	}

    	$this->query = $query;

    	return $this;
    }

    /**
     * [Вставка даних в вибрану таблицю. Якщо передається класичний массив, тоді вставка відбувається послідовно. 
     * При передачі ассоціативного массиву ключі звязуются з конкретними стовпчиками таблиці]
     * @param  array  $values [['$name_column_in_table'=>'value'] or ['value', 'value']]
     * @return [type]         [description]
     */
    public function insert(array $values){
    	
    	$columns_str = '';
    	$values_str = '';
    	$this->prepare = [];

    	if($this->isAssoc($values)){

    		$tmpParams = [];

    		foreach ($this->list_columns as $column) {
    			if(key_exists($column, $values)){
    				$columns_str =  $columns_str.' '.$column.',';
    			    $values_str = $values_str." :$column,";

    			    $this->prepare[':'.$column] = $values[$column];
    			}else{
    			    $columns_str =  $columns_str.' '.$column.',';
    			    $values_str = $values_str." :$column,";

    			    $this->prepare[':'.$column] = '';	
    			}
    		}

    	}else{

    		$columns_str = implode(', ', $this->list_columns);
    		$size = count($this->list_columns)-1;
    		
    		for($i = 0; $i<= $size; $i++){

    			if(!isset($values[$i]) || empty($values[$i])){
    				$this->prepare[':'.$this->list_columns[$i]] = '';
    				$values_str = $values_str."' ',";
    			}else{
    				$this->prepare[':'.$this->list_columns[$i]] = $values[$i];
    				$values_str = $values_str." '$values[$i]',";
    			}
    		}
	
    	}

    	$values_str = rtrim($values_str, ',');
    	$columns_str = rtrim($columns_str, ',');


    	$this->query = "INSERT INTO ".$this->table."($columns_str) "."VALUES($values_str)";



    	
    	$sth = $this->db->prepare($this->query);
    	$res = $sth->execute($this->prepare);

    	// dump($this->query );

    	// dump($sth->errorInfo());
    	
    	return $res;
    	
    }

    /**
     * [Перевіряє, чи являється переданий масив ассоциативним]
     * @param  array   $array [description]
     * @return boolean        [description]
     */
    public function isAssoc(array $array) {

    	return count(array_filter(array_keys($array), 'is_string')) > 0 ? true : false;
    }

    /**
     * [Запуск запросу на виконнання]
     * @return [array] [result rows of database]
     */
    public function get(){

    	
    	$sth = $this->db->prepare($this->query);
    	
    	$res = $sth->execute($this->prepare); 

    	var_dump($sth->errorInfo());
    	

    	$rows = $sth->fetchAll();
    	

    	return $rows;

    }


    /**
     * [Установка нового імені таблиці]
     * @param  [string] $table [description]
     * @return []        [description]
     */
    public function table(string $table){

    	$this->table = $table;

    	return $this;
    }


    /**
     * [Установка нового підключення з БД]
     * @return [null] [description]
     */
    public function connect(){
    	$this->db = new PDO($this->dsn, $this->user, $this->password);
    }

    /**
     * [Установка нових параметрів підключення до БД]
     * @param [type] $dsn      [description]
     * @param [type] $user     [description]
     * @param [type] $password [description]
     */
    public function setParamsConnect($dsn, $user, $password){
    	$this->dsn = $dsn;
    	$this->user = $user;
    	$this->password =  $password;

    }



}
