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

	$name = $_POST['name'];
	$year = $_POST['year'];
	$tag = $_POST['tag'];
	
/* Проверка уникальности фильма в базе данных */

	// Формируем запрос на получение данных из таблицы green_films
	$query_films = sprintf("SELECT NAME FROM green_films") or die("Не удалось ~1~: " . mysql_error()); //Ошибка №1

	// Выполняем запрос
	$films = mysql_query($query_films) or die("Не удалось ~2~: " . mysql_error()); //Ошибка №2

	// Проверяем результат, который показывает реальный запрос, посланный к MySQL, а также ошибку. Удобно при отладке.
	if (!$films) {
		$message  = 'Неверный запрос: ' . mysql_error() . "\n";
		$message .= 'Запрос целиком: ' . $query_films;
		die($message);
	}
	
	// Используем результат
	// Попытка напечатать $films не выведет информацию, которая в нем хранится
	// Необходимо использовать какую-либо mysql-функцию, работающую с результатом запроса
	// См. также mysql_result(), mysql_fetch_array(), mysql_fetch_row() и т.п.
    while ($row_films = mysql_fetch_assoc($films)) {
		$array_films[] = $row_films['NAME'];
    }
	
	// Проверка уникальности введённого названия фильма, с последующим его добавлением в БД
	$replay_films = 0;
	foreach($array_films as $val) {
		if($name == $val){
			$replay_films++; 
		}
	}
	if ($replay_films == 0) {
		$result_films = mysql_query("INSERT INTO green_films (name, year, tag) 
		VALUES ('$name', '$year', '$tag')");

/* Проверка уникальности тега(жанра) в базе данных */

		// Формируем запрос на получение данных из таблицы green_tags
		$query_tags = sprintf("SELECT TAG FROM green_tags") or die("Не удалось ~3~: " . mysql_error()); //Ошибка №3

		// Выполняем запрос
		$tags = mysql_query($query_tags) or die("Не удалось ~4~: " . mysql_error()); //Ошибка №4

		if (!$tags) {
			$message  = 'Неверный запрос: ' . mysql_error() . "\n";
			$message .= 'Запрос целиком: ' . $query_tags;
			die($message);
		}

		// Используем результат
		while ($row_tags = mysql_fetch_assoc($tags)) {
			$array_tags[] = $row_tags['TAG'];
		}

		// Проверка уникальности введённого тега(жанра), и последующее его добавление в БД
		$replay_tags = 0;
		foreach($array_tags as $val){
			if($tag == $val){
				$replay_tags++; 
			}
		}
		if ($replay_tags == 0){
			$result_tags = mysql_query("INSERT INTO green_tags (tag) 
			VALUES ('$tag')");
			if ($result_films == true && $result_tags == true) {
				echo "Данные успешно сохранены!<br /><a href='http://portnovlaboratory.ru/green-dot/add.html'>Добавить новый фильм</a>";
			}
		} else {
			echo "Добавлен новый фильм, такой жанр уже существует в базе!<br /><a href='http://portnovlaboratory.ru/green-dot/add.html'>Добавить новый фильм</a>";
		}
	} else {
		echo "Такой фильм уже имеется в базе!<br /><a href='http://portnovlaboratory.ru/green-dot/add.html'>Добавить новый фильм</a><br /><br />";
	}

	if ($result_films == false) {
		echo "Пожалуйста <a href='http://portnovlaboratory.ru/green-dot/add.html'>повторите попытку</a>";
	}
?>