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
