<?

abstract class AbstractContent extends Db {

public function postaviDb($pdoSet=null){ //constructor in wihch is PDO defined
    if(!isset($this->pdo)){
      try {

        $this->pdo = $pdoSet;

      } catch (PDOException $e) {
       print "Error!: " . $e->getMessage() . "<br/>";
       die();
      }
      //echo "Connected! <br>";
    }  
  }



}

?>