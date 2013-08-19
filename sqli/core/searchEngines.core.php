<?php
	 	 
namespace sqlCore;
use \Framework as Framework;

	
class searchEngines extends Framework {
	
		 
	protected $framework, $name, $description, $sqli;
	
  	public function __construct($framework)
	{
		$this->framework = $framework;
		$this->name = "Bing! Search Function";
		$this->description = "Provide search query and we fetch link results";
		$this->base_path = $this->framework->base;
		$this->defaultVariables = array(
		'url' => array('required' => false, 'description' => ' ', 'match' => self::regexURL)
		);
		
	}
	public function bingSearch() {
		echo $this->framework->libs['colours']->cstring("\n\n\tOpenWire Framework\n", "blue");
        echo $this->framework->libs['colours']->cstring("\tSearch Engine: Bing!\n", "purple");
        echo $this->framework->libs['colours']->cstring("\t--------------------------------------------------------------------\n", "white");
        
        print $this->framework->libs['colours']->cstring(" \tSearch Query: ", "blue");
		$handle = fopen ("php://stdin","r");
		$squery = strtoupper(fgets($handle));
		
		print $this->framework->libs['colours']->cstring(" \tNumber of Results: ", "blue");
		$handle = fopen ("php://stdin","r");
		$count = strtoupper(fgets($handle));
		
		$secondcound = 1;
		$goodlinks = array('');
		$usablelinks = array('');
		$arrayoflinks = array('');
		$bing = 'http://www.bing.com/search?q='.$squery.'&go=&qs=n&sk=&sc=8-13&first='.$count;		
		
		$page = $this->framework->libs['webot']->curl_get_contents($bing);
		$links = $this->framework->libs['webot']->parse_array($page, '<h3>', '</h3>');
		

		
		print $this->framework->libs['colours']->cstring(" \n\n\tBing! Search Complete\n", "blue");
        print $this->framework->libs['colours']->cstring("\t--------------------------\n", "white");
		print("\tSearch Query: ");
		print $this->framework->libs['colours']->cstring($squery."\n", "blue");
		print("\tUsable Links: ");
		print $this->framework->libs['colours']->cstring($count."\n", "blue");
		
		foreach ($links as $link) {
				$clean_links = $this->framework->libs['webot']->return_between($link, '<a href="', '" h=', 1);
				print("\tLink: ");
				print $this->framework->libs['colours']->cstring($clean_links."\n", "blue");				
		}
		print $this->framework->libs['colours']->cstring("\t--------------------------------------\n\n", "white");
		


		
		

		
		
		
	}
	public function googleSearch() {
		
		
	}
}	
?>
