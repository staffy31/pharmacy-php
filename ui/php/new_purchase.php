<?php

if (isset($_GET['action']) && $_GET['action'] == "add_row")
  createMedicineInfoRow();

if (isset($_GET['action']) && $_GET['action'] == "is_supplier")
  isSupplier(strtoupper($_GET['name']));

if (isset($_GET['action']) && $_GET['action'] == "is_invoice")
  isInvoiceExist(strtoupper($_GET['invoice_number']));

if (isset($_GET['action']) && $_GET['action'] == "is_new_medicine")
  isNewMedicine(strtoupper($_GET['name']), strtoupper($_GET['packing']));

if (isset($_GET['action']) && $_GET['action'] == "add_stock")
  addStock();

if (isset($_GET['action']) && $_GET['action'] == "add_new_purchase")
  addNewPurchase();

function loadJsonFile($filename)
{
  if (file_exists($filename)) {
    $jsonContent = file_get_contents($filename);
    return json_decode($jsonContent, true);
  }
  return [];
}

function saveJsonFile($filename, $data)
{
  file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
}

function isSupplier($name)
{
  $suppliers = loadJsonFile('../data/suppliers.json');
  foreach ($suppliers as $supplier) {
    if (strtoupper($supplier['NAME']) === $name) {
      echo "true";
      return;
    }
  }
  echo "false";
}

function isInvoiceExist($invoice_number)
{
  $purchases = loadJsonFile('../data/purchases.json');
  foreach ($purchases as $purchase) {
    if ($purchase['INVOICE_NUMBER'] == $invoice_number) {
      echo "true";
      return;
    }
  }
  echo "false";
}

function isNewMedicine($name, $packing)
{
  $medicines = loadJsonFile('../data/medicines.json');
  foreach ($medicines as $medicine) {
    if (strtoupper($medicine['NAME']) === $name && strtoupper($medicine['PACKING']) === $packing) {
      echo "false";
      return;
    }
  }
  echo "true";
}


function addStock()
{
  $medicinesStock = loadJsonFile('../data/medicines_stock.json');
  $name = ucwords($_GET['name']);
  $batch_id = strtoupper($_GET['batch_id']);
  $expiry_date = $_GET['expiry_date'];
  $quantity = $_GET['quantity'];
  $mrp = $_GET['mrp'];
  $rate = $_GET['rate'];
  $invoice_number = $_GET['invoice_number'];

  $found = false;
  foreach ($medicinesStock as &$stock) {
    if (strtoupper($stock['NAME']) === strtoupper($name) && strtoupper($stock['BATCH_ID']) === $batch_id) {
      $stock['QUANTITY'] += $quantity;
      $found = true;
      break;
    }
  }

  if (!$found) {
    $medicinesStock[] = [
      'ID' => 1,
      'NAME' => $name,
      'BATCH_ID' => $batch_id,
      'EXPIRY_DATE' => $expiry_date,
      'QUANTITY' => $quantity,
      'MRP' => $mrp,
      'RATE' => $rate,
      'INVOICE_NUMBER' => $invoice_number
    ];
  }

  saveJsonFile('../data/medicines_stock.json', $medicinesStock);
  echo $found ? "Stock updated" : "New stock added";
}

function addNewPurchase()
{
  $purchases = loadJsonFile('../data/purchases.json');
  $suppliers_name = ucwords($_GET['suppliers_name']);
  $invoice_number = $_GET['invoice_number'];
  $payment_type = $_GET['payment_type'];
  $invoice_date = $_GET['invoice_date'];
  $grand_total = $_GET['grand_total'];
  $payment_status = ($payment_type == "Payment Due") ? "DUE" : "PAID";

  $newPurchase = [
    'ID' => 1,
    'SUPPLIER_NAME' => $suppliers_name,
    'INVOICE_NUMBER' => $invoice_number,
    'PURCHASE_DATE' => $invoice_date,
    'TOTAL_AMOUNT' => $grand_total,
    'PAYMENT_STATUS' => $payment_status
  ];

  $purchases[] = $newPurchase;
  saveJsonFile('../data/purchases.json', $purchases);

  echo "Purchase saved...";
}

function createMedicineInfoRow()
{
  $row_id = $_GET['row_id'];
  $row_number = $_GET['row_number'];
?>
  <div class="row col col-md-12">
    <div class="col col-md-2">
      <input type="text" class="form-control" placeholder="Medicine Name" name="medicine_name">
      <code class="text-danger small font-weight-bold float-right" id="medicine_name_error_<?php echo $row_number; ?>" style="display: none;"></code>
    </div>
    <div class="col col-md-1">
      <input type="text" class="form-control" name="packing">
      <code class="text-danger small font-weight-bold float-right" id="pack_error_<?php echo $row_number; ?>" style="display: none;"></code>
    </div>
    <div class="col col-md-2">
      <input type="text" class="form-control" name="batch_id">
      <code class="text-danger small font-weight-bold float-right" id="batch_id_error_<?php echo $row_number; ?>" style="display: none;"></code>
    </div>
    <div class="col col-md-1">
      <input type="text" class="form-control" name="expiry_date">
      <code class="text-danger small font-weight-bold float-right" id="expiry_date_error_<?php echo $row_number; ?>" style="display: none;"></code>
    </div>
    <div class="col col-md-1">
      <input type="number" class="form-control" placeholder="0" id="quantity_<?php echo $row_number; ?>" name="quantity" onkeyup="getAmount(<?php echo $row_number; ?>);">
      <code class="text-danger small font-weight-bold float-right" id="quantity_error_<?php echo $row_number; ?>" style="display: none;"></code>
    </div>
    <div class="col col-md-1">
      <input type="number" class="form-control" name="mrp">
      <code class="text-danger small font-weight-bold float-right" id="mrp_error_<?php echo $row_number; ?>" style="display: none;"></code>
    </div>
    <div class="col col-md-1">
      <input type="number" class="form-control" id="rate_<?php echo $row_number; ?>" name="rate" onkeyup="getAmount(<?php echo $row_number; ?>);">
      <code class="text-danger small font-weight-bold float-right" id="rate_error_<?php echo $row_number; ?>" style="display: none;"></code>
    </div>
    <div class="row col col-md-3">
      <div class="col col-md-7"><input type="text" class="form-control" id="amount_<?php echo $row_number; ?>" disabled></div>
      <div class="col col-md-5">
        <button class="btn btn-primary" onclick="addRow();">
          <i class="fa fa-plus"></i>
        </button>
        <button class="btn btn-danger" onclick="removeRow('<?php echo $row_id ?>');">
          <i class="fa fa-trash"></i>
        </button>
      </div>
    </div>
  </div><br>
  <div class="row col col-md-8">
    <div class="col col-md-4"><label for="generic_name" class="font-weight-bold">&nbsp;If new medicine, generic name : </label></div>
    <div class="col col-md-8">
      <input type="text" class="form-control" placeholder="Generic Name" name="generic_name">
      <code class="text-danger small font-weight-bold float-right" id="generic_name_error_<?php echo $row_number; ?>" style="display: none;"></code>
    </div>
  </div>
  <div class="col col-md-12">
    <hr class="col-md-12" style="padding: 0px;">
  </div>
<?php
}
?>