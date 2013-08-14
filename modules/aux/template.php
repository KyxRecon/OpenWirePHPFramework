<?php


/*
PHP Documenttation goes here
*/

// We use 3 namespaces currently: aux, exploit, and payload. One of these must be used and placed in the correct folder. 
namespace aux;
use \Framework as Framework;

// Class names must be unique. extends Framework is required
class template extends Framework {
 
	protected $framework, $name, $description, $variables;
	public $type, $ext;

	public function __construct($framework) 
	{
	   
		$this->framework = $framework;
		// Modules Name
		$this->name = 'Template';
		// Module Description
		$this->description = 'Template for making modules';
		// How you call the module using the framework
		$this->modName = 'test';
		// You can use variables here as global variables For instance I could set a specific target, port or anything I wanted.
	    $this->variables = array(
	        'varName' => array('required' => false, 'description' => 'Description goes here', 'default' => 'robots'),


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

	// You can initiate a check to verify that the target is vuln or even alive
	public function check()
	{
		return 1;
	}

	// Triggers the exploit command
	public function exploit()
	{
		$this->run();
		return 1;
	}

	// Initiate a post exploit ex. shell upload
	public function post()
	{
		print "This module does not support post Exploit\n";
		return 0;
	}

	// This is where the exploit goes
	public function run()
	{

	}
}
?>
