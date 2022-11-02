#!/usr/bin/php
<?php
include "conf.php";

/*
//print $contract_dir."\n";
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
    }

}
return $coins;
}
*/
$coins = contract_list();
//print_r($coins);
$mas = "<?php\n";
$mas .= "// See bin/".basename(__FILE__)."\n\n";
$mas .= "unset(\$mas);\n";
foreach($coins as $k1=>$v1)
{
    $mas .= "\n\n\$k = \"$k1\";\n";
    foreach($v1 as $k2=>$v2)
    {
    $mas .= "\n\$net = \"$k2\";\n";
	foreach($v2 as $k3=>$v3)
	{
	    if(is_array($v3))
	    {
		$mas .= "\$name = \"$k3\";\n";
		foreach($v3 as $k4=>$v4)
		{
		    $mas .= "\$mas[\$k][\$net][\$name][$k4]\t= \"$v4\";\n";
		}
	    }
	    else
	    $mas .= "\$mas[\$k][\$net][$k3]\t= \"$v3\";\n";
	}
    }
}
$mas .= "\n\$contract_list = \$mas;\n";
//$mas .= "unset()";
$mas .= "\n?>";
print $mas;
$f = dirname(__DIR__)."/contract_list.php";
print $f."\n";
//file_put_contents($f,$mas);

?>