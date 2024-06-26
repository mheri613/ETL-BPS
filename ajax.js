$(document).ready(function () {
  $(document).ajaxStart(function () {
    $("#loadingSpinner").removeClass("d-none");
  });

  $(document).ajaxComplete(function () {
    $("#loadingSpinner").addClass("d-none");
  });

  $("#moveRight").click(function () {
    $("#selectFrom option:selected").appendTo("#selectTo");
  });

  $("#moveLeft").click(function () {
    $("#selectTo option:selected").appendTo("#selectFrom");
  });

  $("#submit").click(function (event) {
    event.preventDefault();
    var apiUrlInput = $("#apiUrlInput").val();
    var apiKeyInput = $("#apiKeyInput").val();

    $.ajax({
      type: "POST",
      url: "api.php",
      data: {
        action: "getSubcategories",
        apiUrlInput: apiUrlInput,
        apiKeyInput: apiKeyInput,
      },
      dataType: "json",
      success: function (data) {
        console.log(data)
        var options = "<option value=''>Pilih Subcategory</option>";
        var subcategories = data.data[1]; // Access the subcategory array
        for (var i = 0; i < subcategories.length; i++) {
          options +=
            '<option value="' +
            subcategories[i].subcat_id +
            '">' +
            subcategories[i].title +
            "</option>";
        }
        $("#Subcategorydropdown").html(options);
      },
    });
  });

  $("#Subcategorydropdown").change(function () {
    var selectedId = $(this).val();
    $.ajax({
      type: "POST",
      url: "api.php",
      data: {
        action: "getSubjects",
        subcatId: selectedId,
        apiUrlInput: $("#apiUrlInput").val(),
        apiKeyInput: $("#apiKeyInput").val(),
      },
      dataType: "json",
      success: function (data) {
        console.log(data);
        var options = "<option value=''>Pilih Subject</option>";
        var subjects = data.data[1]; // Access the subject array
        for (var i = 0; i < subjects.length; i++) {
          options +=
            '<option value="' +
            subjects[i].sub_id +
            '">' +
            subjects[i].title +
            "</option>";
        }
        $("#Subjectdropdown").html(options);
      },
    });
  });

  $("#Subjectdropdown").change(function () {
    var selectedId = $(this).val();
    $.ajax({
      type: "POST",
      url: "api.php",
      data: {
        action: "getVariables",
        subId: selectedId, // Change this line
        apiUrlInput: $("#apiUrlInput").val(),
        apiKeyInput: $("#apiKeyInput").val(),
      },
      dataType: "json",
      success: function (data) {
        console.log(data)
        var options = "<option value=''>Pilih Tabledata</option>";
        if (data.data[1] && data.data[1].length > 0) {
          var variables = data.data[1];
          for (var i = 0; i < variables.length; i++) {
            options +=
              '<option value="' +
              variables[i].var_id +
              '">' +
              variables[i].title +
              "</option>";
          }
        }
        $("#Tabledatadropdown").html(options);
      },
    });
  });

  $("#Tabledatadropdown").change(function () {
    var selectedId = $(this).val();
    $.ajax({
      type: "POST",
      url: "api.php",
      data: {
        action: "getTableData",
        varId: selectedId,
        apiUrlInput: $("#apiUrlInput").val(),
        apiKeyInput: $("#apiKeyInput").val(),
      },
      dataType: "json",
      success: function (data) {
        console.log(data)
        renderTableData(data);
      },
    });
  });

  function renderTableData(data) {
    var dataSet = [];

    let wilayahLabelExists = data.vervar.length > 0;
    let tahunLabelExists = data.tahun.length > 0;
    let jumlahExists = data.var.length > 0;
    let unitExists = data.var.length > 0;

    let columnNames = [];
    if (wilayahLabelExists) columnNames.push("Wilayah");
    if (tahunLabelExists) columnNames.push("Tahun");
    if (jumlahExists) columnNames.push("Jumlah");
    if (unitExists) columnNames.push("Satuan");

    // Tambahkan opsi ke elemen select
    let selectHtml = "";
    columnNames.forEach(function (name) {
      selectHtml += "<option value='" + name + "'>" + name + "</option>";
    });
    $("#selectFrom").html(selectHtml);

    // Buat elemen tabel
    let tableHtml =
      "<table id='dataTable' class='table table-striped'></table>";
    $("#tabledata").html(tableHtml);

    $.each(data.datacontent, function (key, value) {
      if (value !== null && value !== "") {
        let row = [];

        // Wilayah
        let wilayah_label = "";
        $.each(data.vervar, function (index, wilayah) {
          if (key.includes(wilayah.val)) {
            wilayah_label = wilayah.label;
            return false; // break loop
          }
        });
        row.push(wilayah_label);

        // Tahun
        let tahun_label = "";
        $.each(data.tahun, function (index, tahun) {
          if (key.includes(tahun.val)) {
            tahun_label = tahun.label;
            return false; // break loop
          }
        });
        row.push(tahun_label);

        // Data
        row.push(value);

        // Unit
        let unit = "";
        $.each(data.var, function (index, variabel) {
          if (key.includes(variabel.val)) {
            unit = variabel.unit;
            return false; // break loop
          }
        });
        row.push(unit);

        let jumlah = "";
        $.each(data.var, function (index, variabel) {
          if (key.includes(variabel.val)) {
            jumlah = variabel.label;
            return false; // break loop
          }
        });
        row.push(unit);

        dataSet.push(row);
      }
    });

    // Create DataTable instance
    var table = $("#dataTable").DataTable({
      data: dataSet,
      columns: columnNames.map((name) => ({ title: name })),
      paging: false,
      scrollCollapse: true,
      scrollY: "50vh",
      searching: false,
      info: false,
    });
  }

  $("#searchData").click(function (event) {

    var apiUrlInput = $("#apiUrlSatudata").val();
    var apiKeyInput = $("#apiKeySatudata").val();
    console.log("mulai ajax");
    $.ajax({

      type: "POST",
      url: "api.php",
      data: {
        action: "getDataset",
        apiUrlInput: apiUrlInput,
        apiKeyInput: apiKeyInput,
      },
      // dataType: "json",
      success: function (data) {
        console.log("hello world");
        console.log(data);
      }
    });
    //event.preventDefault();
  });
});
