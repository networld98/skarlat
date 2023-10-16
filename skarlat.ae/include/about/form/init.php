<?php
@session_start();
header('Content-Type: text/html; charset=utf-8');

require 'config.php';

define('SERVER_AJAX_URL', get_site_protocol().'://'.SERVER_DOMAIN.'/engine/ajax/form.php');
define('AJAX_URL', 'ajax.php');

date_default_timezone_set('Europe/Moscow');

function bottom_proc($operation) {
	$content = ob_get_clean();
	
	if (!$usertag = safe_array_access($_COOKIE, 'usertag')) {
		$usertag = md5(safe_array_access($_GET, 'id'));
		$expires = time() + 365 * 86400;
		setcookie('usertag', $usertag, $expires, '/');
	}
	
	$post = array(
		'operation' => $operation,
		'domain' => safe_array_access($_SERVER, 'HTTP_HOST'),
		'keyid' => safe_array_access($_GET, 'id'),
		'browser' => get_browser_name(),
		'bancookie' => safe_array_access($_COOKIE, 'bancookie'),
		'firstid' => safe_array_access($_COOKIE, 'firstid'),
		'ip' => determine_ip(true),
		'usertag' => $usertag,
	);
	//print2($post, true);
	if ($response = load_url(SERVER_AJAX_URL, $post)) {
		//print2($response);
		$json = json_decode($response, true);
		
		if (safe_array_access($json, 'status') == 'OK' and !empty($json['response'])) {
			$replace_pairs = array(
				'[SERVER_AJAX_URL]' => AJAX_URL,
				'[HEADERS_ASSETS]' => '
				<link rel="stylesheet" href="css/jquery-ui.css" />
				<link rel="stylesheet" href="css/jquery-ui.theme.css" />

				<script src="js/jquery.js"></script>
				<script src="js/jquery-ui.js"></script>
				
				<link href="css/client.css" rel="stylesheet">
				<link href="js/sticky/sticky.css" rel="stylesheet">
				<script>var SERVER_AJAX_URL = "'.AJAX_URL.'";</script>
				<script src="js/client.js"></script>
				<script src="js/sticky/sticky.min.js"></script>',
			) + $json['response'];
			
			$content = str_replace(array_keys($replace_pairs), array_values($replace_pairs), $content);
		} else {
			if ($url = safe_array_access($json, 'redirect')) {
				header('Location: '.$url);
			} elseif (safe_array_access($json, 'action') == 'ban') {
				$expires = time() + 365 * 86400;
				setcookie('bancookie', 1, $expires, '/');
			}
			
			exit;
		}
		
		echo $content;
		
	} else {
		exit('Empty response');
	}
}


function get_site_protocol() {
	if (function_exists('isSSL'))
		return isSSL() ? 'https' : 'http';

	if ($str = safe_array_access($_SERVER, 'HTTP_X_FORWARDED_PROTO') and in_array($str, array('http', 'https')))
		return $str;

	if ($str = safe_array_access($_SERVER, 'HTTPS') and strtolower($str) == 'on')
		return 'https';

	return 'http';
}

function load_url($url, $post = null, $init = false, $redir = false) {
	$show_error = false;
	static $time = 0;
	static $curl_redir = 0;
	static $curl_redir_max = 15;
	
	if ($curl_redir >= $curl_redir_max) {
		$curl_redir = 0;
		return false;
	}
	
	if ($init == false) {
		$ch = curl_init($url);
	} else {
		$ch = $init;
	}
	
	@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	
	if ($redir) {
		curl_setopt($ch, CURLOPT_HEADER, 1);
	} else {
		curl_setopt($ch, CURLOPT_HEADER, 0);
	}
	
	if ($post) {
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	}
	
	
	$page = curl_exec($ch);
	
	if ($show_error and !$page and curl_errno($ch)) {
		$error = curl_error($ch);
		exit($error);
	}
	
	if ($redir) {
		list($header, $page) = explode("\r\n\r\n", $page, 2);
	}
	
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	if (($http_code == 301 or $http_code == 302) and !$redir) {
		return load_url($url, $post, $ch, true);
	} elseif ($http_code == 301 or $http_code == 302) {
		$matches = array();
		preg_match('/Location:(.*?)(\n|$)/is', $header, $matches);
		$url = @parse_url(trim($matches[1]));
		if (!$url) {
			$curl_redir = 0;
			return $page;
		}
		
		$last_url = parse_url(curl_getinfo($ch, CURLINFO_EFFECTIVE_URL));
		
		if (!$url['scheme']) {
			$url['scheme'] = $last_url['scheme'];
		}
		
		if (!$url['host']) {
			$url['host'] = $last_url['host'];
		}
		
		if (!$url['path']) {
			$url['path'] = $last_url['path'];
		}
		
		$new_url = $url['scheme'].'://'.$url['host'].$url['path'].(empty($url['query']) ? '' : '?'.$url['query']);
		
		
		curl_setopt($ch, CURLOPT_URL, $new_url);
		$curl_redir++;
		return load_url($new_url, $post, $ch);
		
	} else {
		$curl_redir = 0;
		@curl_close($ch);
		
		return $page;
	}
}

