<?php
/**
 * клас для керуванням MYSQL, створенння БД, створення таблиць та їх заповнення
 */
class MysqliTools
{
  
  function __construct($serverIP, $user, $pass)//конструктор, при створенні класу передаємо данні для з'єднання в виді "адреса сервераMySQL, логін, пароль"
  {
    $this -> serverName = $serverIP;
    $this -> username = $user;
    $this -> password = $pass;
    $this -> link = mysqli_connect($this -> serverName, $this -> username, $this -> password);
		if (!$this -> link) {
    	die('Помилка з єднання: ' . mysqli_connect_error());
		}
  }

  public function __closeConnection(){
    mysqli_close($this -> link);
  }

  public function __createDB($db_name){//стрворення БД
    if (mysqli_select_db($this -> link, $db_name)) {
      echo "База " . $db_name . " існує\n";
    }
    else{
      $sql = "CREATE DATABASE " . $db_name; 
      if (mysqli_query($this -> link, $sql)) {
          echo "База " . $db_name . " створена\n";
      } else {
          echo 'Помилка при створенні бази даних: ' . mysqli_error($this -> link) . "\n";
    }
    }
  }

  public function __dropDB($db_name){// видалення бази даних
    $sql = "DROP DATABASE " . $db_name; 
    if (mysqli_query($this -> link, $sql)) {
      echo "База " . $db_name . " успішно видалена\n";
    } else {
      echo 'Помилка при видаленні бази даних: ' . mysqli_error($this -> link) . "\n";
      }
  }

  public function __selectDB($db_name){//вибір бази даних
	if (mysqli_select_db($this -> link, $db_name)) {
	  //echo "База " . $db_name . " выбрана\n";
	} else {
	  echo 'помилка при виборі бази даних: ' . mysqli_error($this -> link) . "\n";
	}
  }

  public function __createTable($table_name, $columns){ //назва бази данних, назва таблиці, колонки в виді "column1 columnType(), column2 columnType(), column3 columnType()..."
    $query = "CREATE TABLE ".$table_name." (" . $columns . ") ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8";
    if(mysqli_query($this -> link, $query)){
      echo "Створені стовпці в таблиці " . $table_name . "\n";  
    }
    else{
      echo 'помилка при створенні стовпців: ' . mysqli_error($this -> link) . "\n";
    }
  }

  public function __dropTable($table_name){//видалення таблиці
	$query = "DROP TABLE IF EXISTS ".$table_name;
	if(mysqli_query($this -> link, $query)){
	  echo "Таблиця " . $table_name . " видалена\n";
	} else {
	  echo 'помилка при видаленні таблиці: ' . mysqli_error($this -> link) . "\n";
	}
  	}

  public function __insertDataInTable($table_name, $content){//вставка нового радка в таблицю
	$query = "INSERT INTO " . $table_name . " VALUES ('" . $content . ")"; 
	if(mysqli_query($this -> link, $query)){
		echo "Дані записано в колонки таблиці " . $table_name . "\n";  
    } else {
      echo 'помилка при запису колонок: ' . mysqli_error($this -> link) . "\n";
    }
	}
  
  public function __query($content){//запит до MySQL
    $query = $content; 
    if(mysqli_query($this -> link, $query)){
      echo "Запит виконано успішно \n";  
      } else {
        echo 'помилка при запиті: ' . mysqli_error($this -> link) . "\n";
      }
    }

  public function __queryReturn($content){//запит до MySQL
    $query = $content; 
    return mysqli_query($this -> link, $query);
    }

  public function __checkIfColumnContentExist($table_name, $column_name, $column_content){// перевірка чи вснує певне значення в рядку
    $query = "SELECT * FROM $table_name WHERE $column_name = '$column_content'"; 
    if(mysqli_num_rows(mysqli_query($this -> link, $query)) == 0)
      return False; 
    else 
      return True;
    }
    
    public function __getFromDB(){
      $query = "SELECT * FROM $table_name WHERE city = '$city' ORDER BY id LIMIT 1";
      if(mysqli_query($this -> link, $query)){
      echo "Запит виконано успішно \n";  
      } else {
        echo 'помилка при запиті: ' . mysqli_error($this -> link) . "\n";
      }
    }
    

  private $serverName;
  private $username;
  private $password;
  private $link;
}
?>