#!/bin/bash
charge=$(upower -i /org/freedesktop/UPower/devices/battery_BAT0 | awk '/percentage:/ {print $2}' | sed 's/\%//')

if [[ "$charge" -lt 10 ]]; then
	echo "#[bg=red]#[fg=black]$charge"
elif [[ "$charge" -lt 25 ]]; then
	echo "#[fg=red]$charge"
elif [[ "$charge" -lt 75 ]]; then
	echo "#[fg=yellow]$charge"
else
	echo "#[fg=green]$charge"
fi
