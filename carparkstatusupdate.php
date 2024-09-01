<?php
// การตั้งค่าการเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ipark";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// รับข้อมูลจากคำขอ GET หรือ POST (เลือกตามว่าอุปกรณ์ของคุณส่งข้อมูลมาแบบไหน)
$carPresence1 = isset($_GET['carPresence1']) ? $_GET['carPresence1'] : 1;
$carPresence2 = isset($_GET['carPresence2']) ? $_GET['carPresence2'] : 1;

// SQL สำหรับการบันทึกข้อมูล
$sql = "INSERT INTO car_park_status (car_presence_1, car_presence_2) VALUES (?, ?)";

// ใช้ prepared statement เพื่อป้องกัน SQL injection
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $carPresence1, $carPresence2);

if ($stmt->execute()) {
  echo "New record created successfully";
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
