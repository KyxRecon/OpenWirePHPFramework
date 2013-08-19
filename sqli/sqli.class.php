<?php
	 	 
namespace SQLi;
use \Framework as Framework;


class sqli extends Framework {
		 
	protected $framework, $name, $description;

  	public function __construct($framework)
	{
		$this->framework = $framework;
		$this->name = "sqli";
		$this->description = "SQLi Framework";
		$this->base_path = $this->framework->base;
		$this->defaultVariables = array(
		'target' => array('required' => true, 'description' => ' ', 'match' => self::regexURL)
		);
        $this->modType = null;
        $this->base = getcwd();
        $this->sqlclass = array();
        $this->sqlcore = array();
        
        # Establish some Global Variables we will use throughout the framework to drive decisions
		$this->head = ''; 
		$this->ref = '';
		$this->delim = '-- -'; 
		$this->pre = ''; 
		$this->prefix = ''; 
		$this->suf = ''; 
		$this->suffix = ''; 
		$this->timeout = 30;
		$this->auth = array(''); 
		$this->proxy = array(''); 
		$this->ua = 'FireFox'; 
		$this->proxy_auth = array(''); 
		$this->headers_add = array('');
		$this->custom = ''; 
		$this->cookie_support = '';
		$this->user_agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:18.0) Gecko/20100101 Firefox/18.0'; 
		
		#Initialize a results directory if one does not exist
		$results = $this->framework->base."/sqli/results/";
		if (!file_exists($results)) {
	    	mkdir($results, 0777, true);
		}

