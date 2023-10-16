<?php
require 'config.php';

define('SERVER_AJAX_URL', get_site_protocol().'://'.SERVER_DOMAIN.'/engine/ajax/form.php');

$str = file_get_contents('php://input');

$headers = array(
    'User-Agent: '.safe_array_access($_SERVER, 'HTTP_USER_AGENT'),
);

$response = load_url(SERVER_AJAX_URL, $str, $headers);
echo $response;
exit;



function get_site_protocol() {
	if (function_exists('isSSL'))
		return isSSL() ? 'https' : 'http';

	if ($str = safe_array_access($_SERVER, 'HTTP_X_FORWARDED_PROTO') and in_array($str, array('http', 'https')))
		return $str;

	if ($str = safe_array_access($_SERVER, 'HTTPS') and strtolower($str) == 'on')
		return 'https';

	return 'http';
}

function load_url($url, $post = null, $headers = null, $init = false, $redir = false) {
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

	if ($headers) {
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
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
		return load_url($url, $post, $headers, $ch, true);
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
		return load_url($new_url, $post, $headers, $ch);
		
	} else {
		$curl_redir = 0;
		@curl_close($ch);
		
		return $page;
	}
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

function print2($array, $noexit = false) {
	echo '<pre>',print_r($array, 1),'</pre>';
	
	if (!$noexit) exit;
}