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

// SQL สำหรับดึงข้อมูลล่าสุด
$sql = "SELECT car_presence_1, car_presence_2 FROM car_park_status ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // อ่านข้อมูลจากแถวแรกที่พบ
    $row = $result->fetch_assoc();
    // ส่งข้อมูลกลับเป็น JSON
    echo json_encode($row);
} else {
    // ในกรณีที่ไม่มีข้อมูล
    echo json_encode(["car_presence_1" => 0, "car_presence_2" => 0]);
}

$conn->close();
?>
