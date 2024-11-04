
<?php
function showMedicineStockRow($seq_no, $row) {
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