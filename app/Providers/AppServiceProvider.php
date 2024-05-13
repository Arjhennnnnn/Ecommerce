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
        Response::macro("success", function ($data, $message, $statusCode) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $data
            ], $statusCode);
        });
        Response::macro("failed", function ($data, $errorMessage, $statusCode) {
            return response()->json([
                'success' => false,
                'message' => $errorMessage,
                'data' => $data
            ], $statusCode);
        });

        Response::macro("customException", function ($exceptionMessage, $statusCode) {
            return response()->json([
                'status'  => false,
                'message' => $exceptionMessage
            ], $statusCode);
        });
    }
}
