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

function CMD_ALL_USER_SHOW($tabla){
	$tabla = str_replace(' / unlimited', '', $tabla);
	$tabla = preg_replace("/<tr\s*><td align=right colspan=(.+)><a class=toptext href=\'\?view=advanced\'>(.+)<\/a><\/td ><\/tr >/", '', $tabla);
	$tabla = preg_replace("/<tr\s*><td align=right colspan=(.+)><a class=toptext href=\'\?\'>Clear Search Filter<\/a><\/td ><\/tr >/", '', $tabla);
	$tabla = preg_replace("/<(script|SCRIPT)[\s\S]*?>[\s|\S]*?<\/(script|SCRIPT)>/", "", $tabla);
	//$tabla = preg_replace("/(.*)<a(.+)href=\"javascript:selectAll\(\'select\'\);\">Select<\/a>(.*)/", "$1<input type=\"checkbox\" class=\"checkAll\">$3", $tabla);
	$tabla = str_replace("<a class=listtitle href=\"javascript:selectAll('select');\">Select</a>", "<input type=\"checkbox\" class=\"checkAll\">", $tabla);
	return $tabla;
}

function CMD_RESELLER_SHOW($tabla){
	$tabla = str_replace(' / unlimited', '', $tabla);
	$tabla = preg_replace("/<tr\s*><td align=right colspan=(.+)><a class=toptext href=\'\?view=advanced\'>(.+)<\/a><\/td ><\/tr >/", '', $tabla);
	$tabla = preg_replace("/<tr\s*><td align=right colspan=(.+)><a class=toptext href=\'\?\'>Clear Search Filter<\/a><\/td ><\/tr >/", '', $tabla);
	$tabla = preg_replace("/<(script|SCRIPT)[\s\S]*?>[\s|\S]*?<\/(script|SCRIPT)>/", "", $tabla);
	//$tabla = preg_replace("/(.*)<a(.+)href=\"javascript:selectAll\(\'select\'\);\">Select<\/a>(.*)/", "$1<input type=\"checkbox\" class=\"checkAll\">$3", $tabla);
	$tabla = str_replace("<a class=listtitle href=\"javascript:selectAll('select');\">Select</a>", "<input type=\"checkbox\" class=\"checkAll\">", $tabla);
	return $tabla;
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
        $res = @fsockopen($sIP, $_SERVER['SERVER_PORT'], &$sock_errno, &$sock_errstr, 2);
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