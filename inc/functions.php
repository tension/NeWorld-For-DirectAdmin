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

// 调用用户数据
function show_bar($text, $used, $limit, $id) {
	if($limit==0) return;

	$left=round(($used/$limit)*100);
	$right=100-$left;

	switch(TRUE) {
		case ($left > 80)	: $color = "progress-danger";		break;
		case ($left > 60)	: $color = "progress-warning";		break;
		default				: $color = "progress-success";		break;
	}

	echo $text;
}

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

// 服务器端口状态
function getPortStatus($ip,$port) {
	$fp = @fsockopen($ip, $port, &$errno, &$errstr, 10);
	if (!$fp) {
		$string = " <span class=\"badge badge-important\">&chi;</span>";
	} else {
		$string = " <span class=\"badge badge-success\">&radic;</span>";
	}
 	return $string;
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
?>