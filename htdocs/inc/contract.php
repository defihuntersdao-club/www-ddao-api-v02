<?php
//print_r($items);
//if(0)
if(!$item2)
{
    $t = $url.$item."/ContractName/Network";
    $o[error][txt] = "Url must be $t";

}
else
{
//$d = __DIR__;
//$d = dirname($d);
//$d = dirname($d);
if($item3)
$net = $item3;

$sol = $item2;
$d = $contract_dir;
$f = $d."$sol.".$net.".txt";
//print $f."<br>\n";;
if(file_exists($f))
{
$contractAddress = file_get_contents($f);
}
$o[result] = $contractAddress;
}



?>