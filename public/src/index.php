<?php
declare(strict_types=1);

require_once __DIR__ . '/autoload.php';

use Application\Core\GdGraphicsLibrary;
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
$time = (new DateTime())->getTimestamp();
$baseName = $path . $time;
$baseFile = $baseName . $type;
if (!move_uploaded_file($file['tmp_name'], $baseFile)) {
    new JsonResponse('exception', 'File upload failed.');
    exit();
}

/**
 * Initialize GD library
 */
$gd = new GdGraphicsLibrary();

/**
 * Resize: width
 */
$gd->setImage($baseFile);
$resizeWidth = $baseName . '_resize_width' . $type;
if ($gd->width > 1000) {
    $gd->resize(1000, "width");
}
$gd->save($resizeWidth, 90);
$gd->deleteImage();

/**
 * Resize: height
 */
$gd->setImage($baseFile);
$resizeHeight = $baseName . '_resize_height' . $type;
if ($gd->height > 500) {
    $gd->resize(500, "height");
}
$gd->save($resizeHeight, 90);
$gd->deleteImage();

/**
 * Thumbnail
 */
$gd->setImage($baseFile);
$thumbnail = $baseName . '_thumbnail' . $type;
$gd->thumbnail(300);
$gd->save($thumbnail, 90);
$gd->deleteImage();

/**
 * Thumbnail Plus
 */
$gd->setImage($baseFile);
$thumbnailPlus = $baseName . '_thumbnail_plus' . $type;
$gd->thumbnailPlus(500);
$gd->save($thumbnailPlus, 90);
$gd->deleteImage();

/**
 * Crop
 */
$gd->setImage($baseFile);
$crop = $baseName . '_crop' . $type;
if ($gd->width > 768 && $gd->height > 768) {
    $gd->crop(768, 768, 'center');
}
$gd->save($crop, 90);
$gd->deleteImage();

/**
 * Builder the response
 */
new JsonResponse(
    'ok',
    'Successfully uploaded images. Look this images.',
    [
        $time . $type,
        $time . '_resize_width' . $type,
        $time . '_resize_height' . $type,
        $time . '_thumbnail' . $type,
        $time . '_thumbnail_plus' . $type,
        $time . '_crop' . $type
    ]
);
