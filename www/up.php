<?php

	/* ����������� � ����� ������ */
	$hostname = "localhost"; // ��������/���� �������, � MySQL
	$username = "lokyvg_green"; // ��� ������������
	$password = "test-green"; // ������ ������������
	$dbName = "lokyvg_green"; // �������� ���� ������
	
	/* ������� MySQL, � ������� ����� ��������� ������ */
	$table = "green_films";
	$table = "green_tags";
	
	/* ������� ���������� */
	mysql_connect($hostname, $username, $password) or die ("�� ���� ������� ����������");
	 
	/* �������� ���� ������. ���� ���������� ������ - ������� �� */
	mysql_select_db($dbName) or die (mysql_error());

	$id = $_POST['id'];
	$name = $_POST['name'];
	$year = $_POST['year'];
	$tag = $_POST['tag'];
	
/* �������� ������������ ������ � ���� ������ */

	// ��������� ������ �� ��������� ������ �� ������� green_films
	$query_films = sprintf("UPDATE green_films SET NAME='$name', YEAR='$year' WHERE ID=$id") or die("�� ������� ~1~: " . mysql_error()); //������ �1

	// ��������� ������
	$films = mysql_query($query_films) or die("�� ������� ~2~: " . mysql_error()); //������ �2

	// ��������� ���������, ������� ���������� �������� ������, ��������� � MySQL, � ����� ������. ������ ��� �������.
	if (!$films) {
		$message  = '�������� ������: ' . mysql_error() . "\n";
		$message .= '������ �������: ' . $query_films;
		die($message);
	} else {
		echo "������ �{$id} ������� ��������� � ������� green_films. <a href='http://portnovlaboratory.ru/green-dot/'>��������� � ����������</a>";
	}
?>