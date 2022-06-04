<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function responseError(Exception $e, int $code = 500): Response
    {
        return new Response([
            'error' => true,
            'code' => 500,
            'message' => $e->getMessage()
        ], 500);
    }

    public function responseOk(string $message, $data = null, int $code = 200): Response
    {
        if($data) {
            return new Response([
                'data' => $data,
                'message' => $message
            ], $code);
        } else {
            return new Response([
                'message' => $message
            ], $code);
        }
        
    }

    public function responsePaginate($data)
    {
        return response()->json([
            'data' => $data->items(),
            'current_page' => $data->currentpage(),
            'total' => $data->total(),
            'perPage' => $data->perPage(),
            'lastPage' => $data->lastPage(),
            'message' => 'Data fetched successfully'
        ], 200);
    }
}
