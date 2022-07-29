<?php

namespace Ridhwan\LaravelBankDanamon\Facades;

use Illuminate\Support\Facades\Facade;

class DanamonFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'DanamonAPI';
    }
}
