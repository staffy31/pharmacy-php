<?php
$jsonFilePath = '../data/customers.json';

// Function to load customers from JSON
function loadCustomers()
{
  global $jsonFilePath;
  if (file_exists($jsonFilePath)) {
    $jsonData = file_get_contents($jsonFilePath);
    return json_decode($jsonData, true) ?: [];
  }
  return [];
}

// Function to save customers to JSON
function saveCustomers($customers)
{
  global $jsonFilePath;
  file_put_contents($jsonFilePath, json_encode($customers, JSON_PRETTY_PRINT));
}

// Handle different actions based on $_GET['action']
if (file_exists($jsonFilePath)) {
  $action = $_GET["action"] ?? null;

  if ($action == "delete") {
    $id = $_GET["id"];
    deleteCustomer($id);
    showCustomers(0);
  }

  if ($action == "edit") {
    $id = $_GET["id"];
    showCustomers($id);
  }

  if ($action == "update") {
    $id = $_GET["id"];
    $name = ucwords($_GET["name"]);
    $contact_number = $_GET["contact_number"];
    $address = ucwords($_GET["address"]);
    $doctor_name = ucwords($_GET["doctor_name"]);
    $doctor_address = ucwords($_GET["doctor_address"]);
    updateCustomer($id, $name, $contact_number, $address, $doctor_name, $doctor_address);
  }

  if ($action == "cancel") {
    showCustomers(0);
  }

  if ($action == "search") {
    echo',,,'.$_GET["text"].'...'.$action;

    searchCustomer(strtoupper($_GET["text"]));
  }
}

// Function to show customers
function showCustomers($editId)
{
  $customers = loadCustomers();
  $seq_no = 0;
  foreach ($customers as $customer) {
    $seq_no++;
    if ($customer['ID'] == $editId) {
      showEditOptionsRow($seq_no, $customer);
    } else {
      showCustomerRow($seq_no, $customer);
    }
  }
}

// Function to delete a customer
function deleteCustomer($id)
{
  $customers = loadCustomers();
  $customers = array_filter($customers, fn($customer) => $customer['ID'] != $id);
  saveCustomers($customers);
}

// Function to update a customer
function updateCustomer($id, $name, $contact_number, $address, $doctor_name, $doctor_address)
{
  $customers = loadCustomers();
  foreach ($customers as &$customer) {
    if ($customer['ID'] == $id) {
      $customer['NAME'] = $name;
      $customer['CONTACT_NUMBER'] = $contact_number;
      $customer['ADDRESS'] = $address;
      $customer['DOCTOR_NAME'] = $doctor_name;
      $customer['DOCTOR_ADDRESS'] = $doctor_address;
      break;
    }
  }
  saveCustomers($customers);
  showCustomers(0);
}

// Function to search for customers by name
function searchCustomer($text)
{
  $customers = loadCustomers();
  $seq_no = 0;
  foreach ($customers as $customer) {
    if (strpos(strtoupper($customer['NAME']), $text) !== false) {
      $seq_no++;
      showCustomerRow($seq_no, $customer);
    }
  }
}

// Function to display a customer row
function showCustomerRow($seq_no, $customer)
{
?>
  <tr>
    <td><?php echo $seq_no; ?></td>
    <td><?php echo htmlspecialchars($customer['ID']); ?></td>
    <td><?php echo htmlspecialchars($customer['NAME']); ?></td>
    <td><?php echo htmlspecialchars($customer['CONTACT_NUMBER']); ?></td>
    <td><?php echo htmlspecialchars($customer['ADDRESS']); ?></td>
    <td><?php echo htmlspecialchars($customer['DOCTOR_NAME']); ?></td>
    <td><?php echo htmlspecialchars($customer['DOCTOR_ADDRESS']); ?></td>
    <td>
      <button class="btn btn-info btn-sm" onclick="editCustomer(<?php echo htmlspecialchars($customer['ID']); ?>);">
        <i class="fa fa-pencil"></i>
      </button>
      <button class="btn btn-danger btn-sm" onclick="deleteCustomer(<?php echo htmlspecialchars($customer['ID']); ?>);">
        <i class="fa fa-trash"></i>
      </button>
    </td>
  </tr>
<?php
}

// Function to display the edit row for a customer
function showEditOptionsRow($seq_no, $customer)
{
?>
  <tr>
    <td><?php echo $seq_no; ?></td>
    <td><?php echo htmlspecialchars($customer['ID']); ?></td>
    <td>
      <input type="text" class="form-control" value="<?php echo htmlspecialchars($customer['NAME']); ?>" placeholder="Name" id="customer_name">
    </td>
    <td>
      <input type="number" class="form-control" value="<?php echo htmlspecialchars($customer['CONTACT_NUMBER']); ?>" placeholder="Contact Number" id="customer_contact_number">
    </td>
    <td>
      <textarea class="form-control" placeholder="Address" id="customer_address"><?php echo htmlspecialchars($customer['ADDRESS']); ?></textarea>
    </td>
    <td>
      <input type="text" class="form-control" value="<?php echo htmlspecialchars($customer['DOCTOR_NAME']); ?>" placeholder="Doctor's Name" id="customer_doctors_name">
    </td>
    <td>
      <textarea class="form-control" placeholder="Doctor's Address" id="customer_doctors_address"><?php echo htmlspecialchars($customer['DOCTOR_ADDRESS']); ?></textarea>
    </td>
    <td>
      <button class="btn btn-success btn-sm" onclick="updateCustomer(<?php echo htmlspecialchars($customer['ID']); ?>);">
        <i class="fa fa-edit"></i>
      </button>
      <button class="btn btn-danger btn-sm" onclick="cancel();">
        <i class="fa fa-close"></i>
      </button>
    </td>
  </tr>
<?php
}
?>