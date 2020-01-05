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

  //$city = "Kyiv";
  $city = $_REQUEST['city'];
  if($city == "")
    die("Sraqua");
  $update = new StoreUpdateWeather($city);
  $database->__selectDB($database_name);
  $query = "SELECT * FROM $table_name WHERE city = '$city' ORDER BY id LIMIT 1";
  $weatherdata = $database->__queryReturn($query);
  $weatherdata = mysqli_fetch_assoc($weatherdata);
  $database -> __closeConnection();

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
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo("Weather in ". $city ) ?></title>
    <style>
    body{
        background-color: red; 
        color: white; 
        animation: colorchange 50s;
        animation-iteration-count:infinite;
    }

    #wrapper div {
      display: inline-block;
      width: 220px;
      height: 310px;
      background: yellow;
      animation: colorchange1 50s;
      animation-iteration-count:infinite;
      border: 10px solid black;
      padding: 24px;
      margin: 1em;
      text-align: center;
      vertical-align: middle;

    }

    section{
      vertical-align: middle;
    }
      p {
        color: red;
        font: italic 100% Arial Black;
        animation: colorchange2 50s;
        animation-iteration-count:infinite;
      }
      h2 {
        font: bold italic 200% serif;
      }
    @keyframes colorchange
    {
      0%   {background: red;}
      25%  {background: yellow;}
      50%  {background: blue;}
      75%  {background: green;}
      100% {background: red;}
    }

    @keyframes colorchange1
    {
      0%   {background: yellow;}
      25%  {background: blue;}
      50%  {background: green;}
      75%  {background: red;}
      100% {background: yellow;}
    }

    @keyframes colorchange2
    {
      0%   {color: green;}
      25%  {color: red;}
      50%  {color: yellow;}
      75%  {color: blue;}
      100% {color: green;}
    }
    </style>
  </head>
  <body>
    <h2><?php echo("Weather in ". $city ) ?></h2>
    <section id="wrapper">
          <div class="forecastday">
                <?php
                    echo date("<p>d.m.y ", $day1t5time) . "<strong><br>Ранок</strong></p>";
                    $pic_url = "http://openweathermap.org/img/wn/" . $day1t5pic_url . "@2x.png";
                    echo "<br><a href='https://openweathermap.org/api'><img src=$pic_url  width=100 height=100></a><br>";
                    echo "<p>Температура: " . number_format($day1t5temp, 0) . "° <br>";

                    echo "Тиск: " . number_format($day1t5pressure * 0.75006375541921, 2)  . " мм рт. ст. <br>";

                    echo "Вологість: " . $day1t5humidity . " %</p><br>";
                ?>
          </div>

          <div class="forecastday">
                <?php
                    echo date("<p>d.m.y ", $day1t5time) . "<strong><br>Ранок</strong></p>";
                    $pic_url = "http://openweathermap.org/img/wn/" . $day1t5pic_url . "@2x.png";
                    echo "<br><a href='https://openweathermap.org/api'><img src=$pic_url  width=100 height=100></a><br>";
                    echo "<p>Температура: " . number_format($day1t5temp, 0) . "° <br>";

                    echo "Тиск: " . number_format($day1t5pressure * 0.75006375541921, 2)  . " мм рт. ст. <br>";

                    echo "Вологість: " . $day1t5humidity . " %</p><br>";
                ?>
          </div>

          <div class="forecastday">
                <?php
                    echo date("<p>d.m.y ", $day1t5time) . "<strong><br>Ранок</strong></p>";
                    $pic_url = "http://openweathermap.org/img/wn/" . $day1t5pic_url . "@2x.png";
                    echo "<br><a href='https://openweathermap.org/api'><img src=$pic_url  width=100 height=100></a><br>";
                    echo "<p>Температура: " . number_format($day1t5temp, 0) . "° <br>";

                    echo "Тиск: " . number_format($day1t5pressure * 0.75006375541921, 2)  . " мм рт. ст. <br>";

                    echo "Вологість: " . $day1t5humidity . " %</p><br>";
                ?>
          </div>
        </section>

        <section id="wrapper">

          <div class="forecastday">
                <?php
                    echo date("<p>d.m.y ", $day1t5time) . "<strong><br>Ранок</strong></p>";
                    $pic_url = "http://openweathermap.org/img/wn/" . $day1t5pic_url . "@2x.png";
                    echo "<br><a href='https://openweathermap.org/api'><img src=$pic_url  width=100 height=100></a><br>";
                    echo "<p>Температура: " . number_format($day1t5temp, 0) . "° <br>";

                    echo "Тиск: " . number_format($day1t5pressure * 0.75006375541921, 2)  . " мм рт. ст. <br>";

                    echo "Вологість: " . $day1t5humidity . " %</p><br>";
                ?>
          </div>

          <div class="forecastday">
                <?php
                    echo date("<p>d.m.y ", $day1t5time) . "<strong><br>Ранок</strong></p>";
                    $pic_url = "http://openweathermap.org/img/wn/" . $day1t5pic_url . "@2x.png";
                    echo "<br><a href='https://openweathermap.org/api'><img src=$pic_url  width=100 height=100></a><br>";
                    echo "<p>Температура: " . number_format($day1t5temp, 0) . "° <br>";

                    echo "Тиск: " . number_format($day1t5pressure * 0.75006375541921, 2)  . " мм рт. ст. <br>";

                    echo "Вологість: " . $day1t5humidity . " %</p><br>";
                ?>
          </div>

          <div class="forecastday">
                <?php
                    echo date("<p>d.m.y ", $day1t5time) . "<strong><br>Ранок</strong></p>";
                    $pic_url = "http://openweathermap.org/img/wn/" . $day1t5pic_url . "@2x.png";
                    echo "<br><a href='https://openweathermap.org/api'><img src=$pic_url  width=100 height=100></a><br>";
                    echo "<p>Температура: " . number_format($day1t5temp, 0) . "° <br>";

                    echo "Тиск: " . number_format($day1t5pressure * 0.75006375541921, 2)  . " мм рт. ст. <br>";

                    echo "Вологість: " . $day1t5humidity . " %</p><br>";
                ?>
          </div>

        </section>

        <section id="wrapper">

          <div class="forecastday">
                <?php
                    echo date("<p>d.m.y ", $day1t5time) . "<strong><br>Ранок</strong></p>";
                    $pic_url = "http://openweathermap.org/img/wn/" . $day1t5pic_url . "@2x.png";
                    echo "<br><a href='https://openweathermap.org/api'><img src=$pic_url  width=100 height=100></a><br>";
                    echo "<p>Температура: " . number_format($day1t5temp, 0) . "° <br>";

                    echo "Тиск: " . number_format($day1t5pressure * 0.75006375541921, 2)  . " мм рт. ст. <br>";

                    echo "Вологість: " . $day1t5humidity . " %</p><br>";
                ?>
          </div>

          <div class="forecastday">
                <?php
                    echo date("<p>d.m.y ", $day1t5time) . "<strong><br>Ранок</strong></p>";
                    $pic_url = "http://openweathermap.org/img/wn/" . $day1t5pic_url . "@2x.png";
                    echo "<br><a href='https://openweathermap.org/api'><img src=$pic_url  width=100 height=100></a><br>";
                    echo "<p>Температура: " . number_format($day1t5temp, 0) . "° <br>";

                    echo "Тиск: " . number_format($day1t5pressure * 0.75006375541921, 2)  . " мм рт. ст. <br>";

                    echo "Вологість: " . $day1t5humidity . " %</p><br>";
                ?>
          </div>

          <div class="forecastday">
                <?php
                    echo date("<p>d.m.y ", $day1t5time) . "<strong><br>Ранок</strong></p>";
                    $pic_url = "http://openweathermap.org/img/wn/" . $day1t5pic_url . "@2x.png";
                    echo "<br><a href='https://openweathermap.org/api'><img src=$pic_url  width=100 height=100></a><br>";
                    echo "<p>Температура: " . number_format($day1t5temp, 0) . "° <br>";

                    echo "Тиск: " . number_format($day1t5pressure * 0.75006375541921, 2)  . " мм рт. ст. <br>";

                    echo "Вологість: " . $day1t5humidity . " %</p><br>";
                ?>
          </div>

        </section>



  </body>
</html>
