<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ETL BPS</title>
    <!-- Bootstrap CSS dari CDN -->
    <link rel="shortcut icon" type="image/png" href="data/icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.1/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>

<?php
// Memuat fungsi-fungsi PHP dari file eksternal
// require_once 'fungsi.php';
// // Panggil fungsi untuk mendapatkan data subkategori
// $subcategoriesData = getSubcategories();
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-primary mb-3">
    <div class="container-fluid">
        <a class="navbar-brand text-white fw-bold" href="akhir.php">ETL-BPS</a>
        <ul class="nav nav-underline ms-auto">
            <li class="nav-item">
                <button class="nav-link text-white fs-6 active" id="proses-tab" data-bs-toggle="tab" data-bs-target="#proses" role="tab" aria-controls="proses" aria-selected="false"><i class="bi bi-list"></i> ETL-Proces</button>
            </li>
            <li class="nav-item">
                <button class="nav-link text-white fs-6" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" role="tab" aria-controls="info" aria-selected="false"><i class="bi bi-info-circle-fill"></i> Info</button>
            </li>
        </ul>
    </div>
</nav>


<div class="container-fluid">
    <div class="tab-content">
        <!-- Tab panel 1: Etl proses -->
        <div class="tab-pane fade show active" id="proses" role="tabpanel" aria-labelledby="proses-tab">
            <!-- Card Container -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    ETL-BPS
                </div>
                <div class="card-body">
                    <div class="row">
                    <div class="form-group col-4">
                        <label for="apiUrlInput">API URL:</label>
                        <input type="text" id="apiUrlInput" class="form-control" placeholder="Enter API URL">
                    </div>

                    <div class="form-group col-3">
                        <label for="subcatDropdown">Subcategories:</label>
                        <select id="subcatDropdown" class="form-control">
                            <option value="">Pilih Subkategori</option>
                        </select>
                    </div>

                    <div class="form-group col-3">
                        <label for="subjectDropdown">Subjects:</label>
                        <select id="subjectDropdown" class="form-control">
                            <option value="">Pilih Subjek</option>
                        </select>
                    </div>

                    <div class="form-group col-4 mt-2">
                        <label for="apiKeyInput">API Key:</label>
                        <input type="text" id="apiKeyInput" class="form-control" placeholder="Enter API Key">
                    </div>

                    <div class="form-group col-6 mt-2">
                        <label for="variableDropdown">Variables:</label>
                        <select id="variableDropdown" class="form-control">
                            <option value="">Pilih Variabel</option>
                        </select>
                    </div>
                    
                    </div>
                    <button id="loadbpsbutton" class="btn btn-primary col-2 mt-3">Load Data</button>
                </div>
                
                <div class="card-body">
                    <ul class="nav nav-tabs " id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="extract-tab" data-bs-toggle="tab" data-bs-target="#extract" type="button" role="tab" aria-controls="extract" aria-selected="true">Extract</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="transform-tab" data-bs-toggle="tab" data-bs-target="#transform" type="button" role="tab" aria-controls="transform" aria-selected="false">Transform</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="load-tab" data-bs-toggle="tab" data-bs-target="#load" type="button" role="tab" aria-controls="load" aria-selected="false">Load</button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Tab panel 1: Etl proses -->
                        <div class="tab-pane fade show active" id="extract" role="tabpanel" aria-labelledby="extract-tab">
                            <!-- Card Container -->
                            <div class="card">
                                <div class="card-header bg-dark text-white">
                                    Extract
                                </div>
                                <div id="tabledata"></div>
                                
                            </div>
                        </div>
                        <!-- Tab panel 2: Etl transform -->
                        <div class="tab-pane fade" id="transform" role="tabpanel" aria-labelledby="transform-tab">
                            <!-- Card Container -->
                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-auto col-sm-12">
                                    <h5 class="text" style="color: black;">URL SatuData</h5>
                                    <input id="apiUrlSatudata" class="form-control" type="text" placeholder="Ketik URL" aria-label="default input example">
                                </div>
                                <!-- Kolom Key App SatuData -->
                                <div class="col-lg-3 col-md-auto col-sm-12">
                                    <h5 class="text" style="color: black;">Key App SatuData</h5>
                                    <input id="apiKeySatudata" class="form-control" type="text" placeholder="Ketik Api Key" aria-label="default input example">
                                </div>
                                <div class="col-md-auto col-sm-10 align-self-center text-center">
                                    <div class="mt-4">
                                        <button type="button" id="searchData" class="btn btn-primary">search</button>
                                    </div>
                                </div>
                                <!-- Kolom Tahun SatuData -->
                                <div class="col-lg-3 col-md-auto col-sm-12">
                                    <label for="tahunDropdown">Tahun:</label>
                                    <select id="tahunDropdown" class="form-control">
                                        <option value="">Pilih Tahun</option>
                                    </select>
                                </div>


                                <!-- Kolom Cari Dataset SatuData -->
                                <div class="col-lg-4 col-md-auto col-sm-12 mt-2">
                                    <h5 class="text" style="color: black;">Cari Dataset SatuData</h5>
                                    <form id="searchForm" class="d-flex">
                                        <input id="searchInput" type="search" class="form-control" placeholder="Search" aria-label="Search">
                                        <button id="searchButton" class="btn btn-primary" type="submit">Find</button>
                                    </form>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <!-- Kolom pertama: Form Configure -->
                                <div class="col-lg-3 col-md-auto col-sm-12">
                                    <div class="card mb-3">
                                        <h5 class="card-header bg-dark text-white">Dataset result</h5>
                                        <div class="card-body">
                                            <form>
                                                <div class="mb-3">
                                                    <label for="filterInput" class="form-label multiple">Filter :</label>
                                                    <select class="form-select" id="selectFrom" multiple>
                                                        <option value="Wilayah">Wilayah</option>
                                                        <option value="Tahun">Tahun</option>
                                                        <option value="Jumlah">Jumlah</option>
                                                        <option value="Satuan">Satuan</option>
                                                    </select>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kolom kedua: Tombol navigasi -->
                                <div class="col-lg-1 col-md-auto col-sm-12 align-self-center text-center">
                                    <div class="mb-2">
                                        <button type="button" id="moveRight" class="btn btn-primary">&gt;&gt;</button>
                                    </div>
                                    <div class="mb-2">
                                        <button type="button" id="moveLeft" class="btn btn-primary">&lt;&lt;</button>
                                    </div>
                                </div>

                                <!-- Kolom ketiga: Form Result -->
                                <div class="col-lg-3 col-md-auto col-sm-12">
                                    <div class="card mb-3">
                                        <h5 class="card-header bg-dark text-white">Result</h5>
                                        <div class="card-body">
                                            <form id="filterForm1">
                                                <div class="mb-2">
                                                    <label for="filterInput" class="form-label multiple">Filter :</label>
                                                    <select class="form-select" id="selectTo1" multiple></select>
                                                    <!-- <button type="submit" class="btn btn-primary mb-2">Apply Filter</button> -->
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kolom keempat: Tombol Match -->
                                <div class="col-lg-2 col-md-auto col-sm-12 align-self-center text-center">
                                    <div class="mb-2">
                                        <button type="button" id="matchButton" class="btn btn-primary">Match</button>
                                    </div>
                                </div>

                                <!-- Kolom kelima: Form Result kedua -->
                                <div class="col-lg-3 col-md-auto col-sm-12">
                                    <div class="card mb-3">
                                        <h5 class="card-header bg-dark text-white">Result</h5>
                                        <div class="card-body">
                                            <form id="filterForm2">
                                                <div class="mb-2">
                                                    <label for="filterInput" class="form-label multiple">Filter :</label>
                                                    <select class="form-select" id="selectTo2" multiple></select>
                                                    <button type="submit" class="btn btn-primary mb-2">Apply Filter</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <!-- Tab panel 3: Etl load -->
                        <div class="tab-pane fade" id="load" role="tabpanel" aria-labelledby="load-tab">
                            <!-- Card Container -->
                            <div class="card">
                                <div class="card-header bg-dark text-white">
                                    Load
                                </div>
                                <div class="card-body">
                                    <div id="load-tabledata"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="info" role="tabpanel" aria-labelledby="info-tab">
        <div class="card">
            <div class="card-header bg-primary text-white">
                ETL-BPS
            </div>
            <div class="card-body">
                Aplikasi ETL-BPS bertujuan untuk memindahkan data dari BPS ke dalam website satudata dengan mencocokkan struktur data antara bps dan satudata sehingga data dari bps dapat dikirim ke satu data.
            </div>    
        </div>
    </div>

    </div>
