<?php
$email = $_GET['email'];

$servername = "localhost";
$username = "your_username";
$password = "your_password";
$database = "your_database";

$pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

$stmt = $pdo->prepare("SELECT report_path FROM health_reports WHERE email = ?");
$stmt->bindParam(1, $email);
$stmt->execute();

if ($stmt->rowCount() > 0) {
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $reportPath = $row['report_path'];

  header("Content-type: application/pdf");
  header("Content-Disposition: attachment; filename=health_report.pdf");
  
  readfile($reportPath);
} else {
  echo "Health report not found for the given email.";
}
?>
