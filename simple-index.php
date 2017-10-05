<?php

for ($x = 1; $x <= 8; $x++) {
    echo "<p>Port " . $x . " <a href='simple-index.php?port=" . $x . "&mode=1'>ein</a> " . "<a href='simple-index.php?port=" . $x . "&mode=2'>aus</a></p>";
}

//settings
$ip = '192.168.188.26';
$user = 'test';
$pw = 'testtesttesttest';

snmp_read_mib('./powernet414.mib');
// 2 aus, 1 an
$mode = htmlspecialchars($_GET["mode"]);
// port 1 bis 8
$port = htmlspecialchars($_GET["port"]);

if (isset($port) && isset($mode)) {
	snmp3_set($ip, $user, 'authNoPriv', 'MD5', $pw, 'AES', $pw, 'PowerNet-MIB::rPDUOutletControlOutletCommand.' . $port, 'i', $mode);
}
?>
