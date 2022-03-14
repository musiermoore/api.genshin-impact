<?php

namespace App\Http\Traits;

trait ApiResponses
{
    public function errorResponse($code, $message)
    {
        $response = [
            'status' => 'error',
            'code' => $code,
            'message' => $message
        ];

        return response()->json($response)->setStatusCode($code);
    }

    public function successResponse($code = 200, $message = null, $data = null)
    {
        $response = [
            'status' => 'success',
            'code' => $code,
        ];

        if (empty($data) && empty($message)) {
            $message = 'Not found.';
        }

        if (!empty($message)) {
            $response['message'] = $message;
        }

        if (!empty($data)) {
            if (!is_array($data)) {
                $data = array($data);
            }

            foreach ($data as $key => $item) {
                $response['data'][$key] = $item;
            }
        }

        return response()->json($response)->setStatusCode($code);
    }
}
