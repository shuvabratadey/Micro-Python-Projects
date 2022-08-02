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
