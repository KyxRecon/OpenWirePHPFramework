<?php


/*
WhatsMyIP Plugin to find Internal & External IP Address
Version: 1.0 
Author: Logic
Date: May 22, 2013
*/

namespace aux;
use \Framework as Framework;

class ip extends Framework {
 
	protected $framework, $name, $description, $variables;

	public function __construct($framework) 
	{
	   
		$this->framework = $framework;
		$this->name = 'IP';
		$this->description = 'Find local and external IP';
		$this->modName = 'get_ip';
		$this->variables = array(
	        'external' => array('required' => false, 'description' => '', 'default' => ''),
	        'internal' => array('required' => false, 'description' => '', 'default' => ''),
	        'target' => array('required' => false, 'description' => '', 'default' => ''),
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
		return 1;
	}

	public function exploit()
	{
		
		$this->run();
		return 1;
	}

	private function local()
	{
		
		socket_connect('74.125.227.32');
		$this->internal = $ip;
	}

	private function external()
	{
		$page = http_get("http://checkip.dyndns.org/");
		$this->external = $ip;

	}

	public function run()
	{


	}

	public function post()
	{
		print "This module does not support post Exploit\n";
		return 0;
	}
}
?>
