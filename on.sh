#!/bin/bash

# Check if correct number of arguments is provided
if [ "$#" -eq 1 ] && [ "$1" -eq 16 ]; then
    echo "$1" > /dev/ttyACM0
else
	if [ "$#" -ne 5 ]; then
		echo "Usage: $0 LED_NUMBER RED GREEN BLUE TOGGLE"
		exit 1
	fi

	# Extract arguments
	LED_NUMBER=$1
	RED=$2
	GREEN=$3
	BLUE=$4
	TOGGLE=$5
	
	# Check if LED_NUMBER is within the valid range (1-8)
	if { [ "$LED_NUMBER" -lt 1 ] || [ "$LED_NUMBER" -gt 8 ]; } then
		echo "Invalid LED number. Please enter a number between 1 and 8 or equal to 16."
		exit 1
	fi
	
	# Send command to /dev/ttyACM0
	echo "$LED_NUMBER $RED $GREEN $BLUE $TOGGLE" > /dev/ttyACM0
fi