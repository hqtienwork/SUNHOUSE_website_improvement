<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Các loại exception không cần ghi log.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * Các input không được flash khi có lỗi validation.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Đăng ký xử lý exception tuỳ chỉnh.
     */
    public function register(): void
    {
        // Ghi log nếu cần
        $this->reportable(function (Throwable $e) {
            // Custom logging logic here (nếu cần)
        });

        // Tuỳ chỉnh render lỗi 404
        $this->renderable(function (Throwable $e, $request) {
            if ($this->isHttpException($e)) {
                if ($e->getStatusCode() === 404) {
                    return response()->view('errors.404', [], 404);
                }
            }
        });
    }
}
