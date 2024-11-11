<?php
if (isset($_GET["action"]) && $_GET["action"] == "refresh")
  showInvoices();

if (isset($_GET["action"]) && $_GET["action"] == "search")
  searchInvoice(strtoupper($_GET["text"]), $_GET["tag"]);

if (isset($_GET["action"]) && $_GET["action"] == "print_invoice")
  printInvoice($_GET["invoice_number"]);


function showInvoices()
{
  $file_path = '../data/invoices.json';

  if (file_exists($file_path)) {
    $json_data = file_get_contents($file_path);
    $invoices = json_decode($json_data, true);

    if ($invoices !== null) {
      $seq_no = 0;
      foreach ($invoices as $row) {
        $seq_no++;
        showInvoiceRow($seq_no, $row);
      }
    } else {
      echo "Failed to decode JSON data.";
    }
  } else {
    echo "JSON file not found.";
  }
}

function showInvoiceRow($seq_no, $row)
{
?>
  <tr>
    <td><?php echo $seq_no; ?></td>
    <td><?php echo $row['INVOICE_ID']; ?></td>
    <td><?php echo $row['NAME']; ?></td>
    <td><?php echo $row['INVOICE_DATE']; ?></td>
    <td><?php echo $row['TOTAL_AMOUNT']; ?></td>
    <td><?php echo $row['TOTAL_DISCOUNT']; ?></td>
    <td><?php echo $row['NET_TOTAL']; ?></td>
    <td>
      <button class="btn btn-warning btn-sm" onclick="printInvoice(<?= $row['INVOICE_ID']; ?>,<?= $row['INVOICE_DATE']; ?>);">
        <i class="fa fa-fax"></i>
      </button>
      <button class="btn btn-danger btn-sm" onclick="deleteInvoice(<?= $row['INVOICE_ID']; ?>);">
        <i class="fa fa-trash"></i>
      </button>
    </td>
  </tr>
<?php
}

