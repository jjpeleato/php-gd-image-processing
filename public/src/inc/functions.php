<?php
declare(strict_types=1);

/**
 * Return file extension
 *
 * @param string $str
 * @return string
 */
function getFileType($str = '')
{
    if ($str === 'image/jpeg') {
        return '.jpeg';
    } elseif ($str === 'image/png') {
        return '.png';
    }

    return '';
}
