<?php 	

include_once('MSQL.php');

$templateHead = '<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Document</title>
</head>
<body>';

$templateFoot = '</body>
</html>';
			
$arr = MSQL::Instance()->Select('SELECT journal_id, name, name_eng, issn, type, subject, founders, founded, gov_registration, gov_registration_file, dak_registration, chief_editor, executive_secretary, editorial_board, period, picture_file, prefix, dak_spec
	FROM periodic.journal');	

echo $templateHead;

foreach ($arr as $key => $value) {
	echo '<li>';
	echo $value['journal_id'];
	echo $value['name'];
	echo $value['name_eng'];
	echo '</li>';	
}

echo $templateFoot;

