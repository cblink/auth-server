<?php


namespace Cblink\AuthServer;


class Auth
{

    public static $beforeMiddleware;

    public static $afterMiddleware;

    public static function beforeMiddleware($request)
    {
        return (static::$beforeMiddleware)($request) ?: false;
    }

    public static function afterMiddleware($request, $authApp)
    {
        return (static::$afterMiddleware)($request, $authApp) ?: $request;
    }

}