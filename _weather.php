<?php
header('Content-Type: text/plaintext; charset=utf-8');
include 'WeatherTools.php';
include 'MysqliTools.php';


$api_key = 'a988988f9b8811b3d5b23b888af9a7ca';
$city = 'Berlin'; //Назва міста

$serverName = "127.0.0.1";// дані для підключення до сервера mysql
$username = "root";
$password = "jlr9tXI2kKs5i";
$database_name = "weather";
$table_name = "forecast";

$weather = new WeatherTools($api_key);
$forecast = $weather -> __GetWeather($city);

for ($j=0; $j < 48; $j++) { 
  if(!empty($forecast["list"][$j])){
    echo date("Y-m-d H:i:s", $forecast["list"][$j]["dt"]) . "\t" . $forecast["list"][$j]["main"]["temp"] ."\n";
  if((int)date("H", $forecast["list"][$j]["dt"]) % 23 == 0)
    echo "\n";
  }
}

$database = new MysqliTools($serverName, $username, $password);

$database -> __createDB($database_name);
$database -> __selectDB($database_name);

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

//$database -> __dropTable($table_name);
//$database -> __createTable($table_name, $columns);
//echo $columns;

$newdate = date('Y-m-d H:i:s');
$latitude = $forecast["city"]["coord"]["lon"];
$longitude = $forecast["city"]["coord"]["lat"];




$last_date = (int)date("d", $forecast["list"][0]["dt"]);
$d = 0;
$t = 2;
for ($j=0; $j < 40; $j++) {
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


for ($d = 0; $d < 6; $d++) { 
  for ($t = 2; $t <= 23; $t = $t + 3) {
      echo ${'day'.$d.'t'.$t.'temp'} . " ";
      echo ${'day'.$d.'t'.$t.'temp_max'} . " ";
      echo ${'day'.$d.'t'.$t.'temp_min'} . " ";
      echo ${'day'.$d.'t'.$t.'pressure'} . " ";
      echo ${'day'.$d.'t'.$t.'humidity'} . " ";
      echo ${'day'.$d.'t'.$t.'pic_url'} . " ";
      echo ${'day'.$d.'t'.$t.'time'} . "\n";
  }
}


$sql_insert_content = "INSERT INTO `" . $table_name . "`(`city`, `location_latitude`, `location_longitude`, `last_update`";
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
$sql_insert_content = $sql_insert_content . ")VALUES ('$city','$latitude','$longitude','$newdate'";
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


$sql_update = "UPDATE " . $table_name . " SET last_update = '$newdate'"  ;
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
$sql_update = $sql_update . ' WHERE city = "'.$city.'"';

echo $sql_insert_content;
echo $sql_update;

//$database -> __query($sql_insert_content);
if($database -> __checkIfColumnContentExist($table_name, "city", $city)){ //перевірка чи існує в таблиці рядок з назвою заданого міста, якщо існує то обновивти контент, якщо не існує то створити рядок
  $database -> __query($sql_update);
  echo "\nupdated table";
}
else{
  $database -> __query($sql_insert_content);
  echo "\ninserted in table";
}

?>
