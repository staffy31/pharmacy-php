
<?php
$supplierFile = '../../data/suppliers.json';
$customerFile = '../../data/customers.json';
$medicineFile = '../../data/medicines.json';

if (isset($_GET['action'])) { 
  switch ($_GET['action']) {
    case "supplier":
      showSuggestionsSupplier("supplier");
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

function showSuggestionsSupplier($action) {
  $supplierFile = '../../data/suppliers.json';

  if (file_exists($supplierFile)) {
    $jsonData = file_get_contents($supplierFile);
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

function showSuggestions($jsonFile, $action) {
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

function getValue($jsonFile, $column) {
  if (file_exists($jsonFile)) {
    $jsonData = file_get_contents($jsonFile);
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