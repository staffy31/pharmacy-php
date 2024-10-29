
<?php
// Define JSON file paths
$supplierFile = '../../data/suppliers.json';
$customerFile = '../../data/customers.json';
$medicineFile = '../../data/medicines.json';

if (isset($_GET['action'])) {
  $action = $_GET['action'];

  switch ($action) {
    case "supplier":
      showSuggestions($supplierFile, "supplier");
      break;
    case "customer":
      showSuggestions($customerFile, "customer");
      break;
    case "medicine":
      showSuggestions($medicineFile, "medicine");
      break;
    case "customers_address":
      getValue($customerFile, "ADDRESS");
      break;
    case "customers_contact_number":
      getValue($customerFile, "CONTACT_NUMBER");
      break;
  }
}

function showSuggestions($filePath, $action)
{
  $text = strtoupper($_GET["text"]);
  echo $action;

  // Load JSON data from file
  $data = file_exists($filePath) ? json_decode(file_get_contents($filePath), true) : [];

  $found = false;
  foreach ($data as $item) {
    if (strpos(strtoupper($item['name']), $text) !== false) {
      $found = true;
      echo '<input type="button" class="list-group-item list-group-item-action" value="' . $item['name'] . '" style="padding: 5px; outline: none;" onclick="suggestionClick(this.value, \'' . $action . '\');">';
    }
  }

  if (!$found) {
    echo '<div class="list-group-item list-group-item-action font-italic" style="padding: 5px;" disabled>No suggestions...</div>';
  }
}

function getValue($filePath, $column)
{
  $name = $_GET['name'];

  // Load JSON data from file
  $data = file_exists($filePath) ? json_decode(file_get_contents($filePath), true) : [];

  foreach ($data as $item) {
    if (strtoupper($item['name']) === strtoupper($name)) {
      echo $item[$column];
      return;
    }
  }
  echo "No data found.";
}
?>
