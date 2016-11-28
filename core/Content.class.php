<?

class Content extends AbstractContent {
	
	public $content;

    public function __construct($connection){ //constructor in which is PDO defined
     if($connection!=null){
	    $this->postaviDb($connection);
    	}
    }



	public function create(){ //insert u bazu
		

	}


	public function read(){ //citanje iz baze
		$this->returnOneRecord();

	}


	public function update(){ //update na bazu

	}


	public function delete(){ //brisanje iz baze


	}





}







?>