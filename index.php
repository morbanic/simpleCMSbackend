<?
require_once('/home/u408050119/public_html/config.php');
header('Content-Type:text/html; charset=UTF-8');

$pdo = new PDO('mysql:host=mysql.hostinger.hr;dbname=u408050119_user', 'u408050119_user', 'useruser123');

?>


<!DOCTYPE html>
<html>
<head>
	<title>simpleCMSbackend </title>
</head>
<body>
<h1>example of simpleCMSbackend</h1>
<hr/>

<?


$insert_rec = new Content($pdo);
$insert_rec->setInsertTable('test_table');
$insert_rec->printInputForm();
$insert_rec->insertPOSTED($_POST[$insert_rec->insertTable]);

$print_rec = new Content($pdo);
$print_rec->setStatementTable('test_table');
$print_rec->returnInForm("<h1>[name]<small>id =  [id]</small></h1> ");


?>


</body>
</html>

