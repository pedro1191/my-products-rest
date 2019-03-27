<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $queryParams = str_replace($request->url(), '', $request->fullUrl());

        $apiUrl = '/products' . $queryParams;

        $response = $this->requestToDashboardAPI($apiUrl);

        return response()->json($response['output'], $response['httpCode']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $queryParams = str_replace($request->url(), '', $request->fullUrl());

        $apiUrl = '/products/' . $id . $queryParams;

        $response = $this->requestToDashboardAPI($apiUrl);

        return response()->json($response['output'], $response['httpCode']);
    }
}
