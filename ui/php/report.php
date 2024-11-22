<?php

if (isset($_GET['action']) && $_GET['action'] == "purchase")
  showPurchases($_GET['start_date'], $_GET['end_date']);

if (isset($_GET['action']) && $_GET['action'] == "sales")
  showSales($_GET['start_date'], $_GET['end_date']);

function showPurchases($start_date, $end_date)
{
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
    $jsonFilePath = '../data/purchases.json';
    if (file_exists($jsonFilePath)) {

      $seq_no = 0;
      $total = 0;
      $jsonData = file_get_contents($jsonFilePath);
      $purchases = json_decode($jsonData, true);
      if ($purchases === null) {
        echo "Error: Unable to parse JSON file.";
      } else {
        foreach ($purchases as $purchase) {
          if (!empty($start_date) && !empty($end_date)) {
            if ($purchase['PURCHASE_DATE'] >= $start_date && $purchase['PURCHASE_DATE'] <= $end_date) {
              $seq_no++;
              showPurchaseRow($seq_no, $purchase);
              $total += $purchase['TOTAL_AMOUNT'];
            }
          } else {
            $seq_no++;
            showPurchaseRow($seq_no, $purchase);
            $total += $purchase['TOTAL_AMOUNT'];
          }
        }
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

  function showPurchaseRow($seq_no, $row)
  {
    ?>
    <tr>
      <td><?php echo $seq_no; ?></td>
      <td><?php echo $row['PURCHASE_DATE']; ?></td>
      <td><?php echo $row['VOUCHER_NUMBER']; ?></td>
      <td><?php echo $row['ID']; ?></td>
      <td><?php echo $row['SUPPLIER_NAME'] ?></td>
      <td><?php echo $row['TOTAL_AMOUNT']; ?></td>
    </tr>
    <?php
  }

  function showSales($start_date, $end_date)
  {
    ?>
    <thead>
      <tr>
        <th>SL</th>
        <th>Sales Date</th>
        <th>Invoice Number</th>
        <th>Customer Name</th>
        <th>Total Amount</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $jsoninvoices = '../data/invoices.json';
      $jsoncustomers = '../data/customers.json';

      $invoices = json_decode(file_get_contents($jsoninvoices), true);
      $customers = json_decode(file_get_contents($jsoncustomers), true);

      if ($invoices && $customers) {
        $seq_no = 0;
        $total = 0;
        $filteredInvoices = [];
        if (!empty($start_date) && !empty($end_date)) {
          foreach ($invoices as $invoice) {
            if ($invoice['INVOICE_DATE'] >= $start_date && $invoice['INVOICE_DATE'] <= $end_date) {
              $filteredInvoices[] = $invoice;
            }
          }
        } else {
          $filteredInvoices = $invoices;
        }

        $joinedData = [];
        foreach ($filteredInvoices as $invoice) {
          foreach ($customers as $customer) {
            if ($invoice['CUSTOMER_ID'] == $customer['ID']) {
              $joinedData[] = array_merge($invoice, $customer);
            }
          }
        }
        foreach ($joinedData as $row) {
          $seq_no++;
          // $total += $row['AMOUNT'];
          showSalesRow($seq_no, $row);
          $total = $total + $row['NET_TOTAL'];
        }
      }
      ?>
      </tbody>
      <tfoot class="font-weight-bold">
        <tr style="text-align: right; font-size: 24px;">
          <td colspan="4" style="color: green;">&nbsp;Total Sales =</td>
          <td class="text-primary"><?php echo $total; ?></td>
        </tr>
      </tfoot>
    <?php
  }
  
  function showSalesRow($seq_no, $row)
  {
    ?>
      <tr>
        <td><?php echo $seq_no; ?></td>
        <td><?php echo $row['INVOICE_DATE']; ?></td>
        <td><?php echo $row['ID']; ?></td>
        <td><?php echo $row['NAME']; ?></td>
        <td><?php echo $row['NET_TOTAL'] ?></td>
      </tr>
    <?php
  }
?>