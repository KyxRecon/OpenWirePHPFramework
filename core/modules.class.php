<?php
	 
	 
namespace Core;
use \Framework as Framework;
	

class modules extends Framework {
		 
	protected $framework, $name, $description;
	private $module, $defaultVariables, $modType;
   
	public function __construct($framework)
	{
		$this->framework = $framework;
		$this->name = "Modules";
		$this->description = "Module functions";
		$this->base_path = $this->framework->base;
		$this->defaultVariables = array(
		'target' => array('required' => true, 'description' => ' ', 'match' => self::regexURL)
		);
        $this->modType = null;
	}

	protected function preloadModules()
	{
	    $modtypes = array("aux", "exploit", "payload");
	    foreach($modtypes as $type)
	    {
	        $this->modtype = $type;
	        $files = glob("{$this->base_path}/modules/$type/*.php");
	        foreach ($files as $file) require_once $file;
	    }
		return true;
	}

	protected function verifyModule()
	{
		if (!is_object($this->module)) {
			echo $this->framework->libs['colours']->cstring("\n\n\tNo Module Defined\n\n", "blue");
			return false;
		}
		return true;
	}

	protected function loadModule($module)
	{
		if (!file_exists("{$this->framework->base}/modules/".$this->modType."/{$module}.php")) {
				echo $this->framework->libs['colours']->cstring("\n\n\t[", "white");
				echo $this->framework->libs['colours']->cstring("*", "red");
				echo $this->framework->libs['colours']->cstring("] ", "white");
				echo $this->framework->libs['colours']->cstring("{$module} is not a valid module\n\n", "blue");
				return false;
		}
		$this->module = null;
		require_once "{$this->framework->base}/modules/".$this->modType."/{$module}.php";
		$class = "\\".ucfirst($this->modType)."\\{$module}";
		$this->module = new $class($this->framework);

		if (!is_object($this->module)) {
				echo $this->framework->libs['colours']->cstring("\n\n\t[", "white");
				echo $this->framework->libs['colours']->cstring("*", "red");
				echo $this->framework->libs['colours']->cstring("] ", "white");
				echo $this->framework->libs['colours']->cstring("Error loading module {$module}\n\n", "blue");
				return false;
		}   
		$vars = $this->module->getVars();
		$this->variables = array_merge($this->defaultVariables, $vars);
				$name = $this->module->getName();
				echo $this->framework->libs['colours']->cstring("\n\n\t[", "white");
				echo $this->framework->libs['colours']->cstring("*", "green");
				echo $this->framework->libs['colours']->cstring("] ", "white");
				echo $this->framework->libs['colours']->cstring("Module ".$name." loaded\n\n", "green");
				return true;
	}

	protected function listModules()
	{
	    $type = $this->modType;
		$this->preloadModules();
		$classes = get_declared_classes();
		echo $this->framework->libs['colours']->cstring("\n\n\tOpenWire Framework\n", "blue");
		echo $this->framework->libs['colours']->cstring("\tList of all $this->modType Modules\n", "purple");
		echo $this->framework->libs['colours']->cstring("\t--------------------------------------------------------------------\n", "white");


		foreach ($classes as $class) {
	            
				preg_match('#('.$type.'\\\.*)#', $class, $matches);
				if (empty($matches[1])) continue;
				$module = new $matches[1]($this);
				$name = $module->getName();
				$desc = $module->getDesc();
				$modname = $module->getMod();

				echo $this->framework->libs['colours']->cstring("\t[*] Name: ", "blue");
				echo $this->framework->libs['colours']->cstring("{$name}\n", "white");
				echo $this->framework->libs['colours']->cstring("\t[*] Description: ", "blue");
				echo $this->framework->libs['colours']->cstring("{$desc}\n", "white");
				echo $this->framework->libs['colours']->cstring("\t[*] Load Name: ", "blue");
				echo $this->framework->libs['colours']->cstring("{$modname}\n", "white");
				echo $this->framework->libs['colours']->cstring("\t--------------------------------------------------------------------\n", "white");

				unset($module);
		}
		echo "\n";
		return true;
	}


	protected function listType()
	{
		return $this->modType;
	}

	public function setModType($type)
	{
		switch($type)
		{
			case 'aux':
				$this->modType = 'aux';
				break;

			case 'exploit':
				$this->modType = 'exploit';
				break;

			case 'payload':
				$this->modType = 'payload';
				break;

			default:
				$this->modType = null;
				return false;
		}
		return true;
	}

