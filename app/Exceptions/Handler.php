<?php

namespace App\Exceptions;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Cache;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        $userId = 0;
        if (\auth()->user()) {
            $userId = auth()->user()->id;
        }
        $userIp = get_client_ip();
        $locationData = \Location::get($userIp);

        $cacheErrors = Cache::get('errors');
        if (! $exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            if (isset($cacheErrors) && $cacheErrors instanceof \Illuminate\Database\Eloquent\Collection) {

                $stdClass = new \stdClass();
                $stdClass->fullUrl = request()->fullUrl();
                $stdClass->ip = $userIp;
                $stdClass->code = $exception->getCode();
                $stdClass->file = $exception->getFile();
                $stdClass->line = $exception->getLine();
                $stdClass->message = $exception->getMessage();
                $stdClass->trace = $exception->getTraceAsString();
                $stdClass->agent = \Request::header('User-Agent');
                $stdClass->location = json_encode($locationData);
                $stdClass->user_id = $userId;
                $stdClass->created_at = Carbon::now();
                $stdClass->updated_at = Carbon::now();
                $stdClass->id = Carbon::now()->timestamp;

                $cacheErrors->push($stdClass);

                Cache::put('errors', $cacheErrors);

            } else {

                $collection = new Collection();
                $stdClass = new \stdClass();
                $stdClass->fullUrl = request()->fullUrl();
                $stdClass->ip = $userIp;
                $stdClass->code = $exception->getCode();
                $stdClass->file = $exception->getFile();
                $stdClass->line = $exception->getLine();
                $stdClass->message = $exception->getMessage();
                $stdClass->trace = $exception->getTraceAsString();
                $stdClass->agent = \Request::header('User-Agent');
                $stdClass->location = json_encode($locationData);
                $stdClass->user_id = $userId;
                $stdClass->created_at = Carbon::now();
                $stdClass->updated_at = Carbon::now();
                $stdClass->id = Carbon::now()->timestamp;

                $collection->push($stdClass);

                Cache::put('errors', $collection);
            }

        }
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {


        if ($request->wantsJson()) {   //add Accept: application/json in request
            return $this->handleApiException($request, $exception);
        } else {
            return parent::render($request, $exception);
        }

    }

    private function handleApiException($request, Throwable $exception)
    {
        $exception = $this->prepareException($exception);

        if ($exception instanceof \Illuminate\Http\Exception\HttpResponseException) {
            $exception = $exception->getResponse();
        }

        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            $exception = $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            $exception = $this->convertValidationExceptionToResponse($exception, $request);
        }

        return $this->customApiResponse($exception);
    }

    private function customApiResponse($exception)
    {
        if (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = 500;
        }

        $response = [];

        switch ($statusCode) {
            case 401:
                $response['message'] = 'Unauthorized';
                break;
            case 403:
                $response['message'] = 'Forbidden';
                break;
            case 404:
                $response['message'] = 'Not Found';
                break;
            case 405:
                $response['message'] = 'Method Not Allowed';
                break;
            case 422:
                $response['message'] = $exception->original['message'];
                $response['errors'] = $exception->original['errors'];
                break;
            default:
                $response['message'] = ($statusCode == 500) ? 'Whoops, looks like something went wrong' : $exception->getMessage();
                break;
        }

        if (config('app.debug')) {
            $response['trace'] = $exception->getTrace();
            $response['code'] = $exception->getCode();
        }

        $response['status'] = $statusCode;

        $stdClass = new \stdClass();

        $errors = new Collection();

        return response()->json([
            'status' => $statusCode,
            'errors' => $errors,
            'message' => $response['message'],
            'data' => $stdClass,
        ], $statusCode);

    }
}
