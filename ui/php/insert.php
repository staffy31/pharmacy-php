<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = htmlspecialchars($_POST['name']);
  $email = htmlspecialchars($_POST['email']);
  $age = intval($_POST['age']);

  $new_data = array(
    'name' => $name,
    'email' => $email,
    'age' => $age
  );

  $file = '../../data/data.json';

  if (file_exists($file)) {
    $json_data = file_get_contents($file);
    $data = json_decode($json_data, true);
  } else {
    $data = array();
  }

  $data[] = $new_data;

  $json_data = json_encode($data, JSON_PRETTY_PRINT);

  if (file_put_contents($file, $json_data)) {
    header('Location: ../forms/inputs.php'); 
    exit();
  } else {
    echo "Error writing to JSON file.";
  }
} else {
  echo "Invalid request.";
}
