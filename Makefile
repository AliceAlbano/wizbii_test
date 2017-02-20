all:

test:
	./db_clear.sh
	./test_get.sh
	./db_test.sh
	./db_clear.sh
	./test_post.sh
	./db_test.sh
