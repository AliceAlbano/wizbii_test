#!/bin/bash

#Return values for curl
RT_OK=0
RT_22=22

test_collect() {
	NAME=$1
	RETURN_EXPECTED=$2
	PARAMS=$3

	curl -s -f -X GET 'http://127.0.0.1:8000/collect.php?'$PARAMS > /dev/null

	RT=$?

	if [ $RT -ne $RETURN_EXPECTED ]
	then
		echo -e '\e[31m'"TEST KO\e[0m" - $NAME "(RT=$RT, EXPECTING $RETURN_EXPECTED)"
	else
		echo -e '\e[32m'"TEST OK\e[0m" - $NAME
	fi
}

test_collect 'All mandatory fields present' $RT_OK 't=pageview&v=1&tid=UA-XXXX-Y'
test_collect 'Field t missing' $RT_22 'v=1&tid=UA-XXXX-Y'
test_collect 'Field v missing' $RT_22 't=pageview&tid=UA-XXXX-Y'
test_collect 'Field tid missing' $RT_22 't=pageview&v=1&'

test_collect 'Invalid value for t' $RT_22 't=test&v=1&tid=UA-XXXX-Y'
test_collect 'Invalid value for v' $RT_22 't=pageview&v=3&tid=UA-XXXX-Y'
test_collect 'Invalid value for tid' $RT_22 't=pageview&v=1&tid=3'
