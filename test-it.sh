#!/bin/bash

( sleep 1; touch src/tox2ik/PasswordCracker.php
) &

while true; do
	(find . -name \*php; echo composer.json) |
		inotifywait -e  modify -e move -e create -e attrib -e delete \
		   --fromfile - 2>/dev/null
	echo;
	echo;
	echo;


	vendor/bin/phpspec -n run

	sleep 0.1
done 


