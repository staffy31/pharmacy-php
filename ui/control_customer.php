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
  <link href="../dist/css/icons/themify-icons/themify-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/sidenav.css">
  <link rel="stylesheet" href="../css/home.css">
  <script src="../js/control_customer.js"></script>
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
      createHeaderDash('home', 'Costumer List', '');
      ?>
      <!-- header section end -->

      <!-- form content -->
      <div class="row">

        <div class="col-md-12 form-group form-inline">
          <label class="font-weight-bold" for="">Search :&emsp;</label>
          <input type="text" class="form-control" id="" placeholder="Search Customer" onkeyup="searchCustomer(this.value);">
        </div>

        <div class="col col-md-12">
          <hr class="col-md-12" style="padding: 0px; border-top: 2px solid  #02b6ff;">
        </div>

        <div class="col col-md-12 table-responsive">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th style="width: 2%;">SL.</th>
                  <th style="width: 10%;">Customer ID</th>
                  <th style="width: 13%;">Customer Name</th>
                  <th style="width: 13%;">Contact Number</th>
                  <th style="width: 17%;">Address</th>
                  <th style="width: 13%;">Doctor's Name</th>
                  <th style="width: 17%;">Doctor's Address</th>
                  <th style="width: 15%;">Action</th>
                </tr>
              </thead>
              <tbody id="customers_div">
                <?php
                require 'php/control_customer.php';
                showCustomers(0);
                ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>

    </div>
  </div>
</body>

</html>