<?php
$name = $_POST['name'];
$age = $_POST['age'];
$weight = $_POST['weight'];
$email = $_POST['email'];

$targetDir = "uploads/";
$targetFile = $targetDir . basename($_FILES["healthReport"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

if ($fileType != "pdf") {
  echo json_encode(['success' => false, 'message' => 'Only PDF files are allowed.']);
  exit;
}

if (move_uploaded_file($_FILES["healthReport"]["tmp_name"], $targetFile)) {
  $servername = "localhost";
  $username = "your_username";
  $password = "your_password";
  $database = "your_database";

  $pdo = new PDO("mysql:host=localhost;dbname=$database", $username, $password);

  $stmt = $pdo->prepare("INSERT INTO health_reports (name, age, weight, email, report_path) VALUES (?, ?, ?, ?, ?)");

  $stmt->bindParam(1, $name);
  $stmt->bindParam(2, $age);
  $stmt->bindParam(3, $weight);
  $stmt->bindParam(4, $email);
  $stmt->bindParam(5, $targetFile);

  if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Health report submitted successfully.']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Failed to submit health report.']);
  }
} else {
  echo json_encode(['success' => false, 'message' => 'Failed to upload health report.']);
}

?>