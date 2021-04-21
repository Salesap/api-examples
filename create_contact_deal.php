<?php

#
# скрипт создает контакт, потом создает сделку и привязывает ее к ранее созданному контакту, а также к создаваемой сделке привязывает этап воронки.
# пропишите свой token и id своей этапа воронки.
#

# связи сделок https://api.salesap.ru/#deals-relationships19

error_reporting(E_ALL);
ini_set('display_errors', 1);

$contact = array(
  'data' => array(
    'type' => 'contacts',
    'attributes' => array(
      'first-name' => 'Иван',
      'last-name' => 'Петрович',
      'mobile-phone' => '79998877857'
    )
  )
);

$responseContact = sendToSalesap('contacts', $contact);

$deal = array(
  'data' => array(
    'type' => 'deals',
    'attributes' => array(
      'name' => 'Сделка',
    ),
    'relationships' => array(
      'contacts' => array(
        'data' => array(
          array(
            'type' => 'contacts',
            'id' => $responseContact['data']['id']
          )
        )
      ),
      'stage' => array(
        'data' => array(
          'type' => 'deal-stages',
          'id' => '2' # Укажите id своего этапа воронки
        )
      )
    )
  )
);

sendToSalesap('deals', $deal);

function sendToSalesap($entityType, $data) {
  $curl = curl_init();
  $url = "https://app.salesap.ru/api/v1/$entityType";

  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/vnd.api+json','Authorization: Bearer 444444fa4444441dd9ee444444f3186c8444444418e4444448a52ca6444444'));
  curl_setopt($curl, CURLOPT_HEADER, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

  $out = curl_exec($curl);
  $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

  echo $out;
  $response = json_decode($out, true);

  return $response;
}
