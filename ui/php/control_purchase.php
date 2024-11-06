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
