<?php

  error_reporting(E_ALL);
  ini_set('display_errors', 1);


  # обновит контакт (имя, телефон, почту, установит статус и привяжет две компании)
  $contact = array(
    'data' => array(
      'type' => 'contacts',
      'id' => 1234567
      'attributes' => array(
	'first-name' => 'новое_имя',
        'general-phone' => '+79999999991',
        'email' => 's2tests2@salesap.ru'
      ),
      "relationships" => array(
        "status" => array(
          "data" => array(
            "type" => "statuses",
            "id" => 63325
          )
        ),
       "companies" => array(
          "data" => array(
            array(
              "type"=>"companies", 
              "id"=>123
            ),
            array(
              "type"=>"companies",
              "id"=>124
            ) 
          )
        )
      )
    )
  );	

  #Формируем ссылку для запроса
  $link = 'https://app.salesap.ru/api/v1/contacts/1234567';
  $curl = curl_init();  

  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_URL, $link);
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
  curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($contact));
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/vnd.api+json','Authorization: Bearer ВАШ_ТОКЕН'));
  curl_setopt($curl, CURLOPT_HEADER, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

  $out = curl_exec($curl);  
  $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);


  /**
   * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
   * нам придётся перевести ответ в формат, понятный PHP
   */
  $Response=json_decode($out,true);

  print_r($Response);
