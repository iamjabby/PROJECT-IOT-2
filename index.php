<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Park Status</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        body {
            font-family: Lucida Console, Monaco, monospace;
            margin: 0;
            padding: 20px;
            background-color: #BBE2EC;
            color: #343a40;
        }
        h1 {
            text-align: center;
            margin-bottom: 40px;
        }
        h2 {
            text-align: center;
            margin-bottom: 40px;
        }
        p {
            background-color: #FFF6E9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            font-size: 20px;
        }
        span {
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 5px;
            color: #fff;
        }
        .Empty {
            background-color: #dc3545; /* Red */
        }
        .Occupied {
            background-color: #0D9276; /* Green */
        }
        img {
            margin-top: 20px;
            width: 80%; /* Adjust based on preference */
            max-width: 400px; /* Adjust based on preference */
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <h1>iPark</h1>

    <h2>Parking status</h2>

    <img src="https://i.pinimg.com/originals/f9/3f/ff/f93fffe7f84bd6493c1dcf3d2959dd1f.jpg" alt="Car Park" style="display:block; margin:auto;" >

    <p><strong>Garage 1:</strong> <span id="garage1" class="ไม่มีรถ">กำลังโหลด...</span></p>
    <p><strong>Garage 2:</strong> <span id="garage2" class="ไม่มีรถ">กำลังโหลด...</span></p>

    <script>
    $(document).ready(function(){
        function fetchStatus() {
            $.ajax({
                url: 'fetch_status.php', // URL ของไฟล์ PHP ที่ดึงข้อมูล
                type: 'GET',
                success: function(response){
                    var data = JSON.parse(response);
                    var garage1Status = data.car_presence_1 == 1 ? 'Empty' : 'Occupied';
                    var garage2Status = data.car_presence_2 == 1 ? 'Empty' : 'Occupied';
                    $('#garage1').text(garage1Status).attr("class", garage1Status);
                    $('#garage2').text(garage2Status).attr("class", garage2Status);
                },
                error: function(error) {
                    console.log("Error fetching status:", error);
                }
            });
        }

        fetchStatus(); // เรียกใช้เมื่อหน้าเว็บโหลด
        setInterval(fetchStatus, 5000); // อัพเดทข้อมูลทุก 5 วินาที
    });
    </script>
</body>
</html>
