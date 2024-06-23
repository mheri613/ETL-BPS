<?php
include 'api.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ETL-BPS</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  <link rel="shortcut icon" type="image/png" href="komponen/icon.png">
</head>

<body>

  <?php include 'komponen/header.php' ?>
  <!-- Tab content -->

  <div class="container-fluid">
    <div class="card">
      <div class="card-header bg-primary text-white">
        ETL-BPS
      </div>
      <div class="card-body">
        <div class="row">
          <div class="form-group col-4">
            <label for="apiUrlInput">API URL:</label>
            <input type="text" id="apiUrlInput" name="apiUrlInput" class="form-control">
          </div>

          <div class="form-group col-3">
            <label for="dropdown1">Select Subcategory:</label>
            <select id="dropdown1" class="form-control">
              <option value="">Select an option</option>
            </select>
          </div>

          <div class="form-group col-3">
            <label for="dropdown2">Select Variable:</label>
            <select id="dropdown2" class="form-control">
              <option value="">Select an option</option>
            </select>
          </div>

          <div class="form-group col-4">
            <label for="apiKeyInput">API Key:</label>
            <input type="text" id="apiKeyInput" name="apiKeyInput" class="form-control">
            <button id="submit" class="btn btn-primary">Submit</button>
          </div>

          <div class="form-group col-6">
            <label for="dropdown3">Select Data:</label>
            <select id="dropdown3" class="form-control">
              <option value="">Select an option</option>
            </select>
          </div>

        </div>
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
              <div class="col-lg-3 col-md-auto col-sm-12">
                <h5 class="text" style="color: black;">Key App SatuData</h5>
                <form id="" class="d-flex">
                  <input id="apiKeySatudata" class="form-control" type="text" placeholder="Ketik Api Key" aria-label="default input example">
                  <button type="button" id="searchData" class="btn btn-primary">Search</button>
                </form>
              </div>
              <div class="col-lg-3 col-md-auto col-sm-12">
                <h5 class="text" style="color: black;">Tahun</h5>
                <select id="tahunDropdown" class="form-control">
                  <option value="">Pilih Tahun</option>
                </select>
              </div>
              <div class="col-lg-4 col-md-auto col-sm-12 mt-2">
                <h5 class="text" style="color: black;">Cari Dataset SatuData</h5>
                <form id="searchForm" class="d-flex">
                  <input id="searchInput" type="search" class="form-control" placeholder="Search" aria-label="Search">
                  <button id="searchButton" class="btn btn-primary" type="submit">Find</button>
                </form>
              </div>
            </div>

            <div class="row mt-3">
              <div class="col-lg-3 col-md-auto col-sm-12">
                <div class="card mb-3">
                  <h5 class="card-header bg-dark text-white">Dataset BPS result</h5>
                  <div class="card-body">
                    <form>
                      <div class="mb-3">
                        <label for="filterInput" class="form-label multiple">Pilih Kolom :</label>
                        <div id="column-names-container">
                          <select class="form-select" id="selectFrom" multiple>
                            <option value=""></option>
                          </select>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-lg-1 col-md-auto col-sm-12 align-self-center text-center mb-4">
                <div class="mb-2">
                  <button type="button" id="moveRight" class="btn btn-primary">&gt;&gt;</button>
                </div>
                <div class="mb-2">
                  <button type="button" id="moveLeft" class="btn btn-primary">
                    <<< /button>
                </div>
              </div>
              <div class="col-lg-3 col-md-auto col-sm-12">
                <div class="card mb-3">
                  <h5 class="card-header bg-dark text-white">Result Collum Order</h5>
                  <div class="card-body">
                    <form id="filterForm1">
                      <div class="mb-4">
                        <label for="filterInput" class="form-label multiple">Filter :</label>
                        <select class="form-select" id="selectTo" multiple></select>
                        <!-- <button type="submit" class="btn btn-primary mb-2">Apply Filter</button> -->
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-lg-2 col-md-auto col-sm-12 align-self-center text-center">
                <div class="mb-2">
                  <button type="button" id="matchButton" class="btn btn-primary">Match</button>
                </div>
              </div>
              <div class="col-lg-3 col-md-auto col-sm-12">
                <div class="card mb-3">
                  <h5 class="card-header bg-dark text-white">Result</h5>
                  <div class="card-body">
                    <form id="filterForm2">
                      <div class="">
                        <label for="filterInput" class="form-label multiple">Filter :</label>
                        <select class="form-select" id="selectTo2" multiple></select>
                        <button type="submit" class="btn btn-primary mt-2">Apply Filter</button>
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

  <div id="loadingSpinner" class="d-none position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-white bg-opacity-75">
    <div class="spinner-border text-primary" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>

  <?php //include 'komponen/footer.php'; 
  ?>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script src="ajax.js"></script>
</body>

</html>