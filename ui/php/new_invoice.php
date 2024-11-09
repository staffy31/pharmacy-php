<?php

if (isset($_GET['action']) && $_GET['action'] == "add_row")
  createMedicineInfoRow();

if (isset($_GET['action']) && $_GET['action'] == "is_customer")
  isCustomer(strtoupper($_GET['name']), $_GET['contact_number']);

if (isset($_GET['action']) && $_GET['action'] == "is_invoice")
  isInvoiceExist($_GET['invoice_number']);

if (isset($_GET['action']) && $_GET['action'] == "is_medicine")
  isMedicine(strtoupper($_GET['name']));

if (isset($_GET['action']) && $_GET['action'] == "current_invoice_number")
  getInvoiceNumber();

if (isset($_GET['action']) && $_GET['action'] == "medicine_list")
  showMedicineList(strtoupper($_GET['text']));

if (isset($_GET['action']) && $_GET['action'] == "fill")
  fill(strtoupper($_GET['name']), $_GET['column']);

if (isset($_GET['action']) && $_GET['action'] == "check_quantity")
  checkAvailableQuantity(strtoupper($_GET['medicine_name']));

if (isset($_GET['action']) && $_GET['action'] == "update_stock")
  updateStock(strtoupper($_GET['name']), $_GET['batch_id'], intval($_GET['quantity']));

if (isset($_GET['action']) && $_GET['action'] == "add_sale")
  addSale();

if (isset($_GET['action']) && $_GET['action'] == "add_new_invoice")
  addNewInvoice();

function isCustomer($name, $contact_number)
{
  $jsonFilePath = '../data/customers.json';
  $name = strtoupper($name);
  if (file_exists($jsonFilePath)) {
    $jsonData = json_decode(file_get_contents($jsonFilePath), true);

    if ($jsonData) {
      $found = false;
      foreach ($jsonData as $customer) {
        if (strtoupper($customer['NAME']) === $name && $customer['CONTACT_NUMBER'] === $contact_number) {
          $found = true;
          break;
        }
      }
      echo $found ? "true" : "false";
    } else {
      echo "Error: Failed to decode JSON data.";
    }
  } else {
    echo "Error: JSON file not found.";
  }
}

function getCustomerId($name, $contact_number)
{
  $name = strtoupper($name);

  $jsonFilePath = '../data/customers.json';

  if (file_exists($jsonFilePath)) {
    $jsonData = json_decode(file_get_contents($jsonFilePath), true);

    if ($jsonData) {
      foreach ($jsonData as $customer) {
        if (strtoupper($customer['NAME']) === $name && $customer['CONTACT_NUMBER'] === $contact_number) {
          return $customer['ID'];
        }
      }
    } else {
      echo "Error: Failed to decode JSON data.";
    }
  } else {
    echo "Error: JSON file not found.";
  }

  return 0;
}

