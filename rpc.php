<?php
$rpc_mas[eth] 		= "https://rpc1-eth.infocoin.pro/";
$rpc_mas[bsc] 		= "https://rpc1-bsc.infocoin.pro/";
$rpc_mas[matic] 	= "https://rpc1-matic.infocoin.pro/";
$f = "/opt/rpc_need.txt";
$a = file_get_contents($f);
$rpc_mas[matic] = $a;

if(0)
{
$rpc_mas[eth] 		= "http://10.0.103.101:8545";
$rpc_mas[eth] 		= "http://10.5.0.14:8542";
$rpc_mas[bsc] 		= "http://10.7.70.30:8545/";
$rpc_mas[matic] 	= "http://10.0.103.174:8545/";
}

?>