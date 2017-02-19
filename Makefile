all:

test_get:
	curl -X GET 'http://127.0.0.1:8000/collect.php?t=pageview&dl=http://www.wizbii.com/bar&ec=ads&el=client&ea=Click%20Masthead&ds=web&cn=bpce&cs=wizbii&cm=web&ck=erasmus&cc=foobar'
