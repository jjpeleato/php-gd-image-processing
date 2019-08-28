<?php
declare(strict_types=1);

require_once __DIR__ . '/autoload.php';

use Application\Core\JsonResponse;

if (empty($_FILES['upload'])){
    new JsonResponse('unauthorized', 'unauthorized');
    exit();
}

new JsonResponse('ok', 'Successfully uploaded images');
