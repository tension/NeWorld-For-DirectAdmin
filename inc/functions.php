<?php
$root = $_ENV['DOCUMENT_ROOT'] . '/';
if ($_ENV['DOCUMENT_ROOT']) {
    $root = $_ENV['DOCUMENT_ROOT'] . '/';
} elseif ($_SERVER['DOCUMENT_ROOT']) {
    $root = $_SERVER['DOCUMENT_ROOT'] . '/';
} else {
    $root = getenv("DOCUMENT_ROOT") . '/';
}
define('ROOT', $root);

$ts = new tsclass();

// 根据不同系统取得CPU相关信息
switch(PHP_OS) {
	case "Linux":
		$sysReShow = (false !== ($sysInfo = sys_linux()))?"show":"none";
		break;
	default:
		break;
}

//linux系统探测
function sys_linux() {

	// UPTIME
	if (false === ($str = @file("/proc/uptime"))) return false;
	$str = explode(" ", implode("", $str));
	$str = trim($str[0]);
	$min = $str / 60;
	$hours = $min / 60;
	$days = floor($hours / 24);
	$hours = floor($hours - ($days * 24));
	$min = floor($min - ($days * 60 * 24) - ($hours * 60));
	if ($days !== 0) $res['uptime'] = $days." Days ";
	if ($hours !== 0) $res['uptime'] .= $hours." Hours";
	//$res['uptime'] .= $min." Minutes";

	// MEMORY
	if (false === ($str = @file("/proc/meminfo"))) return false;
	$str = implode("", $str);
	preg_match_all("/MemTotal\s{0,}\:+\s{0,}([\d\.]+).+?MemFree\s{0,}\:+\s{0,}([\d\.]+).+?Cached\s{0,}\:+\s{0,}([\d\.]+).+?SwapTotal\s{0,}\:+\s{0,}([\d\.]+).+?SwapFree\s{0,}\:+\s{0,}([\d\.]+)/s", $str, $buf);

	$res['memTotal'] = round($buf[1][0]/1024, 2);
	$res['memFree'] = round($buf[2][0]/1024, 2);
	$res['memCached'] = round($buf[3][0]/1024, 2);
	$res['memUsed'] = ($res['memTotal']-$res['memFree']);
	$res['memPercent'] = (floatval($res['memTotal'])!=0)?round($res['memUsed']/$res['memTotal']*100,2):0;

	$res['memRealUsed'] = ($res['memTotal'] - $res['memFree'] - $res['memCached']);
	$res['memRealPercent'] = (floatval($res['memTotal'])!=0)?round($res['memRealUsed']/$res['memTotal']*100,2):0;

	$res['swapTotal'] = round($buf[4][0]/1024, 2);
	$res['swapFree'] = round($buf[4][0]/1024, 2);
	$res['swapUsed'] = ($res['swapTotal']-$res['swapFree']);
	$res['swapPercent'] = (floatval($res['swapTotal'])!=0)?round($res['swapUsed']/$res['swapTotal']*100,2):0;

	// LOAD AVG
	if (false === ($str = @file("/proc/loadavg"))) return false;
	$str = explode(" ", implode("", $str));
	$str = array_chunk($str, 3);
	$res['loadAvg'] = implode(" ", $str[0]);

	return $res;
}

// 淘宝归属地查询
function GetiP($ip,$lid = 0,$cid = 0,$num = 0) {
	$ipapi = @file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=".$ip);
	$ipinfo = json_decode($ipapi, true);
	
	$country = $ipinfo['data']['country'];  //国家
	$country_id = $ipinfo['data']['country_id'];  //简称
	$area = $ipinfo['data']['area'];  //区域
	$region = $ipinfo['data']['region'];  //省份
	$city = $ipinfo['data']['city'];  //城市
	$isp = $ipinfo['data']['isp'];  //运营商
	$isp_id = $ipinfo['data']['isp_id'];  //运营商ID
	$ips = $ipinfo['data']['ip'];  //IP
	
	if ($region == $city) {
		$address = $region;
	} else {
		$address = $region . '' . $city;
	}
	
	if ($lid == '1') {
		$add = $country_id;
	}

	if ($cid == '1') {
		$add = '<i class=" ' . strtolower($country_id) . ' flag"></i>';
	}

	if ($num == '1') {
		$add = $country . '' . $address;
	} else if ($num == '2') {
		$add = $country . '' . $address . '' . $isp;
	}
	return $add;
}

