<?php
$name = ucwords($_GET["name"]);
$packing = strtoupper($_GET["packing"]);
$generic_name = ucwords($_GET["generic_name"]);
$suppliers_name = $_GET["suppliers_name"];

// File path for the JSON file
$file_path = '../../data/medicines.json';

// Check if the file exists and read the JSON data
if (file_exists($file_path)) {
  $json_data = file_get_contents($file_path);
  $medicines = json_decode($json_data, true);
} else {
  $medicines = [];
}

// Find the highest ID in the existing data for auto-increment
$max_id = 0;
foreach ($medicines as $medicine) {
  if ($medicine['ID'] > $max_id) {
    $max_id = $medicine['ID'];
  }
}
$new_id = $max_id + 1;

// Check if the medicine already exists
$medicine_exists = false;
foreach ($medicines as $medicine) {
  if (
    strtoupper($medicine['NAME']) == strtoupper($name) &&
    strtoupper($medicine['PACKING']) == strtoupper($packing) &&
    strtoupper($medicine['SUPPLIER_NAME']) == strtoupper($suppliers_name)
  ) {
    $medicine_exists = true;
    break;
  }
}

if ($medicine_exists) {
  echo "Medicine $name with $packing already exists by supplier $suppliers_name!";
} else {
  // Add the new medicine to the array with the new ID
  $new_medicine = [
    'ID' => $new_id,
    'NAME' => $name,
    'PACKING' => $packing,
    'GENERIC_NAME' => $generic_name,
    'SUPPLIER_NAME' => $suppliers_name
  ];
  $medicines[] = $new_medicine;

  // Encode the array back to JSON and save it to the file
  if (file_put_contents($file_path, json_encode($medicines, JSON_PRETTY_PRINT))) {
    echo "$name added with ID $new_id...";
  } else {
    echo "Failed to add $name!";
  }
}
