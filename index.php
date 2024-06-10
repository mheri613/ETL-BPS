<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ETL BPS</title>
    <!-- Bootstrap CSS dari CDN -->
    <link rel="shortcut icon" type="image/png" href="data/icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </div>
    <div class="container-fluid">
        <ul class="nav nav-underline ms-auto">
            <li class="nav-item">
                <a class="nav-link text-white fs-6 active" id="proses-tab" data-bs-toggle="tab" data-bs-target="#proses" type="button" role="tab" aria-controls="proses" aria-selected="true"><i class="bi bi-list"></i> ETL-Proces</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white fs-6" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true"><i class="bi bi-info-circle-fill"></i> Info</a>
            </li>
        </ul>
        <!-- <a class="navbar-brand text-white fs-6 ms-auto" href="">ETL-process</a>
        <a class="navbar-brand text-white fs-6" href="">ETL-info</a> -->
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
                    <!-- Form API URL dan Dropdown Subkategori (Row 1) -->
                    <div class="row mb-3">
                        <div class="col-4">
                        <label for="apiUrlInput" class="form-label">API URL:</label>
                            <!-- Formulir input untuk API URL -->
                            <input type="text" class="form-control" id="apiUrlInput" placeholder="Enter API URL">
                        </div>
                        <div class="col-3">
                            <label for="subcatDropdown" class="form-label">Filter Subkategori:</label>
                            <select id="subcatDropdown" class="form-select">
                                <option value="">Pilih Subkategori</option>
                                <?php if ($subcategoriesData['success'] && isset($subcategoriesData['data'][1])): ?>
                                    <?php foreach ($subcategoriesData['data'][1] as $subcategory): ?>
                                        <option value="<?= $subcategory->subcat_id ?>"><?= $subcategory->title ?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="" disabled>Tidak ada data subkategori</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="variableDropdown" class="form-label">Filter Variabel:</label>
                            <select id="variableDropdown" class="form-select">
                                <option value="">Pilih Variabel</option>
                                <!-- Variabel akan ditambahkan melalui Ajax setelah subjek dipilih -->
                            </select>
                        </div>
                    </div>
                    <!-- Form API Key dan Dropdown Subjek (Row 2) -->
                    <div class="w-100"></div>
                    <div class="row mb-3">
                        <div class="col-4">
                        <label for="apiKeyInput" class="form-label">API Key:</label>
                            <!-- Formulir input untuk API Key -->
                            <input type="text" class="form-control" id="apiKeyInput" placeholder="Enter API Key">
                        </div>
                        <div class="col-6">
                            <label for="subjectDropdown" class="form-label">Filter Subjek:</label>
                            <select id="subjectDropdown" class="form-select">
                                <option value="">Pilih Subjek</option>
                                <!-- Subjek akan ditambahkan melalui Ajax setelah subkategori dipilih -->
                            </select>
                        </div>

                    </div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-2" id="myTab" role="tablist">
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
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- Tab panel 1: Extract -->
                        <div class="tab-pane fade show active" id="extract" role="tabpanel" aria-labelledby="extract-tab">
                            <div class="card mb-3">
                                <h5 class="card-header bg-dark text-white">Tabel Dinamis - Extract</h5>
                                <div class="card-body">
                                    <div class='col'>
                                        <div id='tabledata' class='table-responsive'></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Tab panel 2: Transform -->
                        <div class="tab-pane fade" id="transform" role="tabpanel" aria-labelledby="transform-tab">
                        <div class="row mb-3">
                                <div class="col-lg-3 col-md-auto col-sm-12">
                                    <h5 class="text" style="color: black;">URL SatuData</h5>
                                    <input class="form-control" type="text" placeholder="Ketik URL" aria-label="default input example">
                
                                    <!-- Ajax loader -->
                                    <div id="loader" class="spinner-border text-info" role="status" style="display: none;">
                                            <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-auto col-sm-12">
                                    <h5 class="text" style="color: black;">Key App SatuData</h5>
                                    <input class="form-control" type="text" placeholder="Ketik Key App" aria-label="default input example">
                
                                    <!-- Ajax loader -->
                                    <div id="loader" class="spinner-border text-info" role="status" style="display: none;">
                                            <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-auto col-sm-12">
                                    <h5 class="text" style="color: black;">Tahun SatuData</h5>
                                    <input class="form-control" type="text" placeholder="2023" aria-label="default input example" disabled>
                
                                    <!-- Ajax loader -->
                                    <div id="loader" class="spinner-border text-info" role="status" style="display: none;">
                                            <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-auto col-sm-12 mt-2">
                                    <h5 class="text" style="color: black;">Cari Dataset SatuData</h5>
                                    <form class="d-flex" role="search">
                                    <input type="search" class="form-control" placeholder="Search"  aria-label="Search" aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2"><i class="bi bi-search"></i></span>
                                        <!-- <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"> -->
                                        <button class="btn btn-primary" class="bi bi-search" type="submit">Find</button>
                                    </form>
                
                                    <!-- Ajax loader -->
                                    <div id="loader" class="spinner-border text-info" role="status" style="display: none;">
                                            <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            <div class="row mt-3">
                                <!-- Kolom pertama: Form Configure -->
                                <div class="col-lg-3 col-md-auto col-sm-12">
                                    <div class="card mb-3">
                                        <h5 class="card-header bg-dark text-white">Select Configure</h5>
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
                                <!-- Kolom ketiga: Form Result id -->
                                <div class="col-lg-3 col-md-auto col-sm-12">
                                    <div class="card mb-3">
                                        <h5 class="card-header bg-dark text-white">Result</h5>
                                        <div class="card-body">
                                            <form id="filterForm1">
                                                <div class="mb-2">
                                                    <label for="filterInput" class="form-label multiple">Filter :</label>
                                                    <select class="form-select" id="selectTo" multiple>
                                                    </select>
                                                    <button type="submit" class="btn btn-primary mb-2">Apply Filter</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-auto col-sm-12 align-self-center text-center">
                                    <div class="mb-2">
                                        <button type="button" id="" class="btn btn-primary">Match</button>
                                    </div>
                                </div>
                                
                                <div class="col-lg-3 col-md-auto col-sm-12">
                                    <div class="card mb-3">
                                        <h5 class="card-header bg-dark text-white">Result</h5>
                                        <div class="card-body">
                                            <form id="filterForm1">
                                                <div class="mb-2">
                                                    <label for="filterInput" class="form-label multiple">Filter :</label>
                                                    <select class="form-select" id="selectTo" multiple>
                                                    </select>
                                                    <button type="submit" class="btn btn-primary mb-2">Apply Filter</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tab panel 3: Load -->
                    <div class="tab-pane fade" id="load" role="tabpanel" aria-labelledby="load-tab">
                            <div class="card mb-3">
                                <h5 class="card-header bg-dark text-white">Tabel Dinamis - Load</h5>
                                <div class="card-body">
                                    <div class='col'>
                                        <div id='loadTabledata' class='table-responsive'>
                                            <!-- Konten yang akan dimuat ke dalam tab Load -->
                                            <!-- Misalnya, tabel atau konten lain -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal fade" id="loadingModal" tabindex="-1" aria-labelledby="loadingModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content">
                            <div class="modal-body text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2">Loading...</p>
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