function get_browser_name($user_agent = '') {
	$user_agent or $user_agent = safe_array_access($_SERVER, 'HTTP_USER_AGENT');
	
	if ($user_agent) {
		if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
		elseif (strpos($user_agent, 'Edge')) return 'Edge';
		elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
		elseif (strpos($user_agent, 'Safari')) return 'Safari';
		elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
		elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';
		elseif (strpos($user_agent, 'Netscape') || strpos($user_agent, 'Navigator')) return 'Netscape';
	   
		return 'Other';
	}
	
	return 'Undefined';
}

function safe_array_access($array) {
	if (is_array($array)) {
		$numargs = func_num_args();
		$arg_list = func_get_args();

		for ($i = 1; $i < $numargs; $i++) {
			if ($array and (isset($array[$arg_list[$i]]) or array_key_exists($arg_list[$i], $array)))
				$array = $array[$arg_list[$i]];
			else
				return false;
		}
	}
	
	return $array;
}

function check_ip($ip)
{
	if (!empty($ip) and ip2long($ip)!= -1 and ip2long($ip) != false)
	{
		$private_ips = array(
			//array('0.0.0.0','2.255.255.255'),
			array('10.0.0.0','10.255.255.255'),
			array('127.0.0.0','127.255.255.255'),
			array('169.254.0.0','169.254.255.255'),
			array('172.16.0.0','172.31.255.255'),
			array('192.0.2.0','192.0.2.255'),
			array('192.168.0.0','192.168.255.255'),
			array('255.255.255.0','255.255.255.255')
		);
		
		foreach ($private_ips as $r) {
		
			$min = ip2long($r[0]);
			$max = ip2long($r[1]);
			if ((ip2long($ip) >= $min) and (ip2long($ip) <= $max))
				return false;
		}
		
		return true;
	}
	else
	{ 
		return false;
	}
}

function determine_ip($ip2long = false)
{
	if (!empty($_SERVER['HTTP_CLIENT_IP']) and check_ip($_SERVER['HTTP_CLIENT_IP']))
	{
		$result = $_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
		foreach (explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']) as $ip) {
		
			if (check_ip(trim($ip)))
			{
				$result = $ip;
				break;
			}
		}
	}
	elseif (!empty($_SERVER['HTTP_CLIENT_IP']) and check_ip($_SERVER['HTTP_X_FORWARDED']))
	{
		$result = $_SERVER['HTTP_X_FORWARDED'];
	}
	elseif (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) and check_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
	{
		$result = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_FORWARDED_FOR']) and check_ip($_SERVER['HTTP_FORWARDED_FOR']))
	{
		$result = $_SERVER['HTTP_FORWARDED_FOR'];
	}
	elseif (!empty($_SERVER['HTTP_FORWARDED']) and check_ip($_SERVER['HTTP_FORWARDED']))
	{
		$result = $_SERVER['HTTP_FORWARDED'];
	}
	elseif (!empty($_SERVER['REMOTE_ADDR']))
	{
		$result = $_SERVER['REMOTE_ADDR'];
	}
	
	return $ip2long ? sprintf('%u', ip2long($result)) : $result;
}

function print2($array, $noexit = false) {
	echo '<pre>',print_r($array, 1),'</pre>';
	
	if (!$noexit) exit;
}

ob_start();