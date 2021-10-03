<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('jsonSuccess', function (string $message, array $data = []) {
            return response()->json([
                'status'  => 'OK',
                'message' => $message,
                'data' => $data,
            ]);
        });

        Response::macro('jsonError', function (string $message, array $data = []) {
            return response()->json([
                'status'  => 'KO',
                'message' => $message,
                'data' => $data,
            ]);
        });
    }
}
