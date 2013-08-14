<?php
/*
pscan.php simple port scanner for Openwire framework
Version: 0.1 
Author: Phaedrus
Date: February 17, 2013
*/
namespace aux;
use \Framework as Framework;
 


class pscan extends Framework {
 
	protected $framework, $name, $description, $variables, $cookie;

	public function __construct($framework) 
	{
	   
		$this->framework = $framework;
		$this->name = 'pScan';
		$this->description = 'Simple Port Scanner';
	    $this->modName = 'pscan';       
	    $this->variables = array(
	        'portrange' => array('required' => false, 'description' => 'Range of ports to scan, seperated by a colon', 'default' => '0-1000'),
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
		
		$this->scan(gethostbyname($this->target));
			
		return 1;
	}

	public function post()
	{
		print "This module does not support post Exploit\n";

		return 0;
	}

	private function scan($ip)
	{
		echo $this->framework->libs['colours']->cstring("Open Ports: \n", "red");

		//scan a list of specified ports
		if(strpos($this->portrange, ","))
		{
			$range = explode(",", $this->portrange);
			foreach($range as $port)
				$this->connect($ip, $port);
			return 1;
		}
		//scan a range of ports
		else if(strpos($this->portrange, "-"))
		{
			$range = explode("-", $this->portrange);
			$start = $range[0];
			$stop = $range[1];
		}
		//scan a single port
		else
			$start = $stop = $this->portrange;
		
		for($i=$start;$i<=$stop;$i++) 
		{
			$this->connect($ip, $i);
		}
		return 1;
	}

	private function connect($ip, $i)
	{
		@$fp = fsockopen($ip,$i,$errno,$errstr,10);
		if($fp)
		{
			echo $this->framework->libs['colours']->cstring("\t$i\n", "yellow");
			fclose($fp);
		}
	}
}
?>
