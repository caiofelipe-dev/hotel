<?php


require_once __DIR__ . '/../app/application.php';

use Fmk\Facades\Request;
$response = Request::exec();
// If a controller/route returned a string (rendered view), output it
if (is_string($response) || is_numeric($response)) {
	echo $response;
} elseif ($response === false) {
	// execution was aborted by middleware or redirect already sent
	// do nothing
}