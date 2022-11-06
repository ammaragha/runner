<?php

namespace App\Helpers;

use Illuminate\Http\Response;

trait ResponseTrait
{


    /**
     * Success With data
     */
    public function succWithData($data, $message = null)
    {
        return response()->json(['massege' => $message, 'data' => $data], Response::HTTP_OK);
    }

    /**
     * internal server Error
     */
    public function serverErr($message = "Internal server Error")
    {
        return response()->json(['massege' => $message], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * bad request
     * 
     */
    public function badRequest($message = "BAD REQUEST")
    {
        return response()->json(['massege' => $message], Response::HTTP_BAD_REQUEST);
    }
}
