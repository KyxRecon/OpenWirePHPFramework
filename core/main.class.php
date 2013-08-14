<?php
 
 
namespace Core;
use \Framework as Framework;


class main extends Framework {
     
      protected $framework, $name, $description;

      public function __construct($framework)
      {
	      $this->framework = $framework;
            $this->name = "main";
            $this->description = "Main framework functions";
      }


      public function outputHeader()
      {
            $this->framework->clearScreen();
            echo "\n";
            echo $this->framework->libs['colours']->cstring("                    ########                  #\n", "white");
            echo $this->framework->libs['colours']->cstring("                #################            #\n", "white");
            echo $this->framework->libs['colours']->cstring("             ######################         #\n", "white");
            echo $this->framework->libs['colours']->cstring("            #########################      #\n", "white");
            echo $this->framework->libs['colours']->cstring("          ############################\n", "white");
            echo $this->framework->libs['colours']->cstring("         ##############################\n", "white");
            echo $this->framework->libs['colours']->cstring("         ###############################\n", "white");
            echo $this->framework->libs['colours']->cstring("        ###############################\n", "white");
            echo $this->framework->libs['colours']->cstring("        ##############################\n", "white");
            echo $this->framework->libs['colours']->cstring("                        #    ########   #\n", "white");
            echo $this->framework->libs['colours']->cstring("           ##        ###", "blue");
            echo $this->framework->libs['colours']->cstring("        ####   ##\n", "white");
            echo $this->framework->libs['colours']->cstring("                                ###   ###\n", "white");
            echo $this->framework->libs['colours']->cstring("                              ####   ###\n", "white");
            echo $this->framework->libs['colours']->cstring("         ####          ##########   ####\n", "white");
            echo $this->framework->libs['colours']->cstring("         #######################   ####\n", "white");
            echo $this->framework->libs['colours']->cstring("           ####################   ####\n", "white");
            echo $this->framework->libs['colours']->cstring("            ##################  ####\n", "white");
            echo $this->framework->libs['colours']->cstring("              ############      ##\n", "white");
            echo $this->framework->libs['colours']->cstring("                 ########        ###\n", "white");
            echo $this->framework->libs['colours']->cstring("                #########        #####\n", "white");
            echo $this->framework->libs['colours']->cstring("              ############      ######\n", "white");
            echo $this->framework->libs['colours']->cstring("             ########      #########\n", "white");
            echo $this->framework->libs['colours']->cstring("               #####       ########\n", "white");
            echo $this->framework->libs['colours']->cstring("                 ###       #########\n", "white");
            echo $this->framework->libs['colours']->cstring("                ######    ############\n", "white");
            echo $this->framework->libs['colours']->cstring("               #######################\n", "white");
            echo $this->framework->libs['colours']->cstring("               #   #   ###  #   #   ##\n", "white");
            echo $this->framework->libs['colours']->cstring("               ########################\n", "white");
            echo $this->framework->libs['colours']->cstring("                ##     ##   ##     ##\n\n\n", "white");


            echo $this->framework->libs['colours']->cstring("\t\t[Open", "white");
            echo $this->framework->libs['colours']->cstring("Wire", "blue");
            echo $this->framework->libs['colours']->cstring(" Framework]\n\n\n", "white");
            echo $this->framework->libs['colours']->cstring("Codename  [", "white");
            echo $this->framework->libs['colours']->cstring("Osiris", "blue");
            echo $this->framework->libs['colours']->cstring("]\n", "white");
            echo $this->framework->libs['colours']->cstring("Developer [", "white");
            echo $this->framework->libs['colours']->cstring("OpenWire Security", "blue");
            echo $this->framework->libs['colours']->cstring("]\n", "white");
            echo $this->framework->libs['colours']->cstring("Concept   [", "white");
            echo $this->framework->libs['colours']->cstring("Antipastes 0x0F Framework", "blue");
            echo $this->framework->libs['colours']->cstring("]\n", "white");
            echo $this->framework->libs['colours']->cstring("Version   [", "white");
            echo $this->framework->libs['colours']->cstring("1.1.2", "blue");
            echo $this->framework->libs['colours']->cstring("]", "white");
            echo $this->framework->libs['colours']->cstring(" PHP\n", "red");
            echo $this->framework->libs['colours']->cstring("Twitter   [", "white");
            echo $this->framework->libs['colours']->cstring("@openwiresec", "blue");
            echo $this->framework->libs['colours']->cstring("]\n", "white");
            echo $this->framework->libs['colours']->cstring("Website   [", "white");
            echo $this->framework->libs['colours']->cstring("http://www.openwiresec.com", "blue");
            echo $this->framework->libs['colours']->cstring("]\n\n\n", "white");
            echo $this->framework->libs['colours']->cstring("\t[Type ", "white");
            echo $this->framework->libs['colours']->cstring("help", "blue");
            echo $this->framework->libs['colours']->cstring(" for a list of commands]\n\n", "white");

            return true;
      }

