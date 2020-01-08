<?php
//header('Content-Type: text/plaintext; charset=utf-8');
include 'WeatherTools.php';//файл з класом для роботи з апі
include 'MysqliTools.php';//файл з класом для роботи з базами даних

/**
 * клас для отримання або оновлення погодних даних
 */
class StoreUpdateWeather{
    protected $api_key = 'a988988f9b8811b3d5b23b888af9a7ca';//апі ключ для https://openweathermap.org/
    private $city; //Назва міста
    private $ServerName = "127.0.0.1";// адреса сервера mysql в мережі
    private $username = "root";//логін для підключення до бази даних
    protected $password = "jlr9tXI2kKs5i";//пароль
    private $database_name = "weather"; //назва бази даних
    private $table_name = "forecast";//назва таблиці в базі даних

  function __construct($city_name)//конструктор класу, отримує назву та викликає метод __GetUpdateWeather
  {
    $this->city = $city_name;
    $this->__GetUpdateWeather();
  }

  private function __GetUpdateWeather(){//метод що виконує створення бд (якщо потрібно), створення таблиці та її заповнення

    $weather = new WeatherTools($this->api_key);//створюємо об'єкт класу WeatherTools та передаємо йому апі ключ
    $forecast = $weather -> __GetWeather($this->city); //отримуємо декодований json об'єкт з апі та записуємо його в змінну, являє собою асоцыативний масив
    if($forecast["cod"] == "404"){//перевірка чи існує задане місто, якщо ні то виводимо помилку
      die($forecast["message"]);
    }

    $database = new MysqliTools($this->ServerName, $this->username, $this->password);//новий об'єкт класу MysqlTools для роботи з БД

    $database -> __createDB($this->database_name);// створюємо бд
    $database -> __selectDB($this->database_name);//вибираємо бд

    //змінна яка містить всі колонки таблиці
    $columns = '
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `city` varchar(45) NOT NULL,
    `location_latitude` float(6) NOT NULL,
    `location_longitude` float(6) NOT NULL,
    `last_update` datetime DEFAULT NULL,';

    for ($d = 0; $d < 6; $d++) { 
      for ($t = 2; $t <= 23; $t = $t + 3) { 
      $temp = '
    `day'.$d.'t'.$t.'temp` float(3) DEFAULT NULL,
    `day'.$d.'t'.$t.'temp_max` float(3) DEFAULT NULL,
    `day'.$d.'t'.$t.'temp_min` float(3) DEFAULT NULL,
    `day'.$d.'t'.$t.'pressure` int(10) DEFAULT NULL,
    `day'.$d.'t'.$t.'humidity` smallint(4) DEFAULT NULL,
    `day'.$d.'t'.$t.'pic_url` char(4) DEFAULT NULL,
    `day'.$d.'t'.$t.'time` int(10) DEFAULT NULL,';
      $columns = $columns . $temp;
      }
    }
    $columns = $columns . 'PRIMARY KEY (`id`)';

    //$database -> __dropTable($this->table_name);//видаляємо таблицю
    //$database -> __createTable($this->table_name, $columns);//створюємо таблицю з раніше заданими колонками
    //echo $columns;

    $newdate = date('Y-m-d H:i:s');//отримуємо дату
    $latitude = $forecast["city"]["coord"]["lon"];
    $longitude = $forecast["city"]["coord"]["lat"];

    $last_date = (int)date("d", $forecast["list"][0]["dt"]);
    $d = 0;
    $t = 2;
    for ($j=0; $j < 40; $j++) {//цикл в якому заповнюються змінні з асоціативного масиву(написано через сраку, зато робить)
          while($t !== (int)date("H", $forecast["list"][$j]["dt"])){
            $t = $t + 3;
          }


          $current_date = (int)date("d", $forecast["list"][$j]["dt"]);
            if ($last_date !== $current_date) {
                  $d++;
            }
            else{};
          ${'day'.$d.'t'.$t.'temp'} = $forecast["list"][$j]["main"]["temp"];
          ${'day'.$d.'t'.$t.'temp'} = !empty(${'day'.$d.'t'.$t.'temp'}) ? ${'day'.$d.'t'.$t.'temp'} : "NULL";

          ${'day'.$d.'t'.$t.'temp_max'} = $forecast["list"][$j]["main"]["temp_max"];
          ${'day'.$d.'t'.$t.'temp_max'} = !empty(${'day'.$d.'t'.$t.'temp_max'}) ? ${'day'.$d.'t'.$t.'temp_max'} : "NULL";

          ${'day'.$d.'t'.$t.'temp_min'} = $forecast["list"][$j]["main"]["temp_min"];
          ${'day'.$d.'t'.$t.'temp_min'} = !empty(${'day'.$d.'t'.$t.'temp_min'}) ? ${'day'.$d.'t'.$t.'temp_min'} : "NULL";

          ${'day'.$d.'t'.$t.'pressure'} = $forecast["list"][$j]["main"]["pressure"];
          ${'day'.$d.'t'.$t.'pressure'} = !empty(${'day'.$d.'t'.$t.'pressure'}) ? ${'day'.$d.'t'.$t.'pressure'} : "NULL";

          ${'day'.$d.'t'.$t.'humidity'} = $forecast["list"][$j]["main"]["humidity"];
          ${'day'.$d.'t'.$t.'humidity'} = !empty(${'day'.$d.'t'.$t.'humidity'}) ? ${'day'.$d.'t'.$t.'humidity'} : "NULL";

          ${'day'.$d.'t'.$t.'pic_url'} = $forecast["list"][$j]["weather"][0]["icon"];
          ${'day'.$d.'t'.$t.'pic_url'} = !empty(${'day'.$d.'t'.$t.'pic_url'}) ? ${'day'.$d.'t'.$t.'pic_url'} : "NULL";

          ${'day'.$d.'t'.$t.'time'} = $forecast["list"][$j]["dt"];
          ${'day'.$d.'t'.$t.'time'} = !empty(${'day'.$d.'t'.$t.'time'}) ? ${'day'.$d.'t'.$t.'time'} : "NULL";
          $last_date = $current_date;
          if($t == 23)
            $t = 2;
        }

    for ($d = 0; $d < 6; $d++) { 
      for ($t = 2; $t <= 23; $t = $t + 3) {
          ${'day'.$d.'t'.$t.'temp'} = !empty(${'day'.$d.'t'.$t.'temp'}) ? ${'day'.$d.'t'.$t.'temp'} : "NULL";
          ${'day'.$d.'t'.$t.'temp_max'} = !empty(${'day'.$d.'t'.$t.'temp_max'}) ? ${'day'.$d.'t'.$t.'temp_max'} : "NULL";
          ${'day'.$d.'t'.$t.'temp_min'} = !empty(${'day'.$d.'t'.$t.'temp_min'}) ? ${'day'.$d.'t'.$t.'temp_min'} : "NULL";
          ${'day'.$d.'t'.$t.'pressure'} = !empty(${'day'.$d.'t'.$t.'pressure'}) ? ${'day'.$d.'t'.$t.'pressure'} : "NULL";
          ${'day'.$d.'t'.$t.'humidity'} = !empty(${'day'.$d.'t'.$t.'humidity'}) ? ${'day'.$d.'t'.$t.'humidity'} : "NULL";
          ${'day'.$d.'t'.$t.'pic_url'} = !empty(${'day'.$d.'t'.$t.'pic_url'}) ? ${'day'.$d.'t'.$t.'pic_url'} : "NULL";
          ${'day'.$d.'t'.$t.'time'} = !empty(${'day'.$d.'t'.$t.'time'}) ? ${'day'.$d.'t'.$t.'time'} : "NULL";
    }
    }

    $sql_insert_content = "INSERT INTO `" . $this->table_name . "`(`city`, `location_latitude`, `location_longitude`, `last_update`";//змінна з sql запитом який вставляє новий рядок в таблицю
    for ($d = 0; $d < 6; $d++) { 
      for ($t = 2; $t <= 23; $t = $t + 3) { 
      $temp = ',
    `day'.$d.'t'.$t.'temp`,
    `day'.$d.'t'.$t.'temp_max`,
    `day'.$d.'t'.$t.'temp_min`,
    `day'.$d.'t'.$t.'pressure`,
    `day'.$d.'t'.$t.'humidity`,
    `day'.$d.'t'.$t.'pic_url`,
    `day'.$d.'t'.$t.'time`';
      $sql_insert_content = $sql_insert_content . $temp;
      }
    }
    $sql_insert_content = $sql_insert_content . ")VALUES ('$this->city','$latitude','$longitude','$newdate'";
    for ($d = 0; $d < 6; $d++) { 
      for ($t = 2; $t <= 23; $t = $t + 3) {
        $sql_insert_content = $sql_insert_content . ",
    " .     ${'day'.$d.'t'.$t.'temp'} . ",
    " .     ${'day'.$d.'t'.$t.'temp_max'} . ",
    " .     ${'day'.$d.'t'.$t.'temp_min'} . ",
    " .     ${'day'.$d.'t'.$t.'pressure'} . ",
    " .     ${'day'.$d.'t'.$t.'humidity'} . ",
    " ."'". ${'day'.$d.'t'.$t.'pic_url'} ."'". ",
    ".      ${'day'.$d.'t'.$t.'time'};

      }
    }
    $sql_insert_content = $sql_insert_content . ");";


    $sql_update = "UPDATE " . $this->table_name . " SET last_update = '$newdate'"  ;//змінна яка оновлює існуючий рядок в таблиці
    for ($d = 0; $d < 6; $d++) { 
      for ($t = 2; $t <= 23; $t = $t + 3) { 
      $temp = ',
    day'.$d.'t'.$t.'temp = '    .${'day'.$d.'t'.$t.'temp'}.',
    day'.$d.'t'.$t.'temp_max = '.${'day'.$d.'t'.$t.'temp_max'}.',
    day'.$d.'t'.$t.'temp_min = '.${'day'.$d.'t'.$t.'temp_max'}.',
    day'.$d.'t'.$t.'pressure = '.${'day'.$d.'t'.$t.'pressure'}.',
    day'.$d.'t'.$t.'humidity = '.${'day'.$d.'t'.$t.'humidity'}.',
    day'.$d.'t'.$t.'pic_url = '."'" .${'day'.$d.'t'.$t.'pic_url'}."'".',
    day'.$d.'t'.$t.'time = '    .${'day'.$d.'t'.$t.'time'};
      $sql_update = $sql_update . $temp;
      }
    }
    $sql_update = $sql_update . ' WHERE city = "'.$this->city.'"';

    //$database -> __query($sql_insert_content);
    if($database -> __checkIfColumnContentExist($this->table_name, "city", $this->city)){ //перевірка чи існує в таблиці рядок з назвою заданого міста, якщо існує то обновивти контент, якщо не існує то створити рядок
      $database -> __query($sql_update);
      //echo "\nupdated table";
    }
    else{
      $database -> __query($sql_insert_content);
      //echo "\ninserted in table";
    }
    $database -> __closeConnection();//закриваємо з'єднання з базою даних
  }
}
?>
