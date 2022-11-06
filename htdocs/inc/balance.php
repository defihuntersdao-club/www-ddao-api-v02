<?php
//print "<pre>";
$wal = $item2;

if(!$wal || strlen($wal) != 42 || substr($wal,0,2)!= "0x")
{
    $t = $url.$item."/Wallet";
    $o[error][txt] = "Address error. Url must be $t";
}
else
{



$coin_name[eth] 	= "ETH";
$coin_name[matic] 	= "MATIC";
$coin_name[bsc] 	= "BNB";


// busd wbnb
$lp[bsc] 	= "0x16b9a82891338f9ba80e2d6970fdda79d1eb0dae";
// WMATIC usdc
$lp[matic]	= "0x6e7a5fafcec6bb1e78bae2a1f0b612012bf14827";
// weth usdc
$lp[eth]	= "0xb4e16d0168e52d35cacd2c6185b44281ec28c9dc";

unset($tkns);
$k = "bsc";
$tkns[$k][dai] 	= "0x1AF3F329e8BE154074D8769D1FFa4eE058B1DBc3";
$tkns[$k][usdt] = "0x55d398326f99059fF775485246999027B3197955";
$tkns[$k][usdc] = "0x8AC76a51cc950d9822D68b83fE1Ad97B32Cd580d";
$tkns[$k][busd] = "0xe9e7CEA3DedcA5984780Bafc599bD69ADd087D56";

$k = "eth";
$tkns[$k][usdc] = "0xA0b86991c6218b36c1d19D4a2e9Eb0cE3606eB48";
$tkns[$k][usdt] = "0xdAC17F958D2ee523a2206206994597C13D831ec7";
$tkns[$k][dai] 	= "0x6B175474E89094C44Da98b954EedeAC495271d0F";

$k = "matic";
$tkns[$k][dai] 	= "0x8f3Cf7ad23Cd3CaDbD9735AFf958023239c6A063";
$tkns[$k][usdt] = "0xc2132D05D31c914a87C6611C10748AEb04B58e8F";
$tkns[$k][usdc] = "0x2791Bca1f2de4661ED88A30C99A7a9449Aa84174";

/*
$b_mas[eth] = "0xA2004cb2e3B72a3A32D5FB5C2b0b5dDe8Cbd3783";
$b_mas[bsc] = "0x918294145B18Ae868b00efa4b7AFe3c3869b8A27";
$b_mas[matic] = "0x608FCdfcaB64439C185CBfC6D39f4e61056E685D";
*/
include "balance.inc";


foreach($b_mas as $net => $contract)
{
unset($v,$jss);
//-------------------------------------------
$v[jsonrpc] = "2.0";
$v[method] = "eth_getBalance";
//$v[params][0] = $row[wal];
//$v[params] = array();
$v[params][0] = $wal;
$v[params][1] = "latest";
//$v[id] = $row[id];
$v[id] = $net."-balance_coin-".$wal;
//$v[id] = "balance_".$name;
//$jss[] = $v;
$jss2[$net][] = $v;

unset($v,$jss);
//-------------------------------------------
$v[jsonrpc] = "2.0";
$v[method] = "eth_blockNumber";
//$v[params][0] = $row[wal];
$v[params] = array();
//$v[params][0] = $wal;
//$v[params][1] = "latest";
//$v[id] = $row[id];
$v[id] = $net."-blk";
//$v[id] = "balance_".$name;
$jss2[$net][] = $v;



unset($v,$t,$t2);
//$b = "0x0902f1ac";
$b = "0x370ebfa6";

//$w = "0x90cbf05fd109331258040c239af19359f66692b9";
$t = substr($wal,2);
$b .= view_number($t,64,0);

$b .= "0000000000000000000000000000000000000000000000000000000000000040";

//unset($tkns[$net]);
//$tkns[] = "0x35212B9CBD74527e559792cB968D862602D22D08";
//$tkns[] = "0x35212B9CBD74527e559792cB968D862602D22D09";
//$tkns[] = "0xbd4598c6a8662be0d619f5e63edf1af116987bbb";
//$tkns[] = "0xbd4598c6a8662be0d619f5e63edf1af116987bbb";
$c = count($tkns[$net]);
$t = dechex($c);
$b .= view_number($t,64,0);

foreach($tkns[$net] as $w)
{
$t = substr($w,2);
$b .= view_number($t,64,0);
}


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
$v[id] = $net."-balance_token-$wal";
$jss2[$net][] = $v;


$b = "0x0902f1ac";

$t2[from] = "0x0000000000000000000000000000000000000000";
$t2[data] = $b;
$t2[to] = $lp[$net];;
//print_r($t);
unset($v);
$v[jsonrpc] = "2.0";
$v[method] = "eth_call";
//$v[params][0] = $row[wal];
$v[params][0] = $t2;
$v[params][1] = "latest";
//$v[id] = $row[id];
//$v[id] = $net."-".$n."-$pair-$name";
$v[id] = $net."-get_reserves";
$jss2[$net][] = $v;



}

$num = 4;
//print_r($jss2);
foreach($jss2 as $net=>$jss)
{

$rpc = $rpc_mas[$net];
$mas = curl_mas2($jss,$rpc,0);
//print_r($mas);
    foreach($mas as $v2)
    {
	$id = $v2[id];
	$t = explode("-",$id);
	$case = $t[1];
	$w = $t[2];
	$v = $v2[result];
//print "CASE: $case\n";
	switch($case)
	{
	    case "balance_coin":
		$t = $v;
		$t = hexdec($t);
		$t /= 10**18;
		$v = $t;
//print "NET: $net $v\n";
		    $o3[$net][$coin_name[$net]][balance_coin2] = $v;
		    $o3[$net][$coin_name[$net]][balance_coin] = floor($v*1000)/1000;
	    break;

	    case "blk":
		$t = $v;
		$t = hexdec($t);
		$v = $t;
	    break;
	    case "get_reserves":
		$t = $v;
		$t1 = substr($t,2,64);
		$t2 = substr($t,2+64,64);
		$t1 = gmp_hexdec($t1);$t1 = gmp_strval($t1);
		$t2 = gmp_hexdec($t2);$t2 = gmp_strval($t2);
//		if(0)
		switch($net)
		{
		    case "eth":
			    $t1 = $t1/10**6;
			    $t2 = $t2/10**18;
			    $t = $t1/$t2;
			    $v = $t;
		    break;
		    case "matic":
			    $t1 = $t1/10**18;
			    $t2 = $t2/10**6;
			    $t = $t2/$t1;
			    $v = $t;

		    break;
		    case "bsc":
			    $t1 = $t1/10**18;
			    $t2 = $t2/10**18;
			    $t = $t1/$t2;
			    $v = $t;

		    break;
		}
		    $o3[$net][$coin_name[$net]][t1] = $t1;
		    $o3[$net][$coin_name[$net]][t2] = $t2;
//		    $o3[$net][$coin_name[$net]][t2] = $t2;
		    $o3[$net][$coin_name[$net]][rate] = $v;
		    $t = $o3[$net][$coin_name[$net]][balance_coin2] * $v;
		    $o3[$net][$coin_name[$net]][balance2] = $t;
		    $t = floor($t*1000)/1000;
		    $o3[$net][$coin_name[$net]][balance] = $t." [".$o3[$net][$coin_name[$net]][balance_coin]." ".$coin_name[$net]."]";

//		    $o3[$net][all][balance] += $t;
		    $balance[$net]+= $t;
	    break;

	    case "balance_token":
		$t = $v;
		$t = substr($t,2);
		$l = strlen($t)/64;
		for($i = 2;$i<$l;$i++)
		{
		    $i2 = $i-2;
		    $n = ($i2/$num-floor($i2/$num))*$num+1;
		    $t2 = substr($t,$i*64,64);
		    //print $n."\t".$t2."\n";	    
		    switch($n)
		    {
			case "1":
			    $t3 = "0x".substr($t2,26);
			    $coin = $t3;
			    $name = "addr";
			    $v = $t3;
			break;
			case "2":
			    $t3 = gmp_hexdec($t2);
			    $t3 = gmp_strval($t3);
			    $name = "balance2";
			    $v = $t3;
			break;
			case "3":
			    $t3 = hexdec($t2);
			    $name = "decimal";
			    $v = $t3;
			break;
			case "4":

			    $flag = 1;
			    $j = 0;
			    $c = "";
			    while($flag)
			    {
				if($j==32)break;
				$tt = substr($t2,$j*2,2);
				if($tt == "00")$flag = 0;
				if($tt == "00")break;
				$tt = hexdec($tt);
				$c .= chr($tt);
				$j++;
			    }
			    $v = $c;


			    $name = "name";
//			    $v = "";
			$tt = $o2[$net][$coin][balance2] / 10**$o2[$net][$coin][decimal];
			$o2[$net][$coin][balance] = $tt;;
//			$o3[$net][all][balance] += $tt;
			$balance[$net] += $tt;
			break;
		    }
		    $o2[$net][$coin][$name] = $v;
		}
	    break;
	}
    }
}
foreach($o2 as $net=>$v3)
{
    foreach($v3 as $addr => $v2)
    {
	    $o3[$net][$v2[name]] = $v2;
    }
}
foreach($balance as $net=>$v2)
{
    $t = round($v2,2);
    $t =  number_format($t,2,"."," ");
    $o3[$net][all][balance] = $t;
}
$o[result][address] = strtolower($wal);;
$o[result][$item] = $o3;
}
//print_r($balance);
?>