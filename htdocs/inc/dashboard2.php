<?php
//print "<pre>";


$skip_result = 1;
include "rate.php";

unset($o3,$mas);
unset($jss);
//$f = "/opt/rpc_need.txt";
//$a = file_get_contents($f);
//print_r($rpc_mas);
reset($rpc_mas);
$r_mas[matic] = $rpc_mas[matic];
//$r_mas[matic] = $a;
$r_mas[eth] = $rpc_mas[eth];
foreach($r_mas as $net=>$rpc)
{
unset($v,$jss);
//-------------------------------------------
$v[jsonrpc] = "2.0";
$v[method] = "eth_gasPrice";
//$v[params][0] = $row[wal];
$v[params] = array();
//$v[params][1] = "latest";
//$v[id] = $row[id];
$v[id] = $net."_gas";
//$v[id] = "balance_".$name;
$jss[] = $v;

/*
//-------------------------------------------
$v[jsonrpc] = "2.0";
$v[method] = "eth_getBlockByNumber";
//$v[params][0] = $row[wal];
$v[params] = array();
$v[params][0] = "latest";
$v[params][1] = false;
//$v[params][1] = true;
//$v[id] = $row[id];
$v[id] = $net."_blk";
//$v[id] = "balance_".$name;
$jss[] = $v;
*/

$mas = curl_mas2($jss,$rpc,0);
//print_r($mas);
    foreach($mas as $v2)
    {
	$id = $v2[id];
	$t = explode("_",$id);
	$net = $t[0];
	$case = $t[1];
	$v = $v2[result];
	switch($case)
	{
	    case "gas":
		$v = hexdec($v);
		$v /= 10**9;
		$v = round($v,2);
	    break;
	    case "blk":
		$v = "";
	    break;
	    default:
//		$v = hexdec($v);
	}
	$o3[$net."_".$case] = $v;
    }
}
$t = $o2[matic][sushi][ddao_weth][rate_usd];
$t = round($t,3);
$o3[rate_ddao] 	= $t;

$t = $o2[matic][quick][wmatic_usdc][rate1];
$t = round($t,3);
$o3[rate_matic]	= $t;

$t = $o2[matic][univ2][weth_usdc][rate_usd];
$t = round($t,1);
$o3[rate_eth] 	= $t;


$t = $o2[matic][univ2][wbtc_usdc][rate_usd];
$t = round($t,1);
$o3[rate_btc] 	= $t;
//$o3[o2] = $o2;

$o[result] = $o3;
?>