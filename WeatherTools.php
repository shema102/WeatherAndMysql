<?php
/**
 * класс для звязку з погодним арі та отриманням з нього даних
 */
class WeatherTools
{
  private $api_key;

  function __construct($key)//в конструкторі предаємо api ключ
  {
    $this -> api_key = $key;
  }
  //api.openweathermap.org/data/2.5/weather?q= погода зараз
  //api.openweathermap.org/data/2.5/forecast?q= прогноз на 5 днів
  public function __GetWeather($city_name)// метод для передачі GET запиту за заданим URL, повертає масив з отриманими данними
  {
    $url = "api.openweathermap.org/data/2.5/forecast?q=" . $city_name . "&units=metric&APPID=" . $this -> api_key;
    $curl = curl_init(); // ініціалізація curl
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array("cache-control: no-cache"),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    echo $err;
    $decoded_response = json_decode($response, true);
    return $decoded_response; //змінна з усіми даними отриманими через арі за допомогою curl
  }
}
?>