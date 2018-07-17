<?php


namespace Cblink\AuthServer\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Cblink\AuthServer\Auth;
use Illuminate\Support\Facades\DB;
use Cblink\AuthServer\AuthServerException;

class CheckSignature
{

    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws \Throwable
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::beforeMiddleware($request) === true) {
            return $next($request);
        }

        throw_if(!$appId = $request->get('app_id'), AuthServerException::class, 'app_id can not be null');
        throw_if(!$sign = $request->get('sign'), AuthServerException::class, 'sign can not be null');

        $payload = $request->except('sign');

        $authApp = DB::table(config('auth_server.table'))->where('app_id', $appId)->first();

        throw_if(!$authApp, AuthServerException::class, 'invalid app_id');

        $payload['secret'] = $authApp->secret;

        ksort($payload);

        throw_if(strtolower(md5(http_build_query($payload))) !== $sign, AuthServerException::class, 'invalid sign');

        $request->attributes->set('auth_app', $authApp);

        $request = Auth::afterMiddleware($request, $authApp);

        return $next($request);
    }
}