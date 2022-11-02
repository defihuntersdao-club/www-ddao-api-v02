<?php

//print "<pre>";

function decimals($name)
{
    switch($name)
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

/*
$sols[] = "weth";
$sols[] = "wbtc";
$sols[] = "ddao";
$sols[] = "gnft";
$sols[] = "cmi";

$lps[] = "lp-sushi_ddao_weth";
$lps[] = "lp-univ2_wbtc_usdc";
$lps[] = "lp-univ2_weth_usdc";
$lps[] = "lp-univ2_gnft_usdc";



$sol = "weth";
$d = $contract_dir;
$f = $d."$sol.".$net.".txt";
*/
$b_mas[token0] = "0x0dfe1681";
$b_mas[token1] = "0xd21220a7";
$b_mas[reserv] = "0x0902f1ac";
$b_mas[supply] = "0x18160ddd";

$mas = contract_list();
$contract_list = $mas;
//print_r($mas);
foreach($mas[lp] as $net=>$v4)
{
    foreach($v4 as $name=>$v3)
    foreach($v3 as $pair=>$contract)
    {
    reset($b_mas);
    foreach($b_mas as $n=>$b)
    {
unset($v,$t,$t2);
//$b = "0x0902f1ac";
$t2[from] = "0x0000000000000000000000000000000000000000";
$t2[data] = $b;
$t2[to] = $contract;
//print_r($t);
unset($v);
$v[jsonrpc] = "2.0";
$v[method] = "eth_call";
//$v[params][0] = $row[wal];
$v[params][0] = $t2;
$v[params][1] = "latest";
//$v[id] = $row[id];
//$v[id] = $net."-".$n."-$pair-$name";
$v[id] = $net."-".$name."-".$n."-$pair";
$jss2[$net][] = $v;

    }
    }
}

//print_r($jss2);
foreach($jss2 as $net=>$jss)
{

    $rpc = $rpc_mas[$net];
    $mas = curl_mas2($jss,$rpc,0);
//print_r($jss);
//print_r($mas);
    foreach($mas as $v2)
    {
	$id = $v2[id];
	$t = explode("-",$id);
	$net = $t[0];
	$name = $t[1];
	$case = $t[2];
	$pair = $t[3];
	$t = explode("_",$pair);
	$coins = $t;
	$coin0 = $t[0];
	$coin1 = $t[1];
	$val = $v2[result];
	$v = $val;
//print_r($t);
	switch($case)
	{
	    case "reserv":
		$t = $v;
	        $t = substr($t,2);
		unset($t4);
		for($i=0;$i<2;$i++)
		{
		    $t2 = substr($t,$i*64,64);
		    $t3 = gmp_hexdec($t2);
		    $t3 = gmp_strval($t3);
		    $t4[] = $t3;
//		    $o2[$net][$name][$case][$pair]["token".$i] 	= $t3;
		    $o2[$net][$name][$pair][$case]["token".$i] 	= $t3;
		    $o2[$net][$name][$pair][$case]["tkn".$i] 	= $t3 / 10**decimals($o2[$net][$name][$pair]["token".$i."name"]);
//		    $o2[$net][$name][$pair][$case]["tkn_addr_".$i] 	= $o2[$net][$name][$pair]["token"+$i];
		    $o2[$net][$name][$pair][$case]["decimal".$i] 	= decimals($o2[$net][$name][$pair]["token".$i."name"]);

		}
//error_reporting(65535);
//		    $t = ($t4[0]/decimals($o2[$net][$name][$pair]["token0name"])) / ($t4[1] / decimals($o2[$net][$name][$pair]["token1name"]));
//print "D0[$coin0]:  ".decimals($coin0)."\n";
//print "v0[$coin0]:  ".$t4[0]."\n";
//print "D0[$coin1]:  ".decimals($coin1)."\n";
//print "v0[$coin1]:  ".$t4[1]."\n";
//print "T: $t\n";
		    $t = $o2[$net][$name][$pair][$case]["tkn0"] / $o2[$net][$name][$pair][$case]["tkn1"];
		    $o2[$net][$name][$pair][rate0] = $t;
		    $o2[$net][$name][$pair][rate1] = 1/$t;
		    if($t > (1/$t))
		    $o2[$net][$name][$pair][rate] = $t;
		    else
		    $o2[$net][$name][$pair][rate] = 1/$t;

		    if($o2[$net][$name][$pair][token0name] != "usdc" && $o2[$net][$name][$pair][token1name] != "usdc")
		    {
		    if($pair != "weth_usdc")
		    {
//			$o2[$net][$name][$pair][rate_usd_eth] = $o2[$net][$name][weth_usdc][rate];
			$o2[$net][$name][$pair][rate_usd] = $o2[$net][$name][weth_usdc][rate] / $o2[$net][$name][$pair][rate];
		    }
		    }
		    else
			$o2[$net][$name][$pair][rate_usd] = $o2[$net][$name][$pair][rate];


		//print_r($t4);
	    break;
	    case "token0":
	    case "token1":
		$v = "0x".substr($v,26);
		$o2[$net][$name][$pair][$case."addr"] = $v;
		$o2[$net][$name][$pair][$case."name"] = $contract_list[addr][$net][$v];
	    break;
	    default:
	    $v = gmp_hexdec($v);
	    $v = strval($v);
//	    $o2[$net][$name][$case][$pair] = $v;
	    $o2[$net][$name][$pair][$case] = $v;
	    $o2[$net][$name][$pair][addr] = $contract_list[lp][$net][$name][$pair];
	}
//print "V:$val\t$v\n";
    }

}

if(!$skip_result)
$o[result] = $o2;
//print_r($o2);

?>