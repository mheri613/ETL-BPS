<?php

// Fungsi untuk melakukan request ke API dan mendapatkan data JSON
function getData($url) {
    $ch = curl_init($url); // Inisialisasi curl
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Set opsi curl
    $response = json_decode(curl_exec($ch)); // Eksekusi curl dan parsing respons JSON
    curl_close($ch); // Tutup curl
    // Set status sukses atau tidak
    $result['success'] = $response->status;
    // Jika respons sukses, simpan data
    if ($response->status) {
        $result['data'] = $response->data;
    } else {
        $result['data'] = $response->error;
    }

    // if ($result['success'] && isset($result['data'][1])){
    //     foreach ($result['data'][1] as $subcategory){
    //         echo "<option value=$subcategory->subcat_id>$subcategory->title </option>";
    //     }
    // } else {
    //     echo '<option value="" disabled>Tidak ada data subkategori</option>';
    // }

    header('Content-Type: application/json');

    if ($result['success'] && isset($result['data'][1])) {
        echo json_encode(array('success' => true, 'data' => $result['data'][1]));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Tidak ada data subkategori'));
    }
}

// Fungsi untuk mendapatkan data subkategori dari API
function getSubcategories($apiUrlInput, $apiKeyInput) {
    $url = "$apiUrlInput/v1/api/list/model/subcat/lang/ind/domain/1100/key/$apiKeyInput/";
    return getData($url);
}

// Fungsi untuk mendapatkan data subjek berdasarkan subkategori dari API
// function getSubjects($subcat_id = null) {
//     if ($subcat_id !== null) {
//         $url = "https://webapi.bps.go.id/v1/api/list/model/subject/lang/ind/domain/1100/subcat/{$subcat_id}/key/effe4127b3a3d38d7fd0cb539852779c/";
//     } else {
//         $url = "https://webapi.bps.go.id/v1/api/list/model/subject/lang/ind/domain/1100/key/effe4127b3a3d38d7fd0cb539852779c/";
//     }
//     return getData($url);
// }

// // Fungsi untuk mendapatkan data variabel berdasarkan subjek dari API
// function getVariables($subject_id = null) {
//     if ($subject_id !== null) {
//         $url = "https://webapi.bps.go.id/v1/api/list/model/data/lang/ind/domain/1100/var/{$var_id}/key/effe4127b3a3d38d7fd0cb539852779c/";
//     } else {
//         $url = "https://webapi.bps.go.id/v1/api/list/model/var/lang/ind/domain/1100/key/effe4127b3a3d38d7fd0cb539852779c/";
//     }
//     return getData($url);
// }

// // Fungsi untuk mendapatkan data tabel berdasarkan variabel dari API
// function getTableData($var_id = null) {
//     if ($var_id !== null) {
//         $url = "https://webapi.bps.go.id/v1/api/list/model/var/lang/ind/domain/1100/var/{$var_id}/key/effe4127b3a3d38d7fd0cb539852779c/";
//     } else {
//         $url = "https://webapi.bps.go.id/v1/api/list/model/var/lang/ind/domain/1100/key/effe4127b3a3d38d7fd0cb539852779c/";
//     }
//     return getData($url);
// }

$apiUrlInput = isset($_GET['apiUrlInput']) ? $_GET['apiUrlInput'] : '';
$apiKeyInput = isset($_GET['apiKeyInput']) ? $_GET['apiKeyInput'] : '';
getSubcategories($apiUrlInput, $apiKeyInput)

?>

