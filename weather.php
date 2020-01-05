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
$mmrtst = 0.75006375541921;

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

    #wrapper div{
      display: inline-block;
      width: 230px;
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

    p{
        color: red;
        font: italic 110% Arial Black;
        animation: colorchange2 50s;
        animation-iteration-count:infinite;
        text-shadow: 0 1px black;
    }

    h2{
        font: bold italic 200% serif;
        text-align: center;
        text-shadow: 0 3px black;
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

                    echo "Тиск: " . number_format($day1t5pressure * $mmrtst, 2)  . " мм рт. ст. <br>";

                    echo "Вологість: " . $day1t5humidity . " %</p><br>";
                ?>
          </div>

          <div class="forecastday">
                <?php
                    echo date("<p>d.m.y ", $day1t14time) . "<strong><br>День</strong></p>";
                    $pic_url = "http://openweathermap.org/img/wn/" . $day1t14pic_url . "@2x.png";
                    echo "<br><a href='https://openweathermap.org/api'><img src=$pic_url  width=100 height=100></a><br>";
                    echo "<p>Температура: " . number_format($day1t14temp, 0) . "° <br>";

                    echo "Тиск: " . number_format($day1t14pressure * $mmrtst, 2)  . " мм рт. ст. <br>";

                    echo "Вологість: " . $day1t14humidity . " %</p><br>";
                ?>
          </div>

          <div class="forecastday">
                <?php
                    echo date("<p>d.m.y ", $day1t20time) . "<strong><br>Вечір</strong></p>";
                    $pic_url = "http://openweathermap.org/img/wn/" . $day1t20pic_url . "@2x.png";
                    echo "<br><a href='https://openweathermap.org/api'><img src=$pic_url  width=100 height=100></a><br>";
                    echo "<p>Температура: " . number_format($day1t20temp, 0) . "° <br>";

                    echo "Тиск: " . number_format($day1t20pressure * $mmrtst, 2)  . " мм рт. ст. <br>";

                    echo "Вологість: " . $day1t20humidity . " %</p><br>";
                ?>
          </div>
        </section>

        <section id="wrapper">

          <div class="forecastday">
                <?php
                    echo date("<p>d.m.y ", $day2t5time) . "<strong><br>Ранок</strong></p>";
                    $pic_url = "http://openweathermap.org/img/wn/" . $day2t5pic_url . "@2x.png";
                    echo "<br><a href='https://openweathermap.org/api'><img src=$pic_url  width=100 height=100></a><br>";
                    echo "<p>Температура: " . number_format($day2t5temp, 0) . "° <br>";

                    echo "Тиск: " . number_format($day2t5pressure * $mmrtst, 2)  . " мм рт. ст. <br>";

                    echo "Вологість: " . $day2t5humidity . " %</p><br>";
                ?>
          </div>

          <div class="forecastday">
                <?php
                    echo date("<p>d.m.y ", $day2t14time) . "<strong><br>День</strong></p>";
                    $pic_url = "http://openweathermap.org/img/wn/" . $day2t14pic_url . "@2x.png";
                    echo "<br><a href='https://openweathermap.org/api'><img src=$pic_url  width=100 height=100></a><br>";
                    echo "<p>Температура: " . number_format($day2t14temp, 0) . "° <br>";

                    echo "Тиск: " . number_format($day2t14pressure * $mmrtst, 2)  . " мм рт. ст. <br>";

                    echo "Вологість: " . $day2t14humidity . " %</p><br>";
                ?>
          </div>

          <div class="forecastday">
                <?php
                    echo date("<p>d.m.y ", $day2t20time) . "<strong><br>Вечір</strong></p>";
                    $pic_url = "http://openweathermap.org/img/wn/" . $day2t20pic_url . "@2x.png";
                    echo "<br><a href='https://openweathermap.org/api'><img src=$pic_url  width=100 height=100></a><br>";
                    echo "<p>Температура: " . number_format($day2t20temp, 0) . "° <br>";

                    echo "Тиск: " . number_format($day2t20pressure * $mmrtst, 2)  . " мм рт. ст. <br>";

                    echo "Вологість: " . $day2t20humidity . " %</p><br>";
                ?>
          </div>

        </section>

        <section id="wrapper">

          <div class="forecastday">
                <?php
                    echo date("<p>d.m.y ", $day3t5time) . "<strong><br>Ранок</strong></p>";
                    $pic_url = "http://openweathermap.org/img/wn/" . $day3t5pic_url . "@2x.png";
                    echo "<br><a href='https://openweathermap.org/api'><img src=$pic_url  width=100 height=100></a><br>";
                    echo "<p>Температура: " . number_format($day3t5temp, 0) . "° <br>";

                    echo "Тиск: " . number_format($day3t5pressure * $mmrtst, 2)  . " мм рт. ст. <br>";

                    echo "Вологість: " . $day3t5humidity . " %</p><br>";
                ?>
          </div>

          <div class="forecastday">
                <?php
                    echo date("<p>d.m.y ", $day3t14time) . "<strong><br>День</strong></p>";
                    $pic_url = "http://openweathermap.org/img/wn/" . $day3t14pic_url . "@2x.png";
                    echo "<br><a href='https://openweathermap.org/api'><img src=$pic_url  width=100 height=100></a><br>";
                    echo "<p>Температура: " . number_format($day3t14temp, 0) . "° <br>";

                    echo "Тиск: " . number_format($day3t14pressure * $mmrtst, 2)  . " мм рт. ст. <br>";

                    echo "Вологість: " . $day3t14humidity . " %</p><br>";
                ?>
          </div>

          <div class="forecastday">
                <?php
                    echo date("<p>d.m.y ", $day3t20time) . "<strong><br>Вечір</strong></p>";
                    $pic_url = "http://openweathermap.org/img/wn/" . $day3t20pic_url . "@2x.png";
                    echo "<br><a href='https://openweathermap.org/api'><img src=$pic_url  width=100 height=100></a><br>";
                    echo "<p>Температура: " . number_format($day3t20temp, 0) . "° <br>";

                    echo "Тиск: " . number_format($day3t20pressure * $mmrtst, 2)  . " мм рт. ст. <br>";

                    echo "Вологість: " . $day3t20humidity . " %</p><br>";
                ?>
          </div>

        </section>
  </body>
</html>
