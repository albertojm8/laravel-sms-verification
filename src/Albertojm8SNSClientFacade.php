<?php

namespace Albertojm8\SMSVerification;

use Illuminate\Support\Facades\Facade;

class Albertojm8SNSClientFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'Albertojm8SNSClientSingleton'; }
}