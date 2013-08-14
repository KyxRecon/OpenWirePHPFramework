<?php
/*
Admin Finder
Version: 1.0 
Author: Logic
Date: May 12, 2013
*/
namespace aux;
use \Framework as Framework;
 
class adminfinder extends Framework {
 
	protected $framework, $name, $description, $variables;
	public $type, $ext;

	public function __construct($framework) 
	{
	   
		$this->framework = $framework;
		$this->name = 'Admin Finder';
		$this->description = 'Scapes webpages looking for admin logins';
		$this->modName = 'adminfinder';
	    $this->variables = array(
	        'searchtype' => array('required' => false, 'description' => 'Set the search type (robots, phpinfo, pma)', 'default' => 'robots'),
	        'language' => array('required' => false, 'description' => 'Set the lang to search for (php, asp, cfm, aspx, jsp, htm, html, shtml, cgi, js', 'default' => 'php'),
	        'check' => array('required' => false, 'description' => ' ', 'default' => ' '),
	        'finder' => array('required' => false, 'description' => ' ', 'default' => ' '),

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
		$this->ext();		
		$this->type();
		$this->run();
			
		return 1;
	}

	public function post()
	{
		print "This module does not support post Exploit\n";
		return 0;
	}

	public function ext()
	{
		print "\n\n\t[*] Detecting LANG Type";
		if ($this->language == 'shtml') {
			print "\n\t[*] LANG Type Detected as SHTML\n";
		}
		else if ($this->language == 'asp') {
			print "\n\t[*] LANG Type Detected as ASP\n";
		}
		else if ($this->language == 'aspx') {
			print "\n\t[*] LANG Type Detected as ASPX\n";
		}
		else if ($this->language == 'cfm') {
			print "\n\t[*] LANG Type Detected as CFM\n";
		}
		else if ($this->language == 'cgi') {
			print "\n\t[*] LANG Type Detected as CGI\n";
		}
		else if ($this->language == 'js') {
			print "\n\t[*] LANG Type Detected as JS\n";
		}
		else if ($this->language == 'jsp') {
			print "\n\t[*] LANG Type Detected as JSP\n";
		}
		else if ($this->language == 'htm') {
			print "\n\t[*] LANG Type Detected as HTM\n";
		}
		else if ($this->language == 'html') {
			print "\n\t[*] LANG Type Detected as HTML\n";
		}
		else {
			print "\n\t[*] LANG Type Detected as PHP\n";
		}


	}

	public function type()
	{
		print "\n\n\t[*] Detecting Search Type";
		if ($this->searchtype == 'robots') {
			print "\n\t[*] Search Type Detected as Robots.txt\n\n";
			$this->robots();
		}
		else if ($this->searchtype == 'phpinfo') {
			print "\n\t[*] Search Type Detected as PHP Info\n\n";
			$this->phpinfo();
		}
		else if ($this->searchtype == 'pma') {
			print "\n\t[*] Search Type Detected as PHPMYADMIN\n\n";
			$this->pma();
		}
	}

	public function run()
	{
		echo "\n\t[*] Commencing Search\n";
		$marker = ".".$this->language;
		$array_output = str_replace(".XXXX", $marker, $this->check);
		foreach ($array_output as $output) {
			$input = $this->target."/".$output;
			$page = $this->framework->libs['webot']->curl_get_contents($input);
			$decode = html_entity_decode($page);
			if (strpos($decode, $this->finder)){
				echo $this->framework->libs['colours']->cstring("\n\tPage Found: ", "green");
				echo $input;
			}
			else {
				echo "";			
			}

		}


	}
	public function robots() {

		$header = $this->target."/robots.txt";
		$getHeader = $this->framework->libs['webot']->get_headers($header);
		if ($getHeader[1] == "200") {
			
		}

	}
	public function pma() {
		$pma = array("phpMyAdmin/", "phpmyadmin/", "PMA/", "admin/", "dbadmin/", "mysql/", "myadmin/", "phpmyadmin2/", "phpMyAdmin2/", "phpMyAdmin-2/", "php-my-admin/", "phpMyAdmin-2.2.3/", "phpMyAdmin-2.2.6/", "phpMyAdmin-2.5.1/", "phpMyAdmin-2.5.4/", "phpMyAdmin-2.5.5-rc1/", "phpMyAdmin-2.5.5-rc2/", "phpMyAdmin-2.5.5/", "phpMyAdmin-2.5.5-pl1/", "phpMyAdmin-2.5.6-rc1/", "phpMyAdmin-2.5.6-rc2/", "phpMyAdmin-2.5.6/", "phpMyAdmin-2.5.7/", "phpMyAdmin-2.5.7-pl1/", "phpMyAdmin-2.6.0-alpha/", "phpMyAdmin-2.6.0-alpha2/", "phpMyAdmin-2.6.0-beta1/", "phpMyAdmin-2.6.0-beta2/", "phpMyAdmin-2.6.0-rc1/", "phpMyAdmin-2.6.0-rc2/", "phpMyAdmin-2.6.0-rc3/", "phpMyAdmin-2.6.0/", "phpMyAdmin-2.6.0-pl1/", "phpMyAdmin-2.6.0-pl2/", "phpMyAdmin-2.6.0-pl3/", "phpMyAdmin-2.6.1-rc1/", "phpMyAdmin-2.6.1-rc2/", "phpMyAdmin-2.6.1/", "phpMyAdmin-2.6.1-pl1/", "phpMyAdmin-2.6.1-pl2/", "phpMyAdmin-2.6.1-pl3/", "phpMyAdmin-2.6.2-rc1/", "phpMyAdmin-2.6.2-beta1/", "phpMyAdmin-2.6.2-rc1/", "phpMyAdmin-2.6.2/", "phpMyAdmin-2.6.2-pl1/", "phpMyAdmin-2.6.3/", "phpMyAdmin-2.6.3-rc1/", "phpMyAdmin-2.6.3/", "phpMyAdmin-2.6.3-pl1/", "phpMyAdmin-2.6.4-rc1/", "phpMyAdmin-2.6.4-pl1/", "phpMyAdmin-2.6.4-pl2/", "phpMyAdmin-2.6.4-pl3/", "phpMyAdmin-2.6.4-pl4/", "phpMyAdmin-2.6.4/", "phpMyAdmin-2.7.0-beta1/", "phpMyAdmin-2.7.0-rc1/", "phpMyAdmin-2.7.0-pl1/", "phpMyAdmin-2.7.0-pl2/", "phpMyAdmin-2.7.0/", "phpMyAdmin-2.8.0-beta1/", "phpMyAdmin-2.8.0-rc1/", "phpMyAdmin-2.8.0-rc2/", "phpMyAdmin-2.8.0/", "phpMyAdmin-2.8.0.1/", "phpMyAdmin-2.8.0.2/", "phpMyAdmin-2.8.0.3/", "phpMyAdmin-2.8.0.4/", "phpMyAdmin-2.8.1-rc1/", "phpMyAdmin-2.8.1/", "phpMyAdmin-2.8.2/", "sqlmanager/", "mysqlmanager/", "p/m/a/", "PMA2005/", "pma2005/", "phpmanager/", "php-myadmin/", "phpmy-admin/", "webadmin/", "sqlweb/", "websql/", "webdb/", "mysqladmin/", "mysql-admin/");
		$this->check = $pma;
	}
	public function phpinfo() {
		$pinfo = array("phpinfo/", "php-info/", "phpdetails/", "php_details/", "information/", "phpinformation/", "php-information/", "phpinfo.php", "php-info.php", "php_info.php", "pinfo.php", "p-info.php", "p_info.php", "info.php", "test.php", "infophp.php", "info_php.php", "info-php.php", "php.php", "p.php", "pop.php", "peep.php", "pip.php", "i.php", "z.php", "help.php", "information.php", "phpinformation.php", "PhPinfo.php", "something.php", "/misc/info.php", "/misc/phpinfo.php", "phpinfo/phpinfo.php", "phpinfo/info.php", "phpinfo/pinfo.php", "phpinfo/php-info.php", "phpinfo/php_info.php", "phpinfo/php.php", "phpinfo/phpdetails.php", "phpinfo/php-details.php", "phpinfo/php_details.php", "php-info/phpinfo.php", "php-info/info.php", "php-info/pinfo.php", "php-info/php-info.php", "php-info/php_info.php", "php-info/php.php", "php-info/phpdetails.php", "php-info/php-details.php", "php-info/php_details.php", "php_info/phpinfo.php", "php_info/info.php", "php_info/pinfo.php", "php_info/php-info.php", "php_info/php_info.php", "php_info/php.php", "php_info/phpdetails.php", "php_info/php-details.php", "php_info/php_details.php", "xampp/phpinfo.php", "xampp/php-info.php", "xampp/php_info.php", "xampp/pinfo.php", "xampp/p-info.php", "xampp/p_info.php", "xampp/info.php", "xampp/test.php", "xampp/infophp.php", "xampp/info_php.php", "xampp/test/php/phpinfo.php", "xampp/phpinfomation.php", "xampp/php.php");
		$this->check = $pinfo;
	}
	public function common() {
		$common = array("@dmin/", "_admin/", "_adm/", "admin/", "adm/", "admincp/", "admcp/", "cp/", "modcp/", "moderatorcp/", "adminare/", "admins/", "cpanel/", "controlpanel/", "0admin/", "0manager/", "admin1/", "admin2/", "ADMIN/", "administrator/", "ADMON/", "AdminTools/", "administrador/", "administracao/", "painel/", "administracao.XXXX", "administrateur/", "administrateur.XXXX", "beheerder/", "administracion/", "administracion.XXXX", "beheerder.XXXX", "amministratore/", "amministratore.XXXX", "v2/painel/", "db/", "dba/", "dbadmin/", "Database_Administration/", "ADMIN/login.XXXX", "ADMIN/login.XXXX", "Indy_admin/", "LiveUser_Admin/", "Lotus_Domino_Admin/", "PSUser/", "Server.XXXX", "Server/", "ServerAdministrator/", "Super-Admin/", "SysAdmin/", "SysAdmin2/", "UserLogin/", "WebAdmin/", "aadmin/", "acceso.XXXX", "acceso.XXXX", "access.XXXX", "access/", "account.XXXX", "accounts.XXXX", "accounts/", "acct_login/", "adm.XXXX", "adm/admloginuser.XXXX", "adm/index.XXXX", "adm_auth.XXXX", "admin-login.XXXX", "admin.XXXX", "admin/account.XXXX", "admin/admin-login.XXXX", "admin/admin.XXXX", "admin/adminLogin.XXXX", "admin/admin_login.XXXX", "admin/controlpanel.XXXX", "admin/cp.XXXX", "admin/home.XXXX", "admin/index.XXXX", "admin/Login.XXXX", "admin/login.XXXX", "admin1.XXXX", "admin1/", "admin2.XXXX", "admin2/index.XXXX", "admin2/login.XXXX", "admin4_account/", "admin4_colon/", "adminLogin.XXXX", "adminLogin/", "admin_area.XXXX", "admin_area/", "admin_area/admin.XXXX", "admin_area/index.XXXX", "admin_area/login.XXXX", "admin_login.XXXX", "adminarea/", "adminarea/admin.XXXX", "adminarea/index.XXXX", "adminarea/login.XXXX", "admincontrol.XXXX", "admincontrol/", "admincontrol/login.XXXX", "admincp/", "admincp/index.XXXX", "administer/", "administr8.XXXX", "administr8/", "administrador/", "administratie/", "administration.XXXX", "administration/", "administrator.XXXX", "administrator/", "administrator/account.XXXX", "administrator/index.XXXX", "administratoraccounts/", "administratorlogin.XXXX", "administratorlogin/", "administrators.XXXX", "administrators/", "administrivia/", "adminitem.XXXX", "adminitem/", "adminitems.XXXX", "adminitems/", "adminpanel.XXXX", "adminpanel/", "adminpro/", "admins.XXXX", "admins/", "adminsite/", "admloginuser.XXXX", "admon/", "affiliate.XXXX", "auth.XXXX", "authadmin.XXXX", "authenticate.XXXX", "authentication.XXXX", "authuser.XXXX", "autologin.XXXX", "autologin/", "backoffice/admin.XXXX", "banneradmin/", "bb-admin/", "bb-admin/admin.XXXX", "bb-admin/index.XXXX", "bb-admin/login.XXXX", "bbadmin/", "bigadmin/", "blogindex/", "cPanel/", "cadmins/", "ccms/", "ccms/index.XXXX", "cms/", "cms/admin.XXXX", "cms/index.XXXX", "ccp14admin/", "cgi-bin/login.XXXX", "cgi-bin/admin.XXXX", "cgi-bin/admin/index.XXXX", "cgi-bin/admin/admin.XXXX", "cgi-bin/admin/login.XXXX", "cgi/index.XXXX", "cgi/admin.XXXX", "cgi/login.XXXX", "cgi/admin/index.XXXX", "cgi/admin/admin.XXXX", "cgi/admin/login.XXXX", "check.XXXX", "checkadmin.XXXX", "CFIDE/administrator/", "CFIDE/admin/", "CFIDE/", "checklogin.XXXX", "checkuser.XXXX", "cmsadmin.XXXX", "cmsadmin/", "configuration/", "configure/", "control.XXXX", "control/", "controlpanel.XXXX", "controlpanel/", "cp.XXXX", "cp/", "cpanel/", "cpanel_file/", "customer_login/", "cvsadmin/", "database_administration/", "dir-login/", "directadmin/", "ezsqliteadmin/", "fileadmin.XXXX", "fileadmin/", "formslogin/", "globes_admin/", "gallery/login.XXXX", "gallery/admin/", "gallery/admin.XXXX", "gallery/users.XXXX",  "gallery_admin/", "home.XXXX", "hpwebjetadmin/", "instadmin/", "irc-macadmin/", "isadmin.XXXX", "kpanel/", "letmein.XXXX", "letmein/", "log-in.XXXX", "log-in/", "log_in.XXXX", "log_in/", "login-redirect/", "login-us/", "login.XXXX", "login/", "login1.XXXX", "login1/", "login_admin.XXXX", "login_admin/", "login_db/", "login_out.XXXX", "login_out/", "login_user.XXXX", "loginerror/", "loginflat/", "loginok/", "loginsave/", "loginsuper.XXXX", "loginsuper/", "logo_sysadmin/", "logout.XXXX", "logout/", "macadmin/", "maintenance/", "manage.XXXX", "manage/", "management.XXXX", "management/", "manager.XXXX", "manager/", "manuallogin/", "member.XXXX", "member/", "memberadmin.XXXX", "memberadmin/", "members.XXXX", "members/", "member/login.XXXX", "members/login.XXXX", "memlogin/", "meta_login/", "modelsearch/admin.XXXX", "modelsearch/index.XXXX", "modelsearch/login.XXXX", "moderator.XXXX", "moderator/", "moderator/admin.XXXX", "moderator/login.XXXX", "modules/admin/", "myadmin/", "navSiteAdmin/", "newsadmin/", "nsw/admin/login.XXXX", "openvpnadmin/", "pages/admin/", "pages/admin/admin-login.XXXX", "panel-administracion/", "panel-administracion/admin.XXXX", "panel-administracion/index.XXXX", "panel-administracion/login.XXXX", "panel.XXXX", "panel/", "panelc/", "paneldecontrol/", "pgadmin/", "phpSQLiteAdmin/", "phpldapadmin/", "phpmyadmin/", "phpMyAdmin/", "phppgadmin/", "platz_login/", "power_user/", "processlogin.XXXX", "project-admins/", "pureadmin/", "radmind-1/", "radmind/", "rcLogin/", "rcjakar/admin/login.XXXX", "relogin.XXXX", "CFIDE/componentutils/", "root/", "secret/", "secrets/", "secure/", "security/", "server/", "server_admin_small/", "showlogin/", "sign-in.XXXX", "sign-in/", "sign_in.XXXX", "sign_in/", "signin.XXXX", "signin/", "simpleLogin/", "siteadmin.XXXX", "siteadmin/", "CFIDE/adminapi/base.cfc?wsdl", "CFIDE/scripts/ajax/FCKeditor/editor/filemanager/connectors/cfm/upload.XXXX", "siteadmin/index.XXXX", "siteadmin/login.XXXX", "smblogin/", "sql-admin/", "ss_vms_admin_sm/", "sshadmin/", "staradmin/", "sub-login/", "super.XXXX", "super1.XXXX", "super1/", "super_index.XXXX", "super_login.XXXX", "superman.XXXX", "shopping-cart-admin-login.XXXX", "shop/manager/", "shop/admin/", "shop/login.XXXX", "shop/admin/login.XXXX", "store/admin/", "store/login.XXXX", "store/admin/login.XXXX", "store/manager/", "superman/", "supermanager.XXXX", "superuser.XXXX", "superuser/", "supervise/", "supervise/Login.XXXX", "supervisor/", "support_login/", "sys-admin/", "sysadm.XXXX", "sysadm/", "sysadmin.XXXX", "sysadmin/", "sysadmins/", "system-administration/", "system_administration/", "typo3/", "ur-admin.XXXX", "ur-admin/", "user.XXXX", "user/", "useradmin/", "user/login.XXXX", "userlogin.XXXX", "users.XXXX", "users/", "users/login.XXXX", "usr/", "utility_login/", "uvpanel/", "vadmind/", "vmailadmin/", "vorod.XXXX", "vorod/", "vorud.XXXX", "vorud/", "webadmin.XXXX", "webadmin/", "webadmin/admin.XXXX", "webadmin/index.XXXX", "webadmin/login.XXXX", "webmaster.XXXX", "webmaster/", "websvn/", "wizmysqladmin/", "blog/wp-admin/", "wp-admin/", "wp-admin/wp-login.XXXX", "wp/wp-login.XXXX", "blog/wp-login.XXXX", "wp-login.XXXX", "wp-login/", "xlogin/", "yonetici.XXXX", "yonetim.XXXX");
		$this->check = $common;

	}
}
?>
