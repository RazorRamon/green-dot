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

	$name = $_POST['name'];
	$year = $_POST['year'];
	$tag = $_POST['tag'];
	
/* �������� ������������ ������ � ���� ������ */

	// ��������� ������ �� ��������� ������ �� ������� green_films
	$query_films = sprintf("SELECT NAME FROM green_films") or die("�� ������� ~1~: " . mysql_error()); //������ �1

	// ��������� ������
	$films = mysql_query($query_films) or die("�� ������� ~2~: " . mysql_error()); //������ �2

	// ��������� ���������, ������� ���������� �������� ������, ��������� � MySQL, � ����� ������. ������ ��� �������.
	if (!$films) {
		$message  = '�������� ������: ' . mysql_error() . "\n";
		$message .= '������ �������: ' . $query_films;
		die($message);
	}
	
	// ���������� ���������
	// ������� ���������� $films �� ������� ����������, ������� � ��� ��������
	// ���������� ������������ �����-���� mysql-�������, ���������� � ����������� �������
	// ��. ����� mysql_result(), mysql_fetch_array(), mysql_fetch_row() � �.�.
    while ($row_films = mysql_fetch_assoc($films)) {
		$array_films[] = $row_films['NAME'];
    }
	
	// �������� ������������ ��������� �������� ������, � ����������� ��� ����������� � ��
	$replay_films = 0;
	foreach($array_films as $val) {
		if($name == $val){
			$replay_films++; 
		}
	}
	if ($replay_films == 0) {
		$result_films = mysql_query("INSERT INTO green_films (name, year, tag) 
		VALUES ('$name', '$year', '$tag')");

/* �������� ������������ ����(�����) � ���� ������ */

		// ��������� ������ �� ��������� ������ �� ������� green_tags
		$query_tags = sprintf("SELECT TAG FROM green_tags") or die("�� ������� ~3~: " . mysql_error()); //������ �3

		// ��������� ������
		$tags = mysql_query($query_tags) or die("�� ������� ~4~: " . mysql_error()); //������ �4

		if (!$tags) {
			$message  = '�������� ������: ' . mysql_error() . "\n";
			$message .= '������ �������: ' . $query_tags;
			die($message);
		}

		// ���������� ���������
		while ($row_tags = mysql_fetch_assoc($tags)) {
			$array_tags[] = $row_tags['TAG'];
		}

		// �������� ������������ ��������� ����(�����), � ����������� ��� ���������� � ��
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
				echo "������ ������� ���������!<br /><a href='http://portnovlaboratory.ru/green-dot/add.html'>�������� ����� �����</a>";
			}
		} else {
			echo "�������� ����� �����, ����� ���� ��� ���������� � ����!<br /><a href='http://portnovlaboratory.ru/green-dot/add.html'>�������� ����� �����</a>";
		}
	} else {
		echo "����� ����� ��� ������� � ����!<br /><a href='http://portnovlaboratory.ru/green-dot/add.html'>�������� ����� �����</a><br /><br />";
	}

	if ($result_films == false) {
		echo "���������� <a href='http://portnovlaboratory.ru/green-dot/add.html'>��������� �������</a>";
	}
?>