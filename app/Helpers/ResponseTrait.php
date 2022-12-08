<?php

namespace App\Helpers;

use Illuminate\Http\Response;

trait ResponseTrait
{
    /**
     * success operation
     * 200
     */
    public static function success(string $message = "Data Retrieved", mixed $data = [])
    {
        $responseArray = [
            "status" => true,
            "message" => $message,
            "data" => $data,
        ];

        return response()->json($responseArray, Response::HTTP_OK);
    }

    /**
     * success operation
     * 200
     */
    public static function successWithMetaData(string $message = "Data Retrieved", mixed $data = [], mixed $metaData = [])
    {
        $responseArray = [
            "status" => true,
            "message" => $message,
            "data" => $data,
            "metaData" => $metaData
        ];

        return response()->json($responseArray, Response::HTTP_OK);
    }

    /**
     * createdSuccessfully
     * 201
     */
    public function createdSuccessfully(string $message, mixed $data = [])
    {
        $responseArray = [
            "status" => true,
            "message" => $message,
            "data" => $data,
        ];
        return response()->json($responseArray, Response::HTTP_CREATED);
    }

    /**
     * operation faild
     * 
     */
    public static function failed(string $message, int $code = 500, array $errors = [])
    {
        $errorArr = array();
        if (str_contains($message, 'No query results for model'))
            $message = "Data with the Provided id was not found";

        if (str_contains($message, 'SQLSTATE')) {
            $errorArr['DBError'] = $message;
            $message = "Database validation Error";
        }

        $responseArray = [
            "status" => false,
            "message" => $message,
            "errors" => array_merge($errorArr, $errors),
        ];

        return response()->json($responseArray, $code);
    }

    /**
     * internal server Error
     * 500
     */
    public function serverError(string $message = "Internal server Error", mixed $data = [])
    {
        $responseArray = [
            "status" => false,
            "message" => $message,
            "data" => $data,
        ];
        return response()->json($responseArray, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * bad request
     * 400
     */
    public function badRequest(string $message = "BAD REQUEST", mixed $data = [])
    {
        $responseArray = [
            "status" => false,
            "message" => $message,
            "data" => $data,
        ];
        return response()->json($responseArray, Response::HTTP_BAD_REQUEST);
    }

    /**
     * bool message if true use success if false use failed
     */
    public function bool(bool $bool, string $successMsg, string $errMsg)
    {
        if ($bool) {
            return $this->success($successMsg);
        } else {
            return $this->failed($errMsg);
        }
    }
}
