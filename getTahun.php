<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://satudata.latih.id/api/v1.1/datasets/list',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'APIKEY: 2b$10$4jCwY.APF2.mEbByX.koJ.QEISLmaaUWx7Z3jtlcOFbS.QN7ucda.' //Ganti dengan API key Anda yang sebenarnya
    ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
?>
