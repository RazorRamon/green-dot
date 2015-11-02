<?php

	/* Соединяемся с базой данных */
	$hostname = "localhost"; // название/путь сервера, к MySQL
	$username = "lokyvg_green"; // имя пользователя
	$password = "test-green"; // пароль пользователя
	$dbName = "lokyvg_green"; // название базы данных
	
	/* Таблицы MySQL, в которых будут храниться данные */
	$table = "green_films";
	$table = "green_tags";
	
	/* Создаем соединение */
	mysql_connect($hostname, $username, $password) or die ("Не могу создать соединение");
	 
	/* Выбираем базу данных. Если произойдет ошибка - вывести ее */
	mysql_select_db($dbName) or die (mysql_error());

	$delete = $_GET['delete'];

#	echo "DELETE FROM green_films WHERE ID=$delete";
	
/* Удаляем запись из таблицы green_films с номером $delete */

	// Формируем запрос на удаление данных из таблицы green_films
	$query_films = sprintf("DELETE FROM green_films WHERE ID=$delete") or die("Не удалось ~1~: " . mysql_error()); //Ошибка №1

	// Выполняем запрос
	$films = mysql_query($query_films) or die("Не удалось ~2~: " . mysql_error()); //Ошибка №2

	// Проверяем результат, который показывает реальный запрос, посланный к MySQL, а также ошибку. Удобно при отладке.
	if (!$films) {
		$message  = 'Неверный запрос: ' . mysql_error() . "\n";
		$message .= 'Запрос целиком: ' . $query_films;
		die($message);
	} else {
		echo "Запись №{$delete} удалена из таблицы green_films. <a href='http://portnovlaboratory.ru/green-dot/'>Вернуться в Фильмотеку</a>";
	}
?>