		#Initialize a temp directory if one does not exist
		$temp = $this->framework->base."/sqli/temp/";
		if (!file_exists($temp)) {
	    	mkdir($temp, 0777, true);
		}
	 }
     public function showsqliUsage()
     {
            echo "\n\n";
            echo $this->framework->libs['colours']->cstring(" \tOpenWire SQLi Framework\n", "blue");
            echo $this->framework->libs['colours']->cstring(" \tList of commands and description of usage\n", "purple");
            echo $this->framework->libs['colours']->cstring("\t--------------------------------------------------------------------\n", "white");


            echo $this->framework->libs['colours']->cstring(" \tbanner", "blue");
            echo $this->framework->libs['colours']->cstring("                   - Display the Banner\n", "white");
            echo $this->framework->libs['colours']->cstring(" \thelp", "blue");
            echo $this->framework->libs['colours']->cstring("                     - Display this list\n", "white");
            echo $this->framework->libs['colours']->cstring(" \tclear/cls", "blue");
            echo $this->framework->libs['colours']->cstring("                - Clears the Screen\n", "white");
            echo $this->framework->libs['colours']->cstring(" \tcrawler", "blue");
            echo $this->framework->libs['colours']->cstring("                  - Crawl Site for Testable Links\n", "white");
            echo $this->framework->libs['colours']->cstring(" \tfinder", "blue");
            echo $this->framework->libs['colours']->cstring("                   - Page Finder Menu (ADMIN|PHPINFO|PMA|CUSTOM)\n", "white");
            echo $this->framework->libs['colours']->cstring(" \tproxy", "blue");
            echo $this->framework->libs['colours']->cstring("                    - Enable Proxy Support for Requests\n", "white");
            echo $this->framework->libs['colours']->cstring(" \tauth", "blue");
            echo $this->framework->libs['colours']->cstring("                     - Enable HTTP Basic Auth for Requests\n", "white");
            echo $this->framework->libs['colours']->cstring(" \tcustom", "blue");
            echo $this->framework->libs['colours']->cstring("                   - Customize HTTP Requests (Headers, Referer, UA, or Cookies)\n", "white");
            echo $this->framework->libs['colours']->cstring(" \tsqlset", "blue");
            echo $this->framework->libs['colours']->cstring("                   - Customize SQL Injection Request Settings (Delimeter, Prefix, Suffix)\n", "white");
            echo $this->framework->libs['colours']->cstring(" \tsqlcore", "blue");
            echo $this->framework->libs['colours']->cstring("                   - Show the list of SQL Core Functions\n", "white");
            echo $this->framework->libs['colours']->cstring(" \tsqlclass", "blue");
            echo $this->framework->libs['colours']->cstring("                   - Show the list of SQL Class Functions\n", "white");
            echo $this->framework->libs['colours']->cstring(" \tfuzz", "blue");
            echo $this->framework->libs['colours']->cstring("                     - Fuzz Test link(s) for signs of SQLi Injection\n", "white");
            echo $this->framework->libs['colours']->cstring(" \tunion", "blue");
            echo $this->framework->libs['colours']->cstring("                    - Union Based Injection Assistant\n", "white");
            echo $this->framework->libs['colours']->cstring(" \tblind", "blue");
            echo $this->framework->libs['colours']->cstring("                    - Blind Based Injection Assistant\n", "white");
            echo $this->framework->libs['colours']->cstring(" \terror", "blue");
            echo $this->framework->libs['colours']->cstring("                    - Error Based Injection Assistant\n", "white");
            echo $this->framework->libs['colours']->cstring(" \tstrass", "blue");
            echo $this->framework->libs['colours']->cstring("                   - String Assistant Tool\n", "white");
            echo $this->framework->libs['colours']->cstring("\t--------------------------------------------------------------------\n\n", "white");

            return true;
      }
      public function sqli()
	  {
        $sqlcorelist = $this->preloadsqlCore();
        foreach($sqlcorelist as $sqlcore)
            $this->loadsqlCore(substr($sqlcore, 10, -9));
                        
        $sqlclasslist = $this->preloadsqlClass();
        foreach($sqlclasslist as $sqlclass)
            $this->loadsqlClass(substr($sqlclass, 10, -9));
            
        $liblist = $this->preloadLibs();
        foreach($liblist as $lib)
            $this->loadLibrary(substr($lib, 5, -10));
        
        $line = '';
        $exitCommands = array('quit', 'exit');

        do {
            $prompt = $this->framework->libs['colours']->cstring("SQLi ", "white");
            $prompt .= $this->framework->libs['colours']->cstring("Framework> ", "blue");
            $line = readline($prompt);
            $commands = explode(' ', $line);
            if (empty($commands) || in_array($commands[0], $exitCommands)) continue;
            switch ($commands[0]) 
            {
                case 'help':
                    $this->showsqliUsage(); break;
                    
                case 'clear':
                case 'cls':
                    $this->framework->clearscreen(); break;

                case 'banner':
                    $this->framework->core['main']->outputHeader(); break;
                    
                case 'crawler':
					$this->showsqliUsage(); break;
					
                case 'finder':
					$this->showsqliUsage(); break;
					
                case 'proxy':
					$this->proxy_support(); break;
					
				case 'sqlcore':
                    $this->listsqlCore(); break;
                    
                case 'sqlclass':
                    $this->listsqlClass(); break;
					
                case 'auth':
					$this->auth_support(); break;
					
                case 'custom':
					$this->custom_support(); break;
					
                case 'sqlset':
					$this->custom_sqli_support(); break;
					
                case 'fuzz':
					$this->showsqliUsage(); break;
					
                case 'union':
					$this->showsqliUsage(); break;

                case 'double':
					$this->sqlcore['doubleQuery']->ordoubleQuery(); break;
					
                case 'blind':
					$this->showsqliUsage(); break;
					
                case 'error':
					$this->showsqliUsage(); break;
					
                case 'strass': 
					$this->genFolders(); break;
					
                case 'display': 
					echo $this->ua."\n";
					echo $this->user_agent."\n";
					echo $this->ref."\n";
					foreach ($this->headers_add as $headers => $value) {
						if ($headers != '0' && $headers != NULL) {
							echo $headers.$value."\n";
						}
					}
					foreach ($this->auth as $auth => $value) {
						if ($auth != '0' && $auth != NULL) {
							echo $auth.$value."\n";
						}
					}
					break;
					
                    
                default:
                    echo $this->framework->libs['colours']->cstring("\tERROR: ", "red");
                    echo "{$line} is not a valid command\n";
            }
            readline_add_history($line);
        }
        while (!in_array($line, $exitCommands));
	}

    public function preloadsqlCore()
    {
        $sqlcore_files = array();
        $sqlcore = glob('sqli/core/*.php');
        for($i = 0; $i < count($sqlcore); $i++)
        {
            $sqlcore_files[$i] = $sqlcore[$i];
            require_once $sqlcore[$i];
        }
        return $sqlcore_files;
    }
    
    private function preloadLibs()
    {
        $lib_files = array();
        $libs = glob('libs/*.php');
        for($i = 0; $i < count($libs); $i++)
        {
            $lib_files[$i] = $libs[$i];
            require_once $libs[$i];
        }
        return $lib_files;
    }
    
    public function preloadsqlClass()
    {
        $sqlclass_files = array();
        $sqlclass = glob('sqli/class/*.php');
        for($i = 0; $i < count($sqlclass); $i++)
        {
            $sqlclass_files[$i] = $sqlclass[$i];
            require_once $sqlclass[$i];
        }
        return $sqlclass_files;
    }
    
    public function loadsqlCore($sqlcore)
    {
        if (!file_exists("sqli/core/{$sqlcore}.core.php")) 
        {
            echo "\t{$sqlcore} is not a valid core function\n";
            return false;
        }
        require_once "sqli/core/{$sqlcore}.core.php";
        $class = "\\sqlCore\\{$sqlcore}";
        $this->sqlcore[$sqlcore] = new $class($this);
        if (!is_object($this->sqlcore[$sqlcore])) 
        {
            echo "\tError loading core function {$sqlcore}\n";
            return false;
        }
        return true;
    }
    
    private function loadLibrary($lib)
    {
        if (!file_exists("libs/{$lib}.class.php")) 
        {
            echo "\t{$lib} is not a valid library\n";
            return false;
        }
        require_once "libs/{$lib}.class.php";
        $class = "\\Libraries\\{$lib}";
        $this->libs[$lib] = new $class($this);
        if (!is_object($this->libs[$lib])) 
        {
            echo "\tError loading library {$lib}\n";
            return false;
        }
        return true;
    }
    
    public function loadsqlClass($sqlclass)
    {
        if (!file_exists("sqli/class/{$sqlclass}.class.php")) 
        {
            echo "\t{$sqlclass} is not a valid core function\n";
            return false;
        }
        require_once "sqli/class/{$sqlclass}.class.php";
        $class = "\\sqlClass\\{$sqlclass}";
        $this->sqlclass[$sqlclass] = new $class($this);
        if (!is_object($this->sqlclass[$sqlclass])) 
        {
            echo "\tError loading core function {$sqlclass}\n";
            return false;
        }
        return true;
    }
    
    public function listsqlCore()
    {
        $this->preloadsqlCore();
        $classes = get_declared_classes();
        echo $this->framework->libs['colours']->cstring("\n\n\tOpenWire Framework\n", "blue");
        echo $this->framework->libs['colours']->cstring("\tList of all SQL Framework Functions\n", "purple");
        echo $this->framework->libs['colours']->cstring("\t--------------------------------------------------------------------\n", "white");
        foreach ($classes as $class) {
            preg_match('#(sqlCore\\\.*)#', $class, $matches);
            if (empty($matches[1])) continue;
            $sqlcore = new $matches[1]($this);
            echo $this->framework->libs['colours']->cstring("\t[*] Name: ", "blue");
            echo $this->framework->libs['colours']->cstring("{$this->sqlcore->name}\n", "white");
            echo $this->framework->libs['colours']->cstring("\t[*] Description: ", "blue");
            echo $this->framework->libs['colours']->cstring("{$this->sqlcore->description}\n", "white");
            echo $this->framework->libs['colours']->cstring("\t--------------------------------------------------------------------\n\n", "white");

            unset($module);
        }
        return true;
    }
    
    
	public function listsqlclass()
    {
        $this->preloadsqlclass();
        $classes = get_declared_classes();
        echo $this->framework->libs['colours']->cstring("\n\n\tOpenWire Framework\n", "blue");
        echo $this->framework->libs['colours']->cstring("\tList of all SQL Framework Functions\n", "purple");
        echo $this->framework->libs['colours']->cstring("\t--------------------------------------------------------------------\n", "white");
        foreach ($classes as $class) {
            preg_match('#(sqlClass\\\.*)#', $class, $matches);
            if (empty($matches[1])) continue;
            $sqlclass = new $matches[1]($this);
            echo $this->framework->libs['colours']->cstring("\t[*] Name: ", "blue");
            echo $this->framework->libs['colours']->cstring("{$sqlclass->name}\n", "white");
            echo $this->framework->libs['colours']->cstring("\t[*] Description: ", "blue");
            echo $this->framework->libs['colours']->cstring("{$sqlclass->description}\n", "white");
            echo $this->framework->libs['colours']->cstring("\t--------------------------------------------------------------------\n\n", "white");

            unset($module);
        }
        return true;
    }


	# Enable HTTP Authentication Support
	public function auth_support() {
        print "\n\n";
        print $this->framework->libs['colours']->cstring(" \tOpenWire SQLi Framework\n", "blue");
        print $this->framework->libs['colours']->cstring(" \tSQLi Framework HTTP Basic Auth Configuration\n", "purple");
		print $this->framework->libs['colours']->cstring("\t----------------------------------------------\n", "white");
		print $this->framework->libs['colours']->cstring(" \tEnable HTTP Auth Support (Y/N)? ", "blue");
		$handle = fopen ("php://stdin","r");
		$line = strtoupper(fgets($handle));
		if(trim($line) == 'YES' || trim($line) == 'Y'){
			print $this->framework->libs['colours']->cstring(" \tUsername for HTTP Auth: ", "blue");
			$user_handle = fopen ("php://stdin","r");
			$user_line = fgets($user_handle);
			
			print $this->framework->libs['colours']->cstring("\n \tPassword for HTTP Auth: ", "blue");
			$pass_handle = fopen ("php://stdin","r");
			$pass_line = fgets($pass_handle);
			
			$this->auth[$user_line] = $pass_line;
			
            print $this->framework->libs['colours']->cstring(" \n\n\tHTTP Basic Authentication Complete\n", "blue");
            print $this->framework->libs['colours']->cstring("\t--------------------------------------\n", "white");
			print("\tHTTP Auth: ");
			print $this->framework->libs['colours']->cstring("Enabled\n", "blue");
			print("\tHTTP User: ");
			print $this->framework->libs['colours']->cstring($user_line, "blue");
			print("\tHTTP Pass: ");
			print $this->framework->libs['colours']->cstring($pass_line, "blue");
			print $this->framework->libs['colours']->cstring("\t--------------------------------------\n\n", "white");
			
		}
	}
	# Enable Custom HTTP Request Options
	# Set Custom Cookies, Headers, or User-Agents
	public function custom_support() {
        print "\n\n";
        print $this->framework->libs['colours']->cstring(" \tOpenWire SQLi Framework\n", "blue");
        print $this->framework->libs['colours']->cstring(" \tSQLi Framework HTTP Basic Auth Configuration\n", "purple");
		print $this->framework->libs['colours']->cstring("\t----------------------------------------------\n", "white");
		print $this->framework->libs['colours']->cstring(" \tCustomize HTTP Requests (Y/N)? ", "blue");
		$handle = fopen ("php://stdin","r");
		$line = strtoupper(fgets($handle));
		if(trim($line) == 'YES' || trim($line) == 'Y'){
			print $this->framework->libs['colours']->cstring(" \tOpenWire SQLi Framework\n", "blue");
			print $this->framework->libs['colours']->cstring(" \tSelect Customization Option:\n", "purple");
			print $this->framework->libs['colours']->cstring("\t----------------------------------------------\n", "white");
			
			print $this->framework->libs['colours']->cstring("\t0)", "blue");
			print $this->framework->libs['colours']->cstring(" \t Return to Main Menu\n", "white");
			print $this->framework->libs['colours']->cstring("\t1)", "blue");
			print $this->framework->libs['colours']->cstring(" \t Set Custom User-Agent\n", "white");
			print $this->framework->libs['colours']->cstring("\t2)", "blue");
			print $this->framework->libs['colours']->cstring(" \t Set Custom Referrer\n", "white");
			print $this->framework->libs['colours']->cstring("\t3)", "blue");
			print $this->framework->libs['colours']->cstring(" \t Set Custom Cookies\n", "white");
			print $this->framework->libs['colours']->cstring("\t4)", "blue");
			print $this->framework->libs['colours']->cstring(" \t Set Custom Headers\n", "white");
			print $this->framework->libs['colours']->cstring("\t5)", "blue");
			print $this->framework->libs['colours']->cstring(" \t Set Request Timeout\n", "white");
			
			print $this->framework->libs['colours']->cstring(" \tMake a Selection ", "blue");
			$handle = fopen("php://stdin","r");
			$line = strtoupper(fgets($handle));
			if(trim($line) == '0'){
				return 0;
			} 
			if(trim($line) == '1'){
				print $this->framework->libs['colours']->cstring(" \tOpenWire SQLi Framework\n", "blue");
				print $this->framework->libs['colours']->cstring(" \tSelect User Agent:\n", "purple");
				print $this->framework->libs['colours']->cstring("\t-----------------------------\n", "white");
			
				print $this->framework->libs['colours']->cstring("\t1)", "blue");
				print $this->framework->libs['colours']->cstring(" \t IE 8\n", "white");
				print $this->framework->libs['colours']->cstring("\t2)", "blue");
				print $this->framework->libs['colours']->cstring(" \t FireFox (Default)\n", "white");
				print $this->framework->libs['colours']->cstring("\t3)", "blue");
				print $this->framework->libs['colours']->cstring(" \t Opera\n", "white");
				print $this->framework->libs['colours']->cstring("\t4)", "blue");
				print $this->framework->libs['colours']->cstring(" \t Chrome\n", "white");
				print $this->framework->libs['colours']->cstring("\t5)", "blue");
				print $this->framework->libs['colours']->cstring(" \t Safari\n", "white");
				
				print $this->framework->libs['colours']->cstring(" \tMake a Selection ", "blue");
					$handle = fopen("php://stdin","r");
					$line = strtoupper(fgets($handle));
					if(trim($line) == '1'){
						$this->ua = 'IE 8';
						$this->user_agent = 'Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 1.1.4322; .NET CLR 2.0.50727)';
						$this->custom_support();
					}
					else if(trim($line) == '2'){
						$this->ua = 'Firefox';
						$this->user_agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:18.0) Gecko/20100101 Firefox/18.0';
						$this->custom_support();
					}
					else if(trim($line) == '3'){
						$this->ua = 'Opera';
						$this->user_agent = 'Opera/9.80 (X11; Linux i686; U; hu) Presto/2.9.168 Version/11.50';
						$this->custom_support();
					}
					else if(trim($line) == '4'){
						$this->ua = 'Chrome';
						$this->user_agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.60 Safari/537.17';
						$this->custom_support();
					}
					else if(trim($line) == '5'){
						$this->ua = 'Safari';
						$this->user_agent = 'Mozilla/5.0 (iPad; CPU OS 5_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko ) Version/5.1 Mobile/9B176 Safari/7534.48.3';
						$this->custom_support();
					}
					else {
						print("Don't understand request: ".$line."\n");
						print("Please Select a valid User-Agent option!\n");
						$this->custom_support();
					}
				
			} 
			else if(trim($line) == '2'){
				print $this->framework->libs['colours']->cstring(" \tOpenWire SQLi Framework\n", "blue");
				print $this->framework->libs['colours']->cstring(" \tCustom Referrer:\n", "purple");
				print $this->framework->libs['colours']->cstring("\t-----------------------------\n", "white");
				print $this->framework->libs['colours']->cstring(" \tEnter Custom Referrer: ", "blue");
				$handle = fopen("php://stdin","r");
				$this->ref = fgets($handle);
				print $this->framework->libs['colours']->cstring(" \tUpdated Referrer to: ", "blue");
				print $this->framework->libs['colours']->cstring($this->ref."\n", "white");
				$this->custom_support();
			} 			
			else if(trim($line) == '3'){
				print $this->framework->libs['colours']->cstring(" \tOpenWire SQLi Framework\n", "blue");
				print $this->framework->libs['colours']->cstring(" \tCustom Cookies:\n", "purple");
				print $this->framework->libs['colours']->cstring("\t-----------------------------\n", "white");
				print $this->framework->libs['colours']->cstring(" \tProvide Path for Cookie: ", "blue");
				$handle = fopen("php://stdin","r");
				$this->cookie_support = fgets($handle);				
			} 
			else if(trim($line) == '4'){
				print $this->framework->libs['colours']->cstring(" \tOpenWire SQLi Framework\n", "blue");
				print $this->framework->libs['colours']->cstring(" \tCustom Headers:\n", "purple");
				print $this->framework->libs['colours']->cstring("\t-----------------------------\n", "white");
				print $this->framework->libs['colours']->cstring(" \tEnter Number of Headers to add: ", "blue");
				$handle = fopen("php://stdin","r");
				$total = fgets($handle);
				for ($i = 0; $i < $total; $i++)
				{
					print $this->framework->libs['colours']->cstring(" \tEnter Header Name: ", "blue");
					$header_name = fopen("php://stdin","r");
					$a = fgets($header_name);
					
					print $this->framework->libs['colours']->cstring(" \tEnter Header Value: ", "blue");
					$header_value = fopen("php://stdin","r");
					$b = fgets($header_value);
					
					$this->headers_add[$a] = $b;
				}
					
			} 
			else if(trim($line) == '5'){
				print $this->framework->libs['colours']->cstring(" \tEnter Request Timeout Time: ", "blue");
				$header_name = fopen("php://stdin","r");
				$this->timeout = fgets($header_name);
			}
			else {
				return 0;
			}
		}
	}
	public function custom_sqli_support() {
		print $this->framework->libs['colours']->cstring(" \tOpenWire SQLi Framework\n", "blue");
		print $this->framework->libs['colours']->cstring(" \tSQLi Customizer\n", "purple");
		print $this->framework->libs['colours']->cstring("\t-----------------------------\n", "white");
		print $this->framework->libs['colours']->cstring(" \tCustomize your SQLi (Y/N)? ", "blue");
		$handle = fopen ("php://stdin","r");
		$line = strtoupper(fgets($handle));
		if(trim($line) == 'YES' || trim($line) == 'Y'){
			print $this->framework->libs['colours']->cstring("\n\n \tOpenWire SQLi Framework\n", "blue");
			print $this->framework->libs['colours']->cstring(" \tSelect Customization Option\n", "purple");
			print $this->framework->libs['colours']->cstring("\t-----------------------------\n", "white");
			print $this->framework->libs['colours']->cstring("\t0)", "blue");
			print $this->framework->libs['colours']->cstring(" \t Return to Main Menu\n", "white");
			print $this->framework->libs['colours']->cstring("\t1)", "blue");
			print $this->framework->libs['colours']->cstring(" \t Set Delimiter Value\n", "white");
			print $this->framework->libs['colours']->cstring("\t2)", "blue");
			print $this->framework->libs['colours']->cstring(" \t Setup Query Prefix\n", "white");
			print $this->framework->libs['colours']->cstring("\t3)", "blue");
			print $this->framework->libs['colours']->cstring(" \t Setup Query Suffix\n", "white");
			
			print $this->framework->libs['colours']->cstring(" \tMake a Selection ", "blue");
			$handle = fopen("php://stdin","r");
			$line = strtoupper(fgets($handle));
			if(trim($line) == '0'){
				print $this->framework->libs['colours']->cstring("\tSQL Injection Customization Finished\n", "white");
				print $this->framework->libs['colours']->cstring("\tReturning to the Main Menu....\n\n", "white");
				return 0;
			}
			if(trim($line) == '1'){
				print("Current Delimeter: ");
				print $this->framework->libs['colours']->cstring($this->delim."\n\n\n", "blue");
				
				print $this->framework->libs['colours']->cstring("\n\n \tOpenWire SQLi Framework\n", "blue");
				print $this->framework->libs['colours']->cstring(" \tSelect Delimeter Option\n", "purple");
				print $this->framework->libs['colours']->cstring("\t-----------------------------\n", "white");
			
				print $this->framework->libs['colours']->cstring("\t0)", "blue");
				print $this->framework->libs['colours']->cstring(" \t Return to Main Menu\n", "white");
				print $this->framework->libs['colours']->cstring("\t1)", "blue");
				print $this->framework->libs['colours']->cstring(" \t --\n", "white");
				print $this->framework->libs['colours']->cstring("\t2)", "blue");
				print $this->framework->libs['colours']->cstring(" \t -- -\n", "white");
				print $this->framework->libs['colours']->cstring("\t3)", "blue");
				print $this->framework->libs['colours']->cstring(" \t /*\n", "white");
				print $this->framework->libs['colours']->cstring("\t4)", "blue");
				print $this->framework->libs['colours']->cstring(" \t #\n", "white");
				print $this->framework->libs['colours']->cstring("\t5)", "blue");
				print $this->framework->libs['colours']->cstring(" \t Custom\n", "white");
				
				print $this->framework->libs['colours']->cstring(" \tMake a Selection ", "blue");
				$handle = fopen("php://stdin","r");
				$line = strtoupper(fgets($handle));
				
				if(trim($line) == '0'){
					print $this->framework->libs['colours']->cstring("\n\n \tSQL Injection Customization Finished\n", "white");
					print $this->framework->libs['colours']->cstring("\tReturning to the Main Menu....\n\n", "white");
					return 0;
				}
				if(trim($line) == '1'){
					$this->delim = '--';
					return 0;
				}
				if(trim($line) == '2'){
					$this->delim = '-- -';
					return 0;
				}
				if(trim($line) == '3'){
					$this->delim = '/*';
					return 0;
				}
				if(trim($line) == '4'){
					$this->delim = '#';
					return 0;
				}
				if(trim($line) == '5'){
					print $this->framework->libs['colours']->cstring(" \n\tPlease Enter Custom Delimeter: ", "blue");
					$handle = fopen("php://stdin","r");
					$this->delim = strtoupper(fgets($handle));
					return 0;
				}							
			}
			if(trim($line) == '2'){
				print $this->framework->libs['colours']->cstring("\n\n \tOpenWire SQLi Framework\n", "blue");
				print $this->framework->libs['colours']->cstring(" \tPrefix Statement to place BEFORE the Injection\n", "purple");
				print $this->framework->libs['colours']->cstring("\t---------------------------------------------------\n", "white");
				print $this->framework->libs['colours']->cstring(" \tPlease Enter Custom Prefix: ", "blue");
				$handle = fopen("php://stdin","r");
				$this->prefix = strtoupper(fgets($handle));
				return 0;
			}
			if(trim($line) == '3'){
				print $this->framework->libs['colours']->cstring("\n\n \tOpenWire SQLi Framework\n", "blue");
				print $this->framework->libs['colours']->cstring(" \tPrefix Statement to place AFTER the Injection\n", "purple");
				print $this->framework->libs['colours']->cstring("\t---------------------------------------------------\n", "white");
				print $this->framework->libs['colours']->cstring(" \tPlease Enter Custom Suffix: ", "blue");
				$handle = fopen("php://stdin","r");
				$this->suffix = strtoupper(fgets($handle));
				return 0;
			}
		}				
	}
	public function proxy_support() {
		print $this->framework->libs['colours']->cstring(" \n\n\tOpenWire SQLi Framework\n", "blue");
		print $this->framework->libs['colours']->cstring(" \tProxy Customizer\n", "purple");
		print $this->framework->libs['colours']->cstring("\t-----------------------------\n", "white");
		print $this->framework->libs['colours']->cstring(" \tCustomize your Proxy Settings (Y/N)? ", "blue");
		$handle = fopen ("php://stdin","r");
		$line = strtoupper(fgets($handle));
		
		if(trim($line) == 'YES' || trim($line) == 'Y'){
			print $this->framework->libs['colours']->cstring("\n\n \tOpenWire SQLi Framework\n", "blue");
			print $this->framework->libs['colours']->cstring(" \tPrefix Statement to place AFTER the Injection\n", "purple");
			print $this->framework->libs['colours']->cstring("\t---------------------------------------------------\n", "white");
			print $this->framework->libs['colours']->cstring(" \tEnter Proxy IP: ", "blue");
			$handle = fopen ("php://stdin","r");
			$proxy_ip = strtoupper(fgets($handle));
			
			print $this->framework->libs['colours']->cstring(" \n\tEnter Proxy Port: ", "blue");
			$handle = fopen ("php://stdin","r");
			$proxy_port = strtoupper(fgets($handle));
									
			$this->proxy[$proxy_ip] = $proxy_port;
			
			print $this->framework->libs['colours']->cstring("\n\n \tOpenWire SQLi Framework\n", "blue");
			print $this->framework->libs['colours']->cstring(" \tProxy Customizer\n", "purple");
			print $this->framework->libs['colours']->cstring("\t-----------------------------\n", "white");
			print $this->framework->libs['colours']->cstring(" \tDoes Proxy Require Auth (Y/N)? ", "blue");
			$handle = fopen ("php://stdin","r");
			$line = strtoupper(fgets($handle));
			if(trim($line) == 'YES' || trim($line) == 'Y'){
				$isEnabled = "Enabled";
				print $this->framework->libs['colours']->cstring(" \tUsername: ", "blue");
				$handle = fopen ("php://stdin","r");
				$proxy_user = fgets($handle);
				
				print $this->framework->libs['colours']->cstring("\n \tPassword: ", "blue");
				$handle = fopen ("php://stdin","r");
				$proxy_pass = fgets($handle);
				
				$this->proxy_auth[$proxy_user] = $proxy_pass;
				
				print $this->framework->libs['colours']->cstring(" \n\n\tProxy Setup Complete\n", "blue");
				print $this->framework->libs['colours']->cstring("\t--------------------------------------\n", "white");
				print("\tProxy Auth: ");
				print $this->framework->libs['colours']->cstring($isEnabled."\n", "blue");
				if($isEnabled == 'Enabled') {
					print("\tProxy Username: ");
					print $this->framework->libs['colours']->cstring($proxy_user, "blue");
					print("\tProxy Pass: ");
					print $this->framework->libs['colours']->cstring($proxy_pass, "blue");
				}
				
				print("\n\tProxy IP: ");
				print $this->framework->libs['colours']->cstring($proxy_ip, "blue");
				print("\tProxy Port: ");
				print $this->framework->libs['colours']->cstring($proxy_port, "blue");
				print $this->framework->libs['colours']->cstring("\t--------------------------------------\n\n", "white");
			}				
				
			if(trim($line) == 'NO' || trim($line) == 'N'){
				$isEnabled = "Disabled";
				print $this->framework->libs['colours']->cstring(" \n\n\tProxy Setup Complete\n", "blue");
				print $this->framework->libs['colours']->cstring("\t--------------------------------------\n", "white");
				print("\tProxy Auth: ");
				print $this->framework->libs['colours']->cstring($isEnabled."\n", "blue");
				print("\n\tProxy IP: ");
				print $this->framework->libs['colours']->cstring($proxy_ip, "blue");
				print("\tProxy Port: ");
				print $this->framework->libs['colours']->cstring($proxy_port, "blue");
				print $this->framework->libs['colours']->cstring("\t--------------------------------------\n\n", "white");		
			}
		}			
	} 		
}
?>