//QQ在线状态
function get_qq_status($string) {
	$ch = curl_init();
	$timeout = 20;
	curl_setopt ($ch, CURLOPT_URL, "http://webpresence.qq.com/getonline?type=1&{$string}:");
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
		
	if(!$data) { return 0; }
	switch($data) {
		case 'online[0]=0;': 
			echo("off");
			break;
		case 'online[0]=1;':
			echo("blue");
			break;
	}
}

// 服务器端口状态
function getPortStatus($ip,$port) {
	$fp = @fsockopen($ip, $port, $errno, $errstr, 10);
	if (!$fp) {
		$string = " <div class=\"ui red label\"><i class=\"icon remove\"></i></div>";
	} else {
		$string = " <div class=\"ui green label\"><i class=\"icon checkmark\"></i></div>";
	}
 	return $string;
}

// 语言切换
function getLanguages($root) {
    $langdir = $root . "lang/";
    $languages = array();
    if ($handle = opendir($langdir)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && is_dir($langdir . $file)) {
                $languages[] = $file;
            }
        }
        closedir($handle);
    }
    return $languages;
}

// 获取域名列表
function getDomainsList() {
    global $ts;
    $ret = array();
    $r = $ts->api_get("/CMD_API_DOMAIN_OWNERS");
    $domainsOwn = @urldecode($r);
    @parse_str($domainsOwn, $domains);
    if (is_array($domains) && count($domains) > 0) {
        foreach ($domains as $domain => $ouwner) {
            $ret[str_replace('_', '.', $domain)] = $ouwner;
        }
    }
    return $ret;
}

// 获取用户状态
function getDateCreated() {
    global $ts;
    $ret = array();
    $r = $ts -> api_get("/CMD_API_SHOW_USER_CONFIG");
    parse_str($r, $ret);
	$datecreated = date('Y-m-d',strtotime($ret['date_created']));
	//$datecreated = $ret['date_created'];
    return $datecreated;
}

class tsclass {

    function api_get($cmd, $post=false) {
        if (is_array($post)) {
            $is_post = true;
            $str = '';
            foreach ($post as $var => $value) {
                if (strlen($str) > 0)
                    $str .= '&';
                $str .= $var . '=' . urlencode($value);
            }
            $post = $str;
        } else {
            $is_post = false;
        }
        $headers = array();
        $headers['Host'] = '127.0.0.1:' . $_ENV['SERVER_PORT'];
        $headers['Cookie'] = 'session=' . $_ENV['SESSION_ID'] . '; key=' . $_ENV['SESSION_KEY'];
        if ($is_post) {
            $headers['Content-type'] = 'application/x-www-form-urlencoded';
            $headers['Content-length'] = strlen($post);
        }
        $send = ($is_post ? 'POST ' : 'GET ') . $cmd . " HTTP/1.1\r\n";
        foreach ($headers as $var => $value)
            $send .= $var . ': ' . $value . "\r\n";
        $send .= "\r\n";
        if ($is_post && strlen($post) > 0)
            $send .= $post . "\r\n\r\n";
        if ($_ENV["SSL"] == 1) {
            $sIP = 'ssl://127.0.0.1';
        } else {
            $sIP = '127.0.0.1';
        }
        $res = @fsockopen($sIP, $_SERVER['SERVER_PORT'], $sock_errno, $sock_errstr, 2);
        if ($sock_errno || $sock_errstr)
            return false;
        fputs($res, $send, strlen($send));
        $result = '';
        while (!feof($res))
            $result .= fgets($res, 32768);
        @fclose($res);
        $data = explode("\r\n\r\n", $result, 2);
        return $data[1];
    }

}
?>