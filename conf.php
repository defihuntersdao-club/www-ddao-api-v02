<?php

error_reporting(0);

include "func.php";

include "rpc.php";

$d = __DIR__;
//$d = dirname($d);
$d .= "/contracts/";
$contract_dir = $d;


$sol = "ddao";
$time_otstup = -3600;
$time_otstup = 0;

$db["name"] = "ddao";
if($need_db)
include "/conf.sql.php";

$curl1 = "curl --connect-timeout 4 -H 'content-type: application/json' -X POST --data ";

//$f = "/opt/rpc_need.txt";
//$rpc = @file_get_contents($f);

$rpc = "https://matic-mumbai.chainstacklabs.com";
$rpc = "http://10.0.103.174:8545";
$rpc = "http://127.0.0.1:8545";
//$rpc = "http://10.0.103.176:8547";
//$rpc = "http://127.0.0.1:8545";
//$rpc = "http://10.9.0.191:8545";
$time = time();
//$chain_id = 137;

$f = "y_contract.$net.$sol.txt";
$a = file_get_contents($f);
$contractAddress = $a;

$glob[chain_id] = 31337;

$f = "wals.json";
if(file_exists($f))
{
$a = file_get_contents($f);
$wal_mas[all] = json_decode($a,1);
$nn = 0;
foreach($wal_mas[all] as $w=>$pk)
{
    $wal_mas[nn][$nn++] = $w; 
}
}
?>