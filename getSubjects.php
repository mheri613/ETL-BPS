<?php
// Fungsi untuk mendapatkan data dari API
function getData($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $response = json_decode(curl_exec($ch), true);
    curl_close($ch);
    return $response;
}

// Fungsi untuk mendapatkan data subjek dari API
function getSubjects($subcat_id, $apiUrlInput, $apiKeyInput) {
    // URL API yang sesuai
    $url = "$apiUrlInput/v1/api/list/model/subject/lang/ind/domain/1100/subcat/{$subcat_id}/key/$apiKeyInput/";

    // Ambil data dari API
    $data = getData($url);

    // Cek apakah data ditemukan
    // if (isset($data['status']) && $data['status'] == 'OK') {
    //     // Buat dropdown
    //     echo '<select id="subjectDropdown" class="form-select">';
    //     echo '<option value="">Pilih Subjek</option>';

    //     // Looping data subjek
    //     foreach ($data['data'][1] as $subjek) {
    //         echo '<option value="' . $subjek['sub_id'] . '">' . $subjek['title'] . '</option>';
    //     }

    //     // Tutup dropdown
    //     echo '</select>';
    // } else {
    //     echo 'Tidak ada data subjek ditemukan.';
    // }

    if (isset($data['status']) && $data['status'] == 'OK') {
        echo json_encode(array('success' => true, 'data' => $data['data'][1]));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Tidak ada data subjek ditemukan.'));
    }
}

// Panggil fungsi untuk mendapatkan data subjek
$subcat_id = isset($_GET['subcat_id']) ? $_GET['subcat_id'] : '';
$apiUrlInput = isset($_GET['apiUrlInput']) ? $_GET['apiUrlInput'] : '';
$apiKeyInput = isset($_GET['apiKeyInput']) ? $_GET['apiKeyInput'] : '';
getSubjects($subcat_id, $apiUrlInput, $apiKeyInput);
?>