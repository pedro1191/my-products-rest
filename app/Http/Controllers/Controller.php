<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Dingo\Api\Routing\Helpers;

class Controller extends BaseController
{
    use Helpers;
    const DEFAULT_PAGINATION_RESULTS = 15;

    /**
     * Call another API to fetch information.
     * 
     * @param string $url
     * @return array
     */
    protected function requestToDashboardAPI(string $url)
    {
        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, env('DASHBOARD_API_URL') . $url);

        // return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close curl resource to free up system resources
        curl_close($ch);

        return ['output' => $output, 'httpCode' => $httpCode];
    }
}
