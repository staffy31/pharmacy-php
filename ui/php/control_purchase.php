<?php
function showPurchases($id)
{
  $file_path = '../data/purchases.json';

  if (file_exists($file_path)) {
    $json_data = file_get_contents($file_path);
    $purchases = json_decode($json_data, true);
  
    if ($purchases !== null) {
      $seq_no = 0;
      foreach ($purchases as $row) {
        $seq_no++;
        if ($row['VOUCHER_NUMBER'] == $id) {
          showEditOptionsRow($seq_no, $row);
        } else {
          showPurchaseRow($seq_no, $row);
        }
      }
    } else {
      echo "Error decoding JSON data.";
    }
  } else {
    echo "File not found.";
  }
}


function showPurchaseRow($seq_no, $row) {
  ?>
  <tr>
    <td><?php echo $seq_no; ?></td>
    <td><?php echo $row['VOUCHER_NUMBER']; ?></td>
    <td><?php echo $row['SUPPLIER_NAME'] ?></td>
    <td><?php echo $row['INVOICE_NUMBER']; ?></td>
    <td><?php echo $row['PURCHASE_DATE']; ?></td>
    <td><?php echo $row['TOTAL_AMOUNT']; ?></td>
    <td><?php echo $row['PAYMENT_STATUS']; ?></td>
    <td>
      <button href="" class="btn btn-info btn-sm" onclick="editPurchase(<?php echo $row['VOUCHER_NUMBER']; ?>);">
        <i class="fa fa-pencil"></i>
      </button>
      <button class="btn btn-danger btn-sm" onclick="deletePurchase(<?php echo $row['VOUCHER_NUMBER']; ?>);">
        <i class="fa fa-trash"></i>
      </button>
    </td>
  </tr>
  <?php
}