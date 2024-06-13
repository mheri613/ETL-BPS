<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://satudata.latih.id/api/v1.1/datasets/list/?limit=10&page=0&search=Ta',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'APIKEY: $2b$10$4jCwY.APF2.mEbByX.koJ.QEISLmaaUWx7Z3jtlcOFbS.QN7ucda.'
    ),
));

$response = curl_exec($curl);

curl_close($curl);
// print_r ($response);
echo "<script>console.log($response);</script>";


