<?php
declare(strict_types=1);

$base = __DIR__ . '/';

$folders = [
    'core'
];

foreach($folders as $f)
{
    foreach (glob($base . "$f/*.php") as $filename)
    {
        require_once $filename;
    }
}
