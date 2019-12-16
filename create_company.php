<?php

#
# скрипт создает компанию и привязывает к ней контакт, источник, статус и тип
# пропишите свой token в константу SALESAP_TOKEN.
#

error_reporting(E_ALL);
ini_set('display_errors', 1);
define("SALESAP_TOKEN", "3a13a7f56ba817030ZZZZZZZZea349b76fe549fffZZZZZZZZZZZZZZZ");

$company = array(
  'data' => array(
    'type' => 'companies',
    'attributes' => array(
      'name' => 'Company API TEST',
      'general-phone' => '+79999999999', 
      'customs' => array(
        'custom-29013' => '2018-04-26 09:43:00'
      )
    ),
    'relationships' => array(
      'contacts' => array(
        'data' => array(
          array(
            'type' => 'contacts',
            'id' => 947677
          )
        )
      ),
      'source' => array(
        'data' => array(
          'type' => 'sources',
          'id' => 82056
        )
      ),
      'status' => array(
        'data' => array(
          'type' => 'company-statuses',
          'id' => 35796
        )
      ),
      'company-type' => array(
        'data' => array(
          'type' => 'company-types',
          'id' => 33510
        )
      ),
    )
  )
);

function sendToSalesap($entityType, $data) {
  $curl = curl_init();
  $url = "https://app.salesap.ru/api/v1/$entityType";

  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/vnd.api+json','Authorization: Bearer '.SALESAP_TOKEN));
  curl_setopt($curl, CURLOPT_HEADER, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

  $out = curl_exec($curl);
  $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  $response = json_decode($out, true);

  return $response;
}

$responseContact = sendToSalesap('companies', $company);

echo "<pre>";
print_r($responseContact);