function createMedicineInfoRow()
{
  $row_id = $_GET['row_id'];
  $row_number = $_GET['row_number'];
?>
  <div class="row col col-md-12">
    <div class="col-md-2">
      <input id="medicine_name_<?php echo $row_number; ?>" name="medicine_name" class="form-control" list="medicine_list_<?php echo $row_number; ?>" placeholder="Select Medicine" onkeydown="medicineOptions(this.value, 'medicine_list_<?php echo $row_number; ?>');" onfocus="medicineOptions(this.value, 'medicine_list_<?php echo $row_number; ?>');" onchange="fillFields(this.value, '<?php echo $row_number; ?>');">
      <code class="text-danger small font-weight-bold float-right" id="medicine_name_error_<?php echo $row_number; ?>" style="display: none;"></code>
      <datalist id="medicine_list_<?php echo $row_number; ?>" style="display: none; max-height: 200px; overflow: auto;">
        <?php showMedicineList("") ?>
      </datalist>
    </div>
    <div class="col col-md-2"><input type="text" class="form-control" id="batch_id_<?php echo $row_number; ?>" disabled></div>
    <div class="col col-md-1"><input type="number" class="form-control" id="available_quantity_<?php echo $row_number; ?>" disabled></div>
    <div class="col col-md-1"><input type="text" class="form-control" id="expiry_date_<?php echo $row_number; ?>" disabled></div>
    <div class="col col-md-1">
      <input type="number" class="form-control" id="quantity_<?php echo $row_number; ?>" value="0" onkeyup="getTotal('<?php echo $row_number; ?>');" onblur="checkAvailableQuantity(this.value, '<?php echo $row_number; ?>');">
      <code class="text-danger small font-weight-bold float-right" id="quantity_error_<?php echo $row_number; ?>" style="display: none;"></code>
    </div>
    <div class="col col-md-1"><input type="number" class="form-control" id="mrp_<?php echo $row_number; ?>" onchange="getTotal('<?php echo $row_number; ?>');" disabled></div>
    <div class="col col-md-1">
      <input type="number" class="form-control" id="discount_<?php echo $row_number; ?>" value="0" onkeyup="getTotal('<?php echo $row_number; ?>');">
      <code class="text-danger small font-weight-bold float-right" id="discount_error_<?php echo $row_number; ?>" style="display: none;"></code>
    </div>
    <div class="col col-md-1"><input type="number" class="form-control" id="total_<?php echo $row_number; ?>" disabled></div>
    <div class="col col-md-2">
      <button class="btn btn-primary" onclick="addRow();">
        <i class="fa fa-plus"></i>
      </button>
      <button class="btn btn-danger" onclick="removeRow('<?php echo $row_id ?>');">
        <i class="fa fa-trash"></i>
      </button>
    </div>
  </div>
  <div class="col col-md-12">
    <hr class="col-md-12" style="padding: 0px;">
  </div>
<?php
}
function addNewInvoice()
{

  $customer_id = getCustomerId(strtoupper($_GET['customers_name']), $_GET['customers_contact_number']);
  $invoice_date = $_GET['invoice_date'];
  $total_amount = $_GET['total_amount'];
  $total_discount = $_GET['total_discount'];
  $net_total = $_GET['net_total'];

  $jsonFilePath = '../data/invoices.json';

  $newInvoice = [
    'ID' => 1,
    "CUSTOMER_ID" => $customer_id,
    "INVOICE_DATE" => $invoice_date,
    "TOTAL_AMOUNT" => $total_amount,
    "TOTAL_DISCOUNT" => $total_discount,
    "NET_TOTAL" => $net_total
  ];

  if (file_exists($jsonFilePath)) {
    $jsonData = json_decode(file_get_contents($jsonFilePath), true);

    if ($jsonData) {
      $jsonData[] = $newInvoice;

      $jsonDataEncoded = json_encode($jsonData, JSON_PRETTY_PRINT);

      if (file_put_contents($jsonFilePath, $jsonDataEncoded)) {
        echo "Invoice saved...";
      } else {
        echo "Failed to save the invoice...";
      }
    } else {
      echo "Error: Failed to decode JSON data.";
    }
  } else {
    $initialData = json_encode([$newInvoice], JSON_PRETTY_PRINT);
    if (file_put_contents($jsonFilePath, $initialData)) {
      echo "Invoice saved...";
    } else {
      echo "Failed to create the JSON file...";
    }
  }
}
function addSale()
{

  $customer_id = getCustomerId(strtoupper($_GET['customers_name']), $_GET['customers_contact_number']);
  $invoice_number = $_GET['invoice_number'];
  $medicine_name = $_GET['medicine_name'];
  $batch_id = $_GET['batch_id'];
  $expiry_date = $_GET['expiry_date'];
  $quantity = $_GET['quantity'];
  $mrp = $_GET['mrp'];
  $discount = $_GET['discount'];
  $total = $_GET['total'];

  $jsonFilePath = '../data/sales.json';

  $newSale = [
    'ID' => 1,
    "CUSTOMER_ID" => $customer_id,
    "INVOICE_NUMBER" => $invoice_number,
    "MEDICINE_NAME" => $medicine_name,
    "BATCH_ID" => $batch_id,
    "EXPIRY_DATE" => $expiry_date,
    "QUANTITY" => $quantity,
    "MRP" => $mrp,
    "DISCOUNT" => $discount,
    "TOTAL" => $total
  ];

  if (file_exists($jsonFilePath)) {
    $jsonData = json_decode(file_get_contents($jsonFilePath), true);

    if ($jsonData) {
      $jsonData[] = $newSale;

      $jsonDataEncoded = json_encode($jsonData, JSON_PRETTY_PRINT);

      if (file_put_contents($jsonFilePath, $jsonDataEncoded)) {
        echo "Inserted sale";
      } else {
        echo "Failed to add sale...";
      }
    } else {
      echo "Error: Failed to decode JSON data.";
    }
  } else {
    $initialData = json_encode([$newSale], JSON_PRETTY_PRINT);
    if (file_put_contents($jsonFilePath, $initialData)) {
      echo "Inserted sale";
    } else {
      echo "Failed to create the JSON file...";
    }
  }
}
