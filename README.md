# IoT-Based-Sensors Project
In this IoT project, We have used an ESP32 microcontroller and a BME680 Sensor, and micro-python programming, Using the help of the ESP32's WiFi we can Send data to a Server, And we can access the data through a website anywhere in the world. The website Link is given below.

A micro-python script is written here which can read the data from the BME680 sensor and send the data to the IoT Cloud using the WiFi of the ESP32 microcontroller. After Uploading the micro-python code to the ESP32 microcontroller, It will connect to the given WiFi Access point and after that, it will send the data to the IoT cloud.
# This project is based on ESP32 microcontroller & micro-python.
</br><img src="https://github.com/shuvabratadey/Micro-Python-Projects/blob/main/pics/ESP32-and-BME680.jpg" width="500"/>
# After Uploading the Script to the ESP32, It will connect to the Access Point/Router.
</br><img src="https://github.com/shuvabratadey/Micro-Python-Projects/blob/main/pics/Connecting.jpg" width="500"/>
# After successfully Connected to the Router It will send the data to the IoT Cloud, and also Show the data to the OLED Display.
</br><img src="https://github.com/shuvabratadey/Micro-Python-Projects/blob/main/pics/show_data.jpg" width="500"/>
# IoT Website Link --> <a href="https://sensorsapp.000webhostapp.com/">Click Here</a>
</br><img src="https://github.com/shuvabratadey/Micro-Python-Projects/blob/main/pics/sensorsapp.jpg" width="1000"/>
# [Please see the codes for better understanding.](https://github.com/shuvabratadey/Micro-Python-Projects/blob/main/sensorsapp.py)
``` python
import network
import urequests
from machine import Pin, I2C
from time import sleep
import ssd1306
from bme680 import *

# ESP32 - Pin assignment
i2c = I2C(-1, scl=Pin(22), sda=Pin(21))
# ESP8266 - Pin assignment
#i2c = I2C(scl=Pin(5), sda=Pin(4))

bme = BME680_I2C(i2c=i2c)

oled_width = 128
oled_height = 64
oled = ssd1306.SSD1306_I2C(oled_width, oled_height, i2c)


wifi = network.WLAN(network.STA_IF)
wifi.active(False)
time.sleep(0.5)
wifi.active(True)

wifi.connect('FTTH-1BA8', 'ssasb@12345')

while True:
    try:
        if(wifi.isconnected()):
            temp = str(round(bme.temperature, 2)) + ' *C'
            #temp = (bme.temperature) * (9/5) + 32
            #temp = str(round(temp, 2)) + 'F'

            hum = str(round(bme.humidity, 2)) + ' %'

            pres = str(round(bme.pressure, 2)) + ' hPa'

            gas = str(round(bme.gas/1000, 2)) + ' KOhms'

            req = urequests.get(url='https://sensorsapp.000webhostapp.com/sensor.php?Temp='+str(round(bme.temperature, 2))+'&Hum='+str(round(bme.humidity, 2))+'&Pre='+str(round(bme.pressure*100)))
            if(req.status_code == 200):
                print('Temperature:', temp)
                print('Humidity:', hum)
                print('Pressure:', pres)
                print('-------')
                oled.fill(0)
                oled.text('Temp:- ' + temp, 0, 0)
                oled.text('Hum:- ' + hum, 0, 10)
                oled.text('Pre:- ' + pres, 0, 20)
                oled.text('Gas:- ' + gas, 0, 30)  
                oled.show()
            else:
                print('can\'t send')
                oled.fill(0)
                oled.text('can\'t send', 0, 0) 
                oled.show()
            req.close()
            sleep(1)
        else:
            print('connecting...')
            oled.fill(0)
            oled.text('connecting...', 0, 0) 
            oled.show()
            while not wifi.isconnected():
                pass
    except Exception as e:
        print('some error occured ==> ' + str(e))
        oled.fill(0)
        oled.text('some error', 0, 0) 
        oled.show()
```

# Second IoT Based Project

# IoT-Room-Light
In this IoT project, a room light and fan can be controled by the Internet from anywhere in the world. Just open the link below then you see a Light Bulb and a Fan, By clicking the bulb and Fan Switch you can change the state of your room light and Fan.
# This project is based on ESP32 microcontroller & micro-python.
</br><img src="https://github.com/shuvabratadey/IoT-Room-Light/blob/main/pics/iot_project.jpg" width="500"/>
# We can control this using this IoT Website --> <a href="https://shuvaiotapp.000webhostapp.com/">Click Here</a>
</br><img src="https://github.com/shuvabratadey/IoT-Room-Light/blob/main/pics/shuvaiot.jpg" width="1000"/>
# [Please see the codes for better understanding.](https://github.com/shuvabratadey/IoT-Room-Light/blob/main/ESP32_IoT_micropthon.py)
``` python
import network
import time
import urequests
import json
import machine

timeout = 0

Led = machine.Pin(2, machine.Pin.OUT)
Fan = machine.Pin(25, machine.Pin.OUT)

wifi = network.WLAN(network.STA_IF)
wifi.active(False)
time.sleep(0.5)
wifi.active(True)

wifi.connect('shuva', 'shuva@123')

if not wifi.isconnected():
    print('connecting..')
    while (not wifi.isconnected() and timeout < 5):
        print(5 - timeout)
        timeout = timeout + 1
        time.sleep(1)
while 1:
    print('----------------------')
    if(wifi.isconnected()):
        try:
            req = urequests.get('https://shuvaiotapp.000webhostapp.com/featch_data.php')
            Json_Data = json.loads(req.text)
            
            Light_Status = Json_Data["Light"]
            if Light_Status is "true":
                Led.value(1)
                print('Light ON')
            else:
                Led.value(0)
                print('Light OFF')
            
            Fan_Status = Json_Data["Fan"]
            if Fan_Status is "true":
                Fan.value(1)
                print('Fan ON')
            else:
                Fan.value(0)
                print('Fan OFF')
        except:
            print("An exception occurred")
    else:
        print('Time Out')
        print('Not Connected')
```
