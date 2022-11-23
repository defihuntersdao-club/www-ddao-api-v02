<?php
//print "<pre>";

$rpc = $rpc_mas[matic];
$wal = $item2;
/*
if(!$wal || strlen($wal) != 42 || substr($wal,0,2)!= "0x")
{
    $t = $url.$item."/Wallet";
    $o[error][txt] = "Address error. Url must be $t";
}
else
*/
{

function decimal($c)
{
    $d = 18;
    switch($c)
    {
	case "usdc":
	    $d = 6;
	break;

	case "wbtc":
	    $d = 8;
	break;
	default:
	$d = 18;
    }
    return $d;
}
//print "!!!!!!!!!!";
include "ddao_tokens.inc";
/*
    $tkn[ddao] 	= "0x90F3edc7D5298918F7BB51694134b07356F7d0C7";
    $tkn[addao]	= "0xca1931c970ca8c225a3401bb472b52c46bba8382";
    $tkn[gnft]	= "0xE58e8391BA17731C5671F9c6E00e420608Dca10e";
    $tkn[wbtc]  = "0x1BFD67037B42Cf73acF2047067bd4F2C47D9BfD6";
    $tkn[wmatic] = "0x0d500B1d8E8eF31E21C99d1Db9A6444d3ADf1270";
    $tkn[weth]  = "0x7ceB23fD6bC0adD59E62ac25578270cFf1b9f619";
    $tkn[usdc]  = "0x2791bca1f2de4661ed88a30c99a7a9449aa84174";

    $factorys[sushi] = "0xc35dadb65012ec5796536bd9864ed8773abc74c4";
    $factorys[quick] = "0x5757371414417b8c6caad45baef941abc7d3ab32";
*/
//    $tkn[lp_sush_

    // getPairs
    $b = "0xe6a43905";

	$tkns1 = $tkn;
	$tkns2 = $tkn;
//print_r();
	reset($tkns1);
	foreach($tkns1 as $coin1=>$tkn1)
	{
//print "....... ";
	    reset($tkns2);
	    foreach($tkns2 as $coin2=>$tkn2)
	    {
		if($coin1 == "addao" || $coin2 == "addao")continue;
		if($coin1 == $coin2)continue;
		if($set[$coin2][$coin1])continue;
		$pair = $coin1."_".$coin2;
		$set[$coin1][$coin2] = 1;
		$b1 = $b;
		$t = substr($tkn1,2);
		$t = strtolower($t);
		$t = view_number($t,64,"0");
		$b1 .= $t;

		$t = substr($tkn2,2);
		$t = strtolower($t);
		$t = view_number($t,64,"0");
		$b1 .= $t;
		$b_mas[$pair] = $b1;
	    }
	}

    foreach($factorys as $fname=>$factory)
    {
//print "!!!!!!!! ";
	reset($b_mas);
	foreach($b_mas as $pair=>$b)
	{
unset($t2,$t,$v);
$t2[from] = "0x0000000000000000000000000000000000000000";
$t2[data] = $b;
$t2[to] = $factory;
//print_r($t);
unset($v);
$v[jsonrpc] = "2.0";
$v[method] = "eth_call";
//$v[params][0] = $row[wal];
$v[params][0] = $t2;
$v[params][1] = "latest";
//$v[id] = $row[id];
$v[id] = $fname."-".$pair;
$jss[] = $v;


	}
    }
//print_r($jss);
//$rpc = $rpc_mas[$net];
$curl_time1 = microtime(true);
$mas = curl_mas2($jss,$rpc,0);
$curl_time2 = microtime(true)-$curl_time1;
//print_r($mas);
    foreach($mas as $v2)
    {
	$id = $v2[id];
	$t = $v2[id];
	$t = explode("-",$t);
	$fname = $t[0];
	$pair = $t[1];
	$t = $v2[result];
	if($t == "0x0000000000000000000000000000000000000000000000000000000000000000")continue;
	$t = "0x".substr($t,26);
	$lps[$id] = $t;
	
//	$b = "0x0902f1ac";

    }

//print_r($lps);
unset($jss);
foreach($lps as $id=>$addr)
{
$b = "0x0902f1ac";
unset($t2,$t,$v);
$t2[from] = "0x0000000000000000000000000000000000000000";
$t2[data] = $b;
$t2[to] = $addr;
//print_r($t);
unset($v);
$v[jsonrpc] = "2.0";
$v[method] = "eth_call";
//$v[params][0] = $row[wal];
$v[params][0] = $t2;
$v[params][1] = "latest";
//$v[id] = $row[id];
$v[id] = $id;
$jss[] = $v;

}
$mas = curl_mas2($jss,$rpc,0);
//print_r($mas);
error_reporting(65535);
    foreach($mas as $v3)
    {
//print_r($v3);
	$id = $v3[id];
	$t = $id;
	$t = explode("-",$t);
	$fname = $t[0];
	$pair = $t[1];
	$t2 = explode("_",$pair);
	$coin1 = $t2[0];
	$coin2 = $t2[1];
	$c1 = $tkn[$coin1];
	$c2 = $tkn[$coin2];
	$flag = gmp_cmp($c2,$c1);

	$t = $v3[result];

	$t = substr($t,2);
	$v1 = substr($t,0,64);
	$v2 = substr($t,64,64);

	$o3[$id][opair] = $pair;
	if($flag == -1)
	{
	$o3[$id][opair] = $coin2."_".$coin1;
	    //$c = $coin1;
	    //$coin1 = $coin2;
	    //$coin2 = $c;
	    $v = $v1;
	    $v1 = $v2;
	    $v2 = $v;
	}
//	$o3[$id][compare] = $flag;

	$v1 = gmp_hexdec($v1);
	$v1 = gmp_strval($v1);
	$v1 /= 10 ** decimal($coin1);

	$v2 = gmp_hexdec($v2);
	$v2 = gmp_strval($v2);
	$v2 /= 10 ** decimal($coin2);

	$kurs1 = $v1/$v2;
	$kurs2 = $v2/$v1;
	$o3[$id][pair] = $pair;
	$o3[$id][c1] = $coin1;
	$o3[$id][c2] = $coin2;
	$o3[$id][t1] = $v1;
	$o3[$id][t2] = $v2;
	$o3[$id][d1] = decimal($coin1);
	$o3[$id][d2] = decimal($coin2);
	$o3[$id][r1] = $kurs1;
	$o3[$id][r2] = $kurs2;
	$o3[$id][lp] = $lps[$id];

    }
    
//    print_r($o3);

$o[result] = $o3;
//print "END";
}
?>