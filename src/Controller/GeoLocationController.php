<?php

namespace CodeblogPro\GeoLocation\Controller;

use CodeblogPro\GeoLocation\Application\Services\GeoLocationService;
use \Illuminate\Routing\Controller;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;
use CodeblogPro\GeoLocation\Application\Exceptions\IncorrectIpException;
use CodeblogPro\GeoLocation\Application\Exceptions\ConnectException;
use CodeblogPro\GeoLocation\Application\Exceptions\GeoLocationAppException;
use CodeblogPro\GeoLocation\Application\Exceptions\IncorrectLanguageCodeException;
use CodeblogPro\GeoLocation\Application\Exceptions\IncorrectResponseContent;

class GeoLocationController extends Controller
{
    public function show(string $ip = '', string $language = '')
    {
        $geoLocationService = new GeoLocationService();

        try {
            $result = ['data' => $geoLocationService->getLocationArrayByIp($ip, $language)];
        } catch (IncorrectIpException $exception) {
            $result = ['error' => 'Incorect ip.' . $exception->getMessage()];

            return response()->json($result, 400);
        } catch (IncorrectLanguageCodeException $exception) {
            $result = ['error' => 'Incorect language code.' . $exception->getMessage()];

            return response()->json($result, 400);
        } catch (ConnectException | GeoLocationAppException | IncorrectResponseContent $exception) {
            $result = ['error' => 'Server error. ' . $exception->getMessage()];

            return response()->json($result, 500);
        } catch (\Exceiption $exception) {
            $result = ['error' => 'Unexpected error. ' . $exception->getMessage()];

            return response()->json($result, 500);
        }

        return response()->json($result);
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