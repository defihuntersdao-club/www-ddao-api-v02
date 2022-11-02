<?php
// See bin/contract_list_v02.php

unset($mas);


$k = "coin";

$net = "matic";
$mas[$k][$net][usdc]	= "0x2791bca1f2de4661ed88a30c99a7a9449aa84174";
$mas[$k][$net][weth]	= "0x7ceb23fd6bc0add59e62ac25578270cff1b9f619";
$mas[$k][$net][aave]	= "0xd6df932a45c0f255f85145f286ea0b292b21c90b";
$mas[$k][$net][gnft]	= "0xe58e8391ba17731c5671f9c6e00e420608dca10e";
$mas[$k][$net][wmatic]	= "0x0d500b1d8e8ef31e21c99d1db9a6444d3adf1270";
$mas[$k][$net][wbtc]	= "0x1bfd67037b42cf73acf2047067bd4f2c47d9bfd6";
$mas[$k][$net][cmi]	= "0x83c92e1a4a824cd42f94012b7b50aff372e4d25f";
$mas[$k][$net][ddao]	= "0x90f3edc7d5298918f7bb51694134b07356f7d0c7";

$net = "bnb";
$mas[$k][$net][usdt]	= "0x55d398326f99059ff775485246999027b3197955";
$mas[$k][$net][wbnb]	= "0xbb4cdb9cbd36b01bd1cbaebf2de08d9173bc095c";

$net = "eth";
$mas[$k][$net][usdc]	= "0xa0b86991c6218b36c1d19d4a2e9eb0ce3606eb48";
$mas[$k][$net][gnft]	= "0xc502002aeb1b9309fccb016adf50507987fc6c2b";
$mas[$k][$net][weth]	= "0xc02aaa39b223fe8d0a0e5c4f27ead9083c756cc2";


foreach($mas[$k] as $net=>$v1)
{
//print "----- $k1 --------\n";
    foreach($v1 as $name=>$v2)
    {
//print "====== $net =======\n";
	$mas[addr][$net][$v2] = $name;
    }
}

/*
$k = "addr";

$net = "matic";
$mas[$k][$net][0x2791bca1f2de4661ed88a30c99a7a9449aa84174]	= "usdc";
$mas[$k][$net][0x7ceb23fd6bc0add59e62ac25578270cff1b9f619]	= "weth";
$mas[$k][$net][0xd6df932a45c0f255f85145f286ea0b292b21c90b]	= "aave";
$mas[$k][$net][0xe58e8391ba17731c5671f9c6e00e420608dca10e]	= "gnft";
$mas[$k][$net][0x0d500b1d8e8ef31e21c99d1db9a6444d3adf1270]	= "wmatic";
$mas[$k][$net][0x1bfd67037b42cf73acf2047067bd4f2c47d9bfd6]	= "wbtc";
$mas[$k][$net][0x83c92e1a4a824cd42f94012b7b50aff372e4d25f]	= "cmi";
$mas[$k][$net][0x90f3edc7d5298918f7bb51694134b07356f7d0c7]	= "ddao";

$net = "bnb";
$mas[$k][$net][0x55d398326f99059ff775485246999027b3197955]	= "usdt";
$mas[$k][$net][0xbb4cdb9cbd36b01bd1cbaebf2de08d9173bc095c]	= "wbnb";

$net = "eth";
$mas[$k][$net][0xa0b86991c6218b36c1d19d4a2e9eb0ce3606eb48]	= "usdc";
$mas[$k][$net][0xc502002aeb1b9309fccb016adf50507987fc6c2b]	= "gnft";
$mas[$k][$net][0xc02aaa39b223fe8d0a0e5c4f27ead9083c756cc2]	= "weth";
*/

$k = "lp";

$net = "eth";
$name = "univ2";
$mas[$k][$net][$name][weth_usdc]	= "0xb4e16d0168e52d35cacd2c6185b44281ec28c9dc";
$mas[$k][$net][$name][gnft_weth]	= "0xbcad06fdfcea3fd7d082b14f47a6757e11c5846c";

$net = "matic";
$name = "univ2";
$mas[$k][$net][$name][weth_usdc]	= "0x853ee4b2a13f8a742d64c8f088be7ba2131f670d";
$mas[$k][$net][$name][wbtc_usdc]	= "0xf6a637525402643b0654a54bead2cb9a83c8b498";
$mas[$k][$net][$name][gnft_usdc]	= "0x3fd0cc5f7ec9a09f232365bded285e744e0446e2";
$name = "sushi";
$mas[$k][$net][$name][weth_usdc]	= "0x853ee4b2a13f8a742d64c8f088be7ba2131f670d";
$mas[$k][$net][$name][gnft_usdc]	= "0x3fd0cc5f7ec9a09f232365bded285e744e0446e2";
$mas[$k][$net][$name][ddao_weth]	= "0xfc067766349d0960bdc993806ea2e13fcfc03c4d";
$name = "quick";
$mas[$k][$net][$name][weth_usdc]	= "0x853ee4b2a13f8a742d64c8f088be7ba2131f670d";
$mas[$k][$net][$name][weth_wmatic]	= "0xadbf1854e5883eb8aa7baf50705338739e558e5b";
$mas[$k][$net][$name][wmatic_usdc]	= "0x6e7a5fafcec6bb1e78bae2a1f0b612012bf14827";

$contract_list = $mas;
unset($mas);
?>