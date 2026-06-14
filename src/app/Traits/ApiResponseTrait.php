<?php

namespace App\Traits;

trait ApiResponseTrait
{
    /**
     * Send a success response.
     */
    protected function successResponse($data = null, $message = null, $code = 200)
    {
        $response = [
            'status' => 'success'
        ];

        if (!is_null($message)) {
            $response['message'] = $message;
        }

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    /**
     * Send an error response.
     */
    protected function errorResponse($message, $code, $errors = null)
    {
        $response = [
            'status' => 'error',
            'message' => $message,
        ];

        if (!is_null($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
}
