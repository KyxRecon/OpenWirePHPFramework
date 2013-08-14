<?php

namespace Libraries;

use \Framework as Framework;

class text extends Framework
{
	//Declare public variables
	public $formattedString;
	private $specialChars;
 	protected $framework, $name, $description;

	public function __construct($framework) 
	{

		$this->framework = $framework;
        $this->name = 'Text';
        $this->description = 'Library to provide generic text manipulation and encoding functions';
		$this->formattedString = "";//Initialize formatted string container
		$this->specialChars = array(" ", ",", "@", "#", "$", "%", "^", "&", "=","[", "]", "-", "{", "}", "\\", "/", "*", "!", ".", "_", "(", ")", "+", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
	}

	/*
		warpText($string)

		randomly capitalizes strings to attempt WAF evasion
	*/
	public function warpText($string)
	{
		$this->formattedString = "";//empty formatted string container
		$string = str_replace("\n", "", $string);
		while($string[strlen($string)-1] == " ") $string = substr($string, 0, -1);//truncate trailing whitespace to prevent hangs
		while($string[0] == " ") $string = substr($string, 1);//truncate leading whitespace to prevent hangs
		$string = explode(" ", $string);//break into sections for parsing using a single space delimeter

		for($x = 0; $x < count($string); $x++)
		{
			$spc_chr;
			$unique = 0;
			while(!$unique)//check to make sure the word is diverse
			{

				$obfWord = "";//empty current word container
				for($i = 0; $i < strlen($string[$x]); $i++)//Iterate through each section letter by letter
				{
					$spc_chr = 0;
					//Handle special characters
					if(in_array($string[$x][$i], $this->specialChars))
					{
						$obfWord .= $string[$x][$i];
						$spc_chr = 1;
						continue;
					}

					//Alphabetic characters
					$cap = rand(0, 1);//Pseudo-randomly determines whether to capitalize
					if($cap)
						$obfWord .= strtoupper($string[$x][$i]);
					else
						$obfWord .= strtolower($string[$x][$i]);
				}
				//$string = implode($string);
				if(strlen($obfWord) == 1 || ($obfWord != strtolower($string[$x]) && $obfWord != strtoupper($string[$x])) || $spc_chr == 1)//As long as not every letter is caps and not every letter is lower, e.g. diversity, or if the current word is composed of special chars
				{
					$unique = 1;
					$this->formattedString .= $obfWord." ";
				}
			}
		}

		return substr($this->formattedString, 0, -1);
	}

	/*
	strHex($string)
	converts $string to its hex value
	*/

	public function strHexStr($string)
	{
    	$this->formattedString = "0x";
    	for ($i=0; $i < strlen($string); $i++)
    	   	$this->formattedString .= dechex(ord($string[$i]));
    	
    	return $this->formattedString;
	}

	/*
	strHex($string)
	converts $string to its hex value
	*/

	public function strHex($string)
	{
		$this->formattedString = "";
    	
    	for ($i=0; $i < strlen($string); $i++)
    	   	$this->formattedString .= "\x".dechex(ord($string[$i]));
    	
    	return $this->formattedString;
	}

	/*
	hexStr($string)
	converts the hex $string to its decimal equivalent, converts to char, and appends to a string.
	*/
	public function hexStr($string)
	{
    	$this->formattedString = "";

    	for ($i=0; $i < strlen($string)-1; $i+=2)
    	   	$this->formattedString .= chr(hexdec(substr($string, $i, 2)));
    	
    	return $this->formattedString;
	}

	/*
	strOct($string)
	converts $string to its oct value
	*/
	public function strOct($string)
	{
		$this->formattedString = "";

		for($i = 0; $i < strlen($string); $i++)
		{
			$chr = decoct(ord($string[$i]));
			$chr = "\o".$chr;
			$this->formattedString .= $chr;
		}
		
		return $this->formattedString;
	}

	/*
	octStr($string)
	converts the oct $string to its decimal equivalent, converts to char, and appends to a string.
	*/
	public function octStr($string)
	{
		$this->formattedString = "";
		$string_data = explode("\o", $string);
		foreach($string_data as $string)
				$this->formattedString .= chr(octdec($string));
	
		return $this->formattedString;
	}

	public function sqlSpace($string)
	{
		$this->formattedString = "";

		$this->formattedString = str_replace(" ", "/**/", str_replace("+", "/**/", $string));

		return $this->formattedString;
	}

	public function strB64($string)
	{
		$this->formattedString = "";
		$this->formattedString = base64_encode($string);

		return $this->formattedString;
	}

	public function b64Str($string)
	{
		$this->formattedString = "";
		$this->formattedString = base64_decode($string);

		return $this->formattedString;
	}

	public function rot13($string)
	{
		return str_rot13($string);
	}

	//mnemonic aliases for ROT13
	public function strRot13($string)
	{
		return $this->rot13($string);	
	}
	public function rot13Str($string)
	{
		return $this->rot13($string);
	}
}
