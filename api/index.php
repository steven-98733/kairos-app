<?php

declare(strict_types=1);

$publicPath = realpath(__DIR__.'/../public');

if ($publicPath === false) {
    http_response_code(500);
    echo 'Unable to locate the public directory.';
    exit;
}

$_SERVER['DOCUMENT_ROOT'] = $publicPath;
$_SERVER['SCRIPT_FILENAME'] = $publicPath.'/index.php';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF'] = '/index.php';

require $publicPath.'/index.php';
