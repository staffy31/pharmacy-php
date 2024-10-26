<?php

function createHeader($heading)
{
?>
  <section class="row content-header ">
    <div class="header-title col-md-7 m-1 header" style="display:flex;">
      <p class="h4 pt-0 ">&emsp; <?= $heading ?></p>
    </div>
    <div class="col-md-4">

    </div>
  </section>
<?php 
} 

function createHeaderDash($icon, $heading, $sub_heading)
{
?>
  <section class="row content-header">

    <div class="header-title col-md-10 d-flex">
      <div class="col-md-4">
        <p class="h4 pt-4">
          &emsp;<?= $heading ?>
        </p>
        &emsp;&emsp;&emsp;<small class="font-weight-bold h6"><?= $sub_heading ?></small>
      </div>
    </div>
    <div class="col-md-2 user_options d-flex">
      <a href="#" class="nav-link text-light "><i class="fas fa-home bg-dark p-3 rounded shadow"></i> </a>
      <a href="#" class="nav-link text-light "><i class="fas fa-qrcode bg-dark p-3 rounded shadow"></i> </a>
      <a href="#" class="nav-link text-light "><i class="fas fa-power-off bg-dark p-3 rounded shadow"></i> </a>
    </div>
  </section>
  <hr style="border-top: 2px solid #09f;">
<?php
}
