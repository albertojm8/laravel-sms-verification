<?php

namespace Albertojm8\SMSVerification;

use Aws\Sns\SnsClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class SMSVerificationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('sms_code', function ($attribute, $value, $parameters, $validator) {

            if (empty($parameters)) {

                return Auth::user()->verifySMSCode($value);

            } else {

                return Route::input($parameters[0])->verifySMSCode($value);
            }
        });

        Validator::replacer('sms_code', function ($message, $attribute, $rule, $parameters) {

            return "Invalid code submitted for SMS verification";
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Albertojm8SNSClientSingleton', function (){

            return new SnsClient([
                'version'     => 'latest',
                'region'      => 'us-west-2',
                'credentials' => [
                    'key'    => env('Albertojm8_AWS_SMS_ID'),
                    'secret' => env('Albertojm8_AWS_SMS_SECRET'),
                ],
            ]);
        });
    }
}
