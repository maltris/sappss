<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body>

<script>
        $(function() {
                $('.toggle-trigger').change(function() {
                        if ($(this).prop('checked') == true) {
                                $.get(
                                        "index.php",
                                        {mode : 1, port : $(this).data('port')}
                                );
                        } else {
                                $.get(
                                        "index.php",
                                        {mode : 2, port : $(this).data('port')}
                                );
                        }
                })
        })
</script>

<?php

//settings
$ip = '192.168.188.26';
$user = 'test';
$pw = 'testtesttesttest';

//read the mib
snmp_read_mib('./powernet414.mib');

if (isset($_GET["mode"]) && isset($_GET["port"])) {
	// 2 off, 1 on
	$mode = htmlspecialchars($_GET["mode"]);
	// port 1 to 8
	$port = htmlspecialchars($_GET["port"]);
	// set the outlet state
        snmp3_set($ip, $user, 'authNoPriv', 'MD5', $pw, 'AES', $pw, 'PowerNet-MIB::rPDUOutletControlOutletCommand.' . $port, 'i', $mode);
} else {
	// bulk-read the outlet states
	$result = snmp3_walk($ip, $user, 'authNoPriv', 'MD5', $pw, 'AES', $pw, 'PowerNet-MIB::rPDUOutletStatusOutletState');
	foreach ($result as $k => $v) {
		$x = $k+1;
		echo '<input type="checkbox" ';
		if (strpos($v, 'outletStatusOn') !== false) {
			echo 'checked ';
		}
		echo 'class="toggle-trigger" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-port="' . $x . '" data-on="Port ' . $x . '" data-off="Port ' . $x . '"><br/>';
	}
}

?>

</body>

