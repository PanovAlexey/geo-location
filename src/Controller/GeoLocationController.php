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
            $result = json_encode(
                ['data' => $geoLocationService->getLocationArrayByIp($ip, $language)]
            );
        } catch (IncorrectIpException $exception) {
            http_response_code(400);

            $result = json_encode(['error' => 'Incorect ip.' . $exception->getMessage()]);
        } catch (IncorrectLanguageCodeException $exception) {
            http_response_code(400);

            $result = json_encode(['error' => 'Incorect language code. ' . $exception->getMessage()]);
        } catch (ConnectException | GeoLocationAppException | IncorrectResponseContent $exception) {
            http_response_code(500);

            $result = json_encode(['error' => 'Server error. ' . $exception->getMessage()]);
        } catch (\Exceiption $exception) {
            http_response_code(500);

            $result = json_encode(['error' => 'Unexpected error. ' . $exception->getMessage()]);
        }

        return $result;
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