<?php
  error_reporting(E_ALL);
	ini_set('display_errors', 1);
 
  # Формируем ссылку для запроса 
  $link = 'app.salesap.ru/api/v1/orders';
  $curl = curl_init(); #Сохраняем дескриптор сеанса cURL
  $token = 'тут должен быть ваш токен';

  #Устанавливаем необходимые опции для сеанса cURL
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_URL, $link);
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET'); 


  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/vnd.api+json','Authorization: Bearer '.$token));

  curl_setopt($curl, CURLOPT_HEADER, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

  $out = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
  $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

  /**
   * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
   * нам придётся перевести ответ в формат, понятный PHP
   */

  $Response=json_decode($out,true);
  print_r($Response);
?>
