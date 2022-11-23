<?php

$rpc = $rpc_mas[matic];
$wal = $item2;

if(!$wal || strlen($wal) != 42 || substr($wal,0,2)!= "0x")
{
    $t = $url.$item."/Wallet";
    $o[error][txt] = "Address error. Url must be $t";
}
else
{
print "<pre>";

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


include "ddao_tokens.inc";

    $lps["sushi-usdc_weth"] = "0x34965ba0ac2451a34a0471f04cca3f990b8dea27";
    $lps["sushi-weth_ddao"] = "0xfc067766349d0960bdc993806ea2e13fcfc03c4d";
    $lps["sushi-weth_gnft"] = "0x03b67a0ce884e806673cc92e9a1c4a77d5bc770b";
    $lps["quick-usdc_gnft"] = "0x3fd0cc5f7ec9a09f232365bded285e744e0446e2";

//$b_mas[]

    foreach($lps as $k=>$lp)
    {

// getReserv
$b = "0x0902f1ac";

unset($t2,$t,$v);
$t2[from] = "0x0000000000000000000000000000000000000000";
$t2[data] = $b;
$t2[to] = $lp;
//print_r($t);
unset($v);
$v[jsonrpc] = "2.0";
$v[method] = "eth_call";
//$v[params][0] = $row[wal];
$v[params][0] = $t2;
$v[params][1] = "latest";
//$v[id] = $row[id];
$v[id] = $k."-reserv";
$jss[] = $v;
//-------------------------------------
$b = "0x18160ddd";

unset($t2,$t,$v);
$t2[from] = "0x0000000000000000000000000000000000000000";
$t2[data] = $b;
$t2[to] = $lp;
//print_r($t);
unset($v);
$v[jsonrpc] = "2.0";
$v[method] = "eth_call";
//$v[params][0] = $row[wal];
$v[params][0] = $t2;
$v[params][1] = "latest";
//$v[id] = $row[id];
$v[id] = $k."-supply";
$jss[] = $v;
//-------------------------------------
$b = "0x70a08231";
$t = $wal;
$t = substr($t,2);
$t = view_number($t,64,"0");
$b .= $t;

unset($t2,$t,$v);
$t2[from] = "0x0000000000000000000000000000000000000000";
$t2[data] = $b;
$t2[to] = $lp;
//print_r($t);
unset($v);
$v[jsonrpc] = "2.0";
$v[method] = "eth_call";
//$v[params][0] = $row[wal];
$v[params][0] = $t2;
$v[params][1] = "latest";
//$v[id] = $row[id];
$v[id] = $k."-balance-".$wal;
$jss[] = $v;
//-------------------------------------
    }

//print_r($jss);
$mas = curl_mas2($jss,$rpc,0);
//$curl_time2 = microtime(true)-$curl_time1;
//print_r($mas);
    foreach($mas as $v2)
    {
	$id = $v2[id];
	$t = explode("-",$id);
	$case = $t[2];
	$pair = $t[1];
	$serv = $t[0];
	$t2 = explode("_",$pair);
	$coin1 = $t2[0];
	$coin2 = $t2[1];
	$v = $v2[result];
	switch($case)
	{
	    case "reserv":
	    $t = $v;
	    $t = substr($t,2);
	    $t1 = substr($t,0,64);
	    $t1 = hexdec($t1);
	    $t1 /= 10**decimal($coin1);

	    $t2 = substr($t,64,64);
	    $t2 = hexdec($t2);
	    $t2 /= 10**decimal($coin2);
	    $o3[$pair][$serv][t1] = $t1;
	    $o3[$pair][$serv][t2] = $t2;
	    switch($pair)
	    {
		case "usdc_weth":
		$o3[$pair][$serv][rate] = $t1/$t2;
		$kurs_eth = $t1/$t2;
		break;
		case "weth_gnft":
		case "weth_ddao":
		    $t = $t1/$t2 * $kurs_eth;
//		$o3[$id][rate] = $t;
		$o3[$pair][$serv][rate] = $t;
		$t = $t1 * $kurs_eth  + $t2 * $t;
		$o3[$pair][$serv][tvl] = $t;

		break;
		case "usdc_gnft":
		$o3[$pair][$serv][rate] = $t1/$t2;

		$t = $t1   + $t2 * $t1/$t2;
		$o3[$pair][$serv][tvl] = $t;

		break;
		default:
//		$o3[$id][rate] = $t1/$t2;
	    }
//	    $
	    break;
	    case "supply":
	    $v = hexdec($v);
	    $v /= 10**18;
//	    $o3[$case][$pair][$serv] = $v;
	    $o3[$pair][$serv][$case] = $v;

	    break;
	    case "balance":
	    $v = hexdec($v);
	    $v /= 10**18;

	    $o3[$pair][$serv][$case] = $v;
	        if($v > 0)
		{
		    $t = $o3[$pair][$serv][$case] / $o3[$pair][$serv][supply];
		    $o3[$pair][$serv][part] = $t;
		    $o3[$pair][$serv][pers] = $t*100;
		    $o3[$pair][$serv][usd] = $o3[$pair][$serv][tvl] * $t;
		}
		else
		    $o3[$pair][$serv][pers] = 0;
	    break;

	    default:
	    $v = hexdec($v);
	    $v /= 10**18;
	    $o3[$id] = $v;
	
	}
    }
    foreach($o3 as $pair=>$v3)
    {
//	if($pair == "usdc_weth")continue;
	foreach($v3 as $serv=>$v2)
	{
	    $o4[$pair."_".$serv] = $v2;
	    
	}
    }
    

$o[result][lp] = $o4;
}