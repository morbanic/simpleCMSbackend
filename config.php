<?

define( ROOT_DIR, dirname(__FILE__).'/' );
define( CORE_DIR, dirname(__FILE__).'/core' );
define( WEB_DIR, 'http://simplecmsbackend.esy.es');

//function that searches for class definitions in files e.g.  class Content is defined in Content.class.php file
function searchClass($className,$dir,$subdirs='') { 
  if ($dh = opendir($dir)) {
          while (($file = readdir($dh)) !== false) { 

            if($file!='.') {
                if( $file!='..') { 
                   if(is_file(CORE_DIR .$subdirs.'/'. $file)){
                      if ($file==$className) {
                      require_once(CORE_DIR .$subdirs.'/'. $file);
                      return 1;
                      }
                   }
                   else {
                           $subdirs.='/'.$file;
                           searchClass($className,CORE_DIR.$subdirs,$subdirs);
                           $subdirs='';
                         }
                     }
               }
          }
          closedir($dh);
      }

}

spl_autoload_register(function ($class){
  searchClass($class.'.class.php',CORE_DIR);
});

?>
