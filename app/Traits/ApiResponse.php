<?php

namespace App\Traits;


trait ApiResponse
{
    protected function success($message = 'success data', $data = [], $code = 200)
    {

        return response()->json([

            'status' => true,
            'message' => $message,
            'data' => $data

        ], $code);
    }




    protected function error($message = 'something went wrong', $data = [], $code = 400)
    {

        return response()->json([

            'status' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