      public function showUsage()
      {
            echo "\n\n";
            echo $this->framework->libs['colours']->cstring(" \tOpenWire Framework\n", "blue");
            echo $this->framework->libs['colours']->cstring(" \tList of commands and description of usage\n", "purple");
            echo $this->framework->libs['colours']->cstring("\t--------------------------------------------------------------------\n", "white");


            echo $this->framework->libs['colours']->cstring(" \thelp", "blue");
            echo $this->framework->libs['colours']->cstring("                        - Display this list\n", "white");
            echo $this->framework->libs['colours']->cstring(" \tclear/cls", "blue");
            echo $this->framework->libs['colours']->cstring("                   - Clears the Screen\n", "white");
            echo $this->framework->libs['colours']->cstring(" \tlibs", "blue");
            echo $this->framework->libs['colours']->cstring("                        - List current libraries\n", "white");
            echo $this->framework->libs['colours']->cstring(" \tbanner", "blue");
            echo $this->framework->libs['colours']->cstring("                      - Displays the Banner\n", "white");
            echo $this->framework->libs['colours']->cstring("\t--------------------------------------------------------------------\n", "white");


            echo $this->framework->libs['colours']->cstring(" \tlist exploit", "blue");
            echo $this->framework->libs['colours']->cstring("                - List current exploit modules\n", "white");
            echo $this->framework->libs['colours']->cstring(" \tlist payload", "blue");
            echo $this->framework->libs['colours']->cstring("                - List current payload modules\n", "white");
            echo $this->framework->libs['colours']->cstring(" \tlist aux", "blue");
            echo $this->framework->libs['colours']->cstring("                    - List current auxiliary modules\n", "white");
            echo $this->framework->libs['colours']->cstring("\t--------------------------------------------------------------------\n", "white");


            echo $this->framework->libs['colours']->cstring(" \tload exploit <exploit>", "blue");
            echo $this->framework->libs['colours']->cstring("      - Load an exploit module\n", "white");
            echo $this->framework->libs['colours']->cstring(" \tload payload <payload>", "blue");
            echo $this->framework->libs['colours']->cstring("      - Load a payload module\n", "white");
            echo $this->framework->libs['colours']->cstring(" \tload aux <aux>", "blue");
            echo $this->framework->libs['colours']->cstring("              - Load an auxiliary module\n", "white");
            echo $this->framework->libs['colours']->cstring("\t--------------------------------------------------------------------\n", "white");


            echo $this->framework->libs['colours']->cstring(" \tset <variable> <value>", "blue");
            echo $this->framework->libs['colours']->cstring("      - Set a variable to value (ex. target host)\n", "white");
            echo $this->framework->libs['colours']->cstring(" \toptions", "blue");
            echo $this->framework->libs['colours']->cstring("                     - Show the global and exploit specific options\n", "white");
            echo $this->framework->libs['colours']->cstring(" \tcheck", "blue");
            echo $this->framework->libs['colours']->cstring("                       - Check if the target is vulnerable to currently loaded exploit\n", "white");
            echo $this->framework->libs['colours']->cstring(" \tlocal", "blue");
            echo $this->framework->libs['colours']->cstring("                       - Drop into a local OS shell\n", "white");
            echo $this->framework->libs['colours']->cstring(" \tsqli", "blue");
            echo $this->framework->libs['colours']->cstring("                        - Drop into the SQL Injection Framework\n", "white");
            echo $this->framework->libs['colours']->cstring(" \texploit", "blue");
            echo $this->framework->libs['colours']->cstring("                     - Run the currently loaded exploit module\n", "white");
            echo $this->framework->libs['colours']->cstring("\t--------------------------------------------------------------------\n", "white");

            return true;
      }
}
?>
