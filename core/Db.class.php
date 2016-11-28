<?
class Db {
  protected $pdo = null;
  public $statement; // SQL query
  public $statement_pdo; // PDO statement
  public $insertTable;

  public $tableName;
  public $columns;
  public $additional;
  
  /**
   * $set_statement if 1 sets statement as current, if 0 doesn't, defaut is 1
   * 
   * 
  */

  public function __construct($connection){ //constructor in wihch is PDO defined
    if(!isset(self::$pdo)){
      try {
       self::$pdo = $connection;
      } catch (PDOException $e) {
       print "Error!: " . $e->getMessage() . "<br/>";
       die();
      }
      //echo "Connected! <br>";
    }  
  }
  
  function __destruct(){
   if(isset(self::$pdo)){
    self::$pdo = null;
    echo ("Signed out!");
   }
  } 

  function returnStatement(){ //returnes statement
    return $this->statement;
  }

  public function setStatementTable($tableName){ //sets statement, only table name 
    $query = "SELECT * FROM " . $tableName . " " . $additional ."";
    $this->statement_pdo = $this->pdo->query($query);
    $this->statement = $query;
    $this->tableName = $tableName;
  }  
  
  public function setStatement($tableName, $fields, $additional=""){ //sets statement, select table, fields and additional(e.g. WHERE id =1)
    $query = "SELECT " . $fields . " FROM " . $tableName . " " . $additional ."";
    $this->statement_pdo = $this->pdo->query($query);
    $this->statement = $query;
    $this->tableName = $tableName;
    $this->columns = $columns;
    $this->additional = $additional;
  }  

  public function setRawStatement($query){ //sets raw statement
    $this->statement_pdo = $this->pdo->query($query);
    $this->statement = $query;
  }  

  

// SELECT ##################################################
// SELECT ##################################################
// SELECT ##################################################

  function returnRows(){ // returns array with results
    $query = $this->statement;
    $result = $this->pdo->query($query);
    return $result->fetchAll();
  }
  
  
  function returnNoOfRows($tableName, $fields, $additional="" , $set_statement = 1){ //returnes nuber of rows
    $query = "SELECT count(" . $fields . ") FROM " . $tableName . " " . $additional ."";
    $query_set = "SELECT " . $fields . " FROM " . $tableName . " " . $additional ."";
    if ($set_statement == 1 ) $this->statement = $this->pdo->query($query_set);
    return  $this->pdo->query($query)->fetchColumn();
  }
  
 function returnListOf($columns){
    $columns = explode(",",$columns);
    foreach ($this->statement as $row) {
      echo "<li>"; 
        foreach($columns as $col){
          echo $row[$col] . " - "; 
        }
      echo "</li>";  
    }
  }

  function getColumnsFromExpression($expression){
    $pos1= strpos($expression, "[");
    $columns = array();  
    while($pos1){  
      if($pos1= strpos($expression, "[")) { } else {break;}
      $pos2= strpos($expression, "]");
      array_push($columns, substr($expression, $pos1+1, $pos2-$pos1-1)) ;
      $expression = substr($expression, $pos2+1);
      
    }  // end of while
    
    return $columns;
  } // end od getColumnsFromExpression()
  
  public function returnInForm($expression){
    $columns = $this->getColumnsFromExpression($expression);
    foreach ($this->statement_pdo as $row) {
        $rez=$expression;
        foreach($columns as $col){
          $rez= str_ireplace("[".$col."]",$row[$col],$rez);
        }
        echo $rez;
    }
  } // end of returnInForm

  public function returnOneRecord(){
    foreach ($this->statement as $row) {
        echo $row[0];
    }
  }
  
  
  function setStatementByQuery($query){
     $this->statement = self::$pdo->query($query);
  }

  public function returnText(){
    echo $this->pdo->query($statement);
  }

// INSERT ##################################################// 
// INSERT ##################################################
// INSERT ##################################################

  public function getTableColumns($tableName){
    $query_col = 'SHOW COLUMNS FROM ' . $tableName;
    $tableColumns = array();
    $rez_col = $this->pdo->query($query_col);
    //print_r($rez_col);
    foreach ($rez_col as $key) {
      if(($key['Extra']!='auto_increment')&&($key['Default']!='CURRENT_TIMESTAMP')){
      array_push($tableColumns, $key['Field']);
      }
    }

    return $tableColumns;

  }



  public function setInsertTable($tableName){
    $this->insertTable = $tableName;
  }

  public function insertIntoTable($values){
    if($this->insertTable!=null){
      
      $columnsOfTable = $this->getTableColumns($this->insertTable);
      $commaSeparatedColumnsOfTable = implode(", ", $columnsOfTable);
      $insertQuery = 'INSERT INTO ' . $this->insertTable . ' (' . $commaSeparatedColumnsOfTable . ') VALUES (' . $values . ')';
      
      if($this->pdo->query($insertQuery)){
        echo "<b> Zapis  </b>uspješno dodan u tablicu <mark style='text-transform: uppercase; '>" . $this->insertTable . "</mark> --- <small>vrijednosti (" . $values. " )</small>" ;
      }
      else { echo "dogodila se greška :/"; }
    }  
  }

  public function printInputForm(){ // podaci se POSTaju i dovati se array sa $_POST['data']
    if($this->insertTable!=null){

     $columnsOfTable = $this->getTableColumns($this->insertTable);
     echo '<h4 onclick="$(this).next().toggle(500);">Add record in table <mark style="text-transform: uppercase; ">' . $this->insertTable . '</mark></h4>';
     echo '<form action="" method="post" id="toggleble">
     <table border="1"> <tr>' ;
     echo '<input type="hidden" value="' . $this->insertTable .'" name="' . $this->insertTable . '[insertinserttable]" /> ';
     
     foreach ($columnsOfTable as $value) {
       echo '<th>' . $value . '</th>';
     }
     echo '</tr><tr>' ;
     foreach ($columnsOfTable as $value) {
       echo '<td><input type="text" name="' . $this->insertTable . '[' . $value . ']"></td>';
     }

     echo '</tr></table><input type="submit" value="Submit"></form>';

   }
  }


  public function insertPOSTED($content){

    if(isset($content) && ($content['insertinserttable'] == $this->insertTable )){ //if content is set, if the insert table is same
      if(($key = array_search($this->insertTable, $content)) !== false) { //removing of table name value
          unset($content[$key]);
      }
    //commaseperated, maing suitable for input into table
      $comma_seperated = implode("', '", $content);
      $comma_seperated="'" . $comma_seperated . "'";
      $this->insertIntoTable($comma_seperated);
    } 
  }

  ### za UPDATE ############################################
  ### za UPDATE ############################################
  ### za UPDATE ############################################
  ### za UPDATE ############################################
  
}// end of Db class







?>