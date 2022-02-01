<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ResponserTraits
{
    public function responseSuccess($message = 'successful', $data = [])
    {
        return response()->json([
            'code'  => Response::HTTP_OK,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function responseCreated($data = [])
    {
        return response()->json([
            'code'  => Response::HTTP_CREATED,
            'message' => 'successfully created',
            'data' => $data
        ]);
    }
}
