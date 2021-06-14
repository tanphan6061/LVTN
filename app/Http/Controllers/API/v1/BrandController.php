<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Resources\BrandR;
use App\Models\Brand;

class BrandController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //dd($brand);
        return $this->responded("Get brand successfully", new BrandR($brand));
    }



}
