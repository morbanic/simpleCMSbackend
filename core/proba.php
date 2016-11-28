<? 
//setStatement($tableName, $fields, $additional="")
require_once('/home/trendovi/public_html/config.php');
header('Content-Type:text/html; charset=UTF-8');

$pdo = new PDO('mysql:host=localhost;dbname=trendovi_database', 'trendovi_admin', 's9jT4kE20xSlgH');
// $naslov = new Text($pdo);
// $naslov->setStatement('YouTube_Zapisi', 'naslov', ' WHERE id=25');
// $naslov->read();


$upis = new Text($pdo);
$upis->setInsertTable('articles');
$upis->printInputForm();


//dohvacanje POSTanig sadržaja
if(isset($_POST[$upis->insertTable]) && ($_POST['insTable'] == $upis->insertTable )){
$vrijednostiInputTablice  = $_POST[$upis->insertTable];
//odvajanje zarezom i upis u tablicu
$odvojene_zarezom = implode("', '", $vrijednostiInputTablice);
$odvojene_zarezom="'" . $odvojene_zarezom . "'";
$upis->insertIntoTable($odvojene_zarezom);

} // kraj ifa za dohvacanje POST-a


$upis = new Text($pdo);
$upis->setInsertTable('blog');
$upis->printInputForm();


//dohvacanje POSTanig sadržaja
if(isset($_POST[$upis->insertTable]) && ($_POST['insTable'] == $upis->insertTable )){
$vrijednostiInputTablice  = $_POST[$upis->insertTable];
//odvajanje zarezom i upis u tablicu
$odvojene_zarezom = implode("', '", $vrijednostiInputTablice);
$odvojene_zarezom="'" . $odvojene_zarezom . "'";


$upis->insertIntoTable($odvojene_zarezom);

} // kraj ifa za dohvacanje POST-a


?>

