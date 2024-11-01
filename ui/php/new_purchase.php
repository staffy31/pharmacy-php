
<?php

$jsonFilePath = '../data/customers.json';
$file_path = '../data/medicines.json';
$jsonFile = '../data/suppliers.json';

function readJson($filePath)
{
  if (!file_exists($filePath)) return [];
  $json = file_get_contents($filePath);
  return json_decode($json, true);
}

function writeJson($filePath, $data)
{
  file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));
}

function isSupplier($name)
{
  global $jsonFile; // path to suppliers.json
  $suppliers = readJson($jsonFile);
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
  $purchases = readJson('../data/purchases.json'); // assuming the path for purchases data
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
  global $file_path; // path to medicines.json
  $medicines = readJson($file_path);
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
  $file = '../data/medicines_stock.json';
  $medicinesStock = readJson($file);

  $name = ucwords($_GET['name']);
  $batch_id = strtoupper($_GET['batch_id']);
  $expiry_date = $_GET['expiry_date'];
  $quantity = $_GET['quantity'];
  $mrp = $_GET['mrp'];
  $rate = $_GET['rate'];
  $invoice_number = $_GET['invoice_number'];

  foreach ($medicinesStock as &$stock) {
    if (strtoupper($stock['NAME']) === strtoupper($name) && strtoupper($stock['BATCH_ID']) === $batch_id) {
      $stock['QUANTITY'] += $quantity;
      writeJson($file, $medicinesStock);
      return;
    }
  }

  $medicinesStock[] = [
    'ID' =>1,
    'NAME' => $name,
    'BATCH_ID' => $batch_id,
    'EXPIRY_DATE' => $expiry_date,
    'QUANTITY' => $quantity,
    'MRP' => $mrp,
    'RATE' => $rate,
    'INVOICE_NUMBER' => $invoice_number
  ];
  writeJson($file, $medicinesStock);
}

function addNewPurchase()
{
  $file = '../data/purchases.json';
  $purchases = readJson($file);

  $suppliers_name = ucwords($_GET['suppliers_name']);
  $invoice_number = $_GET['invoice_number'];
  $payment_type = $_GET['payment_type'];
  $invoice_date = $_GET['invoice_date'];
  $grand_total = $_GET['grand_total'];
  $payment_status = ($payment_type === "Payment Due") ? "DUE" : "PAID";

  $purchases[] = [
    'ID' =>1,
    'SUPPLIER_NAME' => $suppliers_name,
    'INVOICE_NUMBER' => $invoice_number,
    'PURCHASE_DATE' => $invoice_date,
    'TOTAL_AMOUNT' => $grand_total,
    'PAYMENT_STATUS' => $payment_status
  ];
  writeJson($file, $purchases);
  echo "Purchase saved...";
}
