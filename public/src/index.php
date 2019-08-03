<?php
declare(strict_types=1);

require_once __DIR__ . '/autoload.php';

use Application\Core\JsonResponse;

$student = array(
    'name' => 'John Doe',
    'course' => 'Software Engineering',
    'level' => '200',
    'collections' => ['books' => 'Intro to UML', 'music' => 'rap']
);

new JsonResponse('unauthorized', 'unauthorized', $student);
