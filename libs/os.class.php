<?php
/*===========================================================================================
#                                                                                           #
#  class os                                                                                 #
#                                                                                           #
#  methods:                                                                                 #
#                                                                                           #
#    ls($switches, $dir) - Returns the directory contents in an array                       #
#    pwd() - Returns the Present Working Directory                                          # 
#    hostname() - Returns the hostname of the host system                                   #
#    kernel() - Returns the kernel of the host system                                       #
#    proc() - Returns the processor architecture of the host system                         #
#    cd($dir) - Changes the current directory used by the script                            #
#    custom($command) - Executes a custom command and Returns true or false depending on    #
#        if the execution was successful                                                    #
#    username() - Returns the username of the user controlling the php process              #
#    ls_detailed() - Returns an array of values pertaining to the pwd's contents            #
#                                                                                           #
#  The purpose of this class is to simplify use of basic command line operations in php     #
#  it should aid in performing any tasks through the command line in your php script.       #
#                                                                                           #
#  By: Phaedrus                                                                             #
#  Date: December 13, 2012                                                                  #
#                                                                                           #
#                                                                                           #
===========================================================================================*/

namespace Libraries;

use \Framework as Framework;

class os extends Framework
{
	
	public $cust_command;
	public $dir_contents;
	public $userlist;
	public $username;
	public $hostname;
	public $rootdir;
	public $users;
	public $pwd;
	public $os;

	protected $framework, $name, $description;

	/*
		 Constructor Method
		 
		 Determines if the Host OS is Unix based or Windows.  Once the OS is determined
		 it then sets some basic properties such as the hostname, username, present working directory,
		 root directory and a list of system users.
	*/
	public function	__construct($framework)
	{
		$this->framework = $framework;
        $this->name = 'OS';
        $this->description = 'Library to provide interaction with OS functionality';
		$this->os = php_uname('s');
		//Initialize Basic properties for Linux Systems
		if(strstr($this->os, 'Linux'))
		{
			$this->pwd = $this->pwd();
			$this->rootdir = '/';
			$this->hostname = $this->hostname();
			$this->username = $this->username();
			$this->users = $this->get_users();
		}
		//Initialize Basic properties for Windows Systems
		else if(strstr($this->os, 'Win'))
		{
			$this->pwd = $this->pwd();
			$this->rootdir = "C:\\";
			$this->hostname = $this->hostname();
			$this->username = $this->username();
			$this->users = $this->get_users();
		}
	}
	
	/* 
	     Function: ls($switches)

	     Runs the ls command on UNIX Operating Systems.
	     optional parameter $switches to send any formatting switches to the command e.x. -alF
	     it returns the list of contents in a directory in an array. If you wish to send a directory
		 without switches then enter '' as the first value for $switches.
	*/
	
	public function ls($switches="", $dir="")
	{
		if($this->os == "Linux")
		{
			$this->dir_contents = shell_exec("ls ".$dir." ".$switches);
			$this->dir_contents = explode("\n", $this->dir_contents);
			$this->dir_contents = array_slice($this->dir_contents, 3);//Uses offset of 3 to exclude 'total', '.', and '..' items from results
			return $this->dir_contents;
		}
		else
		{
			$this->dir_contents = shell_exec("dir ".$dir." ".$switches);
			$this->dir_contents = explode("\n", $this->dir_contents);
			$this->dir_contents = array_slice($this->dir_contents, 5, count($this->dir_contents)-5-3);//Uses offset 5 and length 3 to exclude irrelevant data from values
			return $this->dir_contents;
		}
	}
	
	/*
		 Function ls_detailed()
		 
		 Runs ls() with no parameters to set a clean dir_contents property, then depending on the Host OS Parses the values
		 into a multidimensional array with indice 0 representing the file in the sequence they were output, and indice 2 is 
		 an associative value representing what value from that file is being displayed. Options: name, date, type(file or directory),
		 size
	
	*/
	public function ls_detailed()
	{
		$this->ls();
		$file_info = array();
		
		if(strstr($this->os, 'Win'))
		{
			for($i = 5; $i < count($files)-3; $i++)
			{
				$file_info[$i]['name'] = substr($this->dir_contents[$i], 39);			
				$file_info[$i]['date'] = substr($files[$i], 0, 20);
				$file_info[$i]['type'] = (substr($files[$i], 24, 5) == "<DIR>") ? "Directory" : "File";
				$file_info[$i]['size'] = intval(str_replace(",", "", substr($files[$i], 29, 9)));
			}
			
			return $file_info;
		}
		else if($this->os == "Linux")
		{
			return 1;
		}
	}
	/*
		 Function: pwd()

		 Returns the Present Working Directory

		 Systems: Windows, Linux
	*/

