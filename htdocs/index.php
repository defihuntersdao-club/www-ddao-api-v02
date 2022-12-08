<?php
//phpinfo();die;
include "../conf.php"; 

//die;
$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
if(in_array($ip,$debug_ip))$debug = 1;

$debug_file = "/tmp/api_debug.txt";
$debug = @file_get_contents($debug_file);


$ref = $_SERVER[HTTP_REFERER];
$t = pathinfo($ref);
//print_r($t);
//print $ref;
$domen[] = "https://app-test.defihuntersdao.club/";
$domen[] = "https://app-test2.defihuntersdao.club/";
$domen[] = "https://app.defihuntersdao.club/";
$domen[] = "https://dbayc.defihuntersdao.club/";

$cache_dir = __DIR__."/cache/";
if(0)
if(!in_array($ref,$domen))
{
    $err = "Your server not accessed";
}


if(!$err)
{
$domen = $_SERVER['HTTP_HOST'];
$url = "https://".$domen."/";
$t = $_SERVER['REQUEST_URI'];                                                                                                                                                               
$t = explode("/",$t);
unset($t[0]);
$items = $t;                                                                                                                                                                       
$item = $t[1];                                                                                                                                                                              
$item2 = $t[2];                                                                                                                                                                             
$item3 = $t[3];   
//print_r($t);                                                                                                                                                                          

$sol = "ddao";

//print "ITEM:".$item."\n";
//if(0)
switch($item)
{
//    case "UserList":
//    case "LevelsInfo":
//    case "TxsList":
//    case "UsersByAddr":
//    case "UserMatrix":
//    case "VaultList":
    case "balance_token":
//	$need_cache = 10;
    break;
    case "balance":
	$need_cache = 5;
    break;
    case "dashboard":
//	$need_cache = 5;
    break;
    case "main":
    case "":
	//print "dddd";die;
	$item = "main";
    break;
}


$itime_start = microtime(true);

$real_data = 1;
    
if($need_cache)
{
$cache_file = __DIR__."/cache/".$sol."_".$item."_".$item2."_".$item3.".cache";
$t = filemtime($cache_file);
if(time() < ($t + $need_cache))
{
$txt = file_get_contents($cache_file);
$o = json_decode($txt,1);

$o[cached] = 1;

$real_data = 0;
$oncached = 1;

}
}

if($real_data)
{
$d = __DIR__;
$f = $d."/inc/".$item.".php";




if(file_exists($f))
{
//    print $f;
    include $f;
}
//$txt = json_encode($o,192);

}
$itime_end = microtime(true);
$script_time = $itime_end - $itime_start;


//print __FILE__.":".__LINE__."\n";die;

if(!isset($o))
{
    $o[error] = "Data doesn't exists";
}
else
{
    //$o[error] = $err;
    if($script_time)
    {
	if($script_time < 0.01)
	$t = round($script_time*10**3,4)." ms";
	else 
	$t = round($script_time,4)." sec";
    $o[etime] = $t;
    }
    else
    unset($o[etime]);
}


}
if($err)$o[err] = $err;


$txt = json_encode($o,192);

print $txt;

if($need_cache && !$skip_cache && !$oncached)
file_put_contents($cache_file,$txt);


//$o[time] = date("y-m-d H:i:s")
?>