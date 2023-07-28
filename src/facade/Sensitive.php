<?php
declare (strict_types = 1);

namespace isszz\sensitive\facade;

use think\Facade;

class Sensitive extends Facade
{
    protected static function getFacadeClass()
    {
        return 'isszz.sensitive';
    }
}