	public function pwd()
	{
		if($this->os == "Linux")
			return shell_exec("pwd");
		else if(strstr($this->os, 'Win'))
			return shell_exec("echo %cd%");
		else
			return 1;
	}

	/*
		 Function hostname()

		 Returns the hostname of the Host system

		 Systems: Windows, Linux
	*/
	public function hostname()
	{
		return php_uname('n');
	}
	
	/*
		 Function kernel()

		 Returns the kernel of the Host machine
		 
		 Systems: Windows, Linux

	*/
	public function kernel()
	{
		return php_uname('s');
	}

	/*
		 Function proc()
		 
		 Returns the processor architecture of the Host machine
		 
		 Systems: Windows, Linux
	*/
	public function proc()
	{
		/*if($this->os == "Linux")
			return php_uname('p');
		else
		{*/
			$proc = explode(" ", php_uname('p'));
			return $proc[count($proc)-1];//Splits the output into an array using a single space ' ' as a delimeter, then returns the last value(CPU Architecture)
		//}
	}

	/*
		 Function: cd($dir)

		 Changes to the specified directory, if no directory is specified
		 it returns true, otherwise if the change is successful it returns
		 true and updates $this->pwd to reflect the change.
		 
		 Systems: Windows, Linux

	*/
	public function cd($dir=null)
	{
		if($dir == null)
			return false;

		//Attempt to change the directory, if successful update pwd otherwise return false
		if(chdir($dir))
		{
			if($this->os == "Linux")
				$this->pwd = shell_exec("pwd");
			else if(strstr($this->os, "Win"))
				$this->pwd = shell_exec("echo %cd%");
			return true;
		}
		else
			return false;
		
	}

	/*
		 Function custom($command)

		 Executes a custom command specified by the programmer. Returns true if successful
		 and false otherwise.
		 
		 Systems: Windows, Linux
	*/
	public function custom($command)
	{
		$this->cust_command = $command;
		if(shell_exec($this->cust_command))
			return true;
		else
			return false;
	}

	/*
		 Function username()

		 Returns the username of the user controlling the php process
		 
		 Systems: Windows, Linux
	*/
	public function username()
	{
		if($this->os == "Linux")
			return shell_exec('whoami');
		else if(strstr($this->os, "Win"))
		{
			$data = shell_exec("whoami");
			$data = explode("\\", $data);
			return $data[1];
		}
		else
			return 1;
	}

	/*
		 Function get_users()

		 Returns an array with each item containing a username from either /etc/passwd or the net user command
		 
		 Systems: Windows, Linux
	*/
	public function get_users()
	{
		if($this->os == "Linux")
		{
			$this->userlist = explode("\n", shell_exec("cat /etc/passwd"));
			for($i = 0; $i < count($this->userlist); $i++)
			{
				$tmp = explode(":", $this->userlist[$i]);
				$this->users[$i] = $tmp[0];
			}
			return $this->users;
		}
		else if(strstr($this->os, 'Win'))
		{
			//Get List of Users:
			$this->userlist = shell_exec("net user");//Run net user command
			$this->userlist = explode("\n", $this->userlist);//Create an array with each element representing one line of output
			$this->userlist = array_slice($this->userlist, 4, count($this->userlist)-3);//Exclude lines that don't include user names
			$this->users = array();//create an array to write each user into
			$count = 0;
			for($i = 0; $i < count($this->userlist)-1; $i++)//Count controlled loop to go through each line and extract users from it(each line may hold more than one user)
			{
				$ul = explode(" ", $this->userlist[$i]);//Break up each line into an array based on a single space " "
				foreach($ul as $user)
				{
					print $count."\n";
					if($user == "") continue;//Many lines include inconsistent numbers of spaces between users, if it is empty space we ignore it and move to the next item
					$this->users[$count] = $user;//If the script has made it this far in execution then we have a username, add it to $users
					$count++;//Increase the count of users in the array
					print $count."\n";
				}
			}
			$this->users = array_slice($this->users, 0, $count-8);//Remove Irrelevant data from final user list
			return $this->users;
		}
	}

	/*
		 Function formatted_users()

		 Returns a formatted list of users and labels the information for each user
		 
		 Systems: Linux
	*/
	public function formatted_users()
	{
		if($this->os == "Linux")
		{
			foreach($this->users as $user)
			{
				if($user == "") continue;
				$user_data = explode(":", $user);
				$cols = array("Username", "Password", "User ID", "Group ID", "User ID Info", "Home Directory", "Shell");
				print $cols[0].": ".$user_data[0]."\n";
				for($i = 1; $i < count($user_data); $i++)
					print "\t".$cols[$i].": ".$user_data[$i]."\n";
			}
		}
	}

}

?>

