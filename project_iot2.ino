#include <ESP8266WiFi.h>
#include <WiFiClient.h>

// -- WiFi network settings --
const char* ssid = "WifiSomying"; // SSID ของ WiFi ที่คุณต้องการเชื่อมต่อ
const char* password = "SomsakSuksom"; // Password ของ WiFi
const char* host = "172.20.10.3"; // IP address ของเซิร์ฟเวอร์ที่ต้องการส่งข้อมูลไป

// -- GPIO pins --
const int irSensorPin1 = D2; // First IR sensor pin (Garage1)
const int irSensorPin2 = D5; // Second IR sensor pin (Garage2)

// -- Other settings --
const int readInterval = 10000; // Interval for checking car presence (10 seconds)

void setup() {
  Serial.begin(115200);
  pinMode(irSensorPin1, INPUT); // Set the IR sensor pin as input
  pinMode(irSensorPin2, INPUT); // Set the second IR sensor pin as input

  // Connect to WiFi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("WiFi connected");
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
}

void loop() {
  // Read sensor values
  int carPresence1 = digitalRead(irSensorPin1);
  int carPresence2 = digitalRead(irSensorPin2);

  // Send car park status to server
  sendCarParkStatus(carPresence1, carPresence2);

  delay(readInterval); // Wait for a specified interval before checking again
}

void sendCarParkStatus(int carPresence1, int carPresence2) {
  WiFiClient client;
  const int httpPort = 80;

  if (!client.connect(host, httpPort)) {
    Serial.println("Connection failed");
    return;
  }

  // Construct URL with query parameters
  String url = "/Test/carparkstatusupdate.php";
  url += "?carPresence1=";
  url += carPresence1; // 1 if car is present in Garage1, 0 if not
  url += "&carPresence2=";
  url += carPresence2; // 1 if car is present in Garage2, 0 if not

  // Make HTTP GET request
  client.print(String("GET ") + url + " HTTP/1.1\r\n" + 
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");

  while (client.available() == 0) {
    delay(1); // Wait for server response
  }

  // Optional: Read and print the server response
  while (client.available()) {
    String line = client.readStringUntil('\r');
    Serial.print(line);
  }

  client.stop(); // Close the connection
}