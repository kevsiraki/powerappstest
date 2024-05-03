import time
from neopixel import Neopixel
import machine
import random

numpix = 8
pixels = Neopixel(numpix, 0, 3, "GRB")
pixels.brightness(20)

# Set up GPIO 15 as an output
led_pin = machine.Pin(16, machine.Pin.OUT)

def set_led(led_number, color, toggle):
    if 1 <= led_number <= numpix:
        # Turn on/off the specified LED with the provided color
        pixels.set_pixel(led_number - 1, color)
        pixels.show()
        print(f"LED {led_number} turned {'on' if toggle == 1 else 'off'} with color {color}")
    else:
        print("Invalid LED number. Please enter a number between 1 and 8.")

# Main loop
while True:
    try:
        # Prompt the user to enter LED number, RGB color, and toggle value on one line
        user_input = input("Enter LED number, RGB color code, and toggle value (e.g., 1 255 0 0 1): ")
        inputs = list(map(int, user_input.split()))
        
        # Check if the input is "15" to toggle pin 15
        if len(inputs) == 1 and inputs[0] == 16:
            # Toggle GPIO 15 on the Raspberry Pi Pico
            led_pin.toggle()
            print(f"GPIO 15 toggled {'on' if led_pin.value() == 1 else 'off'}")
        elif len(inputs) >= 3:
            # Process regular LED control input
            led_number, color, toggle = inputs[0], tuple(inputs[1:4]), inputs[-1]
            set_led(led_number, color, toggle)
        else:
            print("Invalid input. Please enter at least LED number, RGB color code, and toggle value.")
    except ValueError:
        print("Invalid input. Please enter valid numbers.")
    
    time.sleep(1)

