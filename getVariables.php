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

// Fungsi untuk mendapatkan data variabel dari API
function getVariables($subject_id) {
    // URL API yang sesuai
    $url = "https://webapi.bps.go.id/v1/api/list/model/var/lang/ind/domain/1100/subject/{$subject_id}/key/effe4127b3a3d38d7fd0cb539852779c/";

    // Ambil data dari API
    $data = getData($url);

    // Cek apakah data ditemukan
    if (isset($data['status']) && $data['status'] == 'OK') {
        // Buat dropdown
        echo '<select id="variableDropdown" class="form-select">';
        echo '<option value="">Pilih Variabel</option>';

        // Looping data variabel
        foreach ($data['data'][1] as $variable) {
            echo '<option value="' . $variable['var_id'] . '">' . $variable['title'] . '</option>';
        }

        // Tutup dropdown
        echo '</select>';
    } else {
        echo 'Tidak ada data variabel ditemukan.';
    }
}

// Panggil fungsi untuk mendapatkan data variabel
$subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : '';
getVariables($subject_id);
?>