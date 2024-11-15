<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Dashboard - Home</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <script src="../bootstrap/js/jquery.min.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <link href="../dist/css/icons/font-awesome/css/fontawesome-all.min.css" rel="stylesheet">
  <link href="../dist/css/icons/material-design-iconic-font/css/materialdesignicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="../dist/css/icons/themify-icons/themify-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/sidenav.css">
  <link rel="stylesheet" href="../css/home.css">
  <script type="text/javascript" src="../js/suggestions.js"></script>
  <script type="text/javascript" src="../js/new_purchase.js"></script>
  <script src="../js/validateForm.js"></script>

  <style>
    body {
      margin: 0;
      padding: 0;
      background-image: url('../images/bg.png');
      background-size: cover;
      background-attachment: fixed;
      font-family: 'Arial', sans-serif;
    }
  </style>
</head>

<body>
  <div id="new_supplier_model">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #09f; color: white">
          <div class="font-weight-bold">New Supplier</div>
          <button class="close" style="outline: none;" onclick="document.getElementById('new_supplier_model').style.display = 'none';"><i class="fa fa-close"></i></button>
        </div>
        <div class="modal-body">
          <?php
          include('sections/new_supplier.html');
          ?>
        </div>
      </div>
    </div>
  </div>
  <?php include "../menu/side/sections/sidenav.html"; ?>
  <div class="container-fluid">
    <div class="container">
      <!-- header section -->
      <?php
      require "../php/header.php";
      createHeaderDash('home', 'Purchase', 'New Purchase register');
      ?>
      <!-- header section end -->

      <!-- form content -->
      <div class="row">
        <!-- manufacturer details content -->
        <div class="row col col-md-12">

          <div class="col col-md-4 form-group">
            <label class="font-weight-bold" for="suppliers_name">Supplier :</label>
            <input id="suppliers_name" type="text" class="form-control" placeholder="Supplier Name" name="suppliers_name" onkeyup="showSuggestions(this.value, 'supplier');">
            <code class="text-danger small font-weight-bold float-right" id="supplier_name_error" style="display: none;"></code>
            <div id="supplier_suggestions" class="list-group position-fixed" style="z-index: 1; width: 25.10%; overflow: auto; max-height: 200px;"></div>
          </div>

          <div class="col col-md-2 form-group">
            <label class="font-weight-bold" for="">Invoice Number :</label>
            <input type="number" class="form-control" placeholder="Invoice Number" id="invoice_number" name="invoice_number" onblur="notNull(this.value, 'invoice_number_error'); checkInvoice(this.value, 'invoice_number_error');">
            <code class="text-danger small font-weight-bold float-right" id="invoice_number_error" style="display: none;"></code>
          </div>

          <div class="col col-md-2 form-group">
            <label class="font-weight-bold" for="paytype">Payment Type :</label>
            <select id="payment_type" name="paytype" class="form-control">
              <option value="Cash Payment">Cash Payment</option>
              <option value="Net Banking">Net Banking</option>
              <option value="Payment Due">Payment Due</option>
            </select>
          </div>

          <div class="col col-md-2 form-group">
            <label class="font-weight-bold" for="invoice_date">Date :</label>
            <input type="date" class="datepicker form-control hasDatepicker" id="invoice_date" name="invoice_date" value='<?php echo date('Y-m-d'); ?>' onblur="checkDate(this.value, 'date_error');">
            <code class="text-danger small font-weight-bold float-right" id="date_error" style="display: none;"></code>
          </div>

        </div>

        <div class="row col col-md-12">
          <div class="col col-md-2 font-weight-bold" style="color: green; cursor:pointer" onclick="document.getElementById('new_supplier_model').style.display = 'block';">
            <i class="fa fa-plus"></i>&nbsp;New Supplier
          </div>
        </div>
        <!-- supplier details content end -->

        <div class="col col-md-12">
          <hr class="col-md-12" style="padding: 0px; border-top: 2px solid #02b6ff;">
        </div>

        <!-- add medicines -->
        <div class="row col col-md-12 font-weight-bold">
          <div class="col col-md-2">Medicine Name</div>
          <div class="col col-md-1">Packing</div>
          <div class="col col-md-2">Batch ID</div>
          <div class="col col-md-1">Ex. Date (mm/yy)</div>
          <div class="col col-md-1">Quantity</div>
          <div class="col col-md-1">MRP</div>
          <div class="col col-md-1">Rate</div>
          <div class="row col col-md-3">
            <div class="col col-md-7">Amount</div>
            <div class="col col-md-5">Action</div>
          </div>
        </div>
        <div class="col col-md-12">
          <hr class="col-md-12" style="padding: 0px; border-top: 2px solid  #02b6ff;">
        </div>
        <div id="purchase_medicine_list_div">
          <script>
            addRow();
          </script>
        </div>
        <!-- end medicines -->

        <div class="row col col-md-12">
          <div class="col col-md-10"></div>
          <div class="col col-md-2 form-group float-right">
            <label class="font-weight-bold" for="">Grand Total :</label>
            <input type="text" class="form-control" id="grand_total" name="grand_total" disabled>
          </div>
        </div>

        <!-- button -->
        <div class="row col col-md-12">
          <div class="col col-md-5"></div>
          <div class="col col-md-2 form-group">
            <button class="btn btn-primary form-control" onclick="addPurchase();">ADD</button>
          </div>
          <div class="col col-md-5"></div>
        </div>
        <!-- closing button -->
        <div id="purchase_acknowledgement" class="col-md-12 h5 text-success font-weight-bold text-center" style="font-family: sans-serif;" </div>

        </div>
        <!-- form content end -->

      </div>
    </div>
</body>

</html>