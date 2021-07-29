<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    protected $ProductService;
    protected $user;

    public function __construct(ProductService $ProductService)
    {
        $this->ProductService = $ProductService;
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->ProductService->showProducts();
        return response()->json(['data' => $data['data'], 'Message' => $data['message'], 'StatusCode' => $data['statusCode']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formdata = $request;
        $data = $this->ProductService->createProducts($formdata);
        return response()->json(['Message' => $data['message'], 'StatusCode' => $data['StatusCode']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->ProductService->showSingleProduct($id);
        return response()->json(['data'=> $data['data'],'Message' => $data['message'], 'StatusCode' => $data['StatusCode']]);
  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->ProductService->editProducts($id);
        return response()->json(['Message' => $data['message'], 'StatusCode' => $data['StatusCode']]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
