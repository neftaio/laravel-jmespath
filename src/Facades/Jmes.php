<?php
namespace Neftaio\Jmes\Facades;

use Illuminate\Support\Facades\Facade;

class Jmes extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'jmes';
    }
}
