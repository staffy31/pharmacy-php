<?php
// Define the file path to store the data
$jsonFilePath = '../../data/customers.json';

// Load customers from JSON
function loadCustomers() {
    global $jsonFilePath;
    if (file_exists($jsonFilePath)) {
        $jsonData = file_get_contents($jsonFilePath);
        return json_decode($jsonData, true) ?: [];
    }
    return [];
}

// Save customers to JSON
function saveCustomers($customers) {
    global $jsonFilePath;
    file_put_contents($jsonFilePath, json_encode($customers, JSON_PRETTY_PRINT));
}

// Generate a new auto-incrementing ID
function getNextId($customers) {
    $maxId = 0;
    foreach ($customers as $customer) {
        if ($customer['ID'] > $maxId) {
            $maxId = $customer['ID'];
        }
    }
    return $maxId + 1;
}

// Function to add a new customer
function addCustomer($name, $contact_number, $address, $doctor_name, $doctor_address) {
    // Load existing customers
    $customers = loadCustomers();

    // Generate a new ID
    $newId = getNextId($customers);

    // Create a new customer entry
    $newCustomer = [
        'ID' => $newId,
        'NAME' => $name,
        'CONTACT_NUMBER' => $contact_number,
        'ADDRESS' => $address,
        'DOCTOR_NAME' => $doctor_name,
        'DOCTOR_ADDRESS' => $doctor_address,
    ];

    // Add the new customer to the list
    $customers[] = $newCustomer;

    // Save the updated list back to the JSON file
    saveCustomers($customers);

    echo "$name has been added with ID $newId.";
}

// Example usage
$name = ucwords($_GET["name"]);
$contact_number = $_GET["contact_number"];
$address = ucwords($_GET["address"]);
$doctor_name = ucwords($_GET["doctor_name"]);
$doctor_address = ucwords($_GET["doctor_address"]);

addCustomer($name, $contact_number, $address, $doctor_name, $doctor_address);