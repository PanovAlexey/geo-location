<?php

namespace CodeblogPro\GeoLocation\Controller;

use \Illuminate\Routing\Controller;

class GeoLocationController extends Controller
{
    public function show(string $ip = '')
    {

    }

    public function incorrectMethod()
    {
        $result = [
            'status' => 405,
            'body' => ['error' => ['message' => 'Method Not Allowed']]
        ];

        return response()->json($result['body'], $result['status']);
    }
}