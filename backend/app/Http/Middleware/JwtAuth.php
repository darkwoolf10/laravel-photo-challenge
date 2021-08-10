<?php


namespace App\Http\Middleware;

/**
 * Class JwtAuth
 * @package App\Http\Middleware
 */
class JwtAuth
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        //TODO::make jwt auth
    }
}
