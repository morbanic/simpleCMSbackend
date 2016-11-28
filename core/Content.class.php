<?

class Content extends AbstractContent {
	
	public $content;

    public function __construct($connection){ //constructor in which is PDO defined
     if($connection!=null){
	    $this->postaviDb($connection);
    	}
    }


}



?>