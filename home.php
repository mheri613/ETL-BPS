<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ETL BPS</title>
    <!-- Bootstrap CSS dari CDN -->
    <link rel="shortcut icon" type="image/png" href="icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
// Memuat fungsi-fungsi PHP dari file eksternal
require_once 'fungsi.php';
// Panggil fungsi untuk mendapatkan data subkategori
$subcategoriesData = getSubcategories();
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-primary mb-3">
    <div class="container-fluid">
        <a class="navbar-brand text-white fw-bold" href="akhir.php">ETL-BPS</a>
    </div>
    <div class="container-fluid">
        <a class="navbar-brand text-white ms-auto" href="">ETL-process</a>
        <a class="navbar-brand text-white" href="">ETL-info</a>
    </div>
</nav>

<div class="container-fluid">
    <!-- Dropdown Subkategori -->
    <?php if ($subcategoriesData['success'] && isset($subcategoriesData['data'][1])): ?>
        <div class="row mb-3">
            <div class="col">
                <label for="subcatDropdown" class="form-label">Filter:</label>
                <select id="subcatDropdown" class="form-select">
                    <option value="">Pilih Subkategori</option>
                    <?php foreach ($subcategoriesData['data'][1] as $subcategory): ?>
                        <option value="<?= $subcategory->subcat_id ?>"><?= $subcategory->title ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <!-- Placeholder Dropdown Subjek dan Variabel -->
        <div class="row mb-3">
            <div class="col" id="subjectDropdownPlaceholder"></div>
        </div>
        <div class="row mb-3">
            <div class="col" id="variableDropdownPlaceholder"></div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger" role="alert">
            Gagal mengambil data dari API atau tidak ada data yang ditemukan.
        </div>
    <?php endif; ?>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs mb-2" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="extract-tab" data-bs-toggle="tab" data-bs-target="#extract" type="button" role="tab" aria-controls="extract" aria-selected="true">Extract</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="transform-tab" data-bs-toggle="tab" data-bs-target="#transform" type="button" role="tab" aria-controls="transform" aria-selected="false">Transform</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="load-tab" data-bs-toggle="tab" data-bs-target="#Load" type="button" role="tab" aria-controls="load" aria-selected="false">Load</button>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Tab panel 1: Tabel Data -->
        <div class="tab-pane fade show active" id="extract" role="tabpanel" aria-labelledby="extract-tab">
            <div class="card mb-3">
                <h5 class="card-header bg-dark text-white">Tabel Dinamis</h5>
                <div class="card-body">
                    <div class='col'>
                        <div id='tabledata' class='table-responsive'></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab panel 2: Configure Table -->
        <div class="tab-pane fade" id="transform" role="tabpanel" aria-labelledby="transform-tab">
            <div class="row">
                <!-- Kolom pertama: Form Configure -->
                <div class="col-lg-5 col-md-auto col-sm-12">
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
                </div> <!-- col-lg-5 -->

                <!-- Kolom kedua: Tombol navigasi -->
                <div class="col-lg-2 col-md-auto col-sm-12 align-self-center text-center">
                    <div class="mb-2">
                        <button type="button" id="moveRight" class="btn btn-primary">&gt;&gt;</button>
                    </div>
                    <div class="mb-2">
                        <button type="button" id="moveLeft" class="btn btn-primary">&lt;&lt;</button>
                    </div>
                </div> <!-- col-lg-2 -->

                <!-- Kolom ketiga: Form Result id -->
                <div class="col-lg-5 col-md-auto col-sm-12">
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
                </div> <!-- col-lg-5 -->
            </div> <!-- row -->
        </div> <!-- tab-pane -->
        
        <div class="tab-pane fade show active" id="extract" role="tabpanel" aria-labelledby="extract-tab">
            <div class="card mb-3">
                <h5 class="card-header bg-dark text-white">Tabel Dinamis</h5>
                <div class="card-body">
                    <div class='col'>
                        <div id='tabledata' class='table-responsive'></div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- tab-content -->
</div>

<!-- Bootstrap JS dari CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery dari CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Script Ajax dengan menggunakan jQuery
    $(document).ready(function() {
    
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
        showLoadingModal();
        $.ajax({
            url: "getSubjects.php",
            type: "GET",
            data: { subcat_id: selectedSubcat },
            dataType: "html",
            success: function(response) {
                $('#subjectDropdownPlaceholder').html(response);
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
        showLoadingModal();
        $.ajax({
            url: "getVariables.php",
            type: "GET",
            data: { subject_id: selectedSubject },
            dataType: "html",
            success: function(response) {
                $('#variableDropdownPlaceholder').html(response);
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
        showLoadingModal();
        $.ajax({
            url: "getTableData.php",
            type: "GET",
            data: { var_id: selectedVar },
            dataType: "html",
            success: function(response) {
                $('#tabledata').html(response);
                hideLoadingModal();
            },
            error: function(xhr, status, error) {
                console.error("Gagal mengambil data tabel:", error);
                hideLoadingModal();
            }
        });
    });
    });

    $(document).ready(function() {
        // Fungsi untuk menampilkan modal
        function showLoadingModal() {
            $('#loadingModal').modal('show');
        }

        // Fungsi untuk menyembunyikan modal
        function hideLoadingModal() {
            $('#loadingModal').modal('hide');
        }

        // Event saat submit formulir filter
        $('#filterForm1').submit(function(event) {
            event.preventDefault(); // Menghentikan perilaku default saat mengirim formulir
            var selectedSubject = $('#variableDropdown').find(":selected").val();
            var selectedValues = $('#selectTo option').map(function() {
                return $(this).val();
            }).get().join(',');
            console.log(selectedValues)
            // Lakukan permintaan AJAX untuk memperbarui tabel dengan filter yang diterapkan
            showLoadingModal(); // Tampilkan modal loading
            $.ajax({
                url: "updateTableWithFilter.php", // Ganti dengan URL yang sesuai untuk memperbarui tabel dengan filter
                type: "GET",
                data: { filter: selectedValues, var_id: selectedSubject }, // Sertakan nilai filter dalam data permintaan
                dataType: "html",
                success: function(response) {
                    $('#tabledata').html(response); // Perbarui konten tabel dengan respons
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

</body>
</html>
