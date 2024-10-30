<?php
$file_path = '../data/medicines.json';

// Check if the JSON file exists, read it, or initialize an empty array
function loadMedicines()
{
  global $file_path;
  if (file_exists($file_path)) {
    $json_data = file_get_contents($file_path);
    return json_decode($json_data, true) ?? [];
  }
  return [];
}

// Save the updated medicines array back to the JSON file
function saveMedicines($medicines)
{
  global $file_path;
  file_put_contents($file_path, json_encode($medicines, JSON_PRETTY_PRINT));
}

if (isset($_GET["action"])) {
  $action = $_GET["action"];

  if ($action == "delete") {
    $id = $_GET["id"];
    $medicines = loadMedicines();
    $medicines = array_filter($medicines, fn($medicine) => $medicine['ID'] != $id);
    saveMedicines($medicines);
    showMedicines(0);
  }

  if ($action == "edit") {
    $id = $_GET["id"];
    showMedicines($id);
  }

  if ($action == "update") {
    $id = $_GET["id"];
    $name = ucwords($_GET["name"]);
    $packing = strtoupper($_GET["packing"]);
    $generic_name = ucwords($_GET["generic_name"]);
    $suppliers_name = ucwords($_GET["suppliers_name"]);
    updateMedicine($id, $name, $packing, $generic_name, $suppliers_name);
  }

  if ($action == "cancel") {
    showMedicines(0);
  }

  if ($action == "search") {
    searchMedicine(strtoupper($_GET["text"]), $_GET["tag"]);
  }
}

// Display the list of medicines, showing edit options if $id matches
function showMedicines($id)
{
  $medicines = loadMedicines();
  $seq_no = 0;
  foreach ($medicines as $medicine) {
    $seq_no++;
    if ($medicine['ID'] == $id) {
      showEditOptionsRow($seq_no, $medicine);
    } else {
      showMedicineRow($seq_no, $medicine);
    }
  }
}

function showMedicineRow($seq_no, $row)
{
?>
  <tr>
    <td><?php echo $seq_no; ?></td>
    <td><?php echo $row['NAME']; ?></td>
    <td><?php echo $row['PACKING']; ?></td>
    <td><?php echo $row['GENERIC_NAME']; ?></td>
    <td><?php echo $row['SUPPLIER_NAME']; ?></td>
    <td>
      <button href="" class="btn btn-info btn-sm" onclick="editMedicine(<?php echo $row['ID']; ?>);">
        <i class="fa fa-pencil"></i>
      </button>
      <button class="btn btn-danger btn-sm" onclick="deleteMedicine(<?php echo $row['ID']; ?>);">
        <i class="fa fa-trash"></i>
      </button>
    </td>
  </tr>
<?php
}

function showEditOptionsRow($seq_no, $row)
{
?>
  <tr>
    <td><?php echo $seq_no; ?></td>
    <td>
      <input type="text" class="form-control" value="<?php echo $row['NAME']; ?>" placeholder="Medicine Name" id="medicine_name">
      <code class="text-danger small font-weight-bold float-right" id="medicine_name_error" style="display: none;"></code>
    </td>
    <td>
      <input type="text" class="form-control" value="<?php echo $row['PACKING']; ?>" placeholder="Packing" id="packing">
      <code class="text-danger small font-weight-bold float-right" id="pack_error" style="display: none;"></code>
    </td>
    <td>
      <input type="text" class="form-control" value="<?php echo $row['GENERIC_NAME']; ?>" placeholder="Generic Name" id="generic_name">
      <code class="text-danger small font-weight-bold float-right" id="generic_name_error" style="display: none;"></code>
    </td>
    <td>
      <input type="text" class="form-control" value="<?php echo $row['SUPPLIER_NAME']; ?>" placeholder="Supplier Name" id="suppliers_name">
      <code class="text-danger small font-weight-bold float-right" id="supplier_name_error" style="display: none;"></code>
    </td>
    <td>
      <button href="" class="btn btn-success btn-sm" onclick="updateMedicine(<?php echo $row['ID']; ?>);">
        <i class="fa fa-edit"></i>
      </button>
      <button class="btn btn-danger btn-sm" onclick="cancel();">
        <i class="fa fa-close"></i>
      </button>
    </td>
  </tr>
<?php
}

function updateMedicine($id, $name, $packing, $generic_name, $suppliers_name)
{
  $medicines = loadMedicines();
  foreach ($medicines as &$medicine) {
    if ($medicine['ID'] == $id) {
      $medicine['NAME'] = $name;
      $medicine['PACKING'] = $packing;
      $medicine['GENERIC_NAME'] = $generic_name;
      $medicine['SUPPLIER_NAME'] = $suppliers_name;
      break;
    }
  }
  saveMedicines($medicines);
  showMedicines(0);
}

function searchMedicine($text, $tag)
{
  $medicines = loadMedicines();
  $seq_no = 0;

  foreach ($medicines as $medicine) {
    if (strpos(strtoupper($medicine[$tag]), $text) !== false) {
      $seq_no++;
      showMedicineRow($seq_no, $medicine);
    }
  }
}
?>