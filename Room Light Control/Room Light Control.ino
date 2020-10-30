#include<ESP8266WiFi.h>
#include<ESP8266HTTPClient.h>

/*Enter your Network credentials*/

#define ssid "shuva"
#define pass "12345678"

HTTPClient http;

#define led 1
#define load 2

bool state = false;
void setup() {
  pinMode(led, OUTPUT);
  pinMode(load, OUTPUT);
  digitalWrite(load, LOW);
  WiFi.begin(ssid, pass);
}

void loop() {
  while (WiFi.status() != WL_CONNECTED)
  {
    state = !state;
    digitalWrite(led, state);
    delay(500);
  }
  httpSendRequest();
  delay(500);
}

void httpSendRequest()
{
  http.begin("http://rkmsm.000webhostapp.com/send_data.php");
  int req = http.GET();
  if (req == 200)
  {
    String str = http.getString();
    if (str == "1")
    {
      digitalWrite(led, LOW);
      digitalWrite(load, HIGH);
    }
    else if (str == "0")
    {
      digitalWrite(led, HIGH);
      digitalWrite(load, LOW);
    }
  }
  else
  {
    state = !state;
    digitalWrite(led, state);
  }
  http.end();
}
