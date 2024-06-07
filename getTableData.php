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
    $result['success'] = $response['status'];
    if ($response['status'] === 'OK') {
        $result['data'] = $response['datacontent'];
        $result['vervar'] = $response['vervar']; // tambahkan label var untuk unit (satuan)
        $result['tahun'] = $response['tahun']; // tambahkan tahun
        $result['labelvar'] = $response['labelvervar']; //tambahkan labelvar
        $result['var'] = $response['var']; // tambahkan variabel
    } else {
        $result['error'] = $response['error'];
    }
    return $result;
}

$apiUrlInput = isset($_GET['apiUrlInput']) ? $_GET['apiUrlInput'] : '';
$apiKeyInput = isset($_GET['apiKeyInput']) ? $_GET['apiKeyInput'] : '';
// Panggil fungsi untuk mendapatkan data tabel
$tableData = getTableData($apiUrlInput, $apiKeyInput, $_GET['var_id']);

// Cek apakah data berhasil didapatkan
if ($tableData['success'] && !empty($tableData['data'])) {
    $response = array(
        'success' => true,
        'data' => $tableData['data'],
        'vervar' => $tableData['vervar'],
        'tahun' => $tableData['tahun'],
        'var' => $tableData['var']
    );
    echo json_encode($response);
} else {
    echo json_encode(array('success' => false, 'message' => 'Tidak ada data yang tersedia untuk ditampilkan.'));
}

// Cek apakah data berhasil didapatkan
// if ($tableData['success'] && !empty($tableData['data'])) {
//     // Tampilkan struktur tabel hanya jika data ada
//     echo "<div class='table-responsive'>";
//     echo "<table class='table table-bordered'>";  
//     echo "<thead>";
//     echo "<tr>";
//     echo "<th scope='col'>Wilayah</th>";
//     echo "<th scope='col'>Tahun</th>";
//     echo "<th scope='col'>Jumlah</>";
//     echo "<th scope='col'>Satuan</th>";
//     echo "</tr>";
//     echo "</thead>";
//     echo "<tbody>";

//     // Tampilkan data tabelS
//     foreach ($tableData['data'] as $key => $value) {
//         if ($value !== null && $value !== '') {
//             // Ambil kode wilayah dan tahun dari kunci data
//             $wilayah_kode = substr($key, 0, 4);
//             $tahun_kode = substr($key, 7, 3); // Ambil empat karakter berikutnya sebagai tahun

//             // Cari label wilayah dan tahun berdasarkan kode
//             $wilayah_label = "";
//             $tahun_label = "";
//             if (isset($tableData['vervar'])) {
//                 foreach ($tableData['vervar'] as $wilayah) {
//                     if ($wilayah['val'] == $wilayah_kode) {
//                         $wilayah_label = $wilayah['label'];
//                         break;
//                     }
//                 }
//             }
//             if (isset($tableData['tahun'])) {
//                 foreach ($tableData['tahun'] as $tahun) {
//                     if ($tahun['val'] == $tahun_kode) {
//                         $tahun_label = $tahun['label'];
//                         break;
//                     }
//                 }
//             }

//             // Ambil unit (satuan) dari variabel
//             $unit = "";
//             if (isset($tableData['var'])) {
//                 foreach ($tableData['var'] as $var) {
//                     if ($var['val'] == $_GET['var_id']) {
//                         $unit = $var['unit'];
//                         break;
//                     }
//                 }
//             }

//             echo "<tr>";
//             echo "<td>" . $wilayah_label . "</td>";
//             echo "<td>" . $tahun_label . "</td>";
//             echo "<td>" . $value . "</td>";
//             echo "<td>" . $unit . "</td>";
//             echo "</tr>";
//         }
//     }

//     echo "</tbody>";
//     echo "</table>";
//     echo "</div>"; // tutup div .table-responsive
// } else {
//     echo "<div class='alert alert-danger' role='alert'>";
//     echo "Tidak ada data yang tersedia untuk ditampilkan.";
//     echo "</div>";
// }
?>
