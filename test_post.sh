#!/bin/bash

#Return values for curl
RT_OK=0
RT_22=22

test_collect() {
	NAME=$1
	RETURN_EXPECTED=$2
	PARAMS=$3

	curl -f -X POST -d "$PARAMS" 'http://127.0.0.1:8000/collect.php'

	RT=$?

	if [ $RT -ne $RETURN_EXPECTED ]
	then
		echo -e '\e[31m'"TEST KO\e[0m" - $NAME "(RT=$RT, EXPECTING $RETURN_EXPECTED)"
	else
		echo -e '\e[32m'"TEST OK\e[0m" - $NAME
	fi
}

# Test non-conditionnal mandatory fields 

test_collect 'All mandatory fields present' $RT_OK '[{"t":"event", "v":1, "tid":"UA-XXXX-Y", "ds":"apps", "ec":"bdo", "ea":"client", "wui":"r2d2"}]'

