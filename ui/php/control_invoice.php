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

function showInvoiceRow($seq_no, $row) {
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
      <button class="btn btn-warning btn-sm" onclick="printInvoice(<?php echo $row['INVOICE_ID']; ?>);">
        <i class="fa fa-fax"></i>
      </button>
      <button class="btn btn-danger btn-sm" onclick="deleteInvoice(<?php echo $row['INVOICE_ID']; ?>);">
        <i class="fa fa-trash"></i>
      </button>
    </td>
  </tr>
  <?php
}
