<?php
// Retrieve and sanitize input
$name = ucwords($_GET["name"]);
$email = $_GET["email"];
$contact_number = $_GET["contact_number"];
$address = ucwords($_GET["address"]);

// Load the existing data from the JSON file
$jsonFile = '../../data/suppliers.json';
$data = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

// Determine the next available ID
$nextId = 1;
if (!empty($data)) {
    $ids = array_column($data, 'id');
    $nextId = !empty($ids) ? max($ids) + 1 : 1;
}

// Check if the supplier already exists by name
$supplierExists = false;
foreach ($data as $supplier) {
    if (strtoupper($supplier['name']) === strtoupper($name)) {
        $supplierExists = true;
        break;
    }
}

if ($supplierExists) {
    echo "Supplier with name $name already exists!";
} else {
    // Append the new supplier data
    $newSupplier = [
        "id" => $nextId,
        "name" => $name,
        "email" => $email,
        "contact_number" => $contact_number,
        "address" => $address
    ];
    $data[] = $newSupplier;

    // Save the updated data back to the JSON file
    if (file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT))) {
        echo "$name added...";
    } else {
        echo "Failed to add $name!";
    }
}
