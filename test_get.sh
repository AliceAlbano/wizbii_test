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

# Test non-conditionnal mandatory fields 

test_collect 'All mandatory fields present' $RT_OK 't=event&v=1&tid=UA-XXXX-Y&ds=apps&ec=bdo&ea=client&wui=r2d2'
test_collect 'Field t missing' $RT_22 'v=1&tid=UA-XXXX-Y&ds=apps'
test_collect 'Field v missing' $RT_22 't=pageview&tid=UA-XXXX-Y&ds=apps'
test_collect 'Field tid missing' $RT_22 't=pageview&v=1&ds=apps'
test_collect 'Field ds missing' $RT_22 't=pageview&v=1&tid=UA-XXXX-Y'

# Tests with incorrect values

test_collect 'Invalid value for t' $RT_22 't=test&v=1&tid=UA-XXXX-Y'
test_collect 'Invalid value for v' $RT_22 't=pageview&v=3&tid=UA-XXXX-Y'
test_collect 'Invalid value for tid' $RT_22 't=pageview&v=1&tid=3'
test_collect 'Invalid value for ds' $RT_22 't=pageview&v=1&tid=UA-XXXX-Y&ds=8'
test_collect 'Invalid value for qt' $RT_22 't=pageview&v=1&tid=UA-XXXX-Y&ds=8&qt=a'
test_collect 'Invalid value for wui' $RT_22 't=pageview&v=1&tid=UA-XXXX-Y&ds=8&qt=3000&name=totototto'

# Test with conditionnals mandatory fields

test_collect 'Conditional field missing t=screenview -> ec & ea' $RT_22 't=screenview&v=1&tid=UA-XXXX-Y&ds=apps'
test_collect 'Conditional field added t -> ec & ea' $RT_OK 't=screenview&v=1&tid=UA-XXXX-Y&ds=apps&sn=jobs&wui=r2d2'

test_collect 'Conditional field missing t=event -> sn' $RT_22 't=event&v=1&tid=UA-XXXX-Y&ds=apps'
test_collect 'Conditional field added t=event -> sn' $RT_OK 't=event&v=1&tid=UA-XXXX-Y&ds=apps&ec=bdo&ea=client'