	protected function verifyVariables()
	{
	    foreach ($this->variables as $key => $data) {
	            if ($data['required'] && empty($this->module->$key)) {
	                    echo $this->framework->libs['colours']->cstring("\n\t[*] Missing required variable: ", "white");
	                    echo $this->framework->libs['colours']->cstring("{$key}\n\n", "red");
	                    return false;
	            }
	            if (!$data['required'] && empty($this->module->$key)) {
	                    $this->module->$key = $this->variables[$key]['default'];
	            }
	    }
	    return true;
	}

	public function showVariables()
	{
	    if(!$this->verifyModule()) return false;
	    $this->verifyVariables();
	    
	    foreach($this->variables as $key => $variable)
	    {
	        $required = ($variable['required'] ? '*' : ' ');
	        echo $this->framework->libs['colours']->cstring("\t{$required} ", "red");
	        echo $this->framework->libs['colours']->cstring("{$key}", "white");
	        echo " : ";
	        if(isset($this->module->$key))
	            echo $this->framework->libs['colours']->cstring($this->module->$key."", "green");
	        else
	            echo $this->framework->libs['colours']->cstring("default", "blue");
	        echo " : ";
	        echo $this->framework->libs['colours']->cstring("{$variable['description']}\n", "purple");
	    }
	        echo $this->framework->libs['colours']->cstring("\n\n\t*", "red");
	        echo $this->framework->libs['colours']->cstring(" = ", "white");
	        echo $this->framework->libs['colours']->cstring("required\n\n", "blue");
	}

	private function variableExists($variable)
	{
	    $exists = in_array($variable, array_keys($this->variables));
	    return $exists;
	}

	public function setValue($variable, $value)
	{
	    if (!$this->verifyModule()) return false;
	    if (!$this->variableExists($variable)) {
	            echo "\n\n\tVariable {$variable} doesn't exist\n";
	            return false;
	    }

	    $this->module->$variable = $value;
	    $variable = ucfirst($variable);
	    echo $this->framework->libs['colours']->cstring("\n\n\t${variable} set as ", "white");
	    echo $this->framework->libs['colours']->cstring("${value}\n\n", "blue");
	    return true;
	}



	public function getModule()
	{
	    $mod = $this->module;
	    return $mod;
	}

	protected function runThreads($callback)
	{
    	$master = curl_multi_init();
    	$threadCount = count($this->framework->threadArray);
    	for ($this->framework->currentThread = 0; ($this->framework->currentThread < Framework::threads && $this->framework->currentThread < $threadCount); $this->framework->currentThread++) {
            $ch = curl_init();
            curl_setopt_array($ch, $this->framework->threadArray[$this->framework->currentThread]);
            curl_multi_add_handle($master, $ch);
    	}
    	$this->framework->currentThread--;
    	do {
            while (($execrun = curl_multi_exec($master, $running)) == CURLM_CALL_MULTI_PERFORM);
            if ($execrun != CURLM_OK) break;
            while ($done = curl_multi_info_read($master)) {
                unset($this->framework->threadArray[$this->framework->currentThread]);
                $this->framework->queries++;
                $this->framework->currentThread++;
                $this->framework->module->$callback($done['handle']);
                if (isset($this->framework->threadArray[$this->framework->currentThread])) {
                        $ch = curl_init();
                        curl_setopt_array($ch, $this->framework->threadArray[$this->framework->currentThread]);
                        curl_multi_add_handle($master, $ch);
                }
                curl_multi_remove_handle($master, $done['handle']);
            }
    	} while ($running);
    	curl_multi_close($master);
    	return true;
	}
	protected function addThread($options)
	{
    	if (!isset($options[CURLOPT_URL])) return false;
    	$options[CURLOPT_RETURNTRANSFER] = true;
    	$this->framework->threadArray[] = $options;
    	return true;
	}
	
	protected function clearThreads()
	{
        $this->framework->threadArray = array();
	}

	public function localShell()
	{
		$line = '';
        $exitCommands = array('quit', 'exit');

        do {
            $prompt = $this->framework->libs['colours']->cstring("Local ", "white");
            $prompt .= $this->framework->libs['colours']->cstring("Shell> ", "blue");
            $line = readline($prompt);
                switch ($line) {
                    default:
                        $post = passthru($line);
            }
            readline_add_history($line);
        }
        while (!in_array($line, $exitCommands));
	}
}
?>