</div>
<!-- Loading Spinner -->
<div id="loadingSpinner" class="d-none position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-white bg-opacity-75">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>


<footer class="container-fluid py-5 my-5 border-top bg-secondary ">
        <div class="row row-cols-1 row-cols-md-5">
            <div class="col-lg-3 col-md-auto mb-3">
                <h5 class="text-dark"><i class="bi bi-globe"></i> ETL - PROFILKES </h5>
            </div>

            <div class="col-lg-3 col-md-auto mb-3">
                <h5>Link Website</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">OpenData</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">SatuData</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">GeoPortal</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Pintu</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-auto mb-3">
                <h5>Kontak Kami</h5>
                <ul class="nav flex-column">
                    <li class="nav-item"><p>UPTD Statistik Diskominsa Aceh</p></li>
                    <li class="nav-item"><p>Gedung Sentra Telematika Aceh Jl. Teungku Cot Plieng No.48, Kota Baru, Kec. Kuta Alam, Kota Banda Aceh</p></li>
                </ul>
            </div>

            <div class="col-md-auto"></div>
            <div class="col-md-auto"></div>
        </div>
</footer>    
<div class="fixed-bottom text-light bg-dark py-2 margin-center">
    Dikelola oleh UPTD Statistik Diskominsa Aceh
