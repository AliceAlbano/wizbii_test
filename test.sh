#!/bin/bash

RT_OK=0
RT_22=22

test_collect() {
	NAME=$1
	RETURN_EXPECTED=$2
	T=$3

	curl -s -f -X GET 'http://127.0.0.1:8000/collect.php?'$T'dl=http://www.wizbii.com/bar&ec=ads&el=client&ea=Click%20Masthead&ds=web&cn=bpce&cs=wizbii&cm=web&ck=erasmus&cc=foobar' > /dev/null

	RT=$?

	if [ $RT -ne $RETURN_EXPECTED ]
	then
		echo "Test KO - $NAME (RT=$RT, EXPECTING $RETURN_EXPECTED)"
	else
		echo "Test OK - $NAME"
	fi
}

test_collect 'Field t valid' $RT_OK 't=pageview&'
test_collect 'Field t missing' $RT_22 ''
