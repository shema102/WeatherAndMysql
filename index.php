<?php
//header('Content-Type: text/plaintext; charset=utf-8');
include 'StoreUpdateWeather.php';

  //new StoreUpdateWeather("Tegucigalpa");
  //new StoreUpdateWeather("Tel Aviv");

  $ServerName = "127.0.0.1";// дані для підключення до сервера mysql
  $username = "root";
  $password = "jlr9tXI2kKs5i";
  $database_name = "weather";
  $table_name = "forecast";
  $database = new MysqliTools($ServerName, $username, $password);

  $city = "Kyiv";
  $database->__selectDB($database_name);
  $query = "SELECT * FROM $table_name WHERE city = '$city' ORDER BY id LIMIT 1";
  $weatherdata = $database->__queryReturn($query);
  $weatherdata = mysqli_fetch_assoc($weatherdata);

  for ($d = 0; $d < 6; $d++) { 
    for ($t = 2; $t <= 23; $t = $t + 3) {
      ${'day'.$d.'t'.$t.'temp'}     = $weatherdata["day".$d."t".$t."temp"];
      ${'day'.$d.'t'.$t.'pressure'} = $weatherdata["day".$d."t".$t."pressure"];
      ${'day'.$d.'t'.$t.'humidity'} = $weatherdata["day".$d."t".$t."humidity"];
      ${'day'.$d.'t'.$t.'pic_url'}  = $weatherdata["day".$d."t".$t."pic_url"];
      ${'day'.$d.'t'.$t.'time'}     = $weatherdata["day".$d."t".$t."time"];
    }
  }
/*
for ($d = 0; $d < 6; $d++) { 
  for ($t = 2; $t <= 23; $t = $t + 3) {
      echo ${'day'.$d.'t'.$t.'temp'} . " ";
      echo ${'day'.$d.'t'.$t.'pressure'} . " ";
      echo ${'day'.$d.'t'.$t.'humidity'} . " ";
      echo ${'day'.$d.'t'.$t.'pic_url'} . " ";
      echo ${'day'.$d.'t'.$t.'time'} . "\n";
  }
}*/

?>


          <div class="forecastday">
                <?php
                    echo date("Y-m-d H:i:s", $day4t5time);
                    $date=date_create();
                    //date_add($date,date_interval_create_from_date_string("1 days"));
                    $pic_url = "http://openweathermap.org/img/wn/" . $day4t5pic_url . "@2x.png";
                    echo "<br><a href='https://openweathermap.org/api'><img src=$pic_url  width=100 height=100></a><br>";
                    echo $day4t5temp;
                ?>
          </div>
          <div class="forecastday">
                <?php
                    echo date("Y-m-d H:i:s", $day3t5time);
                    $date=date_create();
                    date_add($date,date_interval_create_from_date_string("1 days"));
                    $pic_url = "http://openweathermap.org/img/wn/" . $day3t5pic_url . "@2x.png";
                    echo "<br><a href='https://openweathermap.org/api'><img src=$pic_url  width=100 height=100></a><br>";
                    echo $day3t5temp;
                ?>
          </div>