<?php namespace Strive\Frontend\Facades;

use Illuminate\Support\Facades\Facade;

class Frontend extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'frontend'; }

}