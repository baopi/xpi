<?php

namespace App\Providers;

use App\Services\ServiceCaller;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Services\Auth\ParseValidators\Authorization;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a UserRepository instance or null. You're free to obtain
        // the UserRepository instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            $bearerField = 'Bearer ';
            $tokenWithBearer = $request->header('Authorization');
            if (strpos($tokenWithBearer, $bearerField) !== 0) {
                return null;
            }
            $token = substr($tokenWithBearer, strlen($bearerField));

            $parseValidateResult = ServiceCaller::call(ServiceCaller::PARSE_VALIDATOR_SERVICE,Authorization::class, ['token' => $token]);
            if ($parseValidateResult->errors) {
                return null;
            }

            return User::where('id', $parseValidateResult->parser->uid)->first();
        });
    }
}
