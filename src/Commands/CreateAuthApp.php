<?php


namespace Cblink\AuthServer\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateAuthApp extends Command
{

    protected $signature = 'auth:server:create';

    public function handle()
    {
        $name = $this->ask('the auth app name ?');

        $foreignId = $this->ask('the '.config('auth_server.foreign_id').' ?');

        $appId = $this->ask('the app id ?', 'create by random');

        $appId = $appId === 'create by random' ? strtolower(str_random(16)) : $appId;

        DB::table(config('auth_server.table'))->insert([
            config('auth_server.foreign_id') => $foreignId,
            'name' => $name,
            'app_id' => $appId,
            'secret' => md5($foreignId.$appId.time()),
        ]);

        $this->info('create auth app successfully !');

        $authApp = DB::table(config('auth_server.table'))->where('app_id', $appId)->first();

        $this->table(['id', config('auth_server.foreign_id'), 'name', 'app_id', 'secret'], [
            $authApp->id, $authApp->{config('auth_server.foreign_id')}, $authApp->name, $authApp->app_id, $authApp->secret
        ]);
    }

}