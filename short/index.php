<?php
include '../backend/class.core.php';
Core::initialize();

if (!isset($_GET['s']) || empty($_GET['s'])) {
	die('You dont have any access here. :--(');
}
$short = $_GET['s'];
header('Location: ' . Core::getShortener()->getLongLinkByShortener($short));
exit;
?>