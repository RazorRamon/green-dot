<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Пополняем Фильмотеку на PortnovLaboratory.ru</title>
		<meta name="description" content="Фильмотека - тестовое задание Зелёной Точки" />
		<meta name="keywords" content="Новый фильм" />
		<!--<meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />-->
		
		<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<link rel="stylesheet" type="text/css" href="http://portnovlaboratory.ru/green-dot/css/style.css" />

		<link rel="icon" href="http://portnovlaboratory.ru/green-dot/images/favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="http://portnovlaboratory.ru/green-dot/images/favicon.ico" type="image/x-icon" />
		<link rel="alternate" type="application/rss+xml" title="RSS Feed" href="/news/rss/" />
		
		<!-- Подключение jQuery -->
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.js"></script>
	</head>

	<body>
		<div class="wrapper">
			<header class="header">
				<h1>Тестовое задание "Зелёная Точка"</h1>
			</header><!-- .header-->

			<div class="middle">
				<div class="container">
					<main class="content">
						<h2>Вся Фильмотека:</h2>
						
<?php
	
	/* Функция, удаляющая из строки всё после встречи с определённым символом */
	function delete44($str,$symbol='') 
	{ 
	    return($strpos=mb_strpos($str,$symbol))!==false?mb_substr($str,0,$strpos,'utf8'):$str;
	}

/* ПОДКЛЮЧЕНИЕ К БД */

	/* Соединяемся с базой данных */
	$hostname = "localhost"; // название/путь сервера, к MySQL
	$username = "lokyvg_green"; // имя пользователя
	$password = "test-green"; // пароль пользователя
	$dbName = "lokyvg_green"; // название базы данных
	
	/* Таблицы MySQL, в которых хранятся данные */
	$table = "green_films";
	$table = "green_tags";
	
	/* Создаем соединение */
	mysql_connect($hostname, $username, $password) or die ("Не могу создать соединение");
	 
	/* Выбираем базу данных. Если произойдет ошибка - вывести ее */
	mysql_select_db($dbName) or die (mysql_error());
	
/* ПОЛУЧАЕМ СПИСОК ВСЕХ ТЕГОВ */
	
	// Формируем запрос на получение данных из таблицы green_tags
	$query_tags = sprintf("SELECT TAG FROM green_tags") or die("Не удалось ~1~: " . mysql_error()); //Ошибка №1

	// Выполняем запрос
	$tags = mysql_query($query_tags) or die("Не удалось ~2~: " . mysql_error()); //Ошибка №2

	if (!$tags) {
		$message  = 'Неверный запрос: ' . mysql_error() . "\n";
		$message .= 'Запрос целиком: ' . $query_tags;
		die($message);
	}

	// Используем результат
	while ($row_tags = mysql_fetch_assoc($tags)) {
		$array_tags[] = $row_tags['TAG'];
	}
	
	// Сортируем полученный массив тегов
	sort($array_tags);
	
/* ПОЛУЧАЕМ СПИСОК ВСЕХ ФИЛЬМОВ */
	
	// Формируем запрос на получение данных из таблицы green_films
	$query_films = sprintf("SELECT ID, NAME, YEAR, TAG FROM green_films") or die("Не удалось ~1~: " . mysql_error()); //Ошибка №1

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
	$i = 0;
    while ($row_films = mysql_fetch_assoc($films)) {
		$array_films[$i]['ID'] = $row_films['ID'];
		$array_films[$i]['NAME'] = $row_films['NAME'];
		$array_films[$i]['YEAR'] = $row_films['YEAR'];
		$array_films[$i]['TAG'] = $row_films['TAG'];
		$i++;
    }
	
/* ВЫВОДИМ СПИСОК ФИЛЬМОВ, ОТСОРТИРОВАННЫХ ПО ТЕГАМ */

	/* Включаем сессии  */
	session_start();
#	if (!isset($_SESSION['counter'])) $_SESSION['counter']=0;
#	echo "Вы обновили эту страницу ".$_SESSION['counter']++." раз.<br>
#	<a href=".$_SERVER['PHP_SELF'].'?'.session_name().'='.session_id().">обновить</a>";

	$i = 0;
	foreach($array_tags as $element_tag){
		echo "<h3>$element_tag</h3>";

		$j = 0;
		foreach($array_films as $element_film)
		{
			if($element_film['TAG'] == $element_tag){
#				echo $element_film['TAG'] . '==' . $element_tag . '<br/>';
				$films_about_tag[$i][$j] = $element_film['NAME'] . '&&' . $element_film['ID'];
#				echo $films_about_tag[$i][$j] . ' == ' . $element_film['ID'] . '+' . $element_film['NAME'] . '<br/>';
				$j++;
			}
		}
	
		// Сортируем полученный массив фильмов определённого тега в порядке ASC
		sort($films_about_tag[$i]);
		
		echo '<table class="list_films">';
		foreach($films_about_tag[$i] as $element_id)
		{
			$nomer = strpos($element_id, '&&');
			$id = (int)substr($element_id , $nomer+2, 4);
#			$id = (int)delete44($element_id , '&&');
#			echo $id . '<br />';
			foreach($array_films as $element)
			{
				if($element['ID'] == $id){
#					echo $element['ID'] . '==' . $id . '<br/>';

					// Формируем правильную ссылку с get-данными для редактирования фильма в таблице green_films
					$string_rew = "http://portnovlaboratory.ru/green-dot/rew.php" . "?rewrite=" . $element['ID'];

					// Формируем правильную ссылку с get-данными для удаления фильма из БД
					$string_del = "http://portnovlaboratory.ru/green-dot/del.php" . "?delete=" . $element['ID'];

					echo "<tr><td>" . $element['NAME'] . "</td><td>" . $element['YEAR'] . "</td><td>" . $element['TAG'] . "</td><td><a href='" . $string_rew . "'>Изменить</a> ... <a href='" . $string_del . "'>Удалить</a></td></tr>";			
				}
			}
		}
		echo '</table>';
		$i++;
	}
?>			
						
					</main><!-- .content -->
				</div><!-- .container-->

				<aside class="left-menu">
					<h2>Меню</h2>
					<ul>
						<li class="active"><a href="http://portnovlaboratory.ru/green-dot/">Вся Фильмотека</a></li>
						<li><a href="http://portnovlaboratory.ru/green-dot/add.html">Пополнить коллекцию фильмов</a></li>
					</ul>
					<div class="clear_div" style="height: 20px;">&nbsp;</div>
				</aside><!-- .left-sidebar -->
			</div><!-- .middle-->
		</div><!-- .wrapper -->

		<footer class="footer">
			<div class="footer_text">Также вы всегда можете посмотреть другие мои проекты - <a href="http://portnovlaboratory.ru/web-projects/">portnovlaboratory.ru</a></div>
		</footer><!-- .footer -->
	</body>
</html>