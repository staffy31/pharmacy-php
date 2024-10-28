<?php
// Define the file path to store the data
$jsonFilePath = '../../data/customers.json';

// Fetch the data from GET parameters
$name = ucwords($_GET["name"]);
$contact_number = $_GET["contact_number"];
$address = ucwords($_GET["address"]);
$doctor_name = ucwords($_GET["doctor_name"]);
$doctor_address = ucwords($_GET["doctor_address"]);

// Load existing data from JSON file
if (file_exists($jsonFilePath)) {
    $jsonData = file_get_contents($jsonFilePath);
    $customers = json_decode($jsonData, true) ?: [];
} else {
    $customers = [];
}

// Determine the next available ID
$nextId = 1;
if (!empty($data)) {
    $ids = array_column($data, 'ID');
    $nextId = max($ids) + 1;
}

// Check if the customer already exists
$customerExists = false;
foreach ($customers as $customer) {
    if ($customer['CONTACT_NUMBER'] == $contact_number) {
        $customerExists = true;
        echo "Customer " . $customer['NAME'] . " with contact number $contact_number already exists!";
        break;
    }
}

// Add new customer if not already present
if (!$customerExists) {
    $newCustomer = [
        "ID" => $nextId,
        'NAME' => $name,
        'CONTACT_NUMBER' => $contact_number,
        'ADDRESS' => $address,
        'DOCTOR_NAME' => $doctor_name,
        'DOCTOR_ADDRESS' => $doctor_address,
    ];
    $customers[] = $newCustomer;

    // Save updated data back to JSON file
    if (file_put_contents($jsonFilePath, json_encode($customers, JSON_PRETTY_PRINT))) {
        echo "$name added...";
    } else {
        echo "Failed to add $name!";
    }
}
