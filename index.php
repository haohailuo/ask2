<?php

/* the tipask entrance */
error_reporting(0);
$mtime = explode(' ', microtime());
$starttime = $mtime[1] + $mtime[0];
define('IN_ASK2', TRUE);
define('ASK2_ROOT', dirname(__FILE__));
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . substr($_SERVER['PHP_SELF'], 0, -9));
include ASK2_ROOT . '/model/sowenda.class.php';
$sowenda = new sowenda();
$sowenda->run();
?>