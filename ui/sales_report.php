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

  <?php include "../menu/side/sections/sidenav.html"; ?>
  <div class="container-fluid">
    <div class="container">
        <!-- header section -->
        <?php
          require "../php/header.php";
          createHeader('book', 'Sales Report', 'Showing Sales Report');
        ?>
        <!-- header section end -->

        <!-- form content -->
        <div class="row">

          <div class="col-md-12 form-group form-inline">
            <label class="font-weight-bold" for="">Start Date :&emsp;</label>
            <input type="date" class="form-control" id="start_date" onchange="showReport('sales');">
            &emsp;
            <label class="font-weight-bold" for="">End Date :&emsp;</label>
            <input type="date" class="form-control" id="end_date" onchange="showReport('sales');">
            &emsp;
            <button class="btn btn-success" onclick="location.reload();"><i class="fa fa-refresh"></i></button>
          </div>

          <div class="col col-md-12">
            <hr class="col-md-12" style="padding: 0px; border-top: 2px solid  #02b6ff;">
          </div>

          <div class="col col-md-12 table-responsive">
            <div id="print_content" class="table-responsive">
            	<table class="table table-bordered table-striped table-hover" id="sales_report_div">
                <?php
                require "php/report.php";
                showSales("", "");
                ?>
            	</table>
            </div>
          </div>

          <div class="col-md-12 text-center">
            <button class="btn btn-primary" onclick="printReport('Sales');">Print</button>
          </div>

        </div>
        <!-- form content end -->
    </div>
  </div>
</body>

</html>