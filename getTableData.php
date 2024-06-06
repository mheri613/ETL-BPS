<?php
// Fungsi untuk mendapatkan data tabel berdasarkan variabel
function getTableData($apiUrlInput, $apiKeyInput, $var_id = null) {
    if ($var_id !== null) {
        $url = "$apiUrlInput/v1/api/list/model/data/lang/ind/domain/1100/var/{$var_id}/key/$apiKeyInput/";
    } else {
        $url = "$apiUrlInput/v1/api/list/model/var/lang/ind/domain/1100/key/$apiKeyInput/";
    }
    return getData($url);
}

function getData($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = json_decode(curl_exec($ch), true);
    curl_close($ch);
    return $response;
}

$apiUrlInput = isset($_GET['apiUrlInput']) ? $_GET['apiUrlInput'] : '';
$apiKeyInput = isset($_GET['apiKeyInput']) ? $_GET['apiKeyInput'] : '';
// Panggil fungsi untuk mendapatkan data tabel
$tableData = getTableData($apiUrlInput, $apiKeyInput, $_GET['var_id']);

// Keluarkan data dalam format JSON
echo json_encode($tableData);
?>
