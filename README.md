# simpleCMSbackend
Simple Content Management System backend written in PHP. Use it to create simplest webpages that need basic interaction with database.


# Usage

clone the project in your preferd directory:

`
git clone https://github.com/morbanic/simpleCMSbackend.git

`

create database, remember host, username and password.
Create tables (entities), remember their names.


on begining of .php file you need to paste this code
`
require_once('/home/uname/public_html/config.php');
header('Content-Type:text/html; charset=UTF-8');
$pdo = new PDO('mysql:host=host;dbname=db_name’, ‘user’, ‘password’);
`

Where :
* uname is your website name, usually username you get from your host provider
* host is host of database, usually “localhost”
* db_name is your database name
* user is your database username
* password is your database user password


To:
Print input form of table for entity. (usually used in admin/index.php to print form to insert new data)
`
$entity = new Text($pdo);
$entity->setInsertTable(‘table_name’);
$entity->printInputForm();
`
Where _table_name_ is table you want to work with.

Used method of form is POST. To get Posted data use following code:
`
if(isset($_POST[$entity->insertTable]) && ($_POST['insTable'] == $entity->insertTable)){
$valuesInputTable  = $_POST[$uentity->insertTable];
//split the commas and insert into table
$commaseperated = implode("', '", $ValuesInputTable);
$commaseperated="'" . $commaseperated . "'";
$entity->insertIntoTable($commaseperated);
} // end of if to POST-a
`


Print data from table (SELECT)
Example using Blog entity with atributes {title , description , date}
`
$entity = new Text($pdo);
$entity->setStatement("blog", "title , description , date " , “ ORDER BY id DESC”);
$entity->returnInForm('
<article class="blog-post-thumb">
  <header>
    <h1>[title]</h1>
    <p>Published: <time pubdate="pubdate">[date]</time></p>
  </header>
  <p>[description]</p>
</article>
  ');
`
Used functions in example:
`
public function setStatement($tableName, $fields, $additional=“”) 
`
  * shorter version of long  SQL query, for your own SQL query use setStatementByQuery($query). 
`
public function returnInForm($expression)
`
  * you can print data in selected SQL statement in format you want. 
Here is how, and simple:
* each selsected data row is printed in in defined html format
* to get atributes value you write the atribute name in [ ] brackets.
* define your own HTML form and CSS classes and refresh page.





