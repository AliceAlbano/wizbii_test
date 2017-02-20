#!/bin/bash

#Return values for grep
RT_OK=0
RT_KO=1

NB_ENTRY=0

dump_db(){
	mongo analytics --eval "db.analytics.find().forEach(printjson)"| tail -n +3 | tr -d '\n' | sed -e 's/}/}\n/g' | sed -e 's/\t/ /g' | sed -e 's/ : /:/g' | sed -e 's/{[^)]*), /{/' > mongo_test
}

assert_present() {
	RETURN_EXPECTED=$1
	ENTRY=$2


	grep -q "$ENTRY" mongo_test
	RT=$?

	if [ $RT -ne $RETURN_EXPECTED ]
	then
		echo -e '\e[31m'"TEST KO\e[0m" "(RT=$RT, EXPECTING $RETURN_EXPECTED)"
	else
		echo -e '\e[32m'"TEST OK\e[0m"
	fi

	if [ $RT -eq 0 ]
	then
		NB_ENTRY=$(($NB_ENTRY + 1))
	fi
}

assert_number() {
	COUNT=$(mongo analytics --eval "db.analytics.find().count()" | tail -1)

	if [ "$COUNT" -ne "$NB_ENTRY" ]
	then
		echo -e '\e[31m'"TEST KO\e[0m" "(WRONG NUMBER OF ENTRIES)"
	else
		echo -e '\e[32m'"NB Entry OK\e[0m"
	fi
}

dump_db

# Test presence of fields in DB
assert_present $RT_OK '{"t":"event", "v":"1", "tid":"UA-XXXX-Y", "ds":"apps", "ec":"bdo", "ea":"client", "wui":"r2d2"}'
assert_present $RT_OK '{"t":"screenview", "v":"1", "tid":"UA-XXXX-Y", "ds":"apps", "sn":"jobs", "wui":"r2d2"}'
assert_present $RT_OK '{"t":"event", "v":"1", "tid":"UA-XXXX-Y", "ds":"apps", "ec":"bdo", "ea":"client"}'

# Test absence of fields
assert_present $RT_KO '{"v":"1", "tid":"UA-XXXX-Y", "ds":"apps"}'
assert_present $RT_KO '{"t":"pageview", "tid":"UA-XXXX-Y", "ds":"apps"}'
assert_present $RT_KO '{"t":"pageview", "v":"1", "tid":"UA-XXXX-Y"}'
assert_present $RT_KO '{"t":"test", "v":"1", "tid":"UA-XXXX-Y"}'
assert_present $RT_KO '{"t":"pageview", "v":"3", "tid":"UA-XXXX-Y"}'
assert_present $RT_KO '{"t":"pageview", "v":"1", "tid":"3"}'
assert_present $RT_KO '{t":"pageview", "v":"1", "tid":"UA-XXXX-Y", "ds":"8"}'
assert_present $RT_KO '{"t":"pageview", "v":"1", "tid":"UA-XXXX-Y", "ds":"8", "qt":"a"}'
assert_present $RT_KO '{"t":"pageview", "v":"1", "tid":"UA-XXXX-Y", "ds":"8", "qt":"3000", "name":"totototto"}'
assert_present $RT_KO '{"t":"screenview", "v":"1", "tid":"UA-XXXX-Y", "ds":"apps"}'
assert_present $RT_KO '{"t":"event", "v":"1", "tid":"UA-XXXX-Y", "ds":"apps"}'

assert_number
rm -f mongo_test
