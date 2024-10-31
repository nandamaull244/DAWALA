<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        // Handle TokenMismatchException (419 Page Expired)
        if ($e instanceof TokenMismatchException) {
            return response()->view('errors.419', [
                'message' => 'Halaman telah kedaluwarsa karena tidak aktif terlalu lama. Silakan coba lagi dan refresh halaman.'
            ], 419);
        }

        // Handle HTTP Exceptions
        if ($this->isHttpException($e)) {
            switch ($e->getStatusCode()) {
                case 401:
                    return response()->view('errors.401', [
                        'message' => 'Akses tidak diizinkan'
                    ], 401);
                
                case 403:
                    return response()->view('errors.403', [
                        'message' => 'Akses dilarang'
                    ], 403);
                
                case 404:
                    return response()->view('errors.404', [
                        'message' => 'Halaman tidak ditemukan'
                    ], 404);
                
                case 419:
                    return response()->view('errors.419', [
                        'message' => 'Halaman telah kedaluwarsa karena tidak aktif terlalu lama. Silakan coba lagi dan refresh halaman.'
                    ], 419);
                
                case 429:
                    return response()->view('errors.429', [
                        'message' => 'Terlalu banyak permintaan. Silakan coba lagi setelah beberapa saat.'
                    ], 429);
                
                case 500:
                    return response()->view('errors.500', [
                        'message' => 'Server Error'
                    ], 500);
                
                case 503:
                    return response()->view('errors.503', [
                        'message' => 'Layanan tidak tersedia'
                    ], 503);
                
                default:
                    return response()->view('errors.default', [
                        'code' => $e->getStatusCode(),
                        'message' => $e->getMessage()
                    ], $e->getStatusCode());
            }
        }

        // Handle other exceptions in development
        if (config('app.debug')) {
            return parent::render($request, $e);
        }

        // Handle any other exceptions in production
        return response()->view('errors.500', [
            'message' => 'Terjadi kesalahan yang tidak diketahui'
        ], 500);
    }
}
