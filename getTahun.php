<?php

    $curl = curl_init($apiUrl);

    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTPHEADER => [$apiKey],
    ]);

    $response = curl_exec($curl);
    console.log($response);
    curl_close($curl);
    echo $response;
?>
