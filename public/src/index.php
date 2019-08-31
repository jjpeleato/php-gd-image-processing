<?php
declare(strict_types=1);

require_once __DIR__ . '/autoload.php';

use Application\Core\JsonResponse;

/**
 * Validate file submission
 */
$file = isset($_FILES['upload']) ? $_FILES['upload'] : null;
$timestamp = isset($_GET['timestamp']) ? $_GET['timestamp'] : null;
if ($file === null || $timestamp === null){
    new JsonResponse('unauthorized', 'Unauthorized.');
    exit();
}

/**
 * Validate the file type
 */
$type = getFileType($file['type']);
if ($type === '') {
    new JsonResponse('bad_request', 'File not allowed. Only .png, .jpeg and .jpg file.');
    exit();
}

/**
 * Validate the size
 */
$size = 5242880; // 5 MB
if ($size <= $file['size']) {
    new JsonResponse('bad_request', 'File not allowed. Maximum size 5 MB.');
    exit();
}

/**
 * Upload file process
 */
$path = $_SERVER['DOCUMENT_ROOT'].'/upload/';
$name = $path . (new DateTime())->getTimestamp() . $type;

if (!move_uploaded_file($file['tmp_name'], $name)) {
    new JsonResponse('exception', 'File upload failed.');
    exit();
}

new JsonResponse('ok', 'Successfully uploaded images');
