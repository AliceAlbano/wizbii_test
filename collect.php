<?php

if (!array_key_exists("t", $_GET)){
	header('HTTP/1.0 400 Bad Request');
	echo "Error 400 Bad Request : field t missing\n";
	exit;
}else{

	foreach($_GET as $key => $item)
	{
		echo $key." : ".$item."<br />\n";
	}
}

