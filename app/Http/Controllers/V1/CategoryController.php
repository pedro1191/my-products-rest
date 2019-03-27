<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apiUrl = "/categories";

        $response = $this->requestToDashboardAPI($apiUrl);

        return response()->json($response['output'], $response['httpCode']);
    }
}
