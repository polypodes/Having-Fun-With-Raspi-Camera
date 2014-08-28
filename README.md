Having-Fun-With-Raspi
=====================

Having fun with a Raspberry-Pi &amp; its camera

## Assembling hardware

- Buy a [Raspberry Pi at Adafruit.com](http://www.adafruit.com/products/1914)
- Buy a [camera board at Adafruit.com](http://www.adafruit.com/products/1367)
- Install `raspistill` ([documentation here](http://www.raspberrypi.org/documentation/usage/camera/raspicam/raspistill.md), this is simple)


Assemble it:

![Raspberry Pi Camera](http://www.adafruit.com/images/230x173/1367-00.jpg)


## Add a cronjob

Make sure that `./images` is writable & `camera.sh` is executable. 

Then `crontab -e`:

```cron
0,10,20,30,40,50 * * * * /path/to/camera.sh 
```

## Launching server:

```bash
php -S "`hostname -I`:8080" -t .
```
