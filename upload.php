<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
  $file = $_FILES['file'];

  // Generate a unique folder name
  $folderName = generateUniqueFolderName();

  // Create the folder
  if (!is_dir($folderName)) {
    mkdir($folderName);
  }

  // Move the uploaded file to the folder
  $destination = $folderName . '/' . basename($file['name']);
  if (move_uploaded_file($file['tmp_name'], $destination)) {
    // Create index.html in the folder
    $indexContent = '<!DOCTYPE html>
<html>
<head>
  <title>Kool - A webapp that lets you upload, download your important files</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      padding: 50px;
      background-color: #f0f0f0;
    }

    #downloadButton {
      padding: 12px 24px;
      background-color: #2ecc71;
      color: #ffffff;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }

    #downloadButton:hover {
      background-color: #27ae60;
    }

    #downloadButton:active {
      background-color: #24a452;
    }
  </style>
</head>
<body>
<h1>
  <h1>
  <p></p>
  <p><a href="' . basename($file['name']) . '" id="downloadButton" download>Download File</a></p>
</body>
</html>';

    file_put_contents($folderName . '/index.html', $indexContent);

    http_response_code(200);
    echo $folderName;
  } else {
    http_response_code(500);
  }
} else {
  http_response_code(400);
}

// Function to generate a unique folder name
function generateUniqueFolderName() {
  return date('YmdHis') . '_' . generateRandomString(8);
}

// Function to generate a random string
function generateRandomString($length = 10) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}
?>
