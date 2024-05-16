<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Return's custom response.
     * 
     * * E1001 => SERVER ERROR
     * * E1002 => <set custom error response> [edit]
     * * E1003 => <set custom error response> [edit]
     * * E1004 => RUNTIME ERROR: BUGS/ERROR FOUND WHILE RUNNING CODE
     * * E1005 => QUERY EXCEPTION ERROR: ERROR FOUND WHILE EXCUTING QUERY
     * * E1006 => QUERY EXCEPTION ERROR: NO RESULT RETURNED AFTER EXECUTION
     * * E1007 => <set custom error response> [edit]
     * * E1008 => FAILED TO UPLOAD FILE ON CUSTOM STORAGE
     * * E1009 => FAILED TO PASS THE SET CONDITION, FORCED THROW ERROR
     * * E1010 => RETURNED ERROR FROM USER DEFINED METHOD
     * * E1011 => BAD REQUEST: REQUEST GIVEN INVALID/MISSING
     * * [add]
     * 
     **/


    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        /**
         * Define a custom macro for generating success responses.
         * 
         * @param mixed $data => The data to be included in the response.
         * 
         * @param string $message => The message to be included in the response.
         * 
         * @param int $statusCode => The HTTP status code of the response.
         * 
         * @param string|null $resource => The resource class to be used for data transformation, if applicable.
         * 
         * @param bool $isMultipleData => Indicates whether the data consists of multiple items.
         * 
         * @return \Illuminate\Http\JsonResponse The success response.
         * 
         */

        Response::macro("success", function ($data, $message, $statusCode, $resource = null, $isMultipleData = false,) {

            function hasResource($resource)
            {
                return $resource != null;
            }

            if (hasResource($resource)) {

                if ($isMultipleData) {

                    $data = $resource::collection($data);
                } else {

                    $data = new $resource($data);
                }
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $data
            ], $statusCode);
        });


        /**
         * Define a custom macro for generating error responses.
         * 
         * This macro constructs a JSON response indicating failure,
         * 
         * including an error message and optional data, with the provided HTTP status code.
         * 
         * @param mixed $data => The additional data to be included in the response.
         * 
         * @param string $errorMessage => The message describing the error.
         * 
         * @param int $statusCode => The HTTP status code to be returned in the response.
         * 
         * @return \Illuminate\Http\JsonResponse
         */

        Response::macro("failed", function ($data, $errorMessage, $statusCode) {
            return response()->json([
                'success' => false,
                'message' => $errorMessage,
                'data' => $data
            ], $statusCode);
        });


        /**
         * Define a custom macro for generating error responses.
         * 
         * This macro constructs a JSON response indicating failure,
         * 
         * including an error message and optional data, with the provided HTTP status code.
         * 
         * @param string $exceptionMessage The message describing the error.
         * 
         * @param int $statusCode The HTTP status code to be returned in the response.
         * 
         * @return \Illuminate\Http\JsonResponse
         */

        Response::macro("customException", function ($exceptionMessage, $statusCode) {
            return response()->json([
                'status'  => false,
                'message' => $exceptionMessage
            ], $statusCode);
        });
    }
}