<script>
    // Script Ajax dengan menggunakan jQuery
    

    $(document).ready(function() {
        var apiKeyInput = $('#apiKeyInput');
        var apiUrlInput = $('#apiUrlInput');

        apiKeyInput.change(function(){
            setTimeout(() => {
                inputApiURL()
            }, 1000);
        })

        apiUrlInput.change(function(){
            setTimeout(() => {
                inputApiURL()
            }, 1000);
        })
        
        function inputApiURL(){
            var apiKeyInput = $('#apiKeyInput').val();
            var apiUrlInput = $('#apiUrlInput').val();
            
            showLoadingModal();
            
            $.ajax({
                url: "getSubCategory.php",
                type: "GET",
                data: { apiKeyInput: apiKeyInput, apiUrlInput: apiUrlInput },
                dataType: "json",
                success: function(response) {
                    // $('#subcatDropdown').html(response);
                    $('#subcatDropdown').empty();

                    if (response.success) {
                        // Tambahkan opsi default
                        $('#subcatDropdown').append('<option value="">Pilih Subkategori</option>');
                        
                        // Loop melalui data dan tambahkan setiap subkategori sebagai opsi
                        $.each(response.data, function(index, subcategory) {
                            $('#subcatDropdown').append(
                                '<option value="' + subcategory.subcat_id + '">' + subcategory.title + '</option>'
                            );
                        });
                    } else {
                        // Tampilkan pesan jika tidak ada data
                        $('#subcatDropdown').append('<option value="" disabled>Tidak ada data subkategori</option>');
                    }

                    hideLoadingModal();
                },
                error: function(xhr, status, error) {
                    console.error("Gagal mengambil data subjek:", error);
                    hideLoadingModal();
                }
            });
        }

        $('#moveRight').click(function() {
            $('#selectFrom option:selected').appendTo('#selectTo');
        });

        $('#moveLeft').click(function() {
            $('#selectTo option:selected').appendTo('#selectFrom');
        });

        // Fungsi untuk menampilkan modal
        function showLoadingModal() {
            $('#loadingModal').modal('show');
        }

        // Fungsi untuk menyembunyikan modal
        function hideLoadingModal() {
            $('#loadingModal').modal('hide');
        }

        // Ketika dropdown subkategori dipilih
        $('#subcatDropdown').change(function() {
            var selectedSubcat = $(this).val();
            var apiKeyInput = $('#apiKeyInput').val();
            var apiUrlInput = $('#apiUrlInput').val();
            
            showLoadingModal();
            $.ajax({
                url: "getSubjects.php",
                type: "GET",
                data: { subcat_id: selectedSubcat, apiKeyInput: apiKeyInput, apiUrlInput: apiUrlInput },
                dataType: "json",
                success: function(response) {
                    // $('#subjectDropdown').html(response);
                    // Pastikan dropdown kosong sebelum menambahkan opsi baru
                    $('#subjectDropdown').empty();
                    
                    if (response.success) {
                        // Tambahkan opsi default
                        $('#subjectDropdown').append('<option value="">Pilih Subjek</option>');
                        
                        // Loop melalui data dan tambahkan setiap subjek sebagai opsi
                        $.each(response.data, function(index, subjek) {
                            $('#subjectDropdown').append(
                                '<option value="' + subjek.sub_id + '">' + subjek.title + '</option>'
                            );
                        });
                    } else {
                        // Tampilkan pesan jika tidak ada data
                        $('#subjectDropdown').append('<option value="" disabled>Tidak ada data subjek ditemukan</option>');
                    }

                    hideLoadingModal();
                },
                error: function(xhr, status, error) {
                    console.error("Gagal mengambil data subjek:", error);
                    hideLoadingModal();
                }
            });
        });

        // Ketika dropdown subjek dipilih
        $(document).on('change', '#subjectDropdown', function() {
            var selectedSubject = $(this).val();
            var apiKeyInput = $('#apiKeyInput').val();
            var apiUrlInput = $('#apiUrlInput').val();
            showLoadingModal();
            $.ajax({
                url: "getVariables.php",
                type: "GET",
                data: { subject_id: selectedSubject, apiKeyInput: apiKeyInput, apiUrlInput: apiUrlInput },
                dataType: "json",
                success: function(response) {
                    // $('#variableDropdown').html(response);

                    $('#variableDropdown').empty();
        
                    if (response.success) {
                        // Tambahkan opsi default
                        $('#variableDropdown').append('<option value="">Pilih Variabel</option>');
                        
                        // Loop melalui data dan tambahkan setiap variabel sebagai opsi
                        $.each(response.data, function(index, variable) {
                            $('#variableDropdown').append(
                                '<option value="' + variable.var_id + '">' + variable.title + '</option>'
                            );
                        });
                    } else {
                        // Tampilkan pesan jika tidak ada data
                        $('#variableDropdown').append('<option value="" disabled>Tidak ada data variabel ditemukan</option>');
                    }


                    hideLoadingModal();
                },
                error: function(xhr, status, error) {
                    console.error("Gagal mengambil data variabel:", error);
                    hideLoadingModal();
                }
            });
        });

        // Ketika dropdown variabel dipilih
        $(document).on('change', '#variableDropdown', function() {
            var selectedVar = $(this).val();
            var apiKeyInput = $('#apiKeyInput').val();
            var apiUrlInput = $('#apiUrlInput').val();
            showLoadingModal();
            $.ajax({
                url: "getTableData.php",
                type: "GET",
                data: { var_id: selectedVar, apiKeyInput: apiKeyInput, apiUrlInput: apiUrlInput },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    // $('#tabledata').html(response);

                    $('#tabledata').empty();

                    if (response.success) {
                        let tableHtml = "<table class='table table-bordered'>";
                        tableHtml += "<thead>";
                        tableHtml += "<tr>";
                        tableHtml += "<th scope='col'>Wilayah</th>";
                        tableHtml += "<th scope='col'>Tahun</th>";
                        tableHtml += "<th scope='col'>Jumlah</th>";
                        tableHtml += "<th scope='col'>Satuan</th>";
                        tableHtml += "</tr>";
                        tableHtml += "</thead>";
                        tableHtml += "<tbody>";

                        // Looping data tabel
                        $.each(response.data, function(key, value) {
                            if (value !== null && value !== '') {
                                // Ambil kode wilayah dan tahun dari kunci data
                                // let wilayah_kode = key.substr(0, 4);
                                // let tahun_kode = key.substr(7, 3); // Ambil tiga karakter berikutnya sebagai tahun

                                // Cari label wilayah dan tahun berdasarkan kode
                                let wilayah_label = "";
                                $.each(response.vervar, function(index, wilayah) {
                                    if (key.includes(wilayah.val)) {
                                        wilayah_label = wilayah.label;
                                        return false; // break loop
                                    }
                                });

                                let tahun_label = "";
                                $.each(response.tahun, function(index, tahun) {
                                    if (key.includes(tahun.val)) {
                                        tahun_label = tahun.label;
                                        return false; // break loop
                                    }
                                });

                                // Ambil unit (satuan) dari variabel
                                let unit = "";
                                $.each(response.var, function(index, variabel) {
                                    if (key.includes(variabel.val)) {
                                        unit = variabel.unit;
                                        return false; // break loop
                                    }
                                });

                                tableHtml += "<tr>";
                                tableHtml += "<td>" + wilayah_label + "</td>";
                                tableHtml += "<td>" + tahun_label + "</td>";
                                tableHtml += "<td>" + value + "</td>";
                                tableHtml += "<td>" + unit + "</td>";
                                tableHtml += "</tr>";
                            }
                        });

                        tableHtml += "</tbody>";
                        tableHtml += "</table>";

                        $('#tabledata').html(tableHtml);
                    } else {
                        $('#tabledata').html("<div class='alert alert-danger' role='alert'>Tidak ada data yang tersedia untuk ditampilkan.</div>");
                    }

                    hideLoadingModal();
                },
                error: function(xhr, status, error) {
                    console.error("Gagal mengambil data tabel:", error);
                    hideLoadingModal();
                }
            });
        });

        // Event saat submit formulir filter
        $('#filterForm1').submit(function(event) {
            event.preventDefault(); // Menghentikan perilaku default saat mengirim formulir
            var selectedSubject = $('#variableDropdown').find(":selected").val();
            var selectedValues = $('#selectTo option').map(function() {
                return $(this).val();
            }).get().join(',');
            // Lakukan permintaan AJAX untuk memperbarui tabel dengan filter yang diterapkan
            var apiKeyInput = $('#apiKeyInput').val();
            var apiUrlInput = $('#apiUrlInput').val();
            showLoadingModal(); // Tampilkan modal loading
            $.ajax({
                url: "updateTableWithFilter.php", // Ganti dengan URL yang sesuai untuk memperbarui tabel dengan filter
                type: "GET",
                data: { filter: selectedValues, var_id: selectedSubject, apiKeyInput: apiKeyInput, apiUrlInput: apiUrlInput }, // Sertakan nilai filter dalam data permintaan
                dataType: "json",
                success: function(response) {
                    // $('#tabledata').html(response); // Perbarui konten tabel dengan respons

                    $('#tabledata').empty();

                    if (response.success) {
                        let tableHtml = "<table class='table table-bordered'>";
                        tableHtml += "<thead>";
                        tableHtml += "<tr>";
                        if (response.filter.includes("wilayah")) {
                            tableHtml += "<th scope='col'>Wilayah</th>";
                        }
                        if (response.filter.includes("tahun")) {
                            tableHtml += "<th scope='col'>Tahun</th>";
                        }
                        if (response.filter.includes("jumlah")) {
                            tableHtml += "<th scope='col'>Jumlah</th>";
                        }
                        if (response.filter.includes("satuan")) {
                            tableHtml += "<th scope='col'>Satuan</th>";
                        }
                        tableHtml += "</tr>";
                        tableHtml += "</thead>";
                        tableHtml += "<tbody>";

                        // Looping data tabel
                        $.each(response.data, function(key, value) {
                            if (value !== null && value !== '') {
                                // Ambil kode wilayah dan tahun dari kunci data
                                let wilayah_kode = key.substr(0, 4);
                                let tahun_kode = key.substr(7, 3); // Ambil tiga karakter berikutnya sebagai tahun

                                // Cari label wilayah dan tahun berdasarkan kode
                                let wilayah_label = "";
                                let tahun_label = "";
                                $.each(response.vervar, function(index, wilayah) {
                                    if (wilayah.val == wilayah_kode) {
                                        wilayah_label = wilayah.label;
                                        return false; // break loop
                                    }
                                });
                                $.each(response.tahun, function(index, tahun) {
                                    if (tahun.val == tahun_kode) {
                                        tahun_label = tahun.label;
                                        return false; // break loop
                                    }
                                });

                                // Ambil unit (satuan) dari variabel
                                let unit = "";
                                $.each(response.var, function(index, variabel) {
                                    if (variabel.val == response.var_id) {
                                        unit = variabel.unit;
                                        return false; // break loop
                                    }
                                });

                                tableHtml += "<tr>";
                                if (response.filter.includes("wilayah")) {
                                    tableHtml += "<td>" + wilayah_label + "</td>";
                                }
                                if (response.filter.includes("tahun")) {
                                    tableHtml += "<td>" + tahun_label + "</td>";
                                }
                                if (response.filter.includes("jumlah")) {
                                    tableHtml += "<td>" + value + "</td>";
                                }
                                if (response.filter.includes("satuan")) {
                                    tableHtml += "<td>" + unit + "</td>";
                                }
                                tableHtml += "</tr>";
                            }
                        });

                        tableHtml += "</tbody>";
                        tableHtml += "</table>";

                        $('#tabledata').html(tableHtml);
                    } else {
                        $('#tabledata').html("<div class='alert alert-danger' role='alert'>Tidak ada data yang tersedia untuk ditampilkan.</div>");
                    }

                    hideLoadingModal(); // Sembunyikan modal loading setelah selesai
                },
                error: function(xhr, status, error) {
                    console.error("Gagal memperbarui tabel dengan filter:", error);
                    hideLoadingModal(); // Sembunyikan modal loading jika terjadi kesalahan
                }
            });
        });
    });
</script>

<!-- Modal Loading -->
</body>
</html>