function searchInvoice($text, $column)
{
  $file_path = '../data/invoices.json';

  if (file_exists($file_path)) {
    $json_data = file_get_contents($file_path);
    $invoices = json_decode($json_data, true);

    if ($invoices !== null) {
      $seq_no = 0;
      $filtered_invoices = [];

      foreach ($invoices as $row) {
        if ($column == 'INVOICE_ID' && strpos((string)$row['INVOICE_ID'], $text) !== false) {
          $filtered_invoices[] = $row;
        } elseif ($column == 'INVOICE_DATE' && $row['INVOICE_DATE'] == $text) {
          $filtered_invoices[] = $row;
        } elseif (isset($row[$column]) && strpos(strtoupper($row[$column]), strtoupper($text)) !== false) {
          $filtered_invoices[] = $row;
        }
      }

      foreach ($filtered_invoices as $row) {
        $seq_no++;
        showInvoiceRow($seq_no, $row);
      }
    } else {
      echo "Failed to decode JSON data.";
    }
  } else {
    echo "JSON file not found.";
  }
}
function printInvoice($invoice_number,$invoice_date)
{

  $file_customers = '../data/customers.json';
  $file_sales = '../data/sales.json';
  $file_invoices = '../data/invoices.json';

  if (file_exists($file_customers) && file_exists($file_sales)) {
    $customers_data = json_decode(file_get_contents($file_customers), true);
    $sales_data = json_decode(file_get_contents($file_sales), true);

    if ($customers_data !== null && $sales_data !== null) {
      $sale_record = null;

      foreach ($sales_data as $sale) {
        if ($sale['INVOICE_NUMBER'] == $invoice_number) {
          $sale_record = $sale;
          break;
        }
      }

      if ($sale_record) {
        $customer_record = null;
        foreach ($customers_data as $customer) {
          if ($customer['ID'] == $sale_record['CUSTOMER_ID']) {
            $customer_record = $customer;
            break;
          }
        }

        if ($customer_record) {
          $customer_name = $customer_record['NAME'];
          $address = $customer_record['ADDRESS'];
          $contact_number = $customer_record['CONTACT_NUMBER'];
          $doctor_name = $sale_record['DOCTOR_NAME'];
          $doctor_address = $sale_record['DOCTOR_ADDRESS'];
        } else {
          echo "Customer not found for the provided CUSTOMER_ID.";
        }
      } else {
        echo "Sale not found for the provided INVOICE_NUMBER.";
      }
    } else {
      echo "Failed to decode JSON data.";
    }
  } else {
    echo "One or both JSON files are missing.";
  }


  if (file_exists($file_invoices)) {
    $invoices_data = json_decode(file_get_contents($file_invoices), true);

    if ($invoices_data !== null) {
      $invoice_record = null;

      foreach ($invoices_data as $invoice) {
        if ($invoice['INVOICE_NUMBER'] == $invoice_number) {
          $invoice_record = $invoice;
          break;
        }
      }

      if ($invoice_record) {
        $invoice_date = $invoice_record['INVOICE_DATE'];
        $total_amount = $invoice_record['TOTAL_AMOUNT'];
        $total_discount = $invoice_record['TOTAL_DISCOUNT'];
        $net_total = $invoice_record['NET_TOTAL'];
      } else {
        echo "Invoice not found for the provided INVOICE_NUMBER.";
      }
    } else {
      echo "Failed to decode JSON data.";
    }
  } else {
    echo "JSON file not found.";
  }
?>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/sidenav.css">
  <link rel="stylesheet" href="css/home.css">
  <div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10 h3" style="color: #ff5252;">Customer Invoice<span class="float-right">Invoice Number : <?php echo $invoice_number; ?></span></div>
  </div>
  <div class="row font-weight-bold">
    <div class="col-md-1"></div>
    <div class="col-md-10"><span class="h4 float-right">Invoice Date. : <?php echo $invoice_date; ?></span></div>
  </div>
  <div class="row text-center">
    <hr class="col-md-10" style="padding: 0px; border-top: 2px solid  #ff5252;">
  </div>
  <div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-4">
      <span class="h4">Customer Details : </span><br><br>
      <span class="font-weight-bold">Name : </span><?php echo $customer_name; ?><br>
      <span class="font-weight-bold">Address : </span><?php echo $address; ?><br>
      <span class="font-weight-bold">Contact Number : </span><?php echo $contact_number; ?><br>
      <span class="font-weight-bold">Doctor's Name : </span><?php echo $doctor_name; ?><br>
      <span class="font-weight-bold">Doctor's Address : </span><?php echo $doctor_address; ?><br>
    </div>
    <div class="col-md-3"></div>

    <?php

    $file_admin = '../data/admin_credentials.json';

    if (file_exists($file_admin)) {
      $admin_data = json_decode(file_get_contents($file_admin), true);

      if ($admin_data !== null) {
        $p_name = $admin_data['PHARMACY_NAME'];
        $p_address = $admin_data['ADDRESS'];
        $p_email = $admin_data['EMAIL'];
        $p_contact_number = $admin_data['CONTACT_NUMBER'];
      } else {
        echo "Failed to decode JSON data.";
      }
    } else {
      echo "JSON file not found.";
    }
    ?>

    <div class="col-md-4">
      <span class="h4">Shop Details : </span><br><br>
      <span class="font-weight-bold"><?php echo $p_name; ?></span><br>
      <span class="font-weight-bold"><?php echo $p_address; ?></span><br>
      <span class="font-weight-bold"><?php echo $p_email; ?></span><br>
      <span class="font-weight-bold">Mob. No.: <?php echo $p_contact_number; ?></span>
    </div>
    <div class="col-md-1"></div>
  </div>
  <div class="row text-center">
    <hr class="col-md-10" style="padding: 0px; border-top: 2px solid  #ff5252;">
  </div>

  <div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10 table-responsive">
      <table class="table table-bordered table-striped table-hover" id="purchase_report_div">
        <thead>
          <tr>
            <th>SL</th>
            <th>Medicine Name</th>
            <th>Expiry Date</th>
            <th>Quantity</th>
            <th>MRP</th>
            <th>Discount</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $file_sales = '../data/sales.json';
          $seq_no = 0;
          $total = 0;
          if (file_exists($file_sales)) {
            $sales_data = json_decode(file_get_contents($file_sales), true);

            if ($sales_data !== null) {
              $matched_sales = [];

              foreach ($sales_data as $sale) {
                if ($sale['INVOICE_NUMBER'] == $invoice_number) {
                  $matched_sales[] = $sale;
                }
              }

              foreach ($matched_sales as $row) {
                $item_name = $row['ITEM_NAME'];
                $quantity = $row['QUANTITY'];
                $price = $row['PRICE'];
                $total = $row['TOTAL'];
                $seq_no++;
          ?>
                <tr>
                  <td><?php echo $seq_no; ?></td>
                  <td><?php echo $row['MEDICINE_NAME']; ?></td>
                  <td><?php echo $row['EXPIRY_DATE']; ?></td>
                  <td><?php echo $row['QUANTITY']; ?></td>
                  <td><?php echo $row['MRP']; ?></td>
                  <td><?php echo $row['DISCOUNT'] . "%"; ?></td>
                  <td><?php echo $row['TOTAL']; ?></td>
                </tr>
          <?php
              }

              if (empty($matched_sales)) {
                echo "No sales found for the specified INVOICE_NUMBER.";
              }
            } else {
              echo "Failed to decode JSON data.";
            }
          } else {
            echo "JSON file not found.";
          }
          ?>
        </tbody>
        <tfoot class="font-weight-bold">
          <tr style="text-align: right; font-size: 18px;">
            <td colspan="6">&nbsp;Total Amount</td>
            <td><?php echo $total_amount; ?></td>
          </tr>
          <tr style="text-align: right; font-size: 18px;">
            <td colspan="6">&nbsp;Total Discount</td>
            <td><?php echo $total_discount; ?></td>
          </tr>
          <tr style="text-align: right; font-size: 22px;">
            <td colspan="6" style="color: green;">&nbsp;Net Amount</td>
            <td class="text-primary"><?php echo $net_total; ?></td>
          </tr>
        </tfoot>
      </table>
    </div>
    <div class="col-md-1"></div>
  </div>
  <div class="row text-center">
    <hr class="col-md-10" style="padding: 0px; border-top: 2px solid  #ff5252;">
  </div>
<?php
}