</div>
<!-- Bootstrap JS dari CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery dari CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS dari CDN -->
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>


<script>
$(document).ready(function() {
    var apiKeyInput = $('#apiKeyInput');
    var apiUrlInput = $('#apiUrlInput');

    $('#loadbpsbutton').click(function() {
        inputApiURL();
    });

    function inputApiURL() {
        var apiKey = apiKeyInput.val();
        var apiUrl = apiUrlInput.val();

        $.ajax({
            url: "getSubCategory.php",
            type: "GET",
            data: { apiKeyInput: apiKey, apiUrlInput: apiUrl },
            dataType: "json",
            success: function(response) {
                $('#subcatDropdown').empty();

                if (response.success) {
                    $('#subcatDropdown').append('<option value="">Pilih Subkategori</option>');
                    $.each(response.data, function(index, subcategory) {
                        $('#subcatDropdown').append(
                            '<option value="' + subcategory.subcat_id + '">' + subcategory.title + '</option>'
                        );
                    });
                } else {
                    $('#subcatDropdown').append('<option value="" disabled>Tidak ada data subkategori</option>');
                }
            },
            error: function(xhr, status, error) {
                console.error("Gagal mengambil data subkategori:", error);
            }
        });
    }

    $('#subcatDropdown').change(function() {
        var selectedSubcat = $(this).val();
        var apiKey = apiKeyInput.val();
        var apiUrl = apiUrlInput.val();

        $.ajax({
            url: "getSubjects.php",
            type: "GET",
            data: { subcat_id: selectedSubcat, apiKeyInput: apiKey, apiUrlInput: apiUrl },
            dataType: "json",
            success: function(response) {
                $('#subjectDropdown').empty();

                if (response.success) {
                    $('#subjectDropdown').append('<option value="">Pilih Subjek</option>');
                    $.each(response.data, function(index, subjek) {
                        $('#subjectDropdown').append(
                            '<option value="' + subjek.sub_id + '">' + subjek.title + '</option>'
                        );
                    });
                } else {
                    $('#subjectDropdown').append('<option value="" disabled>Tidak ada data subjek ditemukan</option>');
                }
            },
            error: function(xhr, status, error) {
                console.error("Gagal mengambil data subjek:", error);
            }
        });
    });

    $('#subjectDropdown').change(function() {
        var selectedSubject = $(this).val();
        var apiKey = apiKeyInput.val();
        var apiUrl = apiUrlInput.val();

        $.ajax({
            url: "getVariables.php",
            type: "GET",
            data: { subject_id: selectedSubject, apiKeyInput: apiKey, apiUrlInput: apiUrl },
            dataType: "json",
            success: function(response) {
                $('#variableDropdown').empty();

                if (response.success) {
                    $('#variableDropdown').append('<option value="">Pilih Variabel</option>');
                    $.each(response.data, function(index, variable) {
                        $('#variableDropdown').append(
                            '<option value="' + variable.var_id + '">' + variable.title + '</option>'
                        );
                    });
                } else {
                    $('#variableDropdown').append('<option value="" disabled>Tidak ada data variabel ditemukan</option>');
                }
            },
            error: function(xhr, status, error) {
                console.error("Gagal mengambil data variabel:", error);
            }
        });
    });

    $('#variableDropdown').change(function() {
        var selectedVar = $(this).val();
        var apiKeyInput = $('#apiKeyInput').val();
        var apiUrlInput = $('#apiUrlInput').val();
        
        $.ajax({
            url: "getTableData.php",
            type: "GET",
            data: { var_id: selectedVar, apiKeyInput: apiKeyInput, apiUrlInput: apiUrlInput },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $('#tabledata').empty();

                if (response.success) {
                    // Create the table element
                    let tableHtml = "<table id='dataTable' class='table table-striped'></table>";
                    $('#tabledata').html(tableHtml);

                    // Format the data for DataTables
                    let dataSet = [];
                    $.each(response.data, function(key, value) {
                        if (value !== null && value !== '') {
                            let wilayah_label = "";
                            let tahun_label = "";
                            let unit = "";

                            $.each(response.vervar, function(index, wilayah) {
                                if (key.includes(wilayah.val)) {
                                    wilayah_label = wilayah.label;
                                    return false; // break loop
                                }
                            });

                            $.each(response.tahun, function(index, tahun) {
                                if (key.includes(tahun.val)) {
                                    tahun_label = tahun.label;
                                    return false; // break loop
                                }
                            });

                            $.each(response.var, function(index, variabel) {
                                if (key.includes(variabel.val)) {
                                    unit = variabel.unit;
                                    return false; // break loop
                                }
                            });

                            dataSet.push([wilayah_label, tahun_label, value, unit]);
                        }
                    });

                    // Initialize DataTables
                    $('#dataTable').DataTable({
                        data: dataSet,
                        columns: [
                            { title: "Wilayah" },
                            { title: "Tahun" },
                            { title: "Jumlah" },
                            { title: "Satuan" }
                        ],
                        paging: false,
                        scrollCollapse: true,
                        scrollY: '50vh',
                        searching: false,
                    });
                } else {
                    alert("Tidak ada data yang tersedia untuk ditampilkan.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Gagal mengambil data tabel:", error);
            }
        });
    });

    $('#searchData').click(function() {
    inputApiURLForTahun();
    });

    function inputApiURLForTahun() {
        var apiKey = $('#apiKeySatudata').val();
        var apiUrl = $('#apiUrlSatudata').val();

        console.log("API Key:", apiKey);
        console.log("API URL:", apiUrl);

        $.ajax({
            url: "getTahun.php",
            type: "GET",
            data: { apiKey, apiUrl },
            dataType: "json",
            success: function(response) {
                console.log(response);
            //     $('#tahunDropdown').empty();

            //     if (response.success) {
            //         $('#tahunDropdown').append('<option value="">Pilih Tahun</option>');
            //         $.each(response.data, function(index, tahun) {
            //             $('#tahunDropdown').append(
            //                 '<option value="' + tahun + '">' + tahun + '</option>'
            //             );
            //         });
            //     } else {
            //         $('#tahunDropdown').append('<option value="" disabled>Tidak ada data tahun</option>');
            //     }
            // },
            // error: function(xhr, status, error) {
            //     console.error("Gagal mengambil data tahun:", error);
            // }
        });
    }


    // Global AJAX event handlers
    $(document).ajaxStart(function() {
        $('#loadingSpinner').removeClass('d-none');
    });

    $(document).ajaxComplete(function() {
        $('#loadingSpinner').addClass('d-none');
    });
});

</script>

</body>
</html>