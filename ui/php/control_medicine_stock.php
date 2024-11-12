<?php

function showMedicinesStock($id)
{
  $medicinesFilePath = '../data/medicines.json';
  $medicinesStockFilePath = '../data/medicines_stock.json';

  if (file_exists($medicinesFilePath) && file_exists($medicinesStockFilePath)) {
    $medicines_data = json_decode(file_get_contents($medicinesFilePath), true);
    $medicines_stock_data = json_decode(file_get_contents($medicinesStockFilePath), true);

    if ($medicines_data !== null && $medicines_stock_data !== null) {
      $seq_no = 0;

      foreach ($medicines_data as $medicine) {
        foreach ($medicines_stock_data as $stock) {
          if ($medicine['NAME'] == $stock['NAME']) {
            $seq_no++;

            $combined_data = array_merge($medicine, $stock);

            if ($combined_data['BATCH_ID'] == $id) {
              showEditOptionsRow($seq_no, $combined_data);
            } else {
              showMedicineStockRow($seq_no, $combined_data);
            }
          }
        }
      }
    } else {
      echo "Failed to decode one or both JSON files.";
    }
  } else {
    echo "One or both JSON files are missing.";
  }
}

function showMedicineStockRow($seq_no, $row)
{
?>
  <tr>
    <td><?php echo $seq_no; ?></td>
    <td><?php echo $row['NAME']; ?></td>
    <td><?php echo $row['PACKING']; ?></td>
    <td><?php echo $row['GENERIC_NAME']; ?></td>
    <td><?php echo $row['BATCH_ID']; ?></td>
    <td><?php echo $row['EXPIRY_DATE']; ?></td>
    <td><?php echo $row['SUPPLIER_NAME']; ?></td>
    <td><?php echo $row['QUANTITY']; ?></td>
    <td><?php echo $row['MRP']; ?></td>
    <td><?php echo $row['RATE']; ?></td>
    <td>
      <button href="" class="btn btn-info btn-sm" onclick="editMedicineStock('<?php echo $row['BATCH_ID']; ?>');">
        <i class="fa fa-pencil"></i>
      </button>
    </td>
  </tr>
<?php
}
