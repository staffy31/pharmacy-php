
<?php
$supplierFile = '../../data/suppliers.json';
$customerFile = '../../data/customers.json';
$medicineFile = '../../data/medicines.json';

if (isset($_GET['action'])) {
  if (isset($_GET['action']) && $_GET['action'] == "supplier")
    showSuggestions($supplierFile, "supplier");

  if (isset($_GET['action']) && $_GET['action'] == "customer")
    showSuggestions($customerFile, "customer");

  if (isset($_GET['action']) && $_GET['action'] == "medicine")
    showSuggestions($medicineFile, "medicine");

  if (isset($_GET['action']) && $_GET['action'] == "customers_address")
    getValue("ADDRESS");

  if (isset($_GET['action']) && $_GET['action'] == "customers_contact_number")
    getValue("CONTACT_NUMBER");
}

function showSuggestions($jsonFile, $action)
{
  if (file_exists($jsonFile)) {
    $jsonData = file_get_contents($jsonFile);
    $data = json_decode($jsonData, true);

    if ($data !== null) {
      $text = strtoupper($_GET["text"]);
      $found = false;

      // Search for matching names
      foreach ($data as $entry) {
        if (isset($entry['NAME']) && strpos(strtoupper($entry['NAME']), $text) !== false) {
          echo '<input type="button" class="list-group-item list-group-item-action" value="' . $entry['NAME'] . '" style="padding: 5px; outline: none;" onclick="suggestionClick(this.value, \'' . $action . '\');">';
          $found = true;
        }
      }

      if (!$found) {
        echo '<div class="list-group-item list-group-item-action font-italic" style="padding: 5px;" disabled>No suggestions...</div>';
      }
    } else {
      echo "Error decoding JSON.";
    }
  } else {
    echo "File not found.";
  }
}

function getValue($column)
{
  $customerFile = '../../data/customers.json';

  if (file_exists($customerFile)) {
    $jsonData = file_get_contents($customerFile);
    $data = json_decode($jsonData, true);

    if ($data !== null) {
      $name = $_GET['name'];
      $found = false;

      foreach ($data as $entry) {
        if (isset($entry['NAME']) && $entry['NAME'] === $name) {
          if (isset($entry[$column])) {
            echo $entry[$column];
          } else {
            echo "Column not found.";
          }
          $found = true;
          break;
        }
      }

      if (!$found) {
        echo "Name not found.";
      }
    } else {
      echo "Error decoding JSON.";
    }
  } else {
    echo "File not found.";
  }
}
?>