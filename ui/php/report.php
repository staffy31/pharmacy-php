<?php

if(isset($_GET['action']) && $_GET['action'] == "purchase")
  showPurchases($_GET['start_date'], $_GET['end_date']);

if(isset($_GET['action']) && $_GET['action'] == "sales")
  showSales($_GET['start_date'], $_GET['end_date']);

  function showPurchases($start_date, $end_date) {
    ?>
    <thead>
      <tr>
        <th>SL</th>
        <th>Purchase Date</th>
        <th>Voucher Number</th>
        <th>Invoice No</th>
        <th>Supplier Name</th>
        <th>Total Amount</th>
      </tr>
    </thead>
    <tbody>
    <?php
    require "db_connection.php";
    if($con) {
      $seq_no = 0;
      $total = 0;
      if($start_date == "" || $end_date == "")
        $query = "SELECT * FROM purchases";
      else
        $query = "SELECT * FROM purchases WHERE PURCHASE_DATE BETWEEN '$start_date' AND '$end_date'";
      $result = mysqli_query($con, $query);
      while($row = mysqli_fetch_array($result)) {
        $seq_no++;
        showPurchaseRow($seq_no, $row);
        $total = $total + $row['TOTAL_AMOUNT'];
      }
      ?>
      </tbody>
      <tfoot class="font-weight-bold">
        <tr style="text-align: right; font-size: 24px;">
          <td colspan="5" style="color: green;">&nbsp;Total Purchases =</td>
          <td style="color: red;"><?php echo $total; ?></td>
        </tr>
      </tfoot>
      <?php
    }
  }
  