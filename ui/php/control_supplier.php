<?php
// File path for the JSON file
$jsonFile = '../data/suppliers.json';

if (file_exists($jsonFile)) {
  $data = json_decode(file_get_contents($jsonFile), true);
} else {
  $data = [];
}

if (isset($_GET["action"])) {
  $action = $_GET["action"];

  switch ($action) {
    case "delete":
      $id = $_GET["id"];
      deleteSupplier($id, $data);
      break;
    case "edit":
      $id = $_GET["id"];
      showSuppliers($data, $id);
      break;
    case "update":
      $id = $_GET["id"];
      $name = ucwords($_GET["name"]);
      $email = $_GET["email"];
      $contact_number = $_GET["contact_number"];
      $address = ucwords($_GET["address"]);
      updateSupplier($id, $name, $email, $contact_number, $address, $data);
      break;
    case "cancel":
      showSuppliers($data, 0);
      break;
    case "search":
      $text = strtoupper($_GET["text"]);
      searchSupplier($text, $data);
      break;
  }
}

function showSuppliers($data, $id)
{
  $seq_no = 0;
  foreach ($data as $supplier) {
    $seq_no++;
    if ($supplier['id'] == $id) {
      showEditOptionsRow($seq_no, $supplier);
    } else {
      showSupplierRow($seq_no, $supplier);
    }
  }
}

function showSupplierRow($seq_no, $supplier)
{
?>
  <tr>
    <td><?php echo $seq_no; ?></td>
    <td><?php echo $supplier['id']; ?></td>
    <td><?php echo $supplier['name']; ?></td>
    <td><?php echo $supplier['email']; ?></td>
    <td><?php echo $supplier['contact_number']; ?></td>
    <td><?php echo $supplier['address']; ?></td>
    <td>
      <button class="btn btn-info btn-sm" onclick="editSupplier(<?php echo $supplier['id']; ?>);">
        <i class="fa fa-pencil"></i>
      </button>
      <button class="btn btn-danger btn-sm" onclick="deleteSupplier(<?php echo $supplier['id']; ?>);">
        <i class="fa fa-trash"></i>
      </button>
    </td>
  </tr>
<?php
}

function showEditOptionsRow($seq_no, $supplier)
{
?>
  <tr>
    <td><?php echo $seq_no; ?></td>
    <td><?php echo $supplier['id']; ?></td>
    <td>
      <input type="text" class="form-control" value="<?php echo $supplier['name']; ?>" placeholder="Name" id="supplier_name">
    </td>
    <td>
      <input type="email" class="form-control" value="<?php echo $supplier['email']; ?>" placeholder="Email" id="supplier_email">
    </td>
    <td>
      <input type="number" class="form-control" value="<?php echo $supplier['contact_number']; ?>" placeholder="Contact Number" id="supplier_contact_number">
    </td>
    <td>
      <textarea class="form-control" placeholder="Address" id="supplier_address"><?php echo $supplier['address']; ?></textarea>
    </td>
    <td>
      <button class="btn btn-success btn-sm" onclick="updateSupplier(<?php echo $supplier['id']; ?>);">
        <i class="fa fa-edit"></i>
      </button>
      <button class="btn btn-danger btn-sm" onclick="cancel();">
        <i class="fa fa-close"></i>
      </button>
    </td>
  </tr>
<?php
}

function updateSupplier($id, $name, $email, $contact_number, $address, &$data)
{
  foreach ($data as &$supplier) {
    if ($supplier['id'] == $id) {
      $supplier['name'] = $name;
      $supplier['email'] = $email;
      $supplier['contact_number'] = $contact_number;
      $supplier['address'] = $address;
      break;
    }
  }
  saveData($data);
  showSuppliers($data, 0);
}

function deleteSupplier($id, &$data)
{
  $data = array_filter($data, function ($supplier) use ($id) {
    return $supplier['id'] != $id;
  });
  saveData(array_values($data));  // Re-index array after deletion
  showSuppliers($data, 0);
}

function searchSupplier($text, $data)
{
  $seq_no = 0;
  foreach ($data as $supplier) {
    if (strpos(strtoupper($supplier['name']), $text) !== false) {
      $seq_no++;
      showSupplierRow($seq_no, $supplier);
    }
  }
}

function saveData($data)
{
  global $jsonFile;
  file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));
}
?>