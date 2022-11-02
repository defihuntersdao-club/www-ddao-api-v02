<?php
function contract_list()
{
global $contract_dir;
$d = $contract_dir;
$h = opendir($d);
while($f = readdir($h))
{
    if($f == "." || $f == "..")continue;
    $tf = $d.$f;

    if(is_dir($tf))continue;

    $t = pathinfo($tf);
    if($t[extension] != "txt")continue;

    $a = file_get_contents($tf);
    $a = strtolower($a);

//    print $tf."\n";
    $f2 = $t[filename];
//    print $f2."\n";
    $t = explode(".",$f2);
    $net = $t[1];
    $f3 = $t[0];
//    print "Net: $net\n";

//    $t = explode("_",$f3);
//    $n = $t[0];
    $n = $f3;

    if(substr($n,0,2)=="lp")
    {
	$t2 = explode("-",$n);
	$n2 = $t2[1];
//print_r($t2);
	$t3 = explode("_",$n2,2);
//print_r($t3);
	$coins[lp][$net][$t3[0]][$t3[1]] = $a;
    }
    else
    {
	$coins[coin][$net][$n] = $a;
	$coins[addr][$net][$a] = $n;
    }

}
return $coins;
}
?>