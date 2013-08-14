<?php
/*
Bing Search
Version: 1.0 
Author: Logic
Date: May 14, 2013
*/

namespace aux;
use \Framework as Framework;
 


class bingsearch extends Framework {
 
	protected $framework, $name, $description, $variables, $cookie;

	public function __construct($framework) 
	{
	   
		$this->framework = $framework;
		$this->name = 'Bing Search';
		$this->description = 'You provide it with the search term or query and it will run it through Bing! Search Engine';
	    $this->modName = 'bingsearch';      
	    $this->variables = array(
	        'searchType' => array('required' => false, 'description' => 'What do you want bing to search for', 'default' => '.php?id=1'),
	        'countryCode' => array('required' => false, 'description' => 'Set what country code you want to use (com, edu, gov)', 'default' => 'com'),

	    );
	   
	}

	public function getName()
	{
		return $this->name;
	}

	public function getDesc()
	{
		return $this->description;
	}
	
	public function getMod()
	{
		return $this->modName;
	}

	public function getVars()
	{
		return $this->variables;
	}

	private function loadModule()
	{
		$this->setModule(1, $this->module_name);
	}

	private function installModule()
	{
		$this->addModule($this->module_name);
		$this->loadModule();
	}

	public function check()
	{
		print "This module does not support check\n";

		return 1;
	}

	public function exploit()
	{
		
		$this->search();
			
		return 1;
	}

	public function post()
	{
		print "This module does not support post Exploit\n";

		return 0;
	}

	

	public function search()
	{
		echo "\n\n\t[*] Dork Set to: ".$this->searchType."\n";
		echo "\t[*] Country Code Set to ".$this->countryCode."\n\n";

		echo "\t[*] Now Commencing Bing Search...\n\n";

		$count = "9";
		$bing = "http://www.bing.com/search?q=".$this->searchType."&qs=n&pq=".$this->searchType."&sc=8-5&sp=-1&sk=&first=".$count."&FORM=PORE";
		$link = $this->framework->libs['webot']->curl_get_contents($bing);
		


	}
}
?>
