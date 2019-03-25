<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $queryParams = str_replace($request->url(), '', $request->fullUrl());

        $apiUrl = "/products$queryParams";

        $response = $this->requestToDashboardAPI($apiUrl);

        return response()->json($response['output'], $response['httpCode']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $apiUrl = "/products/$id";

        $response = $this->requestToDashboardAPI($apiUrl);

        return response()->json($response['output'], $response['httpCode']);
    }

    /**
     * Call another API to fetch information about products.
     * 
     * @param string $url
     * @return array
     */
    private function requestToDashboardAPI(string $url)
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
