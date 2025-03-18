<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            //Backend Route
            Route::middleware('web')
                ->group(base_path('routes/backend.php'));
            },
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (HttpException $e, Request $request) {
            $code = $e->getStatusCode();

            $title = [
                '404' => 'Not Found',
                '403' => 'Forbidden',
                '500' => 'Internal server error',
            ];

            $messages = [
                '404' => 'Oops! Halaman tidak ditemukan.',
                '403' => 'Akses ditolak! <br>Anda tidak memiliki izin.',
                '500' => 'Maaf, sedang terjadi kesalahan pada server.',
            ];

            $messages2 = [
                '404' => 'Halaman yang Anda cari mungkin memang tidak ada atau telah dihapus.',
                '403' => 'Anda tidak memiliki izin untuk mengakses halaman ini.',
                '500' => 'Silakan coba beberapa saat lagi atau hubungi administrator.',
            ];

            if (!array_key_exists($code, $messages)) {
                $code = '404';
            }

            

            return response()->view('error.error-page', [
                'code' => $code,
                'message' => $messages[$code],
                'message2' => $messages2[$code],
                'title' => "{$code} | $title[$code]"
            ], (int) $code);
        });
    })->create();
    
