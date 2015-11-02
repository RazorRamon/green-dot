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

	$rewrite = $_GET['rewrite'];
#	echo "SELECT NAME, YEAR, TAG FROM green_films WHERE ID=$rewrite";

/* Извлекаем запись из таблицы green_films с номером $rewrite */

	// Формируем запрос на получение данных из таблицы green_films
	$query_films = sprintf("SELECT NAME, YEAR, TAG FROM green_films WHERE ID=$rewrite") or die("Не удалось ~1~: " . mysql_error()); //Ошибка №1

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
    while ($row_film = mysql_fetch_assoc($films)) {
		$array_film['ID'] = $row_film['ID'];
		$array_film['NAME'] = $row_film['NAME'];
		$array_film['YEAR'] = $row_film['YEAR'];
		$array_film['TAG'] = $row_film['TAG'];
    }
	
#	echo '<pre>';
#	print_r($array_film);
#	echo'</pre>';
?>

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
						<h2>Редактирование фильма <? echo $array_film['NAME']; ?>:</h2>

						<form id="form_add" action="up.php" method="post">
							<fieldset>
								<legend><input name="id" type="text" required="" value="<? echo $rewrite; ?>" readonly="readonly" /></legend>
								<p>
									<label for="name">Название фильма:
										<input name="name" type="text" required="" value="<? echo $array_film['NAME']; ?>" />
									</label>
									<div class="line_paragraph"></div>
									<label for="year">Год выхода фильма:
										<input name="year" type="text" required="" value="<? echo $array_film['YEAR']; ?>" />
									</label>
									<div class="line_paragraph"></div>
									<label for="tag">Тэг:
										<input name="tag" type="text" required="" value="<? echo $array_film['TAG']; ?>" readonly="readonly" />
									</label>
								</p>
								<div class="clear_div"></div>
								<button class="submit" type="submit" role="button" aria-disabled="false">Изменить</button>
							</fieldset>
						</form>
						
					</main><!-- .content -->
				</div><!-- .container-->

				<aside class="left-menu">
					<h2>Меню</h2>
					<ul>
						<li><a href="http://portnovlaboratory.ru/green-dot/">Вся Фильмотека</a></li>
						<li><a href="http://portnovlaboratory.ru/green-dot/add.html">Пополнить коллекцию фильмов</a></li>
						<li class="active"><a href="#">Редактирование фильма</a></li>
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