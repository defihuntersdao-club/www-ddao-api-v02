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

$tkns[ddao] 	= "0x90F3edc7D5298918F7BB51694134b07356F7d0C7";
$tkns[addao] 	= "0xca1931c970ca8c225a3401bb472b52c46bba8382";
$tkns[vesting]  = "0xa9a2d6b16f3dd4c145aa8c875b9ceb8cda3022e3";

//include "balance.inc";

/*
$f = __DIR__."/".$item.".json";

$f2 = "/www/app.defihuntersdao.club/1_test/www-ddao-app/bin/001_load_tokenlists.php.json";
if(file_exists($f2))
{
    $mtime = filemtime($f);
    $mtime2 = filemtime($f2);
    if($mtime < $mtime2)
    {
	$a = file_get_contents($f2);
	file_put_contents($f,$a);
    }
}


//print $f;
$a = file_get_contents($f);
$mas2 = json_decode($a,1);
*/

//$nets[1] = "eth";
//$nets[56] = "bsc";
$nets[137] = "matic";

foreach($nets as $chain_id=>$net)
{
    $mas = $mas2[chain_id][$chain_id];
//print_r($mas);
    $keys = array_keys($mas);
//    print_r($keys);
    $c = count($keys);
    $b = "0x370ebfa6";
    //$w = "0x90cbf05fd109331258040c239af19359f66692b9";
    $t = substr($wal,2);
    $b .= view_number($t,64,0);

    $b .= "0000000000000000000000000000000000000000000000000000000000000040";



//$c1 = 1;
//$t = dechex($c1);
//$c = count($tkns);

//$c = 1;

$b3 = "";
$kk=0;
foreach($keys as $w)
{

//if($net == "matic" && $kk>420)break;
$w = strtolower($w);
    if(in_array($w,$b_skip[$net]))continue;
$c1++;
$t = substr($w,2);
$b2 = view_number($t,64,0);
$b1 = $b . $b2;
//$b .= $b2;

$b3 .= $b2;
$kk++;
}
$c = $kk;
$t = dechex($c);
$b .= view_number($t,64,0);

$b .= $b3;

$t2[from] = "0x0000000000000000000000000000000000000000";
$t2[data] = $b;
$t2[to] = $b_mas[$net];
//print_r($t);
unset($v);
$v[jsonrpc] = "2.0";
$v[method] = "eth_call";
//$v[params][0] = $row[wal];
$v[params][0] = $t2;
$v[params][1] = "latest";
//$v[id] = $row[id];
$v[id] = $net."_".$c."_".$w."_".$wal;
$jss2[$net][] = $v;


}
//print_r($jss2);
//die;
$num = 4;
foreach($jss2 as $net=>$jss)
{
$rpc = $rpc_mas[$net];
$curl_time1 = microtime(true);
$mas = curl_mas2($jss,$rpc,0);
$curl_time2 = microtime(true)-$curl_time1;
$o[time][$net] = $curl_time2;
//print_r($mas);
foreach($mas as $v2)
{
    $t = $v2[id];
    $t = explode("_",$t);
    $net = $t[0];
    $t = $v2[result];
    $t = substr($t,2+64*2);
    $l = strlen($t)/64;
    for($i=0;$i<$l;$i++)
    {
	//$i2 = $i-2;
	$n = $i-floor($i/$num)*$num+1;
	$t2 = substr($t,$i*64,64);

	switch($n)
	{
	    case "1":
		$t3 = "0x".substr($t2,24);
		$w = $t3;
		$name = "addr";
		$nnn++;
	    break;
	    case "2":
		$t3 = gmp_hexdec($t2);
		$t3 = gmp_strval($t3);
		$name = "balance2";
	    break;
	    case "3":
		$t3 = hexdec($t2);
		$name = "decimal";
		$tt = $o3[$net."_".$w][balance2] / 10**$t3;
		$tt = floor($tt*1000)/1000;
		$o3[$net."_".$w][balance] = $tt;
	    break;
	    case "4":
		$s = "";
		for($i2=0;$i2<32;$i2++)
		{
		    $c = substr($t2,$i2*2,2);
		    if($c == "00")break;
		    $c = hexdec($c);
		    $s .= chr($c);
		}
		$t3 = $s;
		$name = "abbr";
	    break;
	}
//	print $n."\t".$t2."\t$t3\n";
//	$o3[$net][$w][$name] = $t3;
//	$o3[$net][$w][net] = $net;
	$o3[$net."_".$w][$name] = $t3;
	$o3[$net."_".$w][num] = $nnn;
    }
}

}

$o[result] = $o3;
}

?>