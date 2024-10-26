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
  <link rel="stylesheet" href="../css/sidenav.css">
  <link rel="stylesheet" href="../css/home.css">

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
      createHeaderDash('home', 'Dashboard', 'Tools available');
      ?>
      <!-- header section end -->

      <!-- form content -->
      <div class="row">
        <?php function createSection($icon, $location, $title, $description)
        { ?>
          <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2" style="padding: 10px;">
            <div class="dashboard-stats" style="padding: 30px 15px;" onclick="location.href=<?= '\'' . $location . '\'' ?>">
              <div class="text-center">
                <!-- <span class="h1"><i class="fa fa-<? $icon ?> p-2"></i></span> -->
                <div class="h2"><?= $title ?></div>
                <div class="h6"><?= $description ?></div>
              </div>
            </div>
          </div>
        <?php
        }
        createSection('', '#', '', '');
        createSection('', '#', '', '');

        ?>
      </div>

    </div>
  </div>
</body>

</html>