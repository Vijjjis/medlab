<?php
	define(HOST, 'medlab.loc');
	define(USERNAME, 'root');
	define(PASSWD, '275337713');
	define(DB_NAME, 'SONIK_ML');

	$link = mysqli_connect(HOST, USERNAME, PASSWD, DB_NAME);
	if (mysqli_connect_errno()) {
    	printf("Не удалось подключиться: %s\n", mysqli_connect_error());
    exit();
	}
?>