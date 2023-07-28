<?php
declare(strict_types=1);

namespace isszz\sensitive;

/**
 * @param string $str
 * @param string|null $encoding
 *
 * @return int
 * @throws \isszz\sensitive\SensitiveException
 */
function mb_strlen(string $str, string|null $encoding = null)
{
    $length = \mb_strlen($str, $encoding);

    if ($length === false) {
        throw new SensitiveException('Invalid encoding');
    }

    return $length;